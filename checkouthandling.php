<?php
session_start();

include("database.php");
include("checkoutmodal.php");

$userid = $_GET['userid'];
$sqls = "SELECT * FROM furnituretbl WHERE fID = '$userid'";
$resu = mysqli_query($conn, $sqls);
$row = mysqli_fetch_assoc($resu);

$sqlc = "SELECT * FROM furnituretbl WHERE fID = '$userid'";
$resus = mysqli_query($conn, $sqlc);
$rows = mysqli_fetch_assoc($resus);

$sqls = "SELECT * FROM furnituretbl WHERE fID = '$userid'";
$resu = mysqli_query($conn, $sqls);
$rows = mysqli_fetch_assoc($resu);
$number = $rows['cost'];
$formattedNumber = number_format($number, 0, '.', ',');
$cost = $formattedNumber;

$sqlc = "SELECT * FROM furnituretbl WHERE fID = '$userid'";
$resus = mysqli_query($conn, $sqlc);
$rows = mysqli_fetch_assoc($resus);


if (isset($_POST['place'])) {
    $name = $_SESSION['fullName'];
    $address = $_SESSION['address'];
    $contact = $_SESSION['cpNum'];
    $prodname = $rows['fName'];
    $date = date('Y-m-d');
    $stat = "On Queue";


    $sql2 = "INSERT INTO checkout (orderID, fullName, address, cpNum, prodName, cost, date, status )
    VALUES ('$userid','$name', '$address', '$contact', '$prodname', '$cost' , '$date' , '$stat')";

}
?>