<?php

include("database.php");

$currentMonth = date('m');
$currentYear = date('Y');
$sql = "
        (SELECT SUM(cost) AS totalEarnings FROM checkout 
        WHERE (status = 'Completed' OR status = 'Delivered')
        AND MONTH(date) = $currentMonth AND YEAR(date) = $currentYear)
        UNION
        (SELECT SUM(totalCost) AS totalEarnings FROM checkoutcustom 
        WHERE (status = 'Completed' OR status = 'Delivered')
        AND MONTH(date) = $currentMonth AND YEAR(date) = $currentYear)
    ";
$result = $conn->query($sql);
$totalEarnings = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $totalEarnings += $row['totalEarnings'];
    }
} else {
    $totalEarnings = 0;
}


$sql1 = "
    SELECT orderID, prodName AS productName, status FROM checkout 
    WHERE status = 'On Queue'
    UNION ALL
    SELECT orderID, pName AS productName, status FROM checkoutcustom 
    WHERE status = 'Pending Approval'
";
$result1 = $conn->query($sql1);

$orders = [];
if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $orders[] = $row;
    }
}
$totalQueue = count($orders);

$sql2 = "
    SELECT orderID, productName
    FROM payment_receipts 
    WHERE payment_status = 'Pending'
";

$result2 = $conn->query($sql2);

$pendingPayments = [];
if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $pendingPayments[] = $row;
    }
}
$newPayment = count($pendingPayments);



$sqlGo = "
        (SELECT COUNT(*) as onGo FROM checkout 
        WHERE status = 'In Progress')
        UNION ALL
        (SELECT COUNT(*) as onGo FROM checkoutcustom 
        WHERE status = 'In Progress')
    ";
$result1 = $conn->query($sqlGo);
$onGo = 0;
if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $onGo += $row['onGo'];
    }
} else {
    $onGo = 0;
}


$sqlCom = "
        (SELECT COUNT(*) as complete FROM checkout 
        WHERE status = 'Completed' OR status = 'Delivered')
        UNION ALL
        (SELECT COUNT(*) as complete FROM checkoutcustom 
        WHERE status = 'Completed' OR status = 'Delivered')
    ";
$result1 = $conn->query($sqlCom);
$complete = 0;
if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $complete += $row['complete'];
    }
} else {
    $complete = 0;
}


//for line chart
$monthlySales = array_fill(0, 12, 0);

for ($i = 0; $i < 12; $i++) {
    $month = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
    $year = $currentYear;
    $sqlSales = "
        (SELECT SUM(cost) AS totalSales FROM checkout 
        WHERE (status = 'Completed' OR status = 'Delivered') 
        AND MONTH(date) = $month AND YEAR(date) = $year)
        UNION ALL
        (SELECT SUM(totalCost) AS totalSales FROM checkoutcustom 
        WHERE (status = 'Completed' OR status = 'Delivered') 
        AND MONTH(date) = $month AND YEAR(date) = $year)
    ";

    $resultSales = $conn->query($sqlSales);
    $totalSales = 0;
    if ($resultSales->num_rows > 0) {
        while ($row = $resultSales->fetch_assoc()) {
            $totalSales += $row['totalSales'];
        }
    }
    $monthlySales[$i] = $totalSales;
}

$totsls = "
        (SELECT SUM(cost) AS ttlsls FROM checkout 
        WHERE (status = 'Completed' OR status = 'Delivered') AND YEAR(date) = $year)
        UNION ALL
        (SELECT SUM(totalCost) AS ttlsls FROM checkoutcustom 
        WHERE (status = 'Completed' OR status = 'Delivered') AND YEAR(date) = $year)
    ";

$slsres = $conn->query($totsls);
$ttlsls = 0;
if ($slsres->num_rows > 0) {
    while ($row = $slsres->fetch_assoc()) {
        $ttlsls += $row['ttlsls'];
    }
}


$sqlbar = "
    (SELECT MONTH(date) AS month, COUNT(*) AS totalOrders FROM checkout WHERE status = 'Completed' GROUP BY MONTH(date))
    UNION
    (SELECT MONTH(date) AS month, COUNT(*) AS totalOrders FROM checkoutcustom WHERE status = 'Completed' GROUP BY MONTH(date))
    ";
$barres = $conn->query($sqlbar);

for ($i = 1; $i <= 12; $i++) {
    $ordersPerMonth[$i] = 0;
}

