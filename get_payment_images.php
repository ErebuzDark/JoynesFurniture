<?php
include "database.php";
$orderID = $_POST['orderID'];
$source = $_POST['source'];

$stmt = $conn->prepare("SELECT proofImage, paymentDate FROM payment_receipts WHERE orderID = ? AND source = ?");
$stmt->bind_param("is", $orderID, $source);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="mb-3">';
        echo '<img src="' . htmlspecialchars($row['proofImage']) . '" class="img-fluid border rounded mb-1" style="max-width: 100%;">';
        echo '<p class="text-muted" style="font-size:13px;">Uploaded on: ' . date("F j, Y, g:i a", strtotime($row['paymentDate'])) . '</p>';
        echo '</div>';
    }
} else {
    echo '<p class="text-muted">No receipts uploaded for this order yet.</p>';
}
