<?php
include("database.php");

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    $date = date('Y-m-d');


    $sql_insert = "INSERT INTO reviewtbl (fullName, email, comment,  date) 
                           VALUES (?, ?, ?, ?)";

    if ($stmt_insert = $conn->prepare($sql_insert)) {
        $stmt_insert->bind_param("ssds", $name, $email, $comment, $date);

        if ($stmt_insert->execute()) {
            header("Location: shop-detail.php");
            exit();
        } else {
            echo "Error: " . $stmt_insert->error;
        }
    }
}
?>