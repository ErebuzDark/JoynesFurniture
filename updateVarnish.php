<?php
session_start();
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $varnishID = mysqli_real_escape_string($conn, $_POST['varnishID']);
    $varnishName = mysqli_real_escape_string($conn, $_POST['varnishName']);
    $varnishQuantity = mysqli_real_escape_string($conn, $_POST['varnishQuantity']);
    $varnishPrice = mysqli_real_escape_string($conn, $_POST['varnishPrice']);
    $varnishDescription = mysqli_real_escape_string($conn, $_POST['varnishDescription']);
    $varnishImage = $_FILES['varnishImage']['name'];

    if ($varnishImage != "") {
        $target_dir = "./up/";
        $target_file = $target_dir . basename($_FILES["varnishImage"]["name"]);

        if (move_uploaded_file($_FILES["varnishImage"]["tmp_name"], $target_file)) {
            $sql = "UPDATE varnishtbl SET vName = '$varnishName', vQuantity = '$varnishQuantity', cost = '$varnishPrice', vDes = '$varnishDescription', image = '$varnishImage' WHERE ID = '$varnishID'";
        }
    } else {
        $sql = "UPDATE varnishtbl SET vName = '$varnishName', vQuantity = '$varnishQuantity', cost = '$varnishPrice', vDes = '$varnishDescription' WHERE ID = '$varnishID'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Updated successfully.'); window.location.href = 'rawtable.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>