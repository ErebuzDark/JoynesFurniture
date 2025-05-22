<?php
session_start();
include('./database.php');

$userID = $_SESSION['userID'];

if (isset($_POST['action']) && isset($_POST['ID'])) {
    $id = $_POST['ID'];
    $action = $_POST['action'];

    $furnitureSql = "SELECT * FROM furnituretbl WHERE fID = '$id'";
    $furnitureResult = mysqli_query($conn, $furnitureSql);
    $furnitureRow = mysqli_fetch_assoc($furnitureResult);

    $origCost = $furnitureRow['cost'];
    $furnitureQuantity = $furnitureRow['fQuantity'];

    $cartSql = "SELECT * FROM addcart WHERE ID = '$id' AND userID = '$userID'";
    $cartResult = mysqli_query($conn, $cartSql);
    $cartRow = mysqli_fetch_assoc($cartResult);

    $quantity = $cartRow['quantity'];

    if ($action === "plus") {
        if ($furnitureQuantity > $quantity) {
            $quantity++;
        }

        else {
            echo "<script>window.location.href='./cart.php'</script>";
        }
    } else if ($action === "minus" && $quantity > 1) {
        $quantity--;
    }

    $totPrice = $quantity * $origCost;

    $sql = "UPDATE addcart SET quantity = '$quantity', cost = '$totPrice' WHERE ID = '$id' AND userID = '$userID'";

    if (mysqli_query($conn, $sql)) {
        // Refresh the page to reflect updates
        echo "<script>window.location.href='./cart.php'</script>";
    }
}
?>