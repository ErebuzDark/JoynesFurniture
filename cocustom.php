<?php
include("database.php");



if (isset($_POST['cartIds'], $_POST['productDetails'], $_POST['products'], $_POST['quantities'], $_POST['images'], $_POST['totalCost'], $_POST['fullName'], $_POST['address'], $_POST['cpNum'], $_POST['userID'], $_POST['payment'])) {
    $cartIds = $_POST['cartIds'];
    $productDetails = $_POST['productDetails'];
    $products = $_POST['products'];
    $quantities = $_POST['quantities'];
    $images = $_POST['images'];
    $totalCost = $_POST['totalCost'];
    $fullName = $_POST['fullName'];
    $address = $_POST['address'];
    $cpNum = $_POST['cpNum'];
    $userID = $_POST['userID'];
    $payment = $_POST['payment'];
    $width = $_POST['width'];
    $length = $_POST['length'];
    $height = $_POST['height'];

    $qrImageFile = $_FILES['qrImage'];
    $qrImagePath = '';

    if ($qrImageFile['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'up/';
        $fileName = uniqid('qr_', true) . '.' . pathinfo($qrImageFile['name'], PATHINFO_EXTENSION);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($qrImageFile['tmp_name'], $filePath)) {
            // Store the path of the uploaded file
            $qrImagePath = $filePath;
        } else {
            echo "Error uploading image.";
        }
    }

    $sql = "INSERT INTO checkoutcustom (userID, prodDetails, pName, totalCost, fullName, address, cpNum, quantity, image, payment, proofPay, width, length, height)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,? ,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssssssss', $userID, $productDetails, $products, $totalCost, $fullName, $address, $cpNum, $quantities, $images, $payment, $qrImagePath, $width, $length, $height);

    if ($stmt->execute()) {
        $orderID = $conn->insert_id; // Get the inserted order ID
        $source = 'checkoutcustom'; // Table source
        $paymentDate = date("Y-m-d H:i:s");

        $receiptStmt = $conn->prepare("INSERT INTO payment_receipts (orderID, userID, source, productName, amountPaid, proofImage, paymentDate) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $receiptStmt->bind_param("iisssss", $orderID, $userID, $source, $products, $totalCost, $qrImagePath, $paymentDate);
        $receiptStmt->execute();
        $receiptStmt->close();

        $cartIdsArray = explode(',', $cartIds);
        $placeholders = implode(',', array_fill(0, count($cartIdsArray), '?'));

        $deleteSql = "DELETE FROM tbl_cartcus WHERE cart_ID IN ($placeholders)";
        $deleteStmt = $conn->prepare($deleteSql);

        $types = str_repeat('s', count($cartIdsArray));
        $deleteStmt->bind_param($types, ...$cartIdsArray);
        $deleteStmt->execute();

        echo "<script>
                alert('Order successfully placed!');
                window.location.href = 'profile.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>