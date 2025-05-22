<?php
require_once 'database.php';

error_reporting(E_ALL & ~E_WARNING); // Show all errors except warnings
ini_set('display_errors', '1');       // Enable error display (optional)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = $_POST['ID']; // Product ID from the cart
    $action = $_POST['action']; // Action: 'plus' or 'minus'
    $currentQuantity = (int) $_POST['quantity']; // Current quantity


    // Fetch the cost from furnituretbl using fID in addcart
    $stmt = $conn->prepare("
        SELECT furnituretbl.cost 
        FROM furnituretbl 
        WHERE furnituretbl.fID = (SELECT fID FROM addcart WHERE ID = ?)
    ");
    $stmt->bind_param('i', $productID);
    $stmt->execute();
    $stmt->bind_result($unitPrice);
    $stmt->fetch();
    $stmt->close();

    if ($unitPrice) {
        // Update quantity and cost based on action
        if ($action === 'plus') {
            $currentQuantity += 1; // Increase quantity
            $newCost = $currentQuantity * $unitPrice; // Update cost
        } elseif ($action === 'minus') {
            if ($currentQuantity > 1) {
                $currentQuantity -= 1; // Decrease quantity
            }
            $newCost = $currentQuantity * $unitPrice; // Correctly calculate new cost
        }

        // Update the quantity and cost in the database
        $updateStmt = $conn->prepare("UPDATE addcart SET quantity = ?, cost = ? WHERE ID = ?");
        $updateStmt->bind_param('idi', $currentQuantity, $newCost, $productID);
        $updateStmt->execute();
        $updateStmt->close();

        // Redirect to refresh the page or show updated values
        header("Location: cart.php");
        exit;
    } else {
        // echo "Product not found.";
    }
}
?>