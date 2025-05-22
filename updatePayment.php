<?php
include("database.php");

if (isset($_POST['orderID'], $_POST['pay'], $_POST['downPayment'], $_POST['source'], $_POST['totalCost'])) {
    $orderID = $_POST['orderID'];
    $payment = $_POST['pay'];
    $downPayment = isset($_POST['downPayment']) ? (float) $_POST['downPayment'] : 0;  // Cast to float
    $source = $_POST['source'];
    $totalCost = (float) $_POST['totalCost'];  // Cast to float

    if ($payment == 'Down Payment') {
        $balance = $totalCost - $downPayment;
    } else {
        $balance = $totalCost;
    }

    // Update the database based on the source (either checkout or checkoutcustom)
    if ($source == "checkout") {
        $sql = "UPDATE checkout SET payment = ?, balance = ? WHERE orderID = ?";
    } else {
        $sql = "UPDATE checkoutcustom SET payment = ?, balance = ? WHERE orderID = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdi", $payment, $balance, $orderID);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
                alert('Payment Updated!');
                window.location.href = 'adminOrder.php';
              </script>";
    } else {
        echo "Error updating payment: " . $conn->error;
    }
}
?>