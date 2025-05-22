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
            // Store the path of the uploaded file
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
    $status = 'On Queue';
    $userID = $_POST['userID'];
    $images = $_POST['tblImage'];
    $payment = $_POST['payment'];
    $quantity = $_POST['quantity'];
    $prodWidth = $_POST['prodWidth'];
    $prodLength = $_POST['prodLength'];
    $prodHeight = $_POST['prodHeight'];


    $totalCost = array_sum($prodCosts);
    $imagesString = 'up/' . implode(', up/', $images);
    // $imagesString = implode(', ', $image);

    $prodIDsString = implode(', ', $prodIDs);
    $prodNamesString = implode(', ', $prodNames);
    $prodWidthString = implode(', ', $prodWidth);
    $prodLengthString = implode(', ', $prodLength);
    $prodHeightString = implode(', ', $prodHeight);
    mysqli_begin_transaction($conn);

    try {
        $query = "INSERT INTO checkout (userID, image, fID, fullName, prodName, address, cpNum, cost, status, proofPay, payment, quantity, width, length, height) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";

        $stmt = mysqli_prepare($conn, $query);
        if ($stmt === false) {
            throw new Exception("Error preparing statement: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'sssssssssssisss', $userID, $imagesString, $prodIDsString, $fullName, $prodNamesString, $address, $cpNum, $totalCost, $status, $qrImagePath, $payment, $quantity, $prodWidthString, $prodLengthString, $prodHeightString);
        mysqli_stmt_execute($stmt);

        $deleteQuery = "DELETE FROM addcart WHERE ID = ?";
        $deleteStmt = mysqli_prepare($conn, $deleteQuery);
        if ($deleteStmt === false) {
            throw new Exception("Error preparing delete statement: " . mysqli_error($conn));
        }

        foreach ($prodIDs as $prodID) {
            mysqli_stmt_bind_param($deleteStmt, 'i', $prodID);
            mysqli_stmt_execute($deleteStmt);
        }

        mysqli_commit($conn);

        foreach($prodIDs as $prodID) {
            $minusQuantitySql = "SELECT * FROM furnituretbl WHERE fID = '$prodID'";
            $minusQuantityResult = mysqli_query($conn, $minusQuantitySql);
            $minusQuantityRow = mysqli_fetch_assoc($minusQuantityResult);

            $qty2 = $minusQuantityRow['fQuantity'];

            $totQty = (int) $qty2-$quantity;

            $updateQuantitySql = "UPDATE furnituretbl SET fQuantity = '$totQty' WHERE fID = '$prodID'";
            mysqli_query($conn, $updateQuantitySql);
        }
        
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