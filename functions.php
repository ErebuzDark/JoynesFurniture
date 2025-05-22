<?php
session_start();
include("database.php");

$i = 0;
$start = 0;
$per_page = 9;
$all = 0;
$mir = 0;
$cab = 0;
$cha = 0;
$tab = 0;
$bed = 0;
$sala = 0;
$tvs = 0;



$result = $conn->query("SELECT * FROM furnituretbl WHERE category = 'mirror' ORDER BY fID DESC");
$rec = $result->num_rows;
$pages = ceil($rec / $per_page);

$result = $conn->query("SELECT * FROM furnituretbl WHERE category = 'cabinet' ORDER BY fID DESC");
$rec = $result->num_rows;
$pages = ceil($rec / $per_page);

$result = $conn->query("SELECT * FROM furnituretbl WHERE category = 'chair' ORDER BY fID DESC");
$rec = $result->num_rows;
$pages = ceil($rec / $per_page);

$result = $conn->query("SELECT * FROM furnituretbl WHERE category = 'table' ORDER BY fID DESC");
$rec = $result->num_rows;
$pages = ceil($rec / $per_page);

$result = $conn->query("SELECT * FROM furnituretbl WHERE category = 'bed' ORDER BY fID DESC");
$rec = $result->num_rows;
$pages = ceil($rec / $per_page);

$result = $conn->query("SELECT * FROM furnituretbl WHERE category = 'sala' ORDER BY fID DESC");
$rec = $result->num_rows;
$pages = ceil($rec / $per_page);

$result = $conn->query("SELECT * FROM furnituretbl WHERE category = 'tv' ORDER BY fID DESC");
$rec = $result->num_rows;
$pages = ceil($rec / $per_page);

if (isset($_GET['page-nr'])) {

    $page = $_GET['page-nr'] - 1;
    $start = $page * $per_page;
}

$sqlm = "SELECT * FROM furnituretbl WHERE category = 'mirror' ORDER BY fID DESC LIMIT $start, $per_page";
$mirror = mysqli_query($conn, $sqlm);

$sqlc = "SELECT * FROM furnituretbl WHERE category = 'cabinet' ORDER BY fID DESC LIMIT $start, $per_page";
$cabinet = mysqli_query($conn, $sqlc);

$sqlch = "SELECT * FROM furnituretbl WHERE category = 'chair' ORDER BY fID DESC LIMIT $start, $per_page";
$chair = mysqli_query($conn, $sqlch);

$sqltbl = "SELECT * FROM furnituretbl WHERE category = 'table' ORDER BY fID DESC LIMIT $start, $per_page";
$table = mysqli_query($conn, $sqltbl);

$sqlb = "SELECT * FROM furnituretbl WHERE category = 'bed' ORDER BY fID DESC LIMIT $start, $per_page";
$bedframe = mysqli_query($conn, $sqlb);

$sqlss = "SELECT * FROM furnituretbl WHERE category = 'sala' ORDER BY fID DESC LIMIT $start, $per_page";
$sala = mysqli_query($conn, $sqlss);

$sqlt = "SELECT * FROM furnituretbl WHERE category = 'tv' ORDER BY fID DESC LIMIT $start, $per_page";
$tv = mysqli_query($conn, $sqlt);


$userID = $_SESSION['userID'];
$sql5 = "SELECT COUNT(*) FROM addcart WHERE userID = '$userID'";
$result5 = mysqli_query($conn, $sql5);
$row5 = mysqli_fetch_assoc($result5);
$i = $row5['COUNT(*)'];

$sqlmir = "SELECT * FROM furnituretbl WHERE category = 'mirror' ORDER BY fID DESC";
$resultmir = mysqli_query($conn, $sqlmir);
$row5 = mysqli_num_rows($resultmir);
$mir = $row5;

$sqlcab = "SELECT * FROM furnituretbl WHERE category = 'cabinet' ORDER BY fID DESC";
$resultcab = mysqli_query($conn, $sqlcab);
$row5 = mysqli_num_rows($resultcab);
$cab = $row5;

$sqlch = "SELECT * FROM furnituretbl WHERE category = 'chair' ORDER BY fID DESC";
$resultch = mysqli_query($conn, $sqlch);
$row5 = mysqli_num_rows($resultch);
$ch = $row5;

