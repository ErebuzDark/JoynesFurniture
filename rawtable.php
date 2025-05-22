<?php

session_start();

include("database.php");

$furnituresql = "SELECT * FROM furnituretbl";
$furnitureresult = mysqli_query($conn, $furnituresql);

$rawsql = "SELECT * FROM rawmtbl";
$rawresult = mysqli_query($conn, $rawsql);

$varsql = "SELECT * FROM varnishtbl";
$varresult = mysqli_query($conn, $varsql);




?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Furniture Product</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/newstyle.css" rel="stylesheet">


    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="logo sidebar-brand d-flex align-items-center justify-content-center" href="admin.php">
                <div class="sidebar-brand-icon ">
                    <img src="logo.png" class="img-fluid ">
                </div>
            </a>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item mt-5">
                <a class="nav-link" href="admin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
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


            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link collapsed" href="rawtable.php">
                    <i class="fas fa-solid fa-tree"></i>
                    <span>Raw Materials</span>
                </a>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link " href="suppliers.php">
                    <i class="fas fa-solid fa-user"></i>
                    <span>Suppliers</span>
                </a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
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
                <nav
                    class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow align-items-center">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>



                    <!-- Topbar Navbar -->

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
                    <div class="container-fluid">
                        <!-- Toggle Buttons -->
                        <div class="d-flex justify-content-center mb-4">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons" id="toggleButtons">
                                <label class="btn btn-outline-primary active" id="btnWood" style="border-radius: 30px 0 0 30px; padding: 10px 30px; font-weight: 600; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: background-color 0.3s ease;">
                                    <input type="radio" name="options" autocomplete="off" checked> Wood
                                </label>
                                <label class="btn btn-outline-primary" id="btnVarnish" style="border-radius: 0 30px 30px 0; padding: 10px 30px; font-weight: 600; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: background-color 0.3s ease;">
                                    <input type="radio" name="options" autocomplete="off"> Varnish
                                </label>
                            </div>
                        </div>

                        <!-- Woods Table Container -->
                        <div id="woodsContainer" style="display: block; opacity: 1; transition: opacity 0.5s ease;">
                            <div class="card shadow mb-4">
                                <div class="row  py-3 px-3">
                                    <div class="col-lg-10">
                                        <h2 class=" font-weight-bold text-primary">Woods</h2>
                                    </div>
                                    <div class="col-lg-2">
                                        <a type="btn" class="btn btn-primary  " href="#" data-toggle="modal"
                                            data-target="#addModal" style="margin-left: 50px;">
                                            <i class="fa fa-plus"></i>Add Wood
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="woodsTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>

                                                    <th>Wood Name</th>
                                                    <th>Image</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Description</th>
                                                    <th>Date</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($rawresult)) {
                                                        ?>
                                                        <td><?php echo $row['pName']; ?></td>
                                                        <td>
                                                            <center><img src="./up/<?php echo $row['image']; ?>" alt="" width="150"
                                                                    height="150"></center>
                                                        </td>
                                                        <td><?php echo $row['pQuantity']; ?></td>
                                                        <td>&#8369;<?php echo number_format($row['pCost'], 0, '.', ','); ?></td>
                                                        <td><?php echo $row['pDes']; ?></td>
                                                        <td><?php echo $row['date']; ?></td>
                                                        <td>
                                                            <center><button class="update btn btn-primary" data-toggle="modal"
                                                                    data-target="#editRawModal" data-id="<?php echo $row['pID']; ?>"
                                                                    data-name="<?php echo $row['pName']; ?>"
                                                                    data-quantity="<?php echo $row['pQuantity']; ?>"
                                                                    data-price="<?php echo $row['pCost']; ?>"
                                                                    data-description="<?php echo $row['pDes']; ?>"
                                                                    data-image="<?php echo $row['image']; ?>">
                                                                    Edit
                                                                </button></center>
                                                        </td>
                                                        <td>
                                                            <center><a href="rawmdelete.php?id=<?php echo $row['pID']; ?>"><button
                                                                        class="delete btn btn-danger">Remove</button></a></center>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Varnish Table Container -->
                        <div id="varnishContainer" style="display: none; opacity: 0; transition: opacity 0.5s ease;">
                            <div class="card shadow mb-4">
                                <div class="row  py-3 px-3">
                                    <div class="col-lg-10">
                                        <h2 class=" font-weight-bold text-primary">VARNISH</h2>
                                    </div>
                                    <div class="col-lg-2">
                                        <a type="btn" class="btn btn-primary  " href="#" data-toggle="modal"
                                            data-target="#addvarnishModal" style="margin-left: 50px;">
                                            <i class="fa fa-plus"></i>Add Varnish
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="varnishTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>

                                                    <th>Varnish Name</th>
                                                    <th>Image</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Description</th>
                                                    <th>Date</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($varresult)) {
                                                        ?>
                                                        <td><?php echo $row['vName']; ?></td>
                                                        <td>
                                                            <center><img src="./up/<?php echo $row['image']; ?>" alt="" width="150"
                                                                    height="150"></center>
                                                        </td>
                                                        <td><?php echo $row['vQuantity']; ?></td>
                                                        <td>&#8369;<?php echo number_format($row['cost'], 0, '.', ','); ?></td>
                                                        <td><?php echo $row['vDes']; ?></td>
                                                        <td><?php echo $row['date']; ?></td>
                                                        <td>
                                                            <center><button class="update btn btn-primary" data-toggle="modal"
                                                                    data-target="#editVarnishModal"
                                                                    data-id="<?php echo $row['ID']; ?>"
                                                                    data-name="<?php echo $row['vName']; ?>"
                                                                    data-quantity="<?php echo $row['vQuantity']; ?>"
                                                                    data-price="<?php echo $row['cost']; ?>"
                                                                    data-description="<?php echo $row['vDes']; ?>"
                                                                    data-image="<?php echo $row['image']; ?>">
                                                                    Edit
                                                                </button></center>
                                                        </td>
                                                        <td>
                                                            <center><a href="varnishdelete.php?id=<?php echo $row['ID']; ?>"><button
                                                                        class="delete btn btn-danger">Remove</button></a></center>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- /.container-fluid -->

            </div>
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

    <!-- Modal for Adding Wood -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="eaddModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-lg" role="document">
            <div class="modal-content">
                <div class="container">
                    <!-- Outer Row -->
                    <div class="row justify-content-center">
                        <div class="card o-hidden border-0 my-2">
                            <div class="card-body p-0 rounded">
                                <!-- Nested Row within Card Body -->
                                <div class="col-lg-12">
                                    <div class="p-3">
                                        <div class="text-center mb-5">
                                            <h1 class="h4 text-gray-900 mb-4">Add New Wood</h1>
                                        </div>
                                        <!-- Corrected form action -->
                                        <form action="" method="POST" class="user" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <input type="text" name="pName" class="form-control"
                                                    placeholder="Wood Name" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="file" name="image" class="form-control" value=""
                                                    placeholder="Image">
                                            </div>
                                            <div class="form-group">
                                                <input type="number" name="pQuantity" class="form-control"
                                                    placeholder="Quantity" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" name="cost" class="form-control"
                                                    placeholder="Price" required>
                                            </div>
                                            <div class="form-group">
                                                <textarea type="text" name="pDes" id="fDes" cols="48" rows="10"
                                                    class="input2 form-control" placeholder="Description"></textarea>
                                            </div>

                                            <button type="submit" name="submitWood"
                                                class="btn btns btn-user btn-block btn-outline-dark">
                                                SUBMIT
                                            </button>
                                        </form>

                                        <?php 
                                        if (isset($_POST['submitWood'])) {
                                            $pName = $_POST['pName'];
                                            $pQuantity = $_POST['pQuantity'];
                                            $cost = $_POST['cost'];
                                            $pDes = $_POST['pDes'];
                                            $date = date('y-m-d');

                                            $filename = $_FILES['image']['name'];
                                            $tempname = $_FILES['image']['tmp_name'];
                                            $folder = "./up/" . $filename;

                                            $addWoodSql = "INSERT INTO rawmtbl(pName, image, pQuantity, pCost, pDes, date) VALUES('$pName','$filename','$pQuantity','$cost','$pDes','$date')";

                                            if (mysqli_query($conn, $addWoodSql)) {
                                                move_uploaded_file($tempname, $folder);
                                                echo "<script>window.location.href='./rawtable.php';</script>";
                                            }
                                        }
                                        ?>

                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addvarnishModal" tabindex="-1" role="dialog" aria-labelledby="eaddModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-lg" role="document">
            <div class="modal-content">
                <div class="container">
                    <!-- Outer Row -->
                    <div class="row justify-content-center">
                        <div class="card o-hidden border-0 my-2">
                            <div class="card-body p-0 rounded">
                                <!-- Nested Row within Card Body -->
                                <div class="col-lg-12">
                                    <div class="p-3">
                                        <div class="text-center mb-5">
                                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        </div>
                                        <form action="varnishadd.php" method="POST" class="user"
                                            enctype="multipart/form-data">
                                            <div class="form-group">
                                                <input type="text" name="vName" class="form-control"
                                                    placeholder="Varnish Name" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="file" name="image" class="form-control" value=""
                                                    placeholder="Image">
                                            </div>
                                            <div class="form-group">
                                                <input type="number" name="vQuantity" class="form-control"
                                                    placeholder="Quantity" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" name="cost" class="form-control"
                                                    placeholder="Price" required>
                                            </div>
                                            <div class="form-group">
                                                <textarea type="text" name="vDes" id="fDes" cols="48" rows="10"
                                                    class="input2 form-control" placeholder="Description"></textarea>
                                            </div>

                                            <button type="submit" name="submit"
                                                class="btn btns btn-user  btn-block btn-outline-dark">
                                                SUBMIT
                                            </button>
                                        </form>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

    <!-- Modal for Raw Material Edit -->
    <div class="modal fade" id="editRawModal" tabindex="-1" aria-labelledby="editRawModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRawModalLabel">Edit Raw Material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="updateRaw.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="rawID" name="rawID">

                        <div class="form-group">
                            <label for="rawName">Wood Name</label>
                            <input type="text" class="form-control" id="rawName" name="rawName" required>
                        </div>
                        <div class="form-group">
                            <label for="rawQuantity">Quantity</label>
                            <input type="number" class="form-control" id="rawQuantity" name="rawQuantity" required>
                        </div>
                        <div class="form-group">
                            <label for="rawPrice">Price</label>
                            <input type="number" class="form-control" id="rawPrice" name="rawPrice" required>
                        </div>
                        <div class="form-group">
                            <label for="rawDescription">Description</label>
                            <textarea class="form-control" id="rawDescription" name="rawDescription" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="rawImage">Image</label>
                            <input type="file" class="form-control" id="rawImage" name="rawImage">
                            <small class="form-text text-muted">Leave blank if you don't want to change the
                                image.</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Varnish Edit -->
    <div class="modal fade" id="editVarnishModal" tabindex="-1" aria-labelledby="editVarnishModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVarnishModalLabel">Edit Varnish</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="updateVarnish.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="varnishID" name="varnishID">

                        <div class="form-group">
                            <label for="varnishName">Varnish Name</label>
                            <input type="text" class="form-control" id="varnishName" name="varnishName" required>
                        </div>
                        <div class="form-group">
                            <label for="varnishQuantity">Quantity</label>
                            <input type="number" class="form-control" id="varnishQuantity" name="varnishQuantity"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="varnishPrice">Price</label>
                            <input type="number" class="form-control" id="varnishPrice" name="varnishPrice" required>
                        </div>
                        <div class="form-group">
                            <label for="varnishDescription">Description</label>
                            <textarea class="form-control" id="varnishDescription" name="varnishDescription" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="varnishImage">Image</label>
                            <input type="file" class="form-control" id="varnishImage" name="varnishImage">
                            <small class="form-text text-muted">Leave blank if you don't want to change the
                                image.</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
    $(document).ready(function () {
        // Initialize DataTable for Woods table
        if (!$.fn.DataTable.isDataTable('#woodsTable')) {
            $('#woodsTable').DataTable({
                "order": [[5, "desc"]] // Order by the first column in descending order
            });
        }

        // Initialize DataTable for Varnish table
        if (!$.fn.DataTable.isDataTable('#varnishTable')) {
            $('#varnishTable').DataTable({
                "order": [[5, "desc"]] // Order by the first column in descending order
            });
        }

        // Toggle tables on button click with animation
        $('#btnWood').click(function () {
            if (!$(this).hasClass('active')) {
                $('#btnVarnish').removeClass('active');
                $(this).addClass('active');
                $('#varnishContainer').css('opacity', '0');
                setTimeout(function () {
                    $('#varnishContainer').hide();
                    $('#woodsContainer').show();
                    $('#woodsContainer').css('opacity', '1');
                }, 300);
            }
        });

        $('#btnVarnish').click(function () {
            if (!$(this).hasClass('active')) {
                $('#btnWood').removeClass('active');
                $(this).addClass('active');
                $('#woodsContainer').css('opacity', '0');
                setTimeout(function () {
                    $('#woodsContainer').hide();
                    $('#varnishContainer').show();
                    $('#varnishContainer').css('opacity', '1');
                }, 300);
            }
        });
    });

    $('#editRawModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#rawID').val(button.data('id'));
        $('#rawName').val(button.data('name'));
        $('#rawQuantity').val(button.data('quantity'));
        $('#rawPrice').val(button.data('price'));
        $('#rawDescription').val(button.data('description'));
    });

    $('#editVarnishModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#varnishID').val(button.data('id'));
        $('#varnishName').val(button.data('name'));
        $('#varnishQuantity').val(button.data('quantity'));
        $('#varnishPrice').val(button.data('price'));
        $('#varnishDescription').val(button.data('description'));
    });
    </script>
</body>
</html>
