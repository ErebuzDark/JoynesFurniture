<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['ID'];
    $action = $_POST['action'];

    // Fetch current quantity
    $query = "SELECT quantity FROM addcart WHERE ID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $quantity = (int)$row['quantity'];

    if ($action === 'plus') {
        $quantity++;
    } elseif ($action === 'minus' && $quantity > 1) {
        $quantity--;
    }

    $update = "UPDATE addcart SET quantity = ? WHERE ID = ?";
    $stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($stmt, 'ii', $quantity, $id);
    mysqli_stmt_execute($stmt);

    header('Location: cart.php');
    exit();
}
