<?php
include 'database.php';

if (isset($_POST['add'])) {
    $fName = $_POST['fName'];
    $vName = isset($_POST['vName']) ? $_POST['vName'][0] : '';
    $pName = isset($_POST['pName']) ? $_POST['pName'][0] : '';
    $width = $_POST['width'];
    $length = $_POST['length'];
    $height = $_POST['height'];
    $lit = $_POST['lit'];
    $quantity = $_POST['quantity'];
    $userID = $_POST['userID'];

    $image = $_POST['image'];
    $cost = $_POST['cost'];
    $laborFee = $_POST['laborFee'];

    $totalWoodCost = 0;
    $totalVarnishCost = 0;

    $woodCostQuery = "SELECT * FROM rawmtbl WHERE pName = '$pName'";
    $woodResult = mysqli_query($conn, $woodCostQuery);

    if ($woodRow = mysqli_fetch_assoc($woodResult)) {
        $totalWoodCost = $woodRow['pCost'];
    }

    $varnishCostQuery = "SELECT * FROM varnishtbl WHERE vName = '$vName'";
    $varnishResult = mysqli_query($conn, $varnishCostQuery);

    if ($varnishRow = mysqli_fetch_assoc($varnishResult)) {
        $totalVarnishCost = $varnishRow['cost'];
    }

    $tWidth = $totalWoodCost * $width;
    $tLength = $totalWoodCost * $length;
    $tHeight = $totalWoodCost * $height;
    $costlang = $tWidth + $tLength + $tHeight + $totalVarnishCost + $laborFee;
    $totalCost = ($tWidth + $tLength + $tHeight + $totalVarnishCost + $laborFee) * $quantity;

    $insertQuery = "INSERT INTO tbl_cartCus (userID, fName, vName, pName, width, length, height, quantity, image, totalCost, cost) 
                    VALUES ('$userID', '$fName', '$vName', '$pName', '$width', '$length', '$height', '$quantity', '$image', '$totalCost', '$costlang')";

    if (mysqli_query($conn, $insertQuery)) {
        $minusVSql = "SELECT * FROM varnishtbl WHERE vName = '$vName'";
        $minusVResult = mysqli_query($conn, $minusVSql);
        $minusVRow = mysqli_fetch_assoc($minusVResult);

        $vQty2 = $minusVRow['vQuantity'];

        $totVQty = (int) $vQty2-1;

        $updateVSql = "UPDATE varnishtbl SET vQuantity = '$totVQty' WHERE vName = '$vName'";

        if (mysqli_query($conn, $updateVSql)) {
            $minusPSql = "SELECT * FROM rawmtbl WHERE pName = '$pName'";
            $minusPResult = mysqli_query($conn, $minusPSql);
            $minusPRow = mysqli_fetch_assoc($minusPResult);

            $pQty2 = $minusPRow['pQuantity'];

            $totPQty = (int) $pQty2-1;

            $updatePSql = "UPDATE rawmtbl SET pQuantity = '$totPQty' WHERE pName = '$pName'";

            if (mysqli_query($conn, $updatePSql)) {
                header('Location: customizecart.php');
            }
        }
    } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
    }
}
?>