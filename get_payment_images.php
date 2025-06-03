<?php
include "database.php";

$orderID = $_POST['orderID'];
$source = $_POST['source'];

$stmt = $conn->prepare("SELECT proofImage, paymentDate, payment_status, amountPaid FROM payment_receipts WHERE orderID = ? AND source = ?");
$stmt->bind_param("is", $orderID, $source);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imagePath = htmlspecialchars($row['proofImage']);
        $fileName = basename($imagePath);

        // Determine badge color based on status
        $status = htmlspecialchars($row['payment_status']);
        $badgeClass = 'secondary';
        switch (strtolower($status)) {
            case 'confirmed':
                $badgeClass = 'success';
                break;
            case 'pending':
                $badgeClass = 'warning';
                break;
            case 'refunded':
                $badgeClass = 'secondary';
                break;
            case 'invalid':
                $badgeClass = 'danger';
                break;
        }

        echo '<div class="d-flex mb-3">';
        echo '<img src="' . $imagePath . '" class="img-fluid border rounded mb-1" style="max-width: 50%;">';
        echo '<div class="d-flex flex-column gap-2 m-2">';
        echo '<p class="text-muted mb-0" style="font-size:1rem;">Uploaded on: ' . date("F j, Y, g:i a", strtotime($row['paymentDate'])) . '</p>';
        echo '<p class="mb-0" style="font-size:1rem;">Amount Paid: '. $row['amountPaid'] .' </p>';
        echo '<p class="mb-0" style="font-size:1rem;">Status: <span class="badge bg-' . $badgeClass . '">' . ucfirst($status) . '</span></p>';
        echo '<a href="' . $imagePath . '" download="' . $fileName . '" class="btn btn-sm btn-outline-primary mt-2">Download Image</a>';
        echo '</div>';
        echo '</div>';
        echo '<hr>';
    }
} else {
    echo '<p class="text-muted">No receipts uploaded for this order yet.</p>';
}
?>