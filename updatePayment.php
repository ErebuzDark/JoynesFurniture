<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();
include("database.php");

try {
    if (
        isset(
        $_POST['orderID'],
        $_POST['amountPaid'],
        $_POST['ref_no'],
        $_POST['payment_status'],
        $_POST['source'],
        $_POST['totalCost'],
        $_POST['currentBalance'],
        $_POST['receiptID']  // <-- new required input
    )
    ) {
        $orderID = $_POST['orderID'];
        $amountPaid = (float) $_POST['amountPaid'];
        $refNo = trim($_POST['ref_no']);
        $paymentStatusPost = $_POST['payment_status'];
        $source = $_POST['source'];
        $totalCost = (float) $_POST['totalCost'];
        $currentBalance = (float) $_POST['currentBalance'];
        $receiptID = (int) $_POST['receiptID']; // Unique receipt to update

        $balance = $currentBalance - $amountPaid;

        if ($amountPaid <= 0) {
            $payment = "Not Paid Yet";
            $balance = $currentBalance;
        } elseif ($balance <= 0) {
            $balance = 0;
            $payment = "Full Payment";
        } else {
            $payment = "Partial Paid";
        }

        $receiptID = (int) $_POST['receiptID'];

        // Check for duplicate reference number
        if (!empty($refNo)) {
            $checkRef = $conn->prepare("SELECT ref_no FROM payment_receipts WHERE ref_no = ? AND id != ?");
            $checkRef->bind_param("ii", $refNo, $receiptID);
            $checkRef->execute();
            $checkRef->bind_result($countRef);
            $checkRef->fetch();
            $checkRef->close();

            if ($countRef > 0) {
                $msg = "Error: Reference number already exists.";
                $url = "adminOrder.php";
                echo "<script>
        alert(" . json_encode($msg) . ");
        setTimeout(function() {
            window.location.href = " . json_encode($url) . ";
        }, 100); // 100ms delay before redirecting
    </script>";
                exit();
            }


        }

        // Continue with balance calculations and updates...

        // Update checkout or checkoutcustom table
        $updateSQL = ($source === "checkout") ?
            "UPDATE checkout SET payment = ?, balance = ? WHERE orderID = ?" :
            "UPDATE checkoutcustom SET payment = ?, balance = ? WHERE orderID = ?";

        $stmt = $conn->prepare($updateSQL);
        $stmt->bind_param("sds", $payment, $balance, $orderID);

        if (!$stmt->execute()) {
            throw new Exception("Failed to update payment status and balance: " . $stmt->error);
        }
        $stmt->close();

        // Get userID for receipt if needed
        $getUserID = $conn->prepare("SELECT userID FROM payment_receipts WHERE id = ?");
        $getUserID->bind_param("i", $receiptID);
        $getUserID->execute();
        $getUserID->bind_result($userID);
        if (!$getUserID->fetch()) {
            throw new Exception("Payment receipt ID not found.");
        }
        $getUserID->close();

        // Insert official_receipts if amountPaid > 0
        if ($amountPaid > 0) {
            $insertOfficial = $conn->prepare(
                "INSERT INTO official_receipts (userID, orderID, payment_receipt_id, totalPaid, reference_number, created_at, update_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())"
            );
            $insertOfficial->bind_param("iiids", $userID, $orderID, $receiptID, $amountPaid, $refNo);
            if (!$insertOfficial->execute()) {
                throw new Exception("Failed to insert official_receipt: " . $insertOfficial->error);
            }
            $insertOfficial->close();
        }

        // Update payment_receipts using receiptID to avoid affecting others
        $updateReceipt = $conn->prepare(
            "UPDATE payment_receipts SET amountPaid = ?, ref_no = ?, payment_status = ?, paymentDate = NOW() WHERE id = ?"
        );
        $updateReceipt->bind_param("dssi", $amountPaid, $refNo, $paymentStatusPost, $receiptID);
        if (!$updateReceipt->execute()) {
            throw new Exception("Failed to update payment_receipts: " . $updateReceipt->error);
        }
        $updateReceipt->close();

        $_SESSION['receipt'] = [
            'userID' => $userID,
            'orderID' => $orderID,
            'payment' => $payment,
            'amountPaid' => $amountPaid,
            'totalCost' => $totalCost,
            'balance' => $balance,
            'referenceNo' => $refNo,
            'source' => $source
        ];

        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Payment updated successfully!'];
        header("Location: adminOrder.php");
        exit;
    } else {
        throw new Exception("Required POST data missing.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
