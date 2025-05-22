<?php
session_start();
include("database.php");

$i = 0;
$q = 0;
$text = array();

$userID = $_SESSION['userID'];
$sql5 = "SELECT COUNT(*) FROM addcart WHERE userID = '$userID'";
$result5 = mysqli_query($conn, $sql5);
$row5 = mysqli_fetch_assoc($result5);
$i = $row5['COUNT(*)'];

$userID = $_SESSION['userID'];
$sqluse = "SELECT * FROM addcart WHERE userID = ?";
$stmt = $conn->prepare($sqluse);
$stmt->bind_param('i', $userID);
$stmt->execute();
$resultu = $stmt->get_result();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql5 = "SELECT quantity FROM addcart WHERE ID = ? AND userID = ?";
    $stmt = $conn->prepare($sql5);
    $stmt->bind_param('ii', $id, $userID);
    $stmt->execute();
    $result5 = $stmt->get_result();
    $row5 = $result5->fetch_assoc();

    $sqlcart = "SELECT * FROM addcart WHERE userID = ?";
    $stmt = $conn->prepare($sqlcart);
    $stmt->bind_param('i', $userID);
    $stmt->execute();
    $resultcart = $stmt->get_result();

    while ($row = mysqli_fetch_assoc($resultcart)) {
        $text[] = $row['prodName'];
    }

    $t = implode(", ", $text);

    $sql_furniture = "SELECT cost FROM furnituretbl WHERE fID = ?";
    $stmt_furniture = $conn->prepare($sql_furniture);
    $stmt_furniture->bind_param('i', $orderID);
    $stmt_furniture->execute();
    $result_furniture = $stmt_furniture->get_result();
    $row_furniture = $result_furniture->fetch_assoc();

    $sql_selectimg = "SELECT * FROM addcart WHERE ID = ?";
    $stmt_selectimg = $conn->prepare($sql_selectimg);
    $stmt_selectimg->bind_param("i", $orderID);
    $stmt_selectimg->execute();
    $result2 = $stmt_selectimg->get_result();
    $row = $result2->fetch_assoc();

    if ($row_furniture) {
        $cost = $row_furniture['cost'];
    } else {
        // echo "<script>alert('No matching cost found for the given orderID.');</script>";
        $cost = 0;
    }

    if (isset($_POST['submit'])) {
        $orderID = $_POST['orderID'];
        $fullName = $_POST['fullName'];
        $address = $_POST['address'];
        $cpNum = $_POST['cpNum'];
        $date = $_POST['date'];
        $status = $_POST['status'];
        $img = $_POST['image'];

        $sql_insert = "INSERT INTO checkout (orderID, fullName, address, cpNum, image, prodName, cost, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ? , ?)";

        if ($stmt_insert = $conn->prepare($sql_insert)) {
            $stmt_insert->bind_param("isssssdss", $orderID, $fullName, $address, $cpNum, $img, $t, $cost, $date, $status);

            if ($stmt_insert->execute()) {
                echo "<script>alert('Order placed successfully!');</script>";
                header("Location: shop.php");
                exit();
            } else {
                echo "Error: " . $stmt_insert->error;
            }

            $stmt_insert->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }
}

?>