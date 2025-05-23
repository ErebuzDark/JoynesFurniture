<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("database.php");

if (isset($_POST['orderID'], $_POST['pay'], $_POST['source'], $_POST['totalCost'], $_POST['currentBalance'])) {
    $orderID = $_POST['orderID'];
    $newPayment = $_POST['pay'];
    $source = $_POST['source'];
    $totalCost = (float) $_POST['totalCost'];
    $currentBalance = (float) $_POST['currentBalance'];
    $downPayment = isset($_POST['downPayment']) ? (float) $_POST['downPayment'] : 0;

    // Fetch existing payment status and balance
    $fetchSQL = ($source === "checkout") ?
        "SELECT payment, balance FROM checkout WHERE orderID = ?" :
        "SELECT payment, balance FROM checkoutcustom WHERE orderID = ?";
    $fetchStmt = $conn->prepare($fetchSQL);
    $fetchStmt->bind_param("s", $orderID);
    $fetchStmt->execute();
    $fetchStmt->bind_result($existingPayment, $existingBalance);
    $fetchStmt->fetch();
    $fetchStmt->close();

    // No change check
    $isSamePayment = ($newPayment === $existingPayment);
    $isDownPaymentZero = ($downPayment <= 0);

    if ($isSamePayment && $isDownPaymentZero) {
        $_SESSION['toast'] = ['type' => 'error', 'message' => 'No changes made. Please update payment status or enter a down payment.'];
        header("Location: adminOrder.php");
        exit;
    }

    // Calculate new balance and amount paid
    $amountPaid = min($downPayment, $currentBalance);
    $balance = $currentBalance - $amountPaid;

    if ($balance <= 0) {
        $newPayment = "Full Payment";
        $balance = 0;
    }

    $referenceNo = strtoupper(uniqid('REF-'));
    $updateSQL = ($source === "checkout") ?
        "UPDATE checkout SET payment = ?, balance = ? WHERE orderID = ?" :
        "UPDATE checkoutcustom SET payment = ?, balance = ? WHERE orderID = ?";

    $stmt = $conn->prepare($updateSQL);
    $stmt->bind_param("sds", $newPayment, $balance, $orderID);

    if ($stmt->execute()) {
        // Check if payment_receipt exists for this orderID
        $check = $conn->prepare("SELECT id, userID FROM payment_receipts WHERE orderID = ?");
        $check->bind_param("s", $orderID);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $check->bind_result($payment_receipt_id, $userID);
            $check->fetch();
        } else {
            // TODO: Get userID for the new payment receipt.
            // For example, you might get it from session or another table based on orderID:
            // $userID = $_SESSION['userID']; 
            // or
            // $userID = getUserIDFromOrder($orderID);
            // Replace the following with actual userID fetch logic:
            $userID = 0; // <-- Replace with real userID

            if ($userID <= 0) {
                die("Cannot insert payment receipt without a valid userID.");
            }

            $insertPaymentReceipt = $conn->prepare("INSERT INTO payment_receipts (userID, orderID) VALUES (?, ?)");
            $insertPaymentReceipt->bind_param("is", $userID, $orderID);
            $insertPaymentReceipt->execute();

            if ($insertPaymentReceipt->affected_rows > 0) {
                $payment_receipt_id = $conn->insert_id;
            } else {
                die("Failed to insert new payment_receipt.");
            }
            $insertPaymentReceipt->close();
        }
        $check->close();

        if ($amountPaid > 0) {
            $insertOfficial = $conn->prepare("INSERT INTO official_receipts (userID, orderID, payment_receipt_id, totalPaid, reference_number, created_at, update_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
            $insertOfficial->bind_param("iiids", $userID, $orderID, $payment_receipt_id, $amountPaid, $referenceNo);
            $insertOfficial->execute();
        }

        $_SESSION['receipt'] = [
            'userID' => $userID,
            'orderID' => $orderID,
            'payment' => $newPayment,
            'amountPaid' => $amountPaid,
            'totalCost' => $totalCost,
            'balance' => $balance,
            'referenceNo' => $referenceNo,
            'source' => $source
        ];

        $_SESSION['toast'] = ['type' => 'success', 'message' => 'Payment updated successfully!'];
        header("Location: adminOrder.php");
        exit;
    } else {
        $_SESSION['toast'] = ['type' => 'error', 'message' => 'Failed to update payment: ' . $conn->error];
        header("Location: adminOrder.php");
        exit;
    }
}
?>
