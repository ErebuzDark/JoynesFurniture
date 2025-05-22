<?php
include('database.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM varnishtbl WHERE ID = '$id'";
    if (mysqli_query($conn, $sql)) {
        $msg = "show";
        header("Location: rawtable.php");
        exit();
    }
}
?>