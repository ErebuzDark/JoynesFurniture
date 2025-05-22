<?php
include("database.php");

if (isset($_GET['period'])) {
    $period = $_GET['period'];
    $currentMonth = date('m');
    $currentYear = date('Y');
    $currentDate = date('Y-m-d');

    if ($period === 'weekly') {
        $startDate = date('Y-m-d', strtotime('monday this week'));
        $endDate = date('Y-m-d', strtotime('sunday this week'));
    } elseif ($period === 'monthly') {
        if (isset($_GET['month']) && preg_match('/^\d{4}-\d{2}$/', $_GET['month'])) {
            $selectedMonth = $_GET['month'];
            $startDate = $selectedMonth . '-01';
            $endDate = date('Y-m-t', strtotime($startDate));
        } else {
            $startDate = "$currentYear-$currentMonth-01";
            $endDate = "$currentYear-$currentMonth-" . date('t');
        }
    } elseif ($period === 'yearly') {
        $startDate = "$currentYear-01-01";
        $endDate = "$currentYear-12-31";
    } else {
        $startDate = "$currentYear-$currentMonth-01";
        $endDate = "$currentYear-$currentMonth-" . date('t');
    }

    $sql = "
    SELECT date, product_name, price, total, fID, num_sales
    FROM (
        -- Checkout table (with fID)
        SELECT 
            prodName AS product_name, 
            date, 
            fID, 
            cost AS price, 
            SUM(cost) AS total,
            COUNT(fID) AS num_sales
        FROM checkout 
        WHERE (status = 'Completed' OR status = 'Delivered') 
        AND date BETWEEN '$startDate' AND '$endDate'
        GROUP BY prodName, date, fID, cost

        UNION

        -- CheckoutCustom table (without fID, so we use NULL as placeholder)
        SELECT 
            pName AS product_name, 
            date, 
            NULL AS fID, 
            totalCost AS price, 
            SUM(totalCost) AS total,
            COUNT(*) AS num_sales
        FROM checkoutcustom 
        WHERE (status = 'Completed' OR status = 'Delivered') 
        AND date BETWEEN '$startDate' AND '$endDate'
        GROUP BY pName, date, totalCost
    ) sales
    WHERE total > 0
    ORDER BY date DESC;
    ";

    $result = $conn->query($sql);

    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<head>';
    echo '<title>Order Report</title>';
    echo '<div style="display: flex; align-items: center; justify-content: space-between; padding: 10px;">';
    echo '<h1>Order Report</h1>';
    echo '<img src="logo.png" alt="Logo" style="width: 2in; height: 2in;">';
    echo '</div>';
    echo '<style>';
    echo 'table { width: 100%; border-collapse: collapse; margin-top: 20px; }';
    echo 'th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }';
    echo 'th { background-color: #f2f2f2; }';
    echo 'button { margin: 20px; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';

    echo '<p><strong>Period: </strong>' . ucfirst($period) . ' (' . date('F j, Y', strtotime($startDate)) . ' to ' . date('F j, Y', strtotime($endDate)) . ')</p>';

    echo '<table>';
    echo '<thead><tr><th>Product Name</th><th>Date</th><th>Number of Sales</th><th>Total Cost</th></tr></thead>';
    echo '<tbody>';

    $total = 0;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['date'] == '1970-01-01' || !$row['date']) {
                continue;
            }
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
            echo '<td>' . date('F j, Y', strtotime($row['date'])) . '</td>';
            echo '<td>' . ($row['num_sales'] ?? 0) . '</td>';
            echo '<td> &#8369;' . number_format($row['price'], 2, '.', ',') . '</td>';
            echo '</tr>';
            $total += $row['total'];
        }
        echo '<tfoot>
        <tr>
            <td colspan="3">Total Sales</td>
            <td> &#8369;' . number_format($total, 2, '.', ',') . '</td>
        </tr>
      </tfoot>';
    } else {
        echo '<tr><td colspan="4">No records found for the selected period.</td></tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '<script>window.focus(); window.print();</script>';

    echo '</body>';
    echo '</html>';
} else {
    header('Location: admin.php');
    exit;
}
?>