$sqltbl = "SELECT * FROM furnituretbl WHERE category = 'table' ORDER BY fID DESC";
$resulttbl = mysqli_query($conn, $sqltbl);
$row5 = mysqli_num_rows($resulttbl);
$tab = $row5;

$sqlb = "SELECT * FROM furnituretbl WHERE category = 'bed' ORDER BY fID DESC";
$resultbed = mysqli_query($conn, $sqlb);
$row5 = mysqli_num_rows($resultbed);
$bed = $row5;

$sqlss = "SELECT * FROM furnituretbl WHERE category = 'sala' ORDER BY fID DESC";
$resultss = mysqli_query($conn, $sqlss);
$row5 = mysqli_num_rows($resultss);
$sala = $row5;

$sqlt = "SELECT * FROM furnituretbl WHERE category = 'tv' ORDER BY fID DESC";
$resulttv = mysqli_query($conn, $sqlt);
$row5 = mysqli_num_rows($resulttv);
$tvs = $row5;

$sqlq = "SELECT * FROM furnituretbl ORDER BY fID DESC";
$resultq = mysqli_query($conn, $sqlq);
$row5 = mysqli_num_rows($resultq);
$all = $row5;

$result = $conn->query("SELECT * FROM furnituretbl ORDER BY fID DESC");
$rec = $result->num_rows;
$pages = ceil($rec / $per_page);

$result1 = $conn->query("SELECT * FROM furnituretbl WHERE category = 'mirror' ORDER BY fID DESC");
$rec1 = $result1->num_rows;
$pages1 = ceil($rec1 / $per_page);

$result2 = $conn->query("SELECT * FROM furnituretbl WHERE category = 'cabinet' ORDER BY fID DESC");
$rec2 = $result2->num_rows;
$pages2 = ceil($rec2 / $per_page); // Fixed variable name

$result3 = $conn->query("SELECT * FROM furnituretbl WHERE category = 'chair' ORDER BY fID DESC");
$rec3 = $result3->num_rows;
$pages3 = ceil($rec3 / $per_page); // Fixed variable name

$result4 = $conn->query("SELECT * FROM furnituretbl WHERE category = 'table' ORDER BY fID DESC");
$rec4 = $result4->num_rows;
$pages4 = ceil($rec4 / $per_page); // Fixed variable name

$result5 = $conn->query("SELECT * FROM furnituretbl WHERE category = 'bed' ORDER BY fID DESC");
$rec5 = $result5->num_rows;
$pages5 = ceil($rec5 / $per_page); // Fixed variable name

$result6 = $conn->query("SELECT * FROM furnituretbl WHERE category = 'sala' ORDER BY fID DESC");
$rec6 = $result6->num_rows;
$pages6 = ceil($rec6 / $per_page); // Fixed variable name

$result7 = $conn->query("SELECT * FROM furnituretbl WHERE category = 'tv' ORDER BY fID DESC");
$rec7 = $result7->num_rows;
$pages7 = ceil($rec7 / $per_page); // Fixed variable name

$sql = "SELECT * FROM furnituretbl WHERE category = 'mirror' ORDER BY fID DESC LIMIT $start, $per_page";
$res = mysqli_query($conn, $sql);



if (isset($_GET['page-nr'])) {

    $page = $_GET['page-nr'] - 1;
    $start = $page * $per_page;
}

$furniture = "SELECT * FROM furnituretbl ORDER BY fID DESC LIMIT  $start, $per_page";
$furResult = mysqli_query($conn, $furniture);

$furnituredis = "SELECT * FROM furnituretbl ORDER BY fID DESC LIMIT 0, 8";
$furResultdis = mysqli_query($conn, $furnituredis);

$furniturenew = "SELECT * FROM furnituretbl ORDER BY fID DESC LIMIT 0, 8";
$furResultnew = mysqli_query($conn, $furniturenew);

