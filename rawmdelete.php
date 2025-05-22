<?php
include('database.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM rawmtbl WHERE pID = '$id'";
    if (mysqli_query($conn, $sql)) {
        $msg = "show";
        header("Location: rawtable.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sample</title>
    <link rel="stylesheet" href="samples.css">
</head>

<body>
    <center>
        <h1 class="bg-success <?php echo $msg; ?>">Successfully Added!</h1>
    </center>
</body>

</html>