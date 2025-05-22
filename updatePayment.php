<?php
include("database.php");

if (isset($_POST['orderID'], $_POST['pay'], $_POST['downPayment'], $_POST['source'], $_POST['totalCost'])) {
    $orderID = $_POST['orderID'];
    $payment = $_POST['pay'];
    $downPayment = isset($_POST['downPayment']) ? $_POST['downPayment'] : 0;  // Default to 0 if not set
    $source = $_POST['source'];
    $totalCost = $_POST['totalCost'];

    if ($payment == 'Down Payment') {
        $balance = $totalCost - $downPayment;
    } else {
        $balance = $totalCost;
    }

    // Update the database based on the source (either checkout or checkoutcustom)
    if ($source == "checkout") {
        if ($payment == 'Full Payment') {
            $sql = "UPDATE checkout SET payment = 'Full Payment', balance = ? WHERE orderID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di", $balance, $orderID);
        } else {
            $sql = "UPDATE checkout SET payment = 'Down Payment', balance = ? WHERE orderID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di", $balance, $orderID);
        }
    } else {
        if ($payment == 'Full Payment') {
            $sql = "UPDATE checkoutcustom SET payment = 'Full Payment', balance = ? WHERE orderID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di", $balance, $orderID);
        } else {
            $sql = "UPDATE checkoutcustom SET payment = 'Down Payment', balance = ? WHERE orderID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di", $balance, $orderID);
        }
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
                alert('Payment Updated!');
                window.location.href = 'admin.php';
              </script>";
    } else {
        echo "Error updating payment: " . $conn->error;
    }
}
?>