if ($_SERVER["REQUEST_METHOD"] == "POST") {



    // Handling Add to Cart action
    if (isset($_POST['add'])) {
        // Prepare data from form
        $fID = $_POST['id'];
        $quantity = $_POST['quantity'];
        $date = date('Y-m-d');

        // Ensure fID and quantity are valid
        if (!is_numeric($fID) || !is_numeric($quantity) || $quantity <= 0) {
            die("Invalid input.");
        }

        // Fetch item details from furniture
        $stmt = $conn->prepare("SELECT * FROM furnituretbl WHERE fID = ?");
        $stmt->bind_param("i", $fID);
        $stmt->execute();
        $result2 = $stmt->get_result();
        $row = $result2->fetch_assoc();

        // Fetch existing cart quantity for the item
        $stmtQuan = $conn->prepare("SELECT quantity FROM addcart WHERE ID = ?");
        $stmtQuan->bind_param("i", $fID);
        $stmtQuan->execute();
        $resultquan = $stmtQuan->get_result();

        // Calculate total price
        $s = $row['cost'];
        $img = $row['image'];
        $name = $row['fName'];
        $total = $s * $quantity;
        $width = $row['width'];
        $length = $row['length'];
        $height = $row['height'];

        // Ensure the user is logged in
        $userID = $_SESSION['userID'] ?? null;
        if (!$userID) {
            header("location: index.php");
            exit();
        }

        // Insert new item into cart or update existing
        if (mysqli_num_rows($resultquan) > 0) {
            // Item exists, update cart
            $row6 = $resultquan->fetch_assoc();
            $quan = $row6['quantity'];
            $quant = $quan + $quantity;

            // Check if total quantity exceeds available stock
            if ($quant > $row['fQuantity']) {
                // Prevent adding more than available stock
                // Redirect back or show error (here redirecting back to shop-detail.php)
                header("Location: shop-detail.php?id=$fID&error=exceed");
                exit();
            }

            $total = $s * $quant;

            $stmtUpdateCart = $conn->prepare("UPDATE addcart SET quantity = ?, cost = ? WHERE ID = ? && userID = ?");
            $stmtUpdateCart->bind_param("idii", $quant, $total, $fID, $userID);
            $stmtUpdateCart->execute();
            if ($stmtUpdateCart->execute()) {
                header("Location: cart.php");
                exit();
            }
        } else {
            // New item, insert into cart

            // Check if requested quantity exceeds available stock
            if ($quantity > $row['fQuantity']) {
                // Prevent adding more than available stock
                header("Location: shop-detail.php?id=$fID&error=exceed");
                exit();
            }

            $stmtAddToCart = $conn->prepare("INSERT INTO addcart (ID, userID, prodName, image, quantity, cost, date, width, length, height) VALUES (?, ?, ?, ?, ?, ?, ?,?,?,?)");
            $stmtAddToCart->bind_param("iissdisddd", $fID, $userID, $name, $img, $quantity, $total, $date, $width, $length, $height);
            if ($stmtAddToCart->execute()) {
                header("Location: cart.php");
                exit();
            }
        }

        // Update furniture stock
        $stmtUpdateStock = $conn->prepare("UPDATE furnituretbl SET fQuantity = fQuantity - ? WHERE fID = ?");
        $stmtUpdateStock->bind_param("ii", $quantity, $fID);
        $stmtUpdateStock->execute();
        $result = $stmtUpdateStock->get_result();

        if ($row = $result->fetch_assoc()) {
            $_SESSION['ID'] = $row['fID'];

        }
        ;
    }



    // Handling Checkout action
    if (isset($_POST['check'])) {
        $fID = $_POST['id'] ?? null;
        $quantity = $_POST['quantity'] ?? 0;

        if (!is_numeric($fID) || !is_numeric($quantity) || $quantity <= 0) {
            die("Invalid input.");
        }

        // Handle checkout logic (you may need additional logic here)
        $date = date('Y-m-d');
        $stmt = $conn->prepare("SELECT * FROM furnituretbl WHERE fID = ?");
        $stmt->bind_param("i", $fID);
        $stmt->execute();
        $result2 = $stmt->get_result();
        $row = $result2->fetch_assoc();

        if (!$row) {
            die("Item not found.");
        }

        $s = $row['cost'];
        $img = $row['image'];
        $name = $row['fName'];
        $total = $s * $quantity;

        $userID = $_SESSION['userID'] ?? null;
        if (!$userID) {
            header("location: index.php");
            exit();
        }

        // Insert item into checkout table
        $stmtAddToCheckout = $conn->prepare("INSERT INTO addtbl (ID, prodName, image, quantity, cost, date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmtAddToCheckout->bind_param("issdis", $fID, $name, $img, $quantity, $total, $date);

        if ($stmtAddToCheckout->execute()) {
            header("Location: checkoutex.php");
            exit();
        }
    }
}
?>