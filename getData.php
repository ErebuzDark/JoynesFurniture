<?php
include 'database.php';

$response = array();

if (isset($_POST['selectedPID']) && isset($_POST['selectedID'])) {
    $selectedPID = $_POST['selectedPID'];
    $selectedID = $_POST['selectedID'];

    // Ensure both values are treated as strings before escaping
    $selectedPID = mysqli_real_escape_string($conn, (string)$selectedPID);
    $selectedID = mysqli_real_escape_string($conn, (string)$selectedID);

    $sql = "SELECT pName, pCost FROM rawmtbl WHERE pID = '$selectedPID'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $response['rawmtbl'] = $row;
    } else {
        $response['rawmtbl'] = null;
    }

    $varnishSql = "SELECT vName, cost FROM varnishtbl WHERE ID = '$selectedID'";
    $varnishResult = mysqli_query($conn, $varnishSql);

    if ($varnishResult && mysqli_num_rows($varnishResult) > 0) {
        $varnishRow = mysqli_fetch_assoc($varnishResult);
        $response['varnishtbl'] = array($varnishRow);
    } else {
        $response['varnishtbl'] = array();
    }

    header('Content-Type: application/json'); // Ensure JSON header
    echo json_encode($response);
}
?>
