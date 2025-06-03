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
    $prodImage = "up/" . $_POST['prodImage'];
    $status = $_POST['status'];
    $quantity = $_POST['quantity'];
    $width = $_POST['width'];
    $length = $_POST['length'];
    $height = $_POST['height'];

    $amountPaid = $_POST['amountPaid'];
    $refNo = trim($_POST['refNo']);

    // Check if refNo already used in payment_receipts table
    $checkRef = $conn->prepare("SELECT COUNT(*) FROM payment_receipts WHERE ref_no = ?");
    $checkRef->bind_param("s", $refNo);
    $checkRef->execute();
    $checkRef->bind_result($refCount);
    $checkRef->fetch();
    $checkRef->close();

    if ($refCount > 0) {
        // Duplicate refNo found - send error back to shop.php with toast
        $_SESSION['error_refNo'] = "This reference number has already been used. Please check and try again.";
        header("Location: shop.php");
        exit();
    } else {
        // Proceed with insert only if no duplicate refNo found

        // Upload file handling
        $filename = "up/" . uniqid('qr_', true) . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $tempname = $_FILES['image']['tmp_name'];
        $folder = $filename;

        $sql_select = "SELECT cost FROM furnituretbl WHERE fID = ?";

        if ($stmt_select = $conn->prepare($sql_select)) {
            $stmt_select->bind_param("i", $orderID);
            $stmt_select->execute();
            $stmt_select->bind_result($cost);

            if ($stmt_select->fetch()) {
                $stmt_select->close();

                $sql_insert = "INSERT INTO checkout (userID, fullName, address, cpNum, image, prodName, cost, date, status, balance, proofPay, quantity, variant, width, length, height) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?)";

                if ($stmt_insert = $conn->prepare($sql_insert)) {
                    $variant = "full";
                    $stmt_insert->bind_param(
                        "isssssdsissssss",
                        $userID,
                        $fullName,
                        $address,
                        $cpNum,
                        $prodImage,
                        $prodName,
                        $cost,
                        $status,
                        $cost,
                        $filename,
                        $quantity,
                        $variant,
                        $width,
                        $length,
                        $height
                    );

                    if ($stmt_insert->execute()) {
                        move_uploaded_file($tempname, $folder);

                        $checkoutOrderID = $conn->insert_id;
                        $source = 'checkout';
                        $paymentDate = date("Y-m-d H:i:s");

                        $receiptStmt = $conn->prepare("INSERT INTO payment_receipts (orderID, userID, source, productName, amountPaid, proofImage, paymentDate, ref_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $receiptStmt->bind_param("iissdsss", $checkoutOrderID, $userID, $source, $prodName, $amountPaid, $filename, $paymentDate, $refNo);
                        $receiptStmt->execute();
                        $receiptStmt->close();

                        $minusQuantitySql = "SELECT fQuantity FROM furnituretbl WHERE fID = ?";
                        $stmtQty = $conn->prepare($minusQuantitySql);
                        $stmtQty->bind_param("i", $orderID);
                        $stmtQty->execute();
                        $stmtQty->bind_result($qty2);
                        $stmtQty->fetch();
                        $stmtQty->close();

                        $totQty = max(0, (int) $qty2 - 1);

                        $updateQuantitySql = "UPDATE furnituretbl SET fQuantity = ? WHERE fID = ?";
                        $stmtUpdate = $conn->prepare($updateQuantitySql);
                        $stmtUpdate->bind_param("ii", $totQty, $orderID);
                        $stmtUpdate->execute();
                        $stmtUpdate->close();

                        $_SESSION['success'] = "Order placed successfully!";
                        header("Location: profile.php");
                        exit();
                    } else {
                        $_SESSION['error'] = "Error placing order: " . $stmt_insert->error;
                        header("Location: shop.php");
                        exit();
                    }

                    $stmt_insert->close();
                } else {
                    $_SESSION['error'] = "Prepare failed: " . $conn->error;
                    header("Location: shop.php");
                    exit();
                }
            } else {
                $_SESSION['error'] = "Order not found or invalid order ID.";
                header("Location: shop.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Prepare failed: " . $conn->error;
            header("Location: shop.php");
            exit();
        }
    }
}

if (isset($_POST['cancel'])) {
    header("Location: shop.php");
    exit();
}
?>