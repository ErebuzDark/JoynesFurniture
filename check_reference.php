<?php
include("database.php");

if (isset($_POST['referenceNumber'])) {
    $refNum = $_POST['referenceNumber'];
    $stmt = $conn->prepare("SELECT COUNT(*) FROM payment_receipts WHERE ref_no = ?");
    $stmt->bind_param("s", $refNum);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    echo json_encode(['exists' => $count > 0]);
}
?>
