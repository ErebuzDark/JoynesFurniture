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
        $imagePath = htmlspecialchars($row['proofImage']);
        $fileName = basename($imagePath); // This will be the default name when downloaded
        echo '<div class="d-flex mb-3">';
        echo '<img src="' . htmlspecialchars($row['proofImage']) . '" class="img-fluid border rounded mb-1" style="max-width: 50%;">';
            echo '<div class="d-flex flex-column gap-2 m-2">';
            echo '<p class="text-muted mb-0" style="font-size:13px;">Uploaded on: ' . date("F j, Y, g:i a", strtotime($row['paymentDate'])) . '</p>';
            echo '<a href="' . $imagePath . '" download="' . $fileName . '" class="btn btn-sm btn-outline-primary">Download Image</a>';
            echo '</div>';
        echo '</div>';
        echo '<hr></hr>';
    }
} else {
    echo '<p class="text-muted">No receipts uploaded for this order yet.</p>';
}
