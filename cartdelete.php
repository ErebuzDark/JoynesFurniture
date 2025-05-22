<?php
include("database.php");



if (isset($_GET['ID'])) {
    $id = $_GET['ID'];



    $sql1 = "DELETE FROM addcartcustom WHERE ID = '$id'";
    if (mysqli_query($conn, $sql1)) {
        header("Location: customizecart.php");
        exit();
    }

}
if (isset($_GET['id'])) {
    $id = $_GET['id'];



    $sql1 = "DELETE FROM addcart WHERE ID = '$id'";
    if (mysqli_query($conn, $sql1)) {
        header("Location: cart.php");
        exit();
    }

}

if (isset($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];



    $sql1 = "DELETE FROM tbl_cartcus WHERE cart_id = '$cart_id'";
    if (mysqli_query($conn, $sql1)) {
        header("Location: customizecart.php");
        exit();
    }

}
?>