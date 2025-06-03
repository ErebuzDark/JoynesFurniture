<?php

session_start();
include("database.php");

if (isset($_POST['add'])) {
    $userID = $_SESSION['userID'];

    if (!$userID) {
        die("You must be logged in to add items to the cart.");
    }

    $prodName = $_POST['prodName'];
    $category = $_POST['category'];
    $vName = $_POST['vName'][0];
    $pName = $_POST['pName'][0];
    $width = $_POST['width'];
    $length = $_POST['length'];
    $height = $_POST['height'];
    $quantity = $_POST['quantity'];
    $pCost = $_POST['pcost'];




    switch ($category) {
        case 'mirror':
            $laborFee = 450;
            break;
        case 'cabinet':
            $laborFee = 600;
            break;
        case 'chair':
            $laborFee = 250;
            break;
        case 'table':
            $laborFee = 450;
            break;
        case 'bed':
            $laborFee = 400;
            break;
        case 'sala set':
            $laborFee = 300;
            break;
        case 'tv stand':
            $laborFee = 350;
            break;
        default:
            $laborFee = 0;
    }


    if ($category == 'chair') {
        $lit = '150';
    } elseif ($category == 'table') {
        $lit = '400';
    } elseif ($category == 'mirror') {
        $lit = '200';
    } elseif ($category == 'cabinet') {
        $lit = '400';
    } elseif ($category == 'bed') {
        $lit = '500';
    } elseif ($category == 'tv') {
        $lit = '400';
    } else {
        $lit = '0';
    }

    $tWidth = $pCost * $width;
    $tLength = $pCost * $length;
    $tHeight = $pCost * $height;
    $cost = ($tWidth + $tLength + $tHeight + $pCost + $lit + $laborFee);

    $totalCost = $cost * $quantity;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];

        if ($imageSize > 2 * 1024 * 1024) {
            die("Image size must be less than 2MB.");
        }

        $imagePath = 'up/' . $imageName;
        move_uploaded_file($imageTmp, $imagePath);
    } else {
        die("Error uploading image.");
    }

    $query = "INSERT INTO tbl_cartcus (userID, fName, vName, pName, width, length, height, quantity, image, cost, totalCost) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    if ($stmt === false) {
        die("Error preparing the statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'ssssdddisds', $userID, $prodName, $vName, $pName, $width, $length, $height, $quantity, $imageName, $cost, $totalCost);

    if (mysqli_stmt_execute($stmt)) {
        $minusVSql = "SELECT * FROM varnishtbl WHERE vName = '$vName'";
        $minusVResult = mysqli_query($conn, $minusVSql);
        $minusVRow = mysqli_fetch_assoc($minusVResult);

        $vQty2 = $minusVRow['vQuantity'];

        $totVQty = (int) $vQty2 - $quantity;

        $updateVSql = "UPDATE varnishtbl SET vQuantity = '$totVQty' WHERE vName = '$vName'";

        if (mysqli_query($conn, $updateVSql)) {
            $minusPSql = "SELECT * FROM rawmtbl WHERE pName = '$pName'";
            $minusPResult = mysqli_query($conn, $minusPSql);
            $minusPRow = mysqli_fetch_assoc($minusPResult);

            $pQty2 = $minusPRow['pQuantity'];

            $totPQty = (int) $pQty2 - $quantity;

            $updatePSql = "UPDATE rawmtbl SET pQuantity = '$totPQty' WHERE pName = '$pName'";

            if (mysqli_query($conn, $updatePSql)) {
                echo "<script>
                    alert('Item added to cart successfully!');
                    window.location.href = 'customizecart.php';
                </script>";
            }
        }

    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}





ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Uncomment below lines to debug POST data if needed
    // var_dump($_POST);
    // exit;

    $cpNum = $_SESSION['cpNum'];
    $fullName = $_SESSION['fullName'];
    $address = $_SESSION['address'];
    $userID = $_SESSION['userID'];

    $pName = $_POST['products'];
    $prodDetails = $_POST['productDetails'];
    $totalCost = $_POST['totalCost'];
    $balance = $totalCost;
    $quantity = $_POST['quantities'];
    $width = $_POST['width'];
    $length = $_POST['length'];
    $height = $_POST['height'];
    $payment = $_POST['payment'];
    $amountPaid = $_POST['amountPaid'];
    $refNo = $_POST['refNo'];

    $qrImagePath = '';
    $image = '';

    $uploadDir = 'up/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // QR Image upload
    if (isset($_FILES['qrImage']) && $_FILES['qrImage']['error'] === UPLOAD_ERR_OK) {
        $qrExt = pathinfo($_FILES['qrImage']['name'], PATHINFO_EXTENSION);
        $qrFileName = uniqid('qr_', true) . '.' . $qrExt;
        $qrFilePath = $uploadDir . $qrFileName;

        if (move_uploaded_file($_FILES['qrImage']['tmp_name'], $qrFilePath)) {
            $qrImagePath = $qrFilePath;
        } else {
            echo "Error uploading QR image.";
            exit;
        }
    }

    // Main image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $mainExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $mainFileName = uniqid('img_', true) . '.' . $mainExt;
        $mainFilePath = $uploadDir . $mainFileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $mainFilePath)) {
            $image = $mainFilePath;
        } else {
            echo "Error uploading the main image.";
            exit;
        }
    } else {
        echo "No main image uploaded or an error occurred.";
        exit;
    }

    // Insert into checkoutcustom
    $stmt = $conn->prepare("INSERT INTO checkoutcustom (userID, pName, image, prodDetails, totalCost, fullName, address, cpNum, quantity, balance, proofPay, width, length, height, payment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssssss", $userID, $pName, $image, $prodDetails, $totalCost, $fullName, $address, $cpNum, $quantity, $balance, $qrImagePath, $width, $length, $height, $payment);

    if ($stmt->execute()) {
        $orderID = $conn->insert_id;
        $paymentSource = 'checkoutcustom';
        $paymentDate = date("Y-m-d H:i:s");

        $receiptStmt = $conn->prepare("INSERT INTO payment_receipts (orderID, userID, source, productName, amountPaid, proofImage, ref_no, paymentDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $receiptStmt->bind_param("iissssss", $orderID, $userID, $paymentSource, $pName, $amountPaid, $qrImagePath, $refNo, $paymentDate);
        $receiptStmt->execute();
        $receiptStmt->close();

        $_SESSION['order_success'] = true;

        header("Location: profile.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "Checkout button not clicked.";
}

ob_end_flush();

?>