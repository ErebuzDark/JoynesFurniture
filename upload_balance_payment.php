<?php
include "database.php";

$orderID = $_POST['orderID'];
$userID = $_POST['userID'];
$prodName = $_POST['prodName'];
$source = $_POST['source']; // 'checkout' or 'checkoutcustom'
$balanceAmount = $_POST['balanceAmount'];
$date = date("Y-m-d H:i:s");

// Handle image upload
if (isset($_FILES['paymentImage']) && $_FILES['paymentImage']['error'] == 0) {
    $fileName = basename($_FILES["paymentImage"]["name"]);
    $targetDir = "up/";
    $targetFile = $targetDir . time() . "_" . $fileName;

    if (move_uploaded_file($_FILES["paymentImage"]["tmp_name"], $targetFile)) {
        // Save new payment proof in a new table (recommended) or append to existing record
        $stmt = $conn->prepare("INSERT INTO payment_receipts (orderID, userID, source, productName, amountPaid, proofImage, paymentDate) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssss", $orderID, $userID, $source, $prodName, $balanceAmount, $targetFile, $date);
        $stmt->execute();

        echo "<script>alert('Payment uploaded successfully!'); window.location.href='customizecart.php';</script>";
    } else {
        echo "<script>alert('Error uploading image.'); history.back();</script>";
    }
} else {
    echo "<script>alert('No image uploaded.'); history.back();</script>";
}
?>