if ($barres->num_rows > 0) {
    while ($row = $barres->fetch_assoc()) {
        $ordersPerMonth[$row['month']] = $row['totalOrders'];
    }
}
$ordersData = json_encode(array_values($ordersPerMonth));

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="vendor/chart.js/Chart.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link href="css/newstyle.css" rel="stylesheet">
    <link href="popupform.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style type="text/css">
        .logo {
            margin-bottom: 30px;
            margin-top: 35px;
        }

        .sidebar {
            background-color: rgba(114, 63, 41, 255);
        }

        .picture img {
            height: 400px;
            width: 98%;
            margin-left: 15px;
            margin-bottom: 35px;
        }

        /* Smooth and pleasing button styles with animation */
        .btn,
        .btn-sm {
            transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn:hover,
        .btn:focus,
        .btn-sm:hover,
        .btn-sm:focus {
            background-color: #6c757d !important;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            transform: scale(1.05);
            outline: none;
            text-decoration: none;
        }

        .btn-outline-primary {
            border: 2px solid #6c757d;
            color: #6c757d;
            background-color: transparent;
        }

        .btn-outline-primary:hover,
        .btn-outline-primary:focus {
            background-color: #6c757d;
            color: #fff;
            border-color: #6c757d;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.5);
            transform: scale(1.05);
        }

        /* Specific smaller buttons */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        /* Payment view button style */
        #view.btn {
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        #view.btn:hover {
            background-color: #28a745 !important;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.5);
            transform: scale(1.05);
        }
    </style>

    <script>
        function printTable() {
            var table = document.getElementById("dataTable");
            if (table) {
                var newWin = window.open("", "Print-Window");
                newWin.document.open();
                newWin.document.write('<html><head><title>Print Table</title></head><body>');
                newWin.document.write('<h2>Table to Print</h2>');
                newWin.document.write(table.outerHTML);
                newWin.document.write('</body></html>');
                newWin.document.close();
                newWin.print();
            }
        }

        function openForm() {
            document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("myForm").style.display = "none";
        }
    </script>
</head>

