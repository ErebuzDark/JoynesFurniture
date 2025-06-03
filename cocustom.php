<?php
session_start();
include("database.php");

if (isset($_POST['cartIds'], $_POST['productDetails'], $_POST['products'], $_POST['quantities'], $_POST['images'], $_POST['totalCost'], $_POST['fullName'], $_POST['address'], $_POST['cpNum'], $_POST['userID'], $_POST['payment'], $_POST['referenceNumber'], $_POST['amountInput'])) {

    $cartIds = $_POST['cartIds'];
    $productDetails = $_POST['productDetails'];
    $products = $_POST['products'];
    $quantities = $_POST['quantities'];
    $images = $_POST['images'];
    $totalCost = $_POST['totalCost'];
    $balance = $_POST['totalCost'];
    $fullName = $_POST['fullName'];
    $address = $_POST['address'];
    $cpNum = $_POST['cpNum'];
    $userID = $_POST['userID'];
    $payment = $_POST['payment'];
    $width = $_POST['width'];
    $length = $_POST['length'];
    $height = $_POST['height'];

    $referenceNumber = $_POST['referenceNumber'];
    $amountInput = $_POST['amountInput'];

    $qrImageFile = $_FILES['qrImage'];
    $qrImagePath = '';

    if ($qrImageFile['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'up/';
        $fileName = uniqid('qr_', true) . '.' . pathinfo($qrImageFile['name'], PATHINFO_EXTENSION);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($qrImageFile['tmp_name'], $filePath)) {
            $qrImagePath = $filePath;
        } else {
            echo "Error uploading image.";
        }
    }

    $sql = "INSERT INTO checkoutcustom (userID, prodDetails, pName, totalCost, fullName, address, cpNum, quantity, image, payment, balance, proofPay, width, length, height)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,? , ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssssdssss', $userID, $productDetails, $products, $totalCost, $fullName, $address, $cpNum, $quantities, $images, $payment, $balance, $qrImagePath, $width, $length, $height);

    if ($stmt->execute()) {
        $orderID = $conn->insert_id; // Get the inserted order ID
        $orderID = $conn->insert_id; // Get the inserted order ID
        $source = 'checkoutcustom';

        $receiptSql = "INSERT INTO payment_receipts (orderID, userID, source, productName, amountPaid, proofImage, ref_no, paymentDate) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $receiptStmt = $conn->prepare($receiptSql);

        $receiptStmt->bind_param(
            "isssdss",
            $orderID,
            $userID,
            $source,
            $products,
            $amountInput,
            $qrImagePath,
            $referenceNumber
        );



        $receiptStmt->execute();
        $receiptStmt->close();

        $cartIdsArray = explode(',', $cartIds);
        $placeholders = implode(',', array_fill(0, count($cartIdsArray), '?'));

        $deleteSql = "DELETE FROM tbl_cartcus WHERE cart_ID IN ($placeholders)";
        $deleteStmt = $conn->prepare($deleteSql);

        $types = str_repeat('i', count($cartIdsArray));
        $deleteStmt->bind_param($types, ...$cartIdsArray);
        $deleteStmt->execute();

        $_SESSION['success_message'] = "Order successfully placed!";
        header("Location: profile.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>