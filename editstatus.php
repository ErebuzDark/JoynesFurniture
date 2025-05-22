<?php
include("database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the order ID and new status from the AJAX request
    $orderID = $_POST['orderID'];
    $status = $_POST['status'];

    // Update the status in the database for the given order ID
    // Here, assume source is also passed, so we know whether to update the checkout or checkoutcustom table
    $source = $_POST['source'];

    // Prepare the SQL query based on the source table
    if ($source === 'checkout') {
        $sql = "UPDATE checkout SET status = ? WHERE orderID = ?";
    } elseif ($source === 'checkoutcustom') {
        $sql = "UPDATE checkoutcustom SET status = ? WHERE orderID = ?";
    } else {
        echo "Invalid source.";
        exit;
    }

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $orderID);  // "si" means string and integer types

    // Check if the update was successful
    if ($stmt->execute()) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status: " . $conn->error;
    }

    $stmt->close();
}

?>