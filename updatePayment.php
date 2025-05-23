<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("database.php");

if (isset($_POST['orderID'], $_POST['pay'], $_POST['source'], $_POST['totalCost'], $_POST['currentBalance'])) {
    $orderID = $_POST['orderID'];
    $payment = $_POST['pay'];
    $source = $_POST['source'];
    $totalCost = (float) $_POST['totalCost'];
    $currentBalance = (float) $_POST['currentBalance'];
    $downPayment = isset($_POST['downPayment']) ? (float) $_POST['downPayment'] : 0;

    if ($payment === 'Full Payment') {
        $amountPaid = $totalCost;
        $balance = 0;
    } else {
        $amountPaid = min($downPayment, $currentBalance); // Prevent overpaying
        $balance = $currentBalance - $amountPaid;
    }

    // Generate unique reference number
    $referenceNo = strtoupper(uniqid('REF-'));

    // Update checkout or checkoutcustom table
    if ($source === "checkout") {
        $sql = "UPDATE checkout SET payment = ?, balance = ? WHERE orderID = ?";
    } else {
        $sql = "UPDATE checkoutcustom SET payment = ?, balance = ? WHERE orderID = ?";
    }

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sds", $payment, $balance, $orderID);

    if ($stmt->execute()) {
        // Retrieve userID from payment_receipts or another reliable source
        $check = $conn->prepare("SELECT userID FROM payment_receipts WHERE orderID = ?");
        if (!$check) {
            die("Prepare failed: " . $conn->error);
        }
        $check->bind_param("s", $orderID);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $check->bind_result($userID);
            $check->fetch();
        } else {
            die("No payment receipt found for this orderID. Cannot retrieve userID.");
        }
        $check->close();

        // Insert a new record in official_receipts with amountPaid and reference_number
        $insertOfficial = $conn->prepare("INSERT INTO official_receipts (userID, orderID, totalPaid, reference_number, created_at, update_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        if (!$insertOfficial) {
            die("Prepare failed: " . $conn->error);
        }
        $insertOfficial->bind_param("isds", $userID, $orderID, $amountPaid, $referenceNo);
        $insertOfficial->execute();

        // Save receipt data in session for later use
        $_SESSION['receipt'] = [
            'userID' => $userID,
            'orderID' => $orderID,
            'payment' => $payment,
            'amountPaid' => $amountPaid,
            'totalCost' => $totalCost,
            'balance' => $balance,
            'referenceNo' => $referenceNo,
            'source' => $source
        ];

        header("Location: receipt.php");
        exit;
    } else {
        echo "Error updating payment: " . $conn->error;
    }
}
?>
