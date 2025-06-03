<?php
include "database.php";
header('Content-Type: application/json');

if (isset($_GET['orderID'], $_GET['source'])) {
    $orderID = intval($_GET['orderID']);
    $source = $_GET['source'];

    if ($source === 'checkout') {
        $stmt = $conn->prepare("
            SELECT 
                'checkout' AS source,
                o.OFC_ID, o.userID AS receipt_userID, o.orderID, o.payment_receipt_id,
                o.reference_number, o.created_at, o.update_at,
                pr.payment_status,
                c.userID AS checkout_userID, c.image, c.fID, c.fullName, c.prodName, c.address, c.cpNum, 
                c.cost, c.date, c.status, c.payment, c.balance, c.proofPay, c.quantity, c.variant
            FROM checkout c
            INNER JOIN official_receipts o ON c.orderID = o.orderID
            INNER JOIN payment_receipts pr ON o.payment_receipt_id = pr.id
            WHERE c.orderID = ? AND pr.source = 'checkout'
            LIMIT 1
        ");
    } else {
        $stmt = $conn->prepare("
            SELECT 
                'checkoutcustom' AS source,
                o.OFC_ID, o.userID AS receipt_userID, o.orderID, o.payment_receipt_id,
                o.reference_number, o.created_at, o.update_at,
                pr.payment_status,
                cc.userID AS checkout_userID, cc.image, NULL AS fID, cc.fullName, cc.pName AS prodName, cc.address, cc.cpNum, 
                cc.totalCost AS cost, cc.date, cc.status, cc.payment, cc.balance, NULL AS proofPay, cc.quantity, cc.variant
            FROM checkoutcustom cc
            INNER JOIN official_receipts o ON cc.orderID = o.orderID
            INNER JOIN payment_receipts pr ON o.payment_receipt_id = pr.id
            WHERE cc.orderID = ? AND pr.source = 'checkoutcustom'
            LIMIT 1
        ");
    }

    $stmt->bind_param("i", $orderID);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'No invoice found for this order ID and source.']);
        exit;
    }

    $row = $result->fetch_assoc();

    // ✅ Hide invoice if payment is still pending
    if (strtolower($row['payment_status']) === 'pending') {
        echo json_encode(['success' => false, 'message' => 'Invoice not available. Payment is still pending.']);
        exit;
    }

    // ✅ Fetch payments for this order (specific to source)
    $payments = [];

    if ($source === 'checkout') {
        // Only 1 payment expected
        $paymentStmt = $conn->prepare("SELECT amountPaid FROM payment_receipts WHERE orderID = ? AND source = 'checkout' LIMIT 1");
        $paymentStmt->bind_param("i", $orderID);
        $paymentStmt->execute();
        $paymentResult = $paymentStmt->get_result();
        $payment = $paymentResult->fetch_assoc();
        $paymentStmt->close();

        $row['amountPaid'] = $payment ? (float)$payment['amountPaid'] : 0;
        $row['totalPaid'] = $row['amountPaid'];
    } else {
        // Up to 3 partial payments
        $paymentStmt = $conn->prepare("SELECT amountPaid FROM payment_receipts WHERE orderID = ? AND source = 'checkoutcustom' ORDER BY id ASC");
        $paymentStmt->bind_param("i", $orderID);
        $paymentStmt->execute();
        $paymentResult = $paymentStmt->get_result();

        while ($p = $paymentResult->fetch_assoc()) {
            $payments[] = (float)$p['amountPaid'];
        }
        $paymentStmt->close();

        $row['firstPayment'] = $payments[0] ?? 0;
        $row['secondPayment'] = $payments[1] ?? 0;
        $row['thirdPayment'] = $payments[2] ?? 0;
        $row['totalPaid'] = array_sum($payments);
    }

    // ✅ Prepare purchase items
    $prodNames = isset($row['prodName']) ? explode(',', $row['prodName']) : [];
    $quantities = isset($row['quantity']) ? explode(',', $row['quantity']) : [];

    $items = [];
    $invoiceTotal = 0;

    for ($i = 0; $i < count($prodNames); $i++) {
        $itemName = trim($prodNames[$i]);
        $qty = isset($quantities[$i]) ? (int) trim($quantities[$i]) : 1;
        $price = 0;

        if ($row['source'] === 'checkout') {
            // ✅ Correctly get cost from furnituretbl
            $stmtPrice = $conn->prepare("SELECT cost FROM furnituretbl WHERE fName = ? LIMIT 1");
            if ($stmtPrice) {
                $stmtPrice->bind_param("s", $itemName);
                $stmtPrice->execute();
                $priceResult = $stmtPrice->get_result();
                if ($priceRow = $priceResult->fetch_assoc()) {
                    $price = (float)$priceRow['cost'];
                }
                $stmtPrice->close();
            }
        } else {
            // Divide total cost evenly
            $totalCost = (float)$row['cost'];
            $price = $totalCost / max(count($prodNames), 1);
        }

        $total = $qty * $price;
        $invoiceTotal += $total;

        $items[] = [
            'item' => $itemName,
            'quantity' => $qty,
            'price' => number_format($price, 2),
            'total' => number_format($total, 2)
        ];
    }

    $row['items'] = $items;
    $row['invoiceTotal'] = number_format($invoiceTotal, 2);

    echo json_encode([
        'success' => true,
        'invoices' => [$row]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
