<?php
include "database.php";

header('Content-Type: application/json');

if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];

    $stmt = $conn->prepare("SELECT proofImage, amountPaid, senderName, paymentDate FROM payment_receipts WHERE orderID = ?");
    $stmt->bind_param("s", $orderID);
    $stmt->execute();
    $result = $stmt->get_result();

    $receipts = [];
    while ($row = $result->fetch_assoc()) {
        $receipts[] = $row;
    }

    echo json_encode($receipts);
} else {
    echo json_encode([]);
}
