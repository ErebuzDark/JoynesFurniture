<?php

include("database.php");

if (isset($_GET['orderID']) && isset($_GET['source'])) {
    $orderID = $_GET['orderID'];
    $source = $_GET['source'];
    $sql = "";
    if ($source === 'checkout') {
        $sql = "SELECT * FROM checkout WHERE orderID = ?";
    } elseif ($source === 'checkoutcustom') {
        $sql = "SELECT * FROM checkoutcustom WHERE orderID = ?";
    } else {
        header("Location: admin.php?error=invalid_source");
        exit;
    }
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $orderID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $images = explode(',', $row['image']);


        } else {
            header("Location: admin.php?error=no_order_found");
            exit;
        }
        $stmt->close();
    } else {
        header("Location: admin.php?error=statement_failed");
        exit;
    }
} else {
    header("Location: admin.php?error=missing_params");
    exit;
}

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

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="logo sidebar-brand d-flex align-items-center justify-content-center" href="admin.html">
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
                    <form action="" method="post">
                        <div class="bg-white p-5">
                            <div class="row row-cols-3">
                                <div class="d-flex align-items-center">
                                    <label for="fullName" class="mx-2 mb-0">Customer's Name: </label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <label for="address" class="mx-2 mb-0">Address: </label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <label for="cpNum" class="mx-2 mb-0">Phone Number: </label>
                                </div>
                            </div>
                            <div class="row row-cols-3 mt-0">
                                <div class="d-flex align-items-center">
                                    <input type="text" name="fullName" id="fullName"
                                        class="form-control form-control-sm  rounded border-0 mx-3" readonly
                                        value="<?php echo $row['fullName']; ?>">
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="text" name="address" id="address"
                                        class="form-control form-control-sm  rounded border-0 mx-3" readonly
                                        value="<?php echo $row['address']; ?>">
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="text" name="cpNum" id="cpNum"
                                        class="form-control form-control-sm  rounded border-0 mx-3" readonly
                                        value="<?php echo $row['cpNum']; ?>">
                                </div>
                            </div>

                            <hr>


                            <div class="d-flex justify-content-center">
                                <?php
                                foreach ($images as $image):
                                    echo '<img src="' . trim($image) . '" class="img-fluid rounded-circle m-2" style="width: 100px; height: 100px; object-fit:cover;" alt="">';
                                endforeach;
                                ?>
                            </div>


                            <div class="row row-cols-2">
                                <div class="d-flex align-items-center">
                                    <label for="address" class="mx-2 mb-0">Address: </label>
                                </div>
                            </div>

                        </div>

                    </form>
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

</body>

</html>