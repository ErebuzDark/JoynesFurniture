<?php
session_start();
include("database.php");
$i = 0;
$start = 0;
$per_page = 9;
$all = 0;
$cab = 0;
$mir = 0;
$cha = 0;
$tab = 0;
$bed = 0;
$sala = 0;
$tvs = 0;



$result1 = $conn->query("SELECT * FROM furnituretbl WHERE category = 'mirror'");
$rec1 = $result1->num_rows;
$pages1 = ceil($rec1 / $per_page);

$result2 = $conn->query("SELECT * FROM furnituretbl WHERE category = 'cabinet'");
$rec2 = $result2->num_rows;
$pages2 = ceil($rec2 / $per_page);

$result3 = $conn->query("SELECT * FROM furnituretbl WHERE category = 'chair'");
$rec3 = $result3->num_rows;
$pages3 = ceil($rec3 / $per_page);

$result4 = $conn->query("SELECT * FROM furnituretbl WHERE category = 'table'");
$rec4 = $result4->num_rows;
$pages4 = ceil($rec4 / $per_page);

$result5 = $conn->query("SELECT * FROM furnituretbl WHERE category = 'bed'");
$rec5 = $result5->num_rows;
$pages5 = ceil($rec5 / $per_page);

$result6 = $conn->query("SELECT * FROM furnituretbl WHERE category = 'sala'");
$rec6 = $result6->num_rows;
$pages6 = ceil($rec6 / $per_page);

$result7 = $conn->query("SELECT * FROM furnituretbl WHERE category = 'tv'");
$rec7 = $result7->num_rows;
$pages7 = ceil($rec7 / $per_page);

if (isset($_GET['page-nr'])) {

    $page = $_GET['page-nr'] - 1;
    $start = $page * $per_page;
}

$sql = "SELECT * FROM furnituretbl WHERE category = 'mirror' LIMIT $start, $per_page";
$mirror = mysqli_query($conn, $sql);

$sqlc = "SELECT * FROM furnituretbl WHERE category = 'cabinet' LIMIT $start, $per_page";
$cabinet = mysqli_query($conn, $sqlc);

$sqlch = "SELECT * FROM furnituretbl WHERE category = 'chair' LIMIT $start, $per_page";
$chair = mysqli_query($conn, $sqlch);

$sqltbl = "SELECT * FROM furnituretbl WHERE category = 'table' LIMIT $start, $per_page";
$table = mysqli_query($conn, $sqltbl);

$sqlb = "SELECT * FROM furnituretbl WHERE category = 'bed' LIMIT $start, $per_page";
$bed = mysqli_query($conn, $sqlb);

$sqls = "SELECT * FROM furnituretbl WHERE category = 'sala' LIMIT $start, $per_page";
$salaset = mysqli_query($conn, $sqls);

$sqltv = "SELECT * FROM furnituretbl WHERE category = 'tv' LIMIT $start, $per_page";
$tvstand = mysqli_query($conn, $sqltv);

$userID = $_SESSION['userID'];
$sql5 = "SELECT COUNT(*) FROM addcart WHERE userID = '$userID'";
$result5 = mysqli_query($conn, $sql5);
$row5 = mysqli_fetch_assoc($result5);
$i = $row5['COUNT(*)'];

$sqlmir = "SELECT * FROM furnituretbl WHERE category = 'mirror'";
$resultmir = mysqli_query($conn, $sqlmir);
$row5 = mysqli_num_rows($resultmir);
$mir = $row5;

$sqlcab = "SELECT * FROM furnituretbl WHERE category = 'cabinet'";
$resultcab = mysqli_query($conn, $sqlcab);
$row5 = mysqli_num_rows($resultcab);
$cab = $row5;

$sqlch = "SELECT * FROM furnituretbl WHERE category = 'chair'";
$resultcha = mysqli_query($conn, $sqlch);
$row5 = mysqli_num_rows($resultcha);
$cha = $row5;

$sqltbl = "SELECT * FROM furnituretbl WHERE category = 'table'";
$resulttbl = mysqli_query($conn, $sqltbl);
$row5 = mysqli_num_rows($resulttbl);
$tab = $row5;

$sqlb = "SELECT * FROM furnituretbl WHERE category = 'bed'";
$resultb = mysqli_query($conn, $sqlb);
$row5 = mysqli_num_rows($resulttbl);
$bed = $row5;

$sqls = "SELECT * FROM furnituretbl WHERE category = 'sala'";
$resultss = mysqli_query($conn, $sqls);
$row5 = mysqli_num_rows($resultss);
$sala = $row5;

$sqls = "SELECT * FROM furnituretbl WHERE category = 'tv'";
$resulttv = mysqli_query($conn, $sqlt);
$row5 = mysqli_num_rows($resulttv);
$tvs = $row5;

$sqlq = "SELECT * FROM furnituretbl";
$resultq = mysqli_query($conn, $sqlq);
$row5 = mysqli_num_rows($resultq);
$all = $row5;

?>