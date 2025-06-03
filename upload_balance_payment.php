<?php
include "database.php";
session_start();

$orderID = $_POST['orderID'];
$userID = $_POST['userID'];
$prodName = $_POST['prodName'];
$source = $_POST['source'];
$balanceAmount = $_POST['balanceAmount'];
$refNo = trim($_POST['refNo']);
$amountPaid = $_POST['amountPaid'];
$date = date("Y-m-d H:i:s");

// Check if reference number already exists
$refCheck = $conn->prepare("SELECT COUNT(*) FROM payment_receipts WHERE ref_no = ?");
$refCheck->bind_param("s", $refNo);
$refCheck->execute();
$refCheck->bind_result($refExists);
$refCheck->fetch();
$refCheck->close();

if ($refExists > 0) {
    $_SESSION['swal_status'] = 'error';
    $_SESSION['swal_title'] = 'Duplicate Reference!';
    $_SESSION['swal_text'] = 'This reference number has already been used.';
    header("Location: profile.php");
    exit;
}

// Count existing uploads excluding 'invalid' or 'refunded' statuses
$stmt = $conn->prepare("SELECT COUNT(*) FROM payment_receipts WHERE orderID = ? AND userID = ? AND source = ? AND payment_status NOT IN ('invalid', 'refunded')");
$stmt->bind_param("iis", $orderID, $userID, $source);
$stmt->execute();
$stmt->bind_result($uploadCount);
$stmt->fetch();
$stmt->close();

if ($uploadCount >= 3) {
    $_SESSION['swal_status'] = 'error';
    $_SESSION['swal_title'] = 'Upload limit reached!';
    $_SESSION['swal_text'] = 'You can only upload your payment receipt 3 times.';
    header("Location: profile.php");
    exit;
}

if (isset($_FILES['paymentImage']) && $_FILES['paymentImage']['error'] == 0) {
    $fileName = basename($_FILES["paymentImage"]["name"]);
    $targetDir = "up/";
    $targetFile = $targetDir . time() . "_" . $fileName;

    if (move_uploaded_file($_FILES["paymentImage"]["tmp_name"], $targetFile)) {
        // Insert payment receipt with default status (e.g., 'pending' or 'confirmed')
        $defaultStatus = 'pending'; // or 'confirmed', adjust if needed
        $stmt = $conn->prepare("INSERT INTO payment_receipts (orderID, userID, source, productName, amountPaid, proofImage, ref_no, paymentDate, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssssss", $orderID, $userID, $source, $prodName, $amountPaid, $targetFile, $refNo, $date, $defaultStatus);
        $stmt->execute();
        $stmt->close();

        $_SESSION['swal_status'] = 'success';
        $_SESSION['swal_title'] = 'Payment uploaded!';
        $_SESSION['swal_text'] = 'Your payment receipt has been submitted.';
    } else {
        $_SESSION['swal_status'] = 'error';
        $_SESSION['swal_title'] = 'Upload Failed!';
        $_SESSION['swal_text'] = 'Error uploading the image.';
    }
} else {
    $_SESSION['swal_status'] = 'error';
    $_SESSION['swal_title'] = 'Upload Failed!';
    $_SESSION['swal_text'] = 'No image uploaded.';
}

header("Location: profile.php");
exit;
?>