<body id="page-top">
    <?php
    $toast = null;
    if (isset($_SESSION['toast'])) {
        $toast = $_SESSION['toast'];
        unset($_SESSION['toast']);
    }
    ?>

    <?php if ($toast): ?>
        <!-- Load SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            .swal2-container {
                z-index: 99999 !important;
                /* Force on top of everything */
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: <?= json_encode($toast['type']) ?>,
                    title: <?= json_encode($toast['message']) ?>,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
    <?php endif; ?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="logo sidebar-brand d-flex align-items-center justify-content-center" href="admin.php">
                <div class="sidebar-brand-icon ">
                    <img src="logo.png" class="img-fluid ">
                </div>
            </a>

            <li class="nav-item mt-5">
                <a class="nav-link" href="admin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">

            <div class="sidebar-heading">Interface</div>

            <li class="nav-item active">
                <a class="nav-link collapsed" href="adminOrder.php">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="tables.php">
                    <i class="fas fa-solid fa-chair"></i>
                    <span>Furniture</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="archiveprod.php">
                    <i class="fas fa-solid fa-chair"></i>
                    <span>Archived Product</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="rawtable.php">
                    <i class="fas fa-solid fa-tree"></i>
                    <span>Raw Materials</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="suppliers.php">
                    <i class="fas fa-solid fa-user"></i>
                    <span>Suppliers</span>
                </a>
            </li>

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>

        <?php if (isset($_SESSION['auto_refresh'])): ?>
            <script>
                setTimeout(function () {
                    location.reload();
                }, 1500); // Delay before auto-refresh (1.5 seconds)
            </script>
            <?php unset($_SESSION['auto_refresh']); ?>
        <?php endif; ?>


        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>

                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">

                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </li>
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <?php
                                $totalNotifications = $totalQueue + $newPayment;
                                if ($totalNotifications > 0):
                                    ?>
                                    <span class="badge badge-danger badge-counter"><?php echo $totalNotifications; ?></span>
                                <?php endif; ?>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notifications
                                </h6>

                                <?php if ($totalQueue > 0): ?>
                                    <?php foreach ($orders as $order): ?>
                                        <a class="dropdown-item d-flex align-items-center" href="adminOrder.php">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-primary">
                                                    <i class="fas fa-shopping-cart text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500"><?php echo date('F j, Y'); ?></div>
                                                <span class="font-weight-bold">[Order ID: <?php echo $order['orderID']; ?>] New
                                                    Order - <?php echo $order['productName']; ?></span>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="dropdown-item text-center small text-gray-500">No new notifications</div>
                                <?php endif; ?>

                                <?php if ($newPayment > 0): ?>
                                    <?php foreach ($pendingPayments as $payment): ?>
                                        <a class="dropdown-item d-flex align-items-center" href="adminOrder.php">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-success">
                                                    <i class="fas fa-receipt text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500"><?php echo date('F j, Y'); ?></div>
                                                <span class="font-weight-bold">
                                                    [Order ID: <?php echo $payment['orderID']; ?>] Pending Payment -
                                                    <?php echo $payment['productName']; ?>
                                                </span>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                <?php endif; ?>


                                <?php if ($totalNotifications == 0): ?>
                                    <div class="dropdown-item text-center small text-gray-500">No new notifications</div>
                                <?php endif; ?>
                            </div>
                        </li>



                        <!-- Nav Item - Messages -->
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>

                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <!-- <div class="dropdown-divider"></div> -->
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>
                </nav>
                <!-- End of Topbar -->



                <!-- DataTales Example -->
                <div class=" px-0">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">

                            <!-- Form to select the period (Weekly, Monthly, Yearly) -->
                            <div id="reportForm">
                                <form id="reportForm" action="report.php" method="get" target="reportFrame"
                                    onsubmit="return printReport();">
                                    <label for="period">Select Period:</label>
                                    <select name="period" id="period" onchange="toggleMonthPicker()">
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly" selected>Monthly</option>
                                        <option value="yearly">Yearly</option>
                                    </select>
                                    <input type="month" name="month" id="monthPicker"
                                        style="display:none; margin-left:10px;">
                                    <button type="submit" class="btn btn-primary">Generate Report</button>
                                </form>
                            </div>

                            <!-- Hidden iframe to load the report -->
                            <iframe id="reportFrame" name="reportFrame" style="display:none;"></iframe>


                            <!-- <h2 class="m-0 font-weight-bold text-primary d-sm-flex align-items-center justify-content-between ">Orders <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" onclick="printTable()"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a></h2> -->
                        </div>



                        <div class="card-body">
                            <!-- Filter container for order statuses -->
                            <div class="mb-3">
                                <div class="btn-group" role="group" aria-label="Order Status Filter">
                                    <button type="button" class="btn btn-outline-primary active"
                                        onclick="filterOrders('All')">All</button>
                                    <button type="button" class="btn btn-outline-primary"
                                        onclick="filterOrders('Pending Approval')">Pending Approval</button>
                                    <button type="button" class="btn btn-outline-primary"
                                        onclick="filterOrders('In Progress')">In Progress</button>
                                    <button type="button" class="btn btn-outline-primary"
                                        onclick="filterOrders('Cancelled')">Cancelled</button>
                                    <button type="button" class="btn btn-outline-primary"
                                        onclick="filterOrders('Delivered')">Delivered</button>
                                    <button type="button" class="btn btn-outline-primary"
                                        onclick="filterOrders('Completed')">Completed</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <?php
                                $sql = "
                                    SELECT 'checkout' AS source, payment, proofPay, balance, fullName, address, cpNum, prodName, image, quantity,variant, 
                                        cost AS totalCost, date, status, orderID, width, length, height 
                                    FROM checkout
                                    UNION
                                    SELECT 'checkoutcustom' AS source, payment, proofPay, balance, fullName, address, cpNum, pName AS prodName, image, 
                                        quantity,variant, totalCost, date, status, orderID, width, length, height 
                                    FROM checkoutcustom
                                ORDER BY 
                                CASE 
                                    WHEN status = 'On Queue' THEN 0 
                                    ELSE 1 
                                END, 
                                orderID DESC

                                ";



                                $receiptQuery = "SELECT * FROM payment_receipts";
                                $receiptResult = $conn->query($receiptQuery);

                                $receiptsByOrder = [];
                                while ($row = $receiptResult->fetch_assoc()) {
                                    $key = $row['orderID'] . '|' . $row['source'];
                                    if (!isset($receiptsByOrder[$key])) {
                                        $receiptsByOrder[$key] = [];
                                    }
                                    $receiptsByOrder[$key][] = $row;
                                }


                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    echo '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Cellphone Number</th>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Source</th>
                                            <th>Dimension</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Payment</th>
                                        </tr>
                                    </thead>
                                    ';

                                    while ($row = $result->fetch_assoc()) {
                                        $orderID = $row['orderID'];
                                        $receipts = isset($receiptsByOrder[$orderID]) ? $receiptsByOrder[$orderID] : [];
                                        $receiptsJson = htmlspecialchars(json_encode($receipts), ENT_QUOTES, 'UTF-8');

                                        $prodNames = explode(',', $row['prodName']);
                                        $images = explode(',', $row['image']);
                                        $maxItems = count($prodNames);

                                        echo '<tr class="bg-light">';
                                        echo '<td>' . $row['orderID'] . '</td>';
                                        echo '<td>' . $row['fullName'] . '</td>';
                                        echo '<td>' . $row['address'] . '</td>';
                                        echo '<td>' . $row['cpNum'] . ' </td>';
                                        echo '<td>';
                                        foreach ($images as $index => $image):
                                            $modalId = 'imageModal' . $index;
                                            $imageSrc = trim($image);

                                            echo '<a href="#" data-toggle="modal" data-target="#' . $modalId . '">';
                                            echo '<img src="' . $imageSrc . '" class="img-fluid rounded-circle mr-1 mb-1" style="width: 70px; height: 70px; object-fit:cover;" alt="">';
                                            echo '</a>';

                                            echo '
                                            <div class="modal fade" id="' . $modalId . '" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content bg-transparent border-0">
                                                        <div class="modal-body text-center">
                                                            <img src="' . $imageSrc . '" class="img-fluid rounded" style="max-height: 90vh;" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                                        endforeach;
                                        echo '</td>';

                                        echo '<td class="align-middle">';
                                        for ($i = 0; $i < $maxItems; $i++) {
                                            $prodName = isset($prodNames[$i]) ? trim($prodNames[$i]) : trim($prodNames[0]);
                                            echo '<h6>' . htmlspecialchars($prodName) . '</h6>';
                                        }
                                        echo '</td>';
                                        echo '<td>' . ($row['variant'] === 'full' ? 'Checkout' : 'Checkoutcustom') . '</td>';

                                        echo '<td class="align-middle">';
                                        // Dimension column
                                        // Try to get width, length, height from the row (comma-separated if multiple)
                                        $widths = isset($row['width']) ? explode(',', $row['width']) : array();
                                        $lengths = isset($row['length']) ? explode(',', $row['length']) : array();
                                        $heights = isset($row['height']) ? explode(',', $row['height']) : array();
                                        $maxDim = max(count($widths), count($lengths), count($heights), $maxItems);

                                        for ($i = 0; $i < $maxDim; $i++) {
                                            $w = isset($widths[$i]) ? trim($widths[$i]) : (isset($widths[0]) ? trim($widths[0]) : '');
                                            $l = isset($lengths[$i]) ? trim($lengths[$i]) : (isset($lengths[0]) ? trim($lengths[0]) : '');
                                            $h = isset($heights[$i]) ? trim($heights[$i]) : (isset($heights[0]) ? trim($heights[0]) : '');
                                            if ($w !== '' || $l !== '' || $h !== '') {
                                                echo '<div style="line-height:1.2;">';
                                                echo 'W: ' . htmlspecialchars($w) . '<br>';
                                                echo 'L: ' . htmlspecialchars($l) . '<br>';
                                                echo 'H: ' . htmlspecialchars($h);
                                                echo '</div>';
                                            } else {
                                                echo '<div style="line-height:1.2;">N/A</div>';
                                            }
                                            if ($i < $maxDim - 1)
                                                echo '<hr style="margin:2px 0;">';
                                        }
                                        echo '</td>';

                                        // Display quantity column
                                        $quantities = isset($row['quantity']) ? explode(',', $row['quantity']) : array();
                                        echo '<td class="align-middle">';
                                        for ($i = 0; $i < $maxItems; $i++) {
                                            $qty = isset($quantities[$i]) ? trim($quantities[$i]) : '1';
                                            echo '<h6>' . htmlspecialchars($qty) . '</h6>';
                                        }
                                        echo '</td>';

                                        $totalCost = isset($row['totalCost']) && is_numeric($row['totalCost']) ? (float) $row['totalCost'] : 0;
                                        echo '<td class="align-middle">' . '&#8369;' . number_format($totalCost, 2, '.', ',') . '</td>';
                                        echo '<td class="align-middle">' . $row['date'] . '</td>';

                                        if ($row['payment'] != 'Full Payment') {
                                            $notcom = 'hidden';
                                        } else {
                                            $notcom = '';
                                        }

                                        echo '<td class="align-middle"><span id="st_' . $row['orderID'] . '">' . $row['status'] . '</span><hr>';
                                        $queryStatus = "SELECT payment_status 
                FROM payment_receipts 
                WHERE orderID = ? 
                AND source = ? 
                AND payment_status NOT IN ('invalid', 'refunded') 
                ORDER BY id ASC"; // Assuming 'id' orders oldest first
                                
                                        $stmtStatus = $conn->prepare($queryStatus);
                                        $stmtStatus->bind_param("is", $row['orderID'], $row['source']);
                                        $stmtStatus->execute();
                                        $resultStatus = $stmtStatus->get_result();

                                        $statuses = [];
                                        $validCount = 0;
                                        $firstStatus = null;

                                        if ($resultStatus && $resultStatus->num_rows > 0) {
                                            $isFirst = true;
                                            while ($rowStatus = $resultStatus->fetch_assoc()) {
                                                if ($isFirst) {
                                                    $firstStatus = $rowStatus['payment_status'];
                                                    $isFirst = false;
                                                }
                                                $statuses[] = $rowStatus['payment_status'];
                                                $validCount++;
                                            }
                                        }

                                        // CASE 1: If any status is pending and NOT eligible to override
                                        if (in_array("Pending", $statuses) && !($row['source'] == "checkoutcustom" && $firstStatus == "Confirmed")) {
                                        } else {
                                            // Render dropdown only if not Completed or Delivered
                                            if ($row['status'] != 'Completed' && $row['status'] != 'Delivered') {
                                                echo '<select name="stats" id="stats_' . $row['orderID'] . '" class="btn btn-sm btn-primary px-0" onchange="updateStatus(' . $row['orderID'] . ', \'' . $row['source'] . '\')">';
                                                echo '<option value="" hidden>Edit Status</option>';
                                                echo '<option value="In Progress" class="bg-white text-dark">IN PROGRESS</option>';
                                                echo '<option value="Completed" class="bg-white text-dark">COMPLETED</option>';
                                                echo '<option value="Cancelled" class="bg-white text-dark">CANCELLED</option>';

                                                // Show REJECT only if valid count <= 1
                                                if ($validCount <= 1) {
                                                    echo '<option value="Rejected" class="bg-white text-dark">REJECT</option>';
                                                }

                                                echo '</select>';
                                            }
                                        }





                                        echo '</td>';
                                        if ($row['payment'] == 'Full Payment') {
                                            $selectedFullPayment = 'selected';
                                            $selectedDownPayment = '';
                                        } else if ($row['payment'] == 'Down Payment') {
                                            $selectedFullPayment = '';
                                            $selectedDownPayment = 'selected';
                                        } else {
                                            $selectedFullPayment = '';
                                            $selectedDownPayment = '';
                                        }
                                        echo '<td class="align-middle text-center">';
                                        if ($row['status'] == 'Completed' || $row['status'] == 'Delivered') {
                                            $action = 'hidden';
                                        } else {
                                            $action = '';
                                        }
                                        if ($row['status'] == 'Cancelled' || $row['status'] == 'Rejected' || $row['status'] == 'Completed' || $row['status'] == 'Delivered') {
                                            $action2 = 'd-none';
                                        } else {
                                            $action2 = '';
                                        }

                                        // Always show the balance
                                        echo '<p class="my-1" style="font-size:14px;">Balance: ' . $row['balance'] . '</p>';
                                        ?>
                                        <?php
                                        $orderID = $row['orderID'];
                                        $source = $row['source'];
                                        $key = $orderID . '|' . $source;
                                        $receiptList = isset($receiptsByOrder[$key]) ? $receiptsByOrder[$key] : [];

                                        // Calculate totalPaid
                                        $totalPaid = 0;
                                        foreach ($receiptList as $receipt) {
                                            $totalPaid += $receipt['amountPaid'];
                                        }
                                        $receiptsJson = htmlspecialchars(json_encode($receiptList), ENT_QUOTES, 'UTF-8');

                                        ?>
                                        <button type="button" class="btn btn-sm btn-primary py-0 mt-2" style="font-size:12px;"
                                            onclick='viewProofPayAll(`<?php echo $receiptsJson; ?>`, "<?php echo $orderID; ?>", "<?php echo htmlspecialchars($row["fullName"]); ?>", "<?php echo $row["balance"]; ?>", "<?php echo $totalPaid; ?>", "<?php echo $row["totalCost"]; ?>")'>
                                            View Payment
                                        </button>

                                        <?php
                                        echo '</td>';
                                        echo '</tr>';
                                    }

                                    echo '</table>';
                                } else {
                                    echo "No orders.";
                                }
                                ?>
                            </div>
                        </div>

                        <script>
                            function filterOrders(status) {
                                const table = document.getElementById("dataTable");
                                const tbody = table.querySelector("tbody");
                                const buttons = document.querySelectorAll(".btn-group button");

                                // Remove active from all buttons and add to selected
                                buttons.forEach(btn => btn.classList.remove("active"));
                                buttons.forEach(btn => {
                                    if (btn.textContent.trim().toLowerCase() === status.toLowerCase()) {
                                        btn.classList.add("active");
                                    }
                                });

                                let rows = Array.from(tbody.querySelectorAll("tr"));

                                // Show/hide rows based on filter
                                rows.forEach(row => {
                                    const statusCell = row.querySelector("td:nth-child(12) span");
                                    const rowStatus = statusCell ? statusCell.textContent.trim().toLowerCase() : "";

                                    if (status.toLowerCase() === "all" || rowStatus === status.toLowerCase()) {
                                        row.style.display = "";
                                    } else {
                                        row.style.display = "none";
                                    }
                                });

                                // If "All" selected, re-sort rows to show "On Queue" first, then orderID desc
                                if (status.toLowerCase() === "all") {
                                    const visibleRows = rows.filter(row => row.style.display !== "none");

                                    visibleRows.sort((a, b) => {
                                        const statusA = a.querySelector("td:nth-child(12) span")?.textContent.trim().toLowerCase();
                                        const statusB = b.querySelector("td:nth-child(12) span")?.textContent.trim().toLowerCase();

                                        // orderID is in the first column (td:nth-child(1))
                                        const idA = parseInt(a.querySelector("td:nth-child(1)")?.textContent) || 0;
                                        const idB = parseInt(b.querySelector("td:nth-child(1)")?.textContent) || 0;

                                        // Sort: "on queue" first, then by orderID descending
                                        if (statusA === "on queue" && statusB !== "on queue") return -1;
                                        if (statusA !== "on queue" && statusB === "on queue") return 1;

                                        return idB - idA;
                                    });

                                    // Re-append rows to tbody in new order
                                    visibleRows.forEach(row => tbody.appendChild(row));
                                }
                            }


                        </script>


                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- The Popup form -->

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


    <script>
        // Line chart (Monthly Sales)
        const ctxLine = document.getElementById('monthlySalesChart').getContext('2d');
        const monthlySalesData = <?php echo json_encode($monthlySales); ?>;
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const barColors = [
            '#FFB3BA', '#FFDFBA', '#FFFFBA', '#BAFFC9', '#BAE1FF', '#D4A5A5',
            '#FFADAD', '#FFD6A5', '#FDFFB6', '#C7F9CC', '#A2C2E1', '#FFB8D1'
        ];

        const monthlySalesChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Monthly Sales',
                    data: monthlySalesData,
                    borderColor: '#343a40',
                    fill: false,
                    tension: 0.1,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Sales (₱)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Months'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });

        // Bar chart (Total Orders)
        const ctxBar = document.getElementById('totalOrdersChart').getContext('2d');
        const totalOrdersData = <?php echo $ordersData; ?>;

        const totalOrdersChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Total Orders',
                    data: totalOrdersData,
                    backgroundColor: barColors,
                    borderColor: '#343a40',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Orders'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Months'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });



        function updateStatus(orderID, source) {
            var status = document.getElementById("stats_" + orderID).value;
            if (status === "") return;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "editstatus.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (xhr.responseText.trim() === "Status updated successfully.") {
                        // Option 1: Refresh the entire page
                        location.reload();

                        // Option 2 (alternative): Only update the DOM without reloading
                        // document.getElementById("st_" + orderID).innerHTML = status;
                    } else {
                        alert("Error updating status.");
                    }
                }
            };

            xhr.send(
                "orderID=" + encodeURIComponent(orderID) +
                "&status=" + encodeURIComponent(status) +
                "&source=" + encodeURIComponent(source)
            );
        }




        function toggleDownPayment(orderID) {
            var paymentType = document.getElementById('pay_' + orderID).value;
            var downPaymentInput = document.getElementById('pd_' + orderID);
            var balanceField = document.getElementById('balance_' + orderID);

            if (paymentType === 'Down Payment') {
                downPaymentInput.style.display = 'block';
            } else {
                downPaymentInput.style.display = 'block';
                balanceField.innerText = '0';
            }
        }


        function toggleMonthPicker() {
            var period = document.getElementById('period').value;
            var monthPicker = document.getElementById('monthPicker');
            if (period === 'monthly') {
                monthPicker.style.display = 'inline-block';
            } else {
                monthPicker.style.display = 'none';
                monthPicker.value = '';
            }
        }

        // Call toggleMonthPicker on page load to set initial state
        window.onload = function () {
            toggleMonthPicker();
        };

        function printReport() {
            var period = document.getElementById('period').value;
            var iframe = document.getElementById('reportFrame');
            var url = 'report.php?period=' + period;

            if (period === 'monthly') {
                var month = document.getElementById('monthPicker').value;
                if (month) {
                    url += '&month=' + month;
                }
            }

            iframe.src = url;

            iframe.onload = function () {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            };

            return false;
        }

        // Modal for viewing payment proof image
        // Add modal HTML at the end of body before </body>
    </script>

    <style>
        .dashed-line {
            border-top: 2px dashed #ccc;
        }

        .receipt-line {
            padding: 8px 0;
            border-bottom: 1px dashed #ddd;
            margin: 0;
        }

        .receipt-line:last-child {
            border-bottom: none;
        }

        hr.border-dashed {
            border-style: dashed !important;
        }
    </style>
    <!-- Payment Proof Modal -->
    <div class="modal fade" id="paymentProofModal" tabindex="-1" role="dialog" aria-labelledby="paymentProofModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded shadow">
                <div class="modal-header bg-light border-bottom-0">
                    <h5 class="modal-title font-weight-bold" id="paymentProofModalLabel">Payment Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close receipt">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <!-- Flex container for image and details -->
                    <div class="d-flex flex-column flex-lg-row gap-4 align-items-start">
                        <!-- Left: Image(s) -->
                        <div id="paymentProofImage" class="d-flex flex-column align-items-start">
                            <!-- Dynamic images inserted here by JS -->
                        </div>

                        <!-- Right: Details -->
                        <div class="receipt-details w-100" aria-live="polite" aria-atomic="true">
                            <!-- Dynamic content inserted here by JS -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Full Image Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-labelledby="imagePreviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark border-0">
                <div class="modal-body p-0 text-center">
                    <img id="modalImage" src="" alt="Full Size" class="img-fluid rounded" />
                </div>
            </div>
        </div>
    </div>
    <!-- Confirmation Modal -->
    <div class="modal fade" id="statusConfirmModal" tabindex="-1" role="dialog"
        aria-labelledby="statusConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="statusConfirmModalLabel">Confirm Status Change</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span> <!-- Bootstrap 4 close icon -->
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to set the status to <span id="statusToConfirm" class="fw-bold"></span>?<br>
                    <small class="text-danger">This action cannot be undone and will lock the fields.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger btn-sm" id="confirmStatusChangeBtn">Yes,
                        Update Payment</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        function viewProofPayAll(receiptsJson, orderID, senderName, balance, totalPaid, totalCost) {
            const receipts = JSON.parse(receiptsJson);
            const imgContainer = document.getElementById('paymentProofImage');
            const details = document.querySelector('.receipt-details');

            // Clear previous content
            imgContainer.innerHTML = '';
            details.innerHTML = '';

            // Calculate total paid (excluding 'Invalid' payments)
            let calculatedTotalPaid = 0;
            receipts.forEach(r => {
                if (r.payment_status !== 'Invalid' && !isNaN(parseFloat(r.amountPaid))) {
                    calculatedTotalPaid += parseFloat(r.amountPaid);
                }
            });

            // Order summary
            details.innerHTML += `
        <div class="mb-4">
            <h6 class="text-uppercase text-muted">Order Details</h6>
            <p><strong>Order No:</strong> <span class="text-muted">${orderID}</span></p>
            <div class="mb-2">
                <p><strong>Total Cost:</strong> <span class="text-muted">&#8369; ${Number(totalCost).toLocaleString('en-US', { minimumFractionDigits: 2 })}</span></p>
            </div>
          <div class="mb-2">
                <p><strong>Total Payment:</strong> <span class="text-muted">&#8369; ${Number(calculatedTotalPaid).toLocaleString('en-US', { minimumFractionDigits: 2 })}</span></p>
            </div>
            <div class="mb-2">
                <p><strong>Balance:</strong> <span class="text-muted">&#8369; ${Number(totalCost - calculatedTotalPaid).toLocaleString('en-US', { minimumFractionDigits: 2 })}</span></p>
            </div>

        </div>
        <hr class="border border-1 border-dark border-dashed">
    `;

            if (receipts.length === 0) {
                imgContainer.innerHTML = `<div class="text-muted"><p class="mt-3 mb-0">No receipt image found.</p></div>`;
                details.innerHTML += '<p class="text-muted">No receipts found.</p>';
            } else {
                usedRefNumbers = receipts.map(r => r.ref_no).filter(ref => ref && ref.trim() !== '');

                receipts.forEach((r, index) => {
                    const row = document.createElement('div');
                    row.className = 'row mb-4 align-items-center';

                    const colImg = document.createElement('div');
                    colImg.className = 'col-md-4 text-center';
                    const img = document.createElement('img');
                    img.src = r.proofImage;
                    img.alt = 'Receipt Image';
                    img.style = "box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.15); max-width: 100%; max-height: 200px; cursor: pointer;";
                    img.className = 'img-thumbnail mb-2';

                    img.addEventListener('click', () => {
                        document.getElementById('modalImage').src = r.proofImage;
                        $('#imagePreviewModal').modal('show');
                    });

                    colImg.appendChild(img);
                    row.appendChild(colImg);

                    const colDetails = document.createElement('div');
                    colDetails.className = 'col-md-8';

                    colDetails.innerHTML = `
                <div class="p-3 bg-light rounded shadow-sm">
                    <h6 class="text-muted mb-3">Receipt #${index + 1}</h6>
                    <form action="updatePayment.php" method="POST" onsubmit="return validateReceiptForm(this);">
                        <input type="hidden" name="receiptID" value="${r.id}">
                        <input type="hidden" name="orderID" value="${orderID}">
                        <input type="hidden" name="source" value="${r.source || ''}">
                        <input type="hidden" name="currentBalance" value="${balance}">
                        <input type="hidden" name="totalCost" value="${totalCost}">

                        <label for="" class="form-label"><strong>Amount Paid:</strong></label>
                        <input type="number" step="0.01" min="1000" id="amountPaid_${index}" name="amountPaid"
                            class="form-control form-control-sm" 
                            value="${r.amountPaid !== undefined ? parseFloat(r.amountPaid).toFixed(2) : ''}" 
                            required
                            readonly
                            oninput="validateAmountPaid(this, ${index})">
                        <small id="amountPaidError_${index}" class="text-danger d-none">Amount must be at least ₱1,000.00</small>

                        <div class="mb-2">
                            <label for="refNo_${index}" class="form-label"><strong>Reference No:</strong></label>
                            <input type="text" 
                                id="refNo_${index}" 
                                name="ref_no" 
                                class="form-control form-control-sm" 
                                placeholder="Enter Reference No." 
                                readonly
                                value="${r.ref_no || ''}" 
                                oninput="validateRefNo(this, ${index})">
                            <small id="refNoError_${index}" class="text-danger d-none">This reference number is already used.</small>
                        </div>

                        <div class="mb-3 d-flex flex-column">
                            <label for="paymentStatus_${index}" class="form-label ">
                            <strong>Payment Status:</strong>
                            </label>
                              <select 
    id="paymentStatus_${index}" 
    name="payment_status" 
    class="form-select form-select-sm mt-1 shadow-sm rounded text-dark fw-semibold" 
    required 
    onchange="toggleAmountEditable(${index})"
    ${['Confirmed', 'Invalid', 'Refunded'].includes(r.payment_status) ? 'disabled' : ''}
>

                                <option value="Pending" ${r.payment_status === 'Pending' ? 'selected' : ''}> Pending</option>
                                <option value="Confirmed" ${r.payment_status === 'Confirmed' ? 'selected' : ''}>Confirmed</option>
                                <option value="Invalid" ${r.payment_status === 'Invalid' ? 'selected' : ''}> Invalid</option>
                                <option value="Refunded" ${r.payment_status === 'Refunded' ? 'selected' : ''}> Refunded</option>
                            </select>
                        </div>

                        
                       
                    </form>
                    <div class="mt-2">
                        <p class="mb-2"><strong>Payment Date:</strong> <span class="text-muted">${r.paymentDate || ''}</span></p>
                        <p class="mb-2"><strong>Sender Name:</strong> <span class="text-muted">${senderName}</span></p>
                    </div>
                </div>
            `;

                    row.appendChild(colDetails);
                    details.appendChild(row);

                    if (index < receipts.length - 1) {
                        const divider = document.createElement('hr');
                        divider.className = 'border border-1 border-dark border-dashed my-4';
                        details.appendChild(divider);
                    }
                });
            }

            $('#paymentProofModal').modal('show');
        }

    </script>

    <script>
        const previousStatusMap = {};
        let pendingStatusChange = { index: null, value: null, selectEl: null, formEl: null };

        function toggleAmountEditable(index) {
            const selectEl = document.getElementById(`paymentStatus_${index}`);
            const newStatus = selectEl.value;
            const formEl = selectEl.closest('form');

            // Save the previous status if not yet saved
            if (!previousStatusMap.hasOwnProperty(index)) {
                previousStatusMap[index] = selectEl.value;
            }

            if (['Confirmed', 'Invalid', 'Refunded'].includes(newStatus)) {
                // Open confirmation modal
                document.getElementById('statusToConfirm').textContent = newStatus;
                const modal = new bootstrap.Modal(document.getElementById('statusConfirmModal'));
                modal.show();

                // Save context for action
                pendingStatusChange = { index, value: newStatus, selectEl, formEl };

                // On confirmation button click
                document.getElementById('confirmStatusChangeBtn').onclick = function () {
                    modal.hide();

                    // Lock fields
                    document.getElementById(`amountPaid_${index}`).setAttribute('readonly', true);
                    document.getElementById(`refNo_${index}`).setAttribute('readonly', true);
                    previousStatusMap[index] = newStatus;

                    // Prepare form data
                    const formData = new FormData(formEl);

                    // Submit via fetch (AJAX)
                    fetch(formEl.action, {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Network error');
                            return response.text(); // Or JSON if your server returns JSON
                        })
                        .then(data => {
                            // Optionally check server response here
                            location.reload(); // ✅ Auto-refresh the page after status change
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to update status. Please try again.');
                        });
                };

                // Cancel and revert selection if modal closes without confirming
                document.getElementById('statusConfirmModal').addEventListener('hidden.bs.modal', () => {
                    if (selectEl.value !== previousStatusMap[index]) {
                        selectEl.value = previousStatusMap[index];
                    }
                }, { once: true });

            } else {
                // Make fields editable again
                document.getElementById(`amountPaid_${index}`).removeAttribute('readonly');
                document.getElementById(`refNo_${index}`).removeAttribute('readonly');
                previousStatusMap[index] = newStatus;
            }
        }
    </script>

    <script>

    </script>

    <!-- <p class="mb-2"><strong>Payment Method:</strong> <span class="text-muted">Gcash</span></p>
    <p class="mb-0"><strong>Amount:</strong> PHP  <span class="text-success fw-bold">${r.amountPaid || ''}</span></p> -->

    <script>
        function viewProofPay(proofPayUrl, orderID, paymentTime, paymentMethod, senderName, amount) {
            // Set image src
            var img = document.getElementById('paymentProofImage');
            img.src = proofPayUrl;

            // Set text details
            document.getElementById('modalOrderID').textContent = orderID;
            document.getElementById('modalPaymentTime').textContent = paymentTime;
            document.getElementById('modalPaymentMethod').textContent = paymentMethod;
            document.getElementById('modalSenderName').textContent = senderName;
            document.getElementById('modalAmount').textContent = amount;

            // Show modal (using jQuery and Bootstrap 4 syntax)
            $('#paymentProofModal').modal('show');
        }
    </script>


</body>

</html>