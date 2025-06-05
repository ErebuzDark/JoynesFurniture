<?php
include "database.php";
header('Content-Type: application/json');

$orderID = $_POST['orderID'] ?? 0;
$userID = $_POST['userID'] ?? 0;
$source = $_POST['source'] ?? '';
$prodName = $_POST['prodName'] ?? '';

$count = 0;

if ($orderID && $userID && $source && $prodName) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM payment_receipts WHERE orderID = ? AND userID = ? AND source = ? AND productName = ? AND payment_status NOT IN ('invalid', 'refunded')");
    $stmt->bind_param("iiss", $orderID, $userID, $source, $prodName);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
}

// Display logic: count + 1 unless already 3
$displayCount = $count + 1;
if ($displayCount > 3)
    $displayCount = 3;

// Set messages
$successMessage = '';
$noteMessage = '';

if ($count >= 3) {
    $successMessage = 'You are fully paid. Please wait for the admin to process your order.';
} elseif ($displayCount == 3) {
    $noteMessage = 'Note: Your last payment will be exact to the balance.';
}

echo json_encode([
    'count' => $displayCount,
    'realCount' => $count,
    'successMessage' => $successMessage,
    'noteMessage' => $noteMessage
]);

exit;
