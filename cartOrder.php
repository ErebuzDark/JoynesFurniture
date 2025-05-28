<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

    $fullName = $_POST['fullName'];
    $address = $_POST['address'];
    $cpNum = $_POST['cpNum'];
    $prodIDs = $_POST['prodIDs'];
    $prodNames = $_POST['prodNames'];
    $prodCosts = $_POST['prodCosts'];
    $balance = $_POST['balance'];
    $status = 'Pending Approval';
    $userID = $_POST['userID'];
    $images = $_POST['tblImage'];
    $payment = $_POST['payment'];
    $quantity = $_POST['quantity'];
    $prodWidth = $_POST['prodWidth'];
    $prodLength = $_POST['prodLength'];
    $prodHeight = $_POST['prodHeight'];
    $variant = "full";

    $totalCost = array_sum($prodCosts);
    $imagesString = 'up/' . implode(', up/', $images);

    $prodIDsString = implode(', ', $prodIDs);
    $prodNamesString = implode(', ', $prodNames);
    $prodWidthString = implode(', ', $prodWidth);
    $prodLengthString = implode(', ', $prodLength);
    $prodHeightString = implode(', ', $prodHeight);
    $quantityString = implode(', ', $quantity);

    mysqli_begin_transaction($conn);

    try {
        $query = "INSERT INTO checkout (userID, image, fID, fullName, prodName, address, cpNum, cost, status, proofPay, payment, balance, quantity, variant, width, length, height) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $query);
        if ($stmt === false) {
            throw new Exception("Error preparing statement: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'sssssssssssiissss', $userID, $imagesString, $prodIDsString, $fullName, $prodNamesString, $address, $cpNum, $totalCost, $status, $qrImagePath, $payment, $balance, $quantityString, $variant, $prodWidthString, $prodLengthString, $prodHeightString);
        mysqli_stmt_execute($stmt);

        // NEW: Insert into payment_receipts
        $orderID = $conn->insert_id;
        $source = 'checkout';
        $paymentDate = date("Y-m-d H:i:s");
        $prodName = implode(', ', $prodNames);
        $cost = $totalCost;

        $receiptStmt = $conn->prepare("INSERT INTO payment_receipts (orderID, userID, source, productName, amountPaid, proofImage, paymentDate) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $receiptStmt->bind_param("iisssss", $orderID, $userID, $source, $prodName, $cost, $qrImagePath, $paymentDate);
        $receiptStmt->execute();
        $receiptStmt->close();

        // Delete from addcart table
        $deleteQuery = "DELETE FROM addcart WHERE ID = ?";
        $deleteStmt = mysqli_prepare($conn, $deleteQuery);
        if ($deleteStmt === false) {
            throw new Exception("Error preparing delete statement: " . mysqli_error($conn));
        }

        foreach ($prodIDs as $prodID) {
            mysqli_stmt_bind_param($deleteStmt, 'i', $prodID);
            mysqli_stmt_execute($deleteStmt);
        }

        // Deduct stock quantities
        foreach ($prodIDs as $index => $prodID) {
            $orderedQty = (int) $quantity[$index];

            $minusQuantitySql = "SELECT fQuantity FROM furnituretbl WHERE fID = '$prodID'";
            $minusQuantityResult = mysqli_query($conn, $minusQuantitySql);
            $minusQuantityRow = mysqli_fetch_assoc($minusQuantityResult);

            $qty2 = (int) $minusQuantityRow['fQuantity'];
            $totQty = $qty2 - $orderedQty;

            $updateQuantitySql = "UPDATE furnituretbl SET fQuantity = '$totQty' WHERE fID = '$prodID'";
            mysqli_query($conn, $updateQuantitySql);
        }

        mysqli_commit($conn);

        echo "<script>
                alert('Order successfully placed!');
                window.location.href = 'profile.php';
              </script>";
        exit();
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }
}
?>