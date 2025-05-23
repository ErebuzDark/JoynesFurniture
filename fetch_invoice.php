<?php
include "database.php";
header('Content-Type: application/json');

if (isset($_GET['orderID'])) {
    $orderID = intval($_GET['orderID']);
    $stmt = $conn->prepare("SELECT * FROM official_receipts WHERE orderID = ?");
    $stmt->bind_param("i", $orderID);
    $stmt->execute();
    $result = $stmt->get_result();

    $invoices = [];
    while ($row = $result->fetch_assoc()) {
        $invoices[] = $row;
    }

    if (!empty($invoices)) {
        echo json_encode([
            'success' => true,
            'invoices' => $invoices
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No invoice found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
