<?php

include("database.php");

// Ensure the query is ordering by fID in descending order
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

if ($selectedCategory && $selectedCategory !== 'all') {
    $furnituresql = "SELECT * FROM furnituretbl WHERE category = '" . mysqli_real_escape_string($conn, $selectedCategory) . "' ORDER BY fID DESC";
} else {
    $furnituresql = "SELECT * FROM furnituretbl ORDER BY fID DESC";
}
$furnitureresult = mysqli_query($conn, $furnituresql);

$rawsql = "SELECT * FROM rawmtbl";
$rawresult = mysqli_query($conn, $rawsql);

$furnituresql1 = "SELECT * FROM furnituretbl";
$furnitureresult1 = mysqli_query($conn, $furnituresql1);
$row = mysqli_fetch_assoc($furnitureresult1);


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
            
            <li class="nav-item active">
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
            <li class="nav-item">
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
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>

                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">

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
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>

                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>

                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="row  py-3 px-3 align-items-center">
                            <div class="col-lg-6">
                                <h2 class="font-weight-bold text-primary mb-0">Furniture</h2>
                            </div>

                            <div class="col-lg-4" style="margin-right: 600px;">
                                <form method="GET" id="categoryFilterForm" class="form-inline" style="margin-right: 500px;">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-outline-primary <?php if ($selectedCategory === '' || $selectedCategory === 'all') echo 'active'; ?>">
                                            <input type="radio" name="category" value="all" autocomplete="off" onchange="this.form.submit()" <?php if ($selectedCategory === '' || $selectedCategory === 'all') echo 'checked'; ?>> All
                                        </label>
                                        <label class="btn btn-outline-primary <?php if ($selectedCategory === 'tv') echo 'active'; ?>">
                                            <input type="radio" name="category" value="tv" autocomplete="off" onchange="this.form.submit()" <?php if ($selectedCategory === 'tv') echo 'checked'; ?>> TV
                                        </label>
                                        <label class="btn btn-outline-primary <?php if ($selectedCategory === 'mirror') echo 'active'; ?>">
                                            <input type="radio" name="category" value="mirror" autocomplete="off" onchange="this.form.submit()" <?php if ($selectedCategory === 'mirror') echo 'checked'; ?>> Mirror
                                        </label>
                                        <label class="btn btn-outline-primary <?php if ($selectedCategory === 'cabinet') echo 'active'; ?>">
                                            <input type="radio" name="category" value="cabinet" autocomplete="off" onchange="this.form.submit()" <?php if ($selectedCategory === 'cabinet') echo 'checked'; ?>> Cabinet
                                        </label>
                                        <label class="btn btn-outline-primary <?php if ($selectedCategory === 'chair') echo 'active'; ?>">
                                            <input type="radio" name="category" value="chair" autocomplete="off" onchange="this.form.submit()" <?php if ($selectedCategory === 'chair') echo 'checked'; ?>> Chair
                                        </label>
                                        <label class="btn btn-outline-primary <?php if ($selectedCategory === 'table') echo 'active'; ?>">
                                            <input type="radio" name="category" value="table" autocomplete="off" onchange="this.form.submit()" <?php if ($selectedCategory === 'table') echo 'checked'; ?>> Table
                                        </label>
                                        <label class="btn btn-outline-primary <?php if ($selectedCategory === 'bed') echo 'active'; ?>">
                                            <input type="radio" name="category" value="bed" autocomplete="off" onchange="this.form.submit()" <?php if ($selectedCategory === 'bed') echo 'checked'; ?>> Bed
                                        </label>
                                        <label class="btn btn-outline-primary <?php if ($selectedCategory === 'sala') echo 'active'; ?>">
                                            <input type="radio" name="category" value="sala" autocomplete="off" onchange="this.form.submit()" <?php if ($selectedCategory === 'sala') echo 'checked'; ?>> Sala Set
                                        </label>
                                    </div>
                                </form>
                            </div>

                            <div class="col-lg-2 text-right">
                                <a type="btn" class="btn btn-primary" href="#" data-toggle="modal" data-target="#addModal" style="margin-left: 30px;">
                                    <i class="fa fa-plus"></i> Add Furniture
                                </a>
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0" style="font-size: 0.95rem;">

                                    <thead class="thead-light">
                                        <tr>
                                            <th>Furniture Name</th>

                                            <th>Category</th>

                                            <th>Image</th>

                                            <th>Quantity</th>

                                            <th>Price</th>

                                            <th>Dimension</th>

                                            <th>Description</th>

                                            <th>Date</th>

                                            <th></th>

                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>

                                            <?php
                                            while ($row = mysqli_fetch_assoc($furnitureresult)) {
                                                $getQuantity = $row['fQuantity'];

                                                if ($getQuantity == 0) {
                                                    $getfID = $row['fID'];
                                                    $getfName = $row['fName'];
                                                    $getImage = $row['image'];
                                                    $getDescription = $row['fDes'];
                                                    $getfQuantity = $row['fQuantity'];
                                                    $getCost = $row['cost'];
                                                    $getDate = $row['date'];
                                                    $autoArchiveSql = "INSERT INTO archived(ID, name, image, description, quantity, cost, date) VALUES('$getfID','$getfName','$getImage','$getDescription','$getfQuantity','$getCost','$getDate')";

                                                    if (mysqli_query($conn, $autoArchiveSql)) {
                                                        $deleteCurrentSql = "DELETE FROM furnituretbl WHERE fID = '$getfID'";
                                                        mysqli_query($conn, $deleteCurrentSql);
                                                    }
                                                }
                                                ?>

                                                <td class="align-middle"><?php echo htmlspecialchars($row['fName']); ?></td>

                                                <td class="align-middle"><?php echo htmlspecialchars($row['category']); ?></td>

                                                <td class="align-middle text-center">
                                                    <img src="./up/<?php echo htmlspecialchars($row['image']); ?>" alt="" width="150" height="150" class="img-thumbnail rounded">
                                                </td>

                                                <td class="align-middle text-center"><?php echo (int)$row['fQuantity']; ?></td>

                                                <td class="align-middle text-right">&#8369;<?php echo number_format($row['cost'], 0, '.', ','); ?></td>
                
                                                <td class="align-middle" style="min-width: 90px;">
                                                <?php
                                                    // Dimension column
                                                    // Try to get width, length, height from the row (comma-separated if multiple)
                                                    $widths = isset($row['width']) ? explode(',', $row['width']) : array();
                                                    $lengths = isset($row['length']) ? explode(',', $row['length']) : array();
                                                    $heights = isset($row['height']) ? explode(',', $row['height']) : array();
                                                    $maxItems = 1; // Default to 1 if all arrays are empty
                                                    if (!empty($widths)) $maxItems = max($maxItems, count($widths));
                                                    if (!empty($lengths)) $maxItems = max($maxItems, count($lengths));
                                                    if (!empty($heights)) $maxItems = max($maxItems, count($heights));
                                                    $maxDim = $maxItems;
                                    
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
                                                        if ($i < $maxDim - 1) echo '<hr style="margin:2px 0;">';
                                                    }
                                                ?>
                                                </td>
                
                                                <td class="align-middle"><?php echo htmlspecialchars($row['fDes']); ?></td>

                                                <td class="align-middle"><?php echo htmlspecialchars($row['date']); ?></td>

                                                <td class="align-middle text-center">
                                                    <button class="update btn btn-primary btn-sm" data-toggle="modal"
                                                            data-target="#editModal" data-id="<?php echo $row['fID']; ?>"
                                                            data-name="<?php echo htmlspecialchars($row['fName']); ?>"
                                                            data-category="<?php echo htmlspecialchars($row['category']); ?>"
                                                            data-quantity="<?php echo (int)$row['fQuantity']; ?>"
                                                            data-price="<?php echo number_format($row['cost'], 2, '.', ','); ?>"
                                                            data-description="<?php echo htmlspecialchars($row['fDes']); ?>"
                                                            data-image="<?php echo htmlspecialchars($row['image']); ?>">
                                                            Edit
                                                    </button>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <a href="archive.php?id=<?php echo $row['fID']; ?>"
                                                            type="button" class="delete btn btn-danger btn-sm">Hide</a>
                                                </td>
                                                <!-- <td><center><a href="#" data-toggle="modal" data-target="#removeModal" type="button" class="delete btn btn-danger">Remove</a></center></td> -->
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
                <!-- /.container-fluid -->

                <!--Modal edit-->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Furniture</h5>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <!-- Edit form -->
                                <form action="updateproduct.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" id="fID" name="fID">

                                    <div class="form-group">
                                        <label for="fName">Furniture Name</label>

                                        <input type="text" class="form-control" id="fName" name="fName" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="category">Category</label>

                                        <input type="text" class="form-control" id="category" name="category" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="fQuantity">Quantity</label>

                                        <input type="number" class="form-control" id="fQuantity" name="fQuantity" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="cost">Price</label>

                                        <input type="number" class="form-control" id="cost" name="cost" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="fDes">Description</label>

                                        <textarea class="form-control" id="fDes" name="fDes" rows="3" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="image">Image</label>

                                        <input type="file" class="form-control" id="image" name="image">

                                        <small id="imageHelp" class="form-text text-muted">Leave blank if you don't want
                                            to change the image.</small>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>




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
    <a class="scroll-to-top rounded" href="#page-top" style="background-color: #4e73df;">
        <i class="fas fa-angle-up" style="color: white;"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="eaddModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-lg" role="document">
            <div class="modal-content">
                <div class="container">
                    <!-- Outer Row -->
                    <div class="row justify-content-center">
                        <div class="card o-hidden border-0 my-2">
                            <div class="card-body p-0 rounded">
                                <!-- Nested Row within Card Body -->
                                <div class="col-lg-12">
                                    <div class="p-3" style="margin-left: 20px;">
                                        <div class="text-center mb-5">
                                            <h1 class="h4 text-gray-900 mb-4">Add Furniture</h1>
                                        </div>

                                        <form action="product.php" method="POST" class="user" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <input type="text" name="fName" class="form-control" placeholder="Furniture Name" required>
                                            </div>

                                            <div class="form-group">
                                                <select name="category" class="form-control" required>
                                                    <option value="" selected disabled>Select Category</option>
                                                    <option value="tv">TV</option>
                                                    <option value="mirror">Mirror</option>
                                                    <option value="cabinet">Cabinet</option>
                                                    <option value="chair">Chair</option>
                                                    <option value="table">Table</option>
                                                    <option value="bed">Bed</option>
                                                    <option value="sala">Sala Set</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <input type="file" name="Image" class="form-control" value="" placeholder="Image" required>
                                            </div>

                                            <div class="form-group">
                                                <input type="number" name="fQuantity" class="form-control" placeholder="Quantity" required>
                                            </div>

                                            <div class="form-group">
                                                <input type="number" name="cost" class="form-control" placeholder="Price" required>
                                            </div>

                                            <div class="d-flex">
                                                <div class="form-group mr-2">
                                                    <label for="" class="form-label">Width: </label>

                                                    <div class="input-group">
                                                        <!-- <div class="input-group-prepend">
                                                            <button type="button" class="btn btn-outline-secondary" onclick="stepInput('width', -1)">-</button>
                                                        </div> -->

                                                        <input type="number" name="width" id="width" class="form-control" min="1" value="1" required>

                                                        <!-- <div class="input-group-append">
                                                            <button type="button" class="btn btn-outline-secondary" onclick="stepInput('width', 1)">+</button>
                                                        </div> -->
                                                    </div>
                                                </div>

                                                <div class="form-group mr-2">
                                                    <label for="">Length: </label>

                                                    <div class="input-group">
                                                        <!-- <div class="input-group-prepend">
                                                            <button type="button" class="btn btn-outline-secondary" onclick="stepInput('length', -1)">-</button>
                                                        </div> -->

                                                        <input type="number" name="length" id="length" class="form-control" min="1" value="1" required>

                                                        <!-- <div class="input-group-append">
                                                            <button type="button" class="btn btn-outline-secondary" onclick="stepInput('length', 1)">+</button>
                                                        </div> -->
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="">Height: </label>

                                                    <div class="input-group">
                                                        <!-- <div class="input-group-prepend">
                                                            <button type="button" class="btn btn-outline-secondary" onclick="stepInput('height', -1)">-</button>
                                                        </div> -->

                                                        <input type="number" name="height" id="height" class="form-control" min="1" value="1" required>
                                                        
                                                        <!-- <div class="input-group-append">
                                                            <button type="button" class="btn btn-outline-secondary" onclick="stepInput('height', 1)">+</button>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <textarea type="text" name="fDes" id="fDes" cols="48" rows="10" class="form-control" style="height:150px;" placeholder="Description" required></textarea>
                                            </div>

                                            <button type="submit" name="submit" class="btn btns btn-user  btn-block btn-outline-dark">SUBMIT</button>
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

    <!-- Remove Modal-->
    <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
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

                    <a class="btn delete btn btn-danger " href="furDelete.php?id=<?php echo $row['fID']; ?>" type="button">Remove</a>

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
            // Initialize DataTable with descending order on the Date column (index 7)
            if (!$.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable({
                    "order": [[7, "desc"]],
                    "paging": true,
                    "searching": true,
                    "lengthChange": true,
                    "info": true
                });
            }
        });

        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var fID = button.data('id');
            var fName = button.data('name');
            var category = button.data('category');
            var fQuantity = button.data('quantity');
            var cost = button.data('price');
            var fDes = button.data('description');
            var image = button.data('image');

            var modal = $(this);
            modal.find('#fID').val(fID);
            modal.find('#fName').val(fName);
            modal.find('#category').val(category);
            modal.find('#fQuantity').val(fQuantity);
            modal.find('#cost').val(cost);
            modal.find('#fDes').val(fDes);
            modal.find('#imagePreview').attr('src', './up/' + image);
        });
    </script>

    <style>
        /* Improve table and page styling for smoother look */
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
            color: #5a5c69;
        }
        .card {
            border-radius: 0.75rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgb(58 59 69 / 15%);
        }
        .card .row.py-3.px-3 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
        h2.text-primary {
            color: #4e73df !important;
        }
        table.dataTable thead th {
            background-color: #4e73df;
            color: white;
            font-weight: 600;
            border-bottom: none;
        }
        table.dataTable tbody tr:hover {
            background-color: #dbe4f7;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
        .form-control {
            border-radius: 0.35rem;
            border: 1px solid #d1d3e2;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 8px rgba(78, 115, 223, 0.5);
        }
        label {
            font-weight: 600;
            color: #4e73df;
        }
        /* Scroll to top button style */
        .scroll-to-top {
            background-color: #4e73df !important;
        }
        .scroll-to-top i {
            color: white !important;
        }
    </style>

</body>

</html>
