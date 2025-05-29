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
                o.OFC_ID, o.userID AS receipt_userID, o.orderID, o.payment_receipt_id, o.totalPaid,
                o.reference_number, o.created_at, o.update_at,
                pr.payment_status,
                c.userID AS checkout_userID, c.image, c.fID, c.fullName, c.prodName, c.address, c.cpNum, 
                c.cost, c.date, c.status, c.payment, c.balance, c.proofPay, c.quantity, c.variant
            FROM checkout c
            INNER JOIN official_receipts o ON c.orderID = o.orderID
            INNER JOIN payment_receipts pr ON o.payment_receipt_id = pr.id
            WHERE c.orderID = ? AND pr.source = 'checkout'
        ");
    } else {
        $stmt = $conn->prepare("
            SELECT 
                'checkoutcustom' AS source,
                o.OFC_ID, o.userID AS receipt_userID, o.orderID, o.payment_receipt_id, o.totalPaid,
                o.reference_number, o.created_at, o.update_at,
                pr.payment_status,
                cc.userID AS checkout_userID, cc.image, NULL AS fID, cc.fullName, cc.pName AS prodName, cc.address, cc.cpNum, 
                cc.totalCost AS cost, cc.date, cc.status, cc.payment, cc.balance, NULL AS proofPay, cc.quantity, cc.variant
            FROM checkoutcustom cc
            INNER JOIN official_receipts o ON cc.orderID = o.orderID
            INNER JOIN payment_receipts pr ON o.payment_receipt_id = pr.id
            WHERE cc.orderID = ? AND pr.source = 'checkoutcustom'
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

    $invoices = [];

    while ($row = $result->fetch_assoc()) {
        $prodNames = isset($row['prodName']) ? explode(',', $row['prodName']) : [];
        $quantities = isset($row['quantity']) ? explode(',', $row['quantity']) : [];

        $items = [];
        $invoiceTotal = 0;

        for ($i = 0; $i < count($prodNames); $i++) {
            $itemName = trim($prodNames[$i]);
            $qty = isset($quantities[$i]) ? (int) trim($quantities[$i]) : 1;

            $price = 0;

            if ($row['source'] === 'checkout') {
                $stmtPrice = $conn->prepare("SELECT cost FROM furnituretbl WHERE fName = ?");
                $stmtPrice->bind_param("s", $itemName);
                $stmtPrice->execute();
                $priceResult = $stmtPrice->get_result();

                if ($priceRow = $priceResult->fetch_assoc()) {
                    $price = (float) $priceRow['cost'];
                }
                $stmtPrice->close();
            } else {
                $totalCost = (float) $row['cost'];
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
        $invoices[] = $row;
    }

    echo json_encode([
        'success' => true,
        'invoices' => $invoices
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
