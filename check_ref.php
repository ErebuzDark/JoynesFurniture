<?php
include("database.php");

session_start();

if (isset($_POST['refNo'])) {
    $refNo = $_POST['refNo'];

    $stmt = $conn->prepare("SELECT id FROM payment_receipts WHERE ref_no = ?");
    $stmt->bind_param("s", $refNo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
    $stmt->close();
} else {
    echo json_encode(['exists' => false]);
}
$conn->close();
?>