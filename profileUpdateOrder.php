<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['orderID']) && isset($_POST['source']) && isset($_POST['status'])) {
        $orderID = $_POST['orderID'];
        $source = $_POST['source'];
        $status = $_POST['status'];

        if ($source == 'checkout') {
            $sql = "UPDATE checkout SET status = ? WHERE orderID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $status, $orderID); // bind status as string and orderID as integer
        } elseif ($source == 'checkoutcustom') {
            $sql = "UPDATE checkoutcustom SET status = ? WHERE orderID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $status, $orderID); // bind status as string and orderID as integer
        }

        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
}
?>