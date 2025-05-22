<?php
include("database.php");

if (isset($_POST['orderID'], $_POST['pay'], $_POST['source'], $_POST['totalCost'], $_POST['currentBalance'])) {
    $orderID = $_POST['orderID'];
    $payment = $_POST['pay'];
    $source = $_POST['source'];
    $totalCost = (float) $_POST['totalCost'];
    $currentBalance = (float) $_POST['currentBalance'];
    $downPayment = isset($_POST['downPayment']) ? (float) $_POST['downPayment'] : 0;

    if ($payment === 'Full Payment') {
        $balance = 0;
    } else {
        // Make sure downPayment is not greater than currentBalance
        if ($downPayment > $currentBalance) {
            $balance = 0;
        } else {
            $balance = $currentBalance - $downPayment;
        }
    }

    // Update the appropriate table
    if ($source == "checkout") {
        $sql = "UPDATE checkout SET payment = ?, balance = ? WHERE orderID = ?";
    } else {
        $sql = "UPDATE checkoutcustom SET payment = ?, balance = ? WHERE orderID = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdi", $payment, $balance, $orderID);

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
