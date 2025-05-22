<?php

$msg = "hide";
// Create connection
include("database.php");

//This function has a process to add all the elements of drinks
if (isset($_POST['submit']) && isset($_FILES['image'])) {

  $vName = $_POST['vName'];
  $quantity = $_POST['vQuantity'];
  $des = $_POST['vDes'];
  $cost = $_POST['cost'];
  $date = date('Y-m-d');
  $filename = $_FILES["image"]["name"];
  $tempname = $_FILES["image"]["tmp_name"];
  $folder = "./up/" . $filename;


  $sql = "INSERT INTO varnishtbl (vName, Image, vQuantity, vDes, cost, date) 
    VALUES ('$vName', '$filename', '$quantity', '$des', '$cost', '$date')";

  if (mysqli_query($conn, $sql)) {
    echo "<script>succes!!</script>";
    $msg = "show";
    move_uploaded_file($tempname, $folder);
    header("Location: rawtable.php");
    exit();
  }

}
?>