<?php
session_start();
include("database.php");

if (isset($_POST['orderID'], $_POST['pay'], $_POST['source'], $_POST['totalCost'], $_POST['currentBalance'])) {
    $orderID = $_POST['orderID'];
    $payment = $_POST['pay'];
    $source = $_POST['source'];
    $totalCost = (float) $_POST['totalCost'];
    $currentBalance = (float) $_POST['currentBalance'];
    $downPayment = isset($_POST['downPayment']) ? (float) $_POST['downPayment'] : 0;

    // Calculate amount paid and balance
    if ($payment === 'Full Payment') {
        $amountPaid = $totalCost;
        $balance = 0;
    } else {
        $amountPaid = min($downPayment, $currentBalance); // Prevent overpaying
        $balance = $currentBalance - $amountPaid;
    }

    // Generate unique reference number
    $referenceNo = strtoupper(uniqid('REF-'));

    // Update checkout or checkoutcustom table
    if ($source === "checkout") {
        $sql = "UPDATE checkout SET payment = ?, balance = ? WHERE orderID = ?";
    } else {
        $sql = "UPDATE checkoutcustom SET payment = ?, balance = ? WHERE orderID = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sds", $payment, $balance, $orderID);

    if ($stmt->execute()) {
        // Check if a payment_receipt already exists
        $check = $conn->prepare("SELECT totalPaid FROM payment_receipts WHERE orderID = ?");
        $check->bind_param("s", $orderID);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $check->bind_result($existingPaid);
            $check->fetch();
            $newTotalPaid = $existingPaid + $amountPaid;

            $update = $conn->prepare("UPDATE payment_receipts SET reference_number = ?, totalPaid = ? WHERE orderID = ?");
            $update->bind_param("sds", $referenceNo, $newTotalPaid, $orderID);
            $update->execute();
        } else {
            $insert = $conn->prepare("INSERT INTO payment_receipts (orderID, reference_number, totalPaid) VALUES (?, ?, ?)");
            $insert->bind_param("ssd", $orderID, $referenceNo, $amountPaid);
            $insert->execute();
        }

        $_SESSION['receipt'] = [
            'orderID' => $orderID,
            'payment' => $payment,
            'amountPaid' => $amountPaid,
            'totalCost' => $totalCost,
            'balance' => $balance,
            'referenceNo' => $referenceNo,
            'source' => $source
        ];

        header("Location: receipt.php");
        exit;
    } else {
        echo "Error updating payment: " . $conn->error;
    }
}
?>
