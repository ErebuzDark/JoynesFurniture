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

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="logo sidebar-brand d-flex align-items-center justify-content-center" href="admin.php">
                <div class="sidebar-brand-icon ">
                    <img src="logo.png" class="img-fluid ">
                </div>
            </a>

            <li class="nav-item active mt-5">
                <a class="nav-link" href="admin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">

            <div class="sidebar-heading">Interface</div>

            <li class="nav-item">
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

                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

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
                                                <span class="font-weight-bold">[Order ID: <?php echo $order['orderID']; ?>] New Order - <?php echo $order['productName']; ?></span>
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
                                                    [Order ID: <?php echo $payment['orderID']; ?>] Pending Payment - <?php echo $payment['productName']; ?>
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

                <!-- Begin Page Content -->
                <div class="px-5">
                    <div class="row g-4 my-3">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Sales</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                &#8369;<?php echo number_format($ttlsls, 0, '.', ','); ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Orders to approve -->
                        <div class="col">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Orders Awaiting Approval
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $totalQueue; ?> orders</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-thumbs-up fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- On progress -->
                        <div class="col">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Ongoing Orders
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo $onGo; ?> orders
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas  fa-hourglass-half fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- sold furniture-->
                        <div class="col">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sold
                                                Furniture
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"></div>
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php echo $complete; ?> sold
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cart-arrow-down fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g2 my-3">
                        <div class="col-12">
                            <div class="border bg-white p-3" style="height: 60vh;">
                                <h5 class="mb-2">Sales</h5>
                                <div style="height: calc(100% - 50px);">
                                    <canvas id="monthlySalesChart" style="width: 100%; height: 90%;"></canvas>
                                </div>
                                <div class="d-flex justify-content-between mt-2 px-2">
                                    <p><i class="fas fa-calendar-alt rounded-circle text-white bg-warning p-2"
                                            style="font-size:14px;"></i> Year: <?php echo $year; ?></p>
                                    <p><span class="rounded-circle px-2 text-white bg-success fw-bold">&#8369;</span>
                                        Total Sales: <?php echo $ttlsls; ?></p>
                                </div>
                            </div>
                        </div>


                        <!-- <div class="col-5">
                            <div class="border border-dark border-5 bg-white p-3">
                                <div>monthlySalesChart
                                    <canvas height="300" id="totalOrdersChart"></canvas>
                                </div>
                                <div class="d-flex justify-content-center mt-2 px-2">
                                    <h5>Total Orders (Every Month)</h5>
                                </div>
                            </div>
                        </div> -->
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

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        if (xhr.responseText === "Status updated successfully.") {
                            document.getElementById("st_" + orderID).innerHTML = status;
                        } else {
                            alert("Error updating status.");
                        }
                    }
                };

                xhr.send("orderID=" + orderID + "&status=" + encodeURIComponent(status) + "&source=" + source);
            }



            function toggleDownPayment(orderID) {
                var paymentType = document.getElementById('pay_' + orderID).value;
                var downPaymentInput = document.getElementById('pd_' + orderID);
                var balanceField = document.getElementById('balance_' + orderID);

                if (paymentType === 'Down Payment') {
                    downPaymentInput.style.display = 'block';
                } else {
                    downPaymentInput.style.display = 'none';
                    balanceField.innerText = '0';
                }
            }


            function printReport() {
                var period = document.getElementById('period').value;

                var iframe = document.getElementById('reportFrame');
                iframe.src = 'report.php?period=' + period;

                iframe.onload = function() {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                };

                return false;
            }

            function viewProofPay(proofPayUrl) {
                window.open(proofPayUrl, '_blank');
            }
        </script>


</body>

</html>