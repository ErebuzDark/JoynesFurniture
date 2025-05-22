<?php

$msg = "hide";
// Create connection
include("database.php");

//This function has a process to add all the elements of drinks
if (isset($_POST['submit']) && isset($_FILES['Image'])) {
  $fID = $_SESSION['fID'];
  $furName = $_POST['fName'];
  $quantity = $_POST['fQuantity'];
  $cat = $_POST['category'];
  $des = $_POST['fDes'];
  $cost = $_POST['cost'];
  $date = date('Y-m-d');
  $filename = $_FILES["Image"]["name"];
  $tempname = $_FILES["Image"]["tmp_name"];
  $folder = "./up/" . $filename;
  $width = $_POST['width'];
  $length = $_POST['length'];
  $height = $_POST['height'];


  $sql = "INSERT INTO furnituretbl (fName, category, Image, fQuantity, fDes, cost, date, width, length, height) 
    VALUES ('$furName', '$cat', '$filename', '$quantity', '$des', '$cost', '$date','$width','$length','$height')";

  if (mysqli_query($conn, $sql)) {
    echo "<script>succes!!</script>";
    $msg = "show";
    move_uploaded_file($tempname, $folder);
    header("Location: tables.php");
    exit();
  }

}
$furnituresql = "SELECT * FROM furnituretbl ORDER BY fID DESC";
$furnitureresult = mysqli_query($conn, $furnituresql);

?>