<?php
require_once 'database.php';
session_start();

if (isset($_POST['place'])) {
    $userID = $_SESSION['userID'];
    $orderID = $_POST['orderID'];
    $fullName = $_POST['fullName'];
    $address = $_POST['address'];
    $cpNum = $_POST['cpNum'];
    $prodName = $_POST['prodName'];
    $prodImage = "up/".$_POST['prodImage'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    $quantity = $_POST['quantity'];
    $width = $_POST['width'];
    $length = $_POST['length'];
    $height = $_POST['height'];

    // Corrected filename and temp file path
    $filename = "up/" . uniqid('qr_', true) . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $tempname = $_FILES['image']['tmp_name'];  // Fix: Correctly getting the temporary file path
    $folder = $filename;  // Fix: Ensure file is moved to the correct destination

    $sql_selectimg = "SELECT * FROM furnituretbl WHERE fID = ?";
    $stmt_selectimg = $conn->prepare($sql_selectimg);
    $stmt_selectimg->bind_param("i", $orderID);
    $stmt_selectimg->execute();
    $result2 = $stmt_selectimg->get_result();
    $row = $result2->fetch_assoc();
    $img = "up/" . $row['image']; // Keeping for reference, but not used in the insert statement

    $sql_select = "SELECT cost FROM furnituretbl WHERE fID = ?";

    if ($stmt_select = $conn->prepare($sql_select)) {
        $stmt_select->bind_param("i", $orderID);
        $stmt_select->execute();
        $stmt_select->bind_result($cost);

        if ($stmt_select->fetch()) {
            $stmt_select->close();

            $sql_insert = "INSERT INTO checkout (fID, userID, fullName, address, cpNum, image, prodName, cost, date, status, proofPay, quantity, width, length, height) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";

            if ($stmt_insert = $conn->prepare($sql_insert)) {
                $stmt_insert->bind_param("iisssssdsssisss", $orderID, $userID, $fullName, $address, $cpNum, $prodImage, $prodName, $cost, $date, $status, $filename, $quantity, $width, $length, $height);

                if ($stmt_insert->execute()) {
                    // Fix: Use correct temp file path and destination
                    move_uploaded_file($tempname, $folder);

                    $minusQuantitySql = "SELECT * FROM furnituretbl WHERE fID = '$orderID'";
                    $minusQuantityResult = mysqli_query($conn, $minusQuantitySql);
                    $minusQuantityRow = mysqli_fetch_assoc($minusQuantityResult);
                    
                    $qty2 = $minusQuantityRow['fQuantity'];

                    $totQty = (int) $qty2-1;

                    $updateQuantitySql = "UPDATE furnituretbl SET fQuantity = '$totQty' WHERE fID = '$orderID'";

                    if (mysqli_query($conn, $updateQuantitySql)) {
                        echo "<script>alert('Order placed successfully!');</script>";
                        header("Location: profile.php");
                        exit();
                    }
                } else {
                    echo "Error: " . $stmt_insert->error;
                }

                $stmt_insert->close();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Error: Order not found or invalid order ID.";
        }

        $stmt_select->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_POST['cancel'])) {
    echo "<script>window.location.href='./shop.php';</script>";
}
?>
