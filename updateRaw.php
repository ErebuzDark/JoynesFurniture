<?php
session_start();
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rawID = mysqli_real_escape_string($conn, $_POST['rawID']);
    $rawName = mysqli_real_escape_string($conn, $_POST['rawName']);
    $rawQuantity = mysqli_real_escape_string($conn, $_POST['rawQuantity']);
    $rawPrice = mysqli_real_escape_string($conn, $_POST['rawPrice']);
    $rawDescription = mysqli_real_escape_string($conn, $_POST['rawDescription']);
    $rawImage = $_FILES['rawImage']['name'];

    if ($rawImage != "") {
        $target_dir = "./up/";
        $target_file = $target_dir . basename($_FILES["rawImage"]["name"]);

        if (move_uploaded_file($_FILES["rawImage"]["tmp_name"], $target_file)) {
            $sql = "UPDATE rawmtbl SET pName = '$rawName', pQuantity = '$rawQuantity', pCost = '$rawPrice', pDes = '$rawDescription', image = '$rawImage' WHERE pID = '$rawID'";
        }
    } else {
        $sql = "UPDATE rawmtbl SET pName = '$rawName', pQuantity = '$rawQuantity', pCost = '$rawPrice', pDes = '$rawDescription' WHERE pID = '$rawID'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Updated successfully.'); window.location.href = 'rawtable.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>