<?php
session_start();
include("database.php");

if (!isset($_SESSION['receipt'])) {
    echo "No receipt available.";
    exit;
}

$receipt = $_SESSION['receipt'];
$orderID = $receipt['orderID'];
$source = $receipt['source'] ?? 'checkout';
$totalCost = (float) $receipt['totalCost'];

$sqlPaid = "SELECT COALESCE(SUM(totalPaid), 0) FROM official_receipts WHERE orderID = ?";
$stmtPaid = $conn->prepare($sqlPaid);
$stmtPaid->bind_param("s", $orderID);
$stmtPaid->execute();
$stmtPaid->bind_result($totalPaid);
$stmtPaid->fetch();
$stmtPaid->close();

$balance = $totalCost - $totalPaid;
?>


<!DOCTYPE html>
<html>

<head>
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f0f0f0;
            padding: 40px;
        }

        .receipt-box {
            width: 380px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border: 1px dashed #000;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            line-height: 1.6;
        }

        .receipt-box h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .receipt-box .title {
            text-align: center;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        .thank-you {
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
        }

        .timestamp {
            text-align: center;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="receipt-box">
        <h2>PAYMENT RECEIPT</h2>
        <div class="title">Joyness Furniture</div>
        <div class="line"></div>

        <div class="row"><span>Reference Number:</span><span><?= htmlspecialchars($receipt['referenceNo']) ?></span>
        </div>
        <div class="row"><span>Order ID:</span><span><?= htmlspecialchars($orderID) ?></span></div>
        <div class="row"><span>Payment Method:</span><span><?= htmlspecialchars($receipt['payment']) ?></span></div>
        <div class="row"><span>Total Cost:</span><span>₱<?= number_format($totalCost, 2) ?></span></div>
        <div class="row"><span>Amount Paid:</span><span>₱<?= number_format($receipt['amountPaid'], 2) ?></span></div>

        <div class="row"><span>Total Amount Paid:</span><span>₱<?= number_format($totalPaid, 2) ?></span></div>
        <div class="row"><span>Balance:</span><span>₱<?= number_format($balance, 2) ?></span></div>


        <div class="line"></div>
        <div class="thank-you">Thank you for your payment!</div>
        <?php date_default_timezone_set('Asia/Manila'); ?>
        <div class="timestamp"><?= date("F j, Y, g:i A") ?></div>
    </div>

</body>

</html>

<?php
unset($_SESSION['receipt']);
?>