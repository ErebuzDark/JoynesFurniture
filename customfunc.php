<?php
session_start();
include("database.php");

$userID = $_SESSION['userID'];

$i = 0;

// Fetch items in the cart
$sql5 = "SELECT COUNT(*) FROM addcart";
$result5 = mysqli_query($conn, $sql5);
$row5 = mysqli_fetch_assoc($result5);

$sql4 = "SELECT COUNT(*) FROM addcartcustom";
$result4 = mysqli_query($conn, $sql4);
$row4 = mysqli_fetch_assoc($result4);

$i = $row5['COUNT(*)'] + $row4['COUNT(*)'];

// Fetch raw materials and varnishes
$rawsql = "SELECT * FROM rawmtbl";
$rawresult = mysqli_query($conn, $rawsql);

$varsql = "SELECT * FROM varnishtbl";
$varresult = mysqli_query($conn, $varsql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user session details
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $name = $_SESSION['fullName'] ?? '';
    $address = $_SESSION['address'] ?? '';
    $contact = $_SESSION['cpNum'] ?? '';
    $date = date('Y-m-d');
    $stat = "On Queue";

    // Fetch first varnish cost and ID
    $varsql1 = "SELECT * FROM varnishtbl";
    $varresult1 = mysqli_query($conn, $varsql1);
    $row1 = mysqli_fetch_assoc($varresult1);

    $rawsql1 = "SELECT * FROM rawmtbl ";
    $rawresult1 = mysqli_query($conn, $rawsql1);
    $row5 = mysqli_fetch_assoc($rawresult1);

    // Proceed if the necessary data is available
    if ($row1 && $row5) {
        $woodName = isset($_POST['pName']) ? implode(", ", $_POST['pName']) : '';
        $varnishName = isset($_POST['vName']) ? implode(", ", $_POST['vName']) : '';

        // Check if an image is uploaded
        if (isset($_FILES["image"]["name"]) && $_FILES["image"]["tmp_name"]) {
            $filename = $_FILES["image"]["name"];
            $tempname = $_FILES["image"]["tmp_name"];
            $folder = "./up/" . $filename;

            // Read the image file's binary data
            $imageData = file_get_contents($tempname);  // Read the file into a binary string

            $vcost = $row1['cost'];
            $wcost = $row5['pCost'];

            $total = $row1['cost'] + $row5['pCost'];
            $finaltot = $total * $quantity;

            // Insert into customcheck if 'checkout' is clicked
            if (isset($_POST['check'])) {
                $stmt = $conn->prepare("INSERT INTO customcheck (image, fullName, address, cpNum, woodname, varnishname, quantity, cost, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssissiiss", $filename, $name, $address, $contact, $woodName, $varnishName, $quantity, $finaltot, $date, $stat);
                if ($stmt->execute()) {

                    echo "Items added to cart successfully!";
                    header("Location: customize.php");
                    exit();

                }

            }
            // Insert into add table if 'addcart' is clicked
            elseif (isset($_POST['add'])) {
                // Prepare data from form

                $quantity = $_POST['quantity'];
                $date = date('Y-m-d');

                // Ensure fID and quantity are valid


                // Fetch item details from furniture
                $stmt = $conn->prepare("SELECT * FROM varnishtbl WHERE ID = ?");
                $stmt->bind_param("i", $ID);
                $stmt->execute();
                $result2 = $stmt->get_result();
                $row = $result2->fetch_assoc();
                $ID = $row['ID'];

                $stmt = $conn->prepare("SELECT * FROM rawmtbl WHERE pID = ?");
                $stmt->bind_param("i", $pID);
                $stmt->execute();
                $result0 = $stmt->get_result();
                $row1 = $result0->fetch_assoc();

                // Fetch existing cart quantity for the item
                $stmtQuan = $conn->prepare("SELECT quantity FROM addcart WHERE ID = ?");
                $stmtQuan->bind_param("i", $ID);
                $stmtQuan->execute();
                $resultquan = $stmtQuan->get_result();



                // Ensure the user is logged in
                $userID = $_SESSION['userID'] ?? null;
                if (!$userID) {
                    header("location: index.php");
                    exit();
                }

                // Insert new item into cart or update existing
                else {
                    // New item, insert into cart
                    $stmt = "INSERT INTO addcartcustom (ID, userID, prodName, image, quantity, cost, date) VALUES ('$ID','$userID', CONCAT('$woodName', ', ', '$varnishName'), '$filename', '$quantity', '$finaltot', '$date')";

                    if (mysqli_query($conn, $stmt)) {

                        $msg = "show";
                        move_uploaded_file($tempname, $folder);
                        header("Location: customizecart.php");
                        exit();

                    }
                }

                // Update furniture stock
                $stmtUpdateStock = $conn->prepare("UPDATE varnishtbl SET vQuantity = vQuantity - ? WHERE ID = ?");
                $stmtUpdateStock->bind_param("ii", $quantity, $ID);
                $stmtUpdateStock->execute();
                $stmtUpdateStock = $conn->prepare("UPDATE rawmtbl SET pQuantity = pQuantity - ? WHERE pID = ?");
                $stmtUpdateStock->bind_param("ii", $quantity, $pID);
                $stmtUpdateStock->execute();
            } else {
                // handle the case where the variable is null or not an array
                echo "Variable is not set or not an array";
            }
        } else {
            echo "No image uploaded!";
        }
    } else {
        echo "Error fetching varnish or raw material data!";
    }
}


?>