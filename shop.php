<?php
include("functions.php");

$salaSql = "SELECT * FROM furnituretbl WHERE category = 'sala' ORDER BY fID DESC";
$salaResult = mysqli_query($conn, $salaSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Joyness Furniture Shop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">


    <!-- Libraries Stylesheet -->
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link type="image/png" sizes="16x16" rel="icon" href=".../icons8-wardrobe-ios11-16.png">
    <meta name="msapplication-square70x70logo" content=".../icons8-wardrobe-ios11-70.png">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
        .nav-text:hover {
            background-color: orange !important;
            color: white !important;

        }


        .fruite-name:hover {
            background-color: orange !important;
            color: white;
            border-radius: 30px;
        }

        .fruite-name {
            margin-bottom: 5px !important;
        }

        a {
            color: black !important;

        }

        a:hover {
            color: #e47011 !important;

        }

        .page-header {
            background-image: url(./img/1.jpg) !important;

        }

        #detail-box {
            position: absolute;
            max-width: 400px;
            background-color: white;
            border: 3px solid orange !important;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: none;
            z-index: 1000;
            margin-left: -100px;
            padding-bottom: 20px;
        }

        #detail-box::after {
            content: '';
            position: absolute;
            bottom: -10px;
            right: 10px;
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-top: 10px solid orange;
            z-index: 3000;

        }
    </style>

</head>
<?php
if (isset($_GET['page-nr'])) {

    $id = $_GET['page-nr'];
} else {

    $id = 1;

}

?>
<?php

$sql = "
    SELECT status, SUM(total) AS total FROM (
        SELECT 'Pending Approval' AS status, COUNT(*) AS total 
        FROM checkoutcustom 
        WHERE status = 'Pending Approval' AND userID = $userID

        UNION ALL

        SELECT 'Pending Approval' AS status, COUNT(*) AS total 
        FROM checkout 
        WHERE status = 'Pending Approval' AND userID = $userID

        UNION ALL

        SELECT 'On Progress' AS status, COUNT(*) AS total 
        FROM checkoutcustom 
        WHERE status = 'In progress' AND userID = $userID

        UNION ALL

        SELECT 'On Progress' AS status, COUNT(*) AS total 
        FROM checkout 
        WHERE status = 'In progress' AND userID = $userID

        UNION ALL

        SELECT 'Completed' AS status, COUNT(*) AS total 
        FROM checkoutcustom 
        WHERE status = 'Completed' AND userID = $userID

        UNION ALL

        SELECT 'Completed' AS status, COUNT(*) AS total 
        FROM checkout 
        WHERE status = 'Completed' AND userID = $userID
    ) AS combined
    GROUP BY status
";

$result = $conn->query($sql);

$notifications = [
    'Pending Approval' => 0,
    'On Progress' => 0,
    'Completed' => 0,
];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[$row['status']] = $row['total'];
    }
}

// Total count of all notifications (if greater than 0)
$totalNotifications = array_sum(array_filter($notifications));


// Total notification count (only count those > 0)
$totalNotifications = array_sum(array_filter($notifications));
?>

<body id="<?php echo $id; ?>">
    <?php if (isset($_SESSION['success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?php echo addslashes($_SESSION['success']); ?>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo addslashes($_SESSION['error']); ?>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000
            });
        </script>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_refNo'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Duplicate Reference',
                text: '<?php echo addslashes($_SESSION['error_refNo']); ?>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        </script>
        <?php unset($_SESSION['error_refNo']); ?>
    <?php endif; ?>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class=" topbar  d-none d-lg-flex">

        </div>

        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <img class="logo" src="./img/logo1.png" alt="Bootstrap" style="width: 200px">

                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>

                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="shop.php" class="position-relative me-3 my-auto text-primary fw-bold">Home</a>

                        <a href="customize.php" class="position-relative me-3 my-auto text-dark">Customize</a>

                        <a href="Profile.php" class="position-relative me-3 my-auto text-dark">Purchase</a>
                    </div>

                    <div class="d-flex m-3 me-0">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link position-relative <?php echo $totalNotifications > 0 ? 'fw-bold text-dark' : 'text-muted'; ?> p-0"
                                    href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fas fa-bell fa-fw fs-1"></i>
                                    <?php if ($totalNotifications > 0): ?>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                                            <?php echo $totalNotifications; ?>
                                        </span>
                                    <?php endif; ?>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in"
                                    aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header">Notifications</h6>

                                    <?php if ($notifications['Pending Approval'] > 0): ?>
                                        <a class="dropdown-item d-flex align-items-center" href="profile.php#on-queue">
                                            <div class="me-3">
                                                <div class="icon-circle">
                                                    <i class="fas fa-hourglass-start text-warning"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500"><?php echo date('F j, Y'); ?></div>
                                                <span
                                                    class="<?php echo $notifications['Pending Approval'] > 0 ? 'fw-bold' : ''; ?>">
                                                    <?php echo $notifications['Pending Approval']; ?> order(s) pending
                                                    approval
                                                </span>
                                            </div>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($notifications['On Progress'] > 0): ?>
                                        <a class="dropdown-item d-flex align-items-center" href="profile.php#on-progress">
                                            <div class="me-3">
                                                <div class="icon-circle">
                                                    <i class="fas fa-cogs text-success"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500"><?php echo date('F j, Y'); ?></div>
                                                <span
                                                    class="<?php echo $notifications['On Progress'] > 0 ? 'fw-bold' : ''; ?>">
                                                    <?php echo $notifications['On Progress']; ?> order(s) on progress
                                                </span>
                                            </div>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($notifications['Completed'] > 0): ?>
                                        <a class="dropdown-item d-flex align-items-center" href="profile.php#completed">
                                            <div class="me-3">
                                                <div class="icon-circle">
                                                    <i class="fas fa-check-circle text-primary"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500"><?php echo date('F j, Y'); ?></div>
                                                <span
                                                    class="<?php echo $notifications['Completed'] > 0 ? 'fw-bold' : ''; ?>">
                                                    <?php echo $notifications['Completed']; ?> order(s) completed
                                                </span>
                                            </div>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($totalNotifications == 0): ?>
                                        <div class="dropdown-item text-center small text-gray-500">No new notifications
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        </ul>
                        <a href="customize.php" class="position-relative me-3 my-auto">

                            <img width="40" height="40" src="https://img.icons8.com/ios-filled/50/737373/hammer.png"
                                alt="hammer" /></a>

                        <a href="cart.php" class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x text-muted"></i>

                            <span
                                class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                                style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?php echo $i; ?></span>
                        </a>

                        <div class="nav-item dropdown">
                            <i class="fas fa-user fa-2x"></i>

                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="profile.php" class="dropdown-item">My Profile</a>

                                <a href="logout.php" class="dropdown-item">Log Out</a>
                            </div>

                        </div>

                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->





    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6" style="text-decoration: underline;">Show Room</h1>
    </div>
    <!-- Single Page Header End -->


    <!-- -->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class ">
                <form method="POST" action="functions.php">
                    <div class="col-lg-4 text-start ms-5">
                        <h1>Categories</h1>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="col-lg-8 text-end">
                                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                                            <li class="nav-item">
                                                <a class="d-flex m-2 py-2 rounded-pill nav-text active"
                                                    data-bs-toggle="pill" href="#tab-1"><img class="ms-2 me-2"
                                                        width="20" height="20"
                                                        src="https://img.icons8.com/fluency-systems-filled/50/border-all.png"
                                                        alt="chair" /><span>All Products</span>
                                                    <span class="text-dark text-end me-3"
                                                        style="width: 135px;">(<?php echo $all ?>)</span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="d-flex py-2 m-2 rounded-pill nav-text" data-bs-toggle="pill"
                                                    href="#tab-2"><img class="me-2 ms-2" width="20" height="20"
                                                        src="https://img.icons8.com/ios-filled/50/dressing-table.png"
                                                        alt="dressing-table" /><span>Mirrors</span>
                                                    <span class="text-dark text-end me-3"
                                                        style="width: 170px;">(<?php echo $mir ?>)</span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="d-flex m-2 py-2 rounded-pill nav-text" data-bs-toggle="pill"
                                                    href="#tab-3"><img class="me-2 ms-2" width="20" height="20"
                                                        src="https://img.icons8.com/ios-glyphs/30/wardrobe.png"
                                                        alt="wardrobe" /><span>Cabinets</span>
                                                    <span class="text-dark text-end me-3"
                                                        style="width: 160px;">(<?php echo $cab ?>)</span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="d-flex m-2 py-2 rounded-pill nav-text" data-bs-toggle="pill"
                                                    href="#tab-4"><img class="ms-2 me-2" width="20" height="20"
                                                        src="https://img.icons8.com/ios-filled/50/chair.png"
                                                        alt="chair" /><span>Chairs</span>
                                                    <span class="text-dark text-end me-3"
                                                        style="width: 180px;">(<?php echo $ch ?>)</span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="d-flex m-2 py-2 rounded-pill nav-text" data-bs-toggle="pill"
                                                    href="#tab-5"><img class="ms-2 me-2" width="20" height="20"
                                                        src="https://img.icons8.com/ios-filled/50/table.png"
                                                        alt="table" /><span>Tables</span>
                                                    <span class="text-dark text-end me-3"
                                                        style="width: 180px;">(<?php echo $tab ?>)</span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="d-flex m-2 py-2 rounded-pill nav-text" data-bs-toggle="pill"
                                                    href="#tab-6"><img class="ms-2 me-2" width="20" height="20"
                                                        src="https://img.icons8.com/ios-filled/50/bed.png"
                                                        alt="chair" /><span>Bedframe</span>
                                                    <span class="text-dark text-end me-3"
                                                        style="width: 155px;">(<?php echo $bed ?>)</span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="d-flex m-2 py-2 rounded-pill nav-text" data-bs-toggle="pill"
                                                    href="#tab-7"><img class="ms-2 me-2" width="20" height="20"
                                                        src="https://img.icons8.com/ios-filled/50/restaurant-table.png"
                                                        alt="chair" /><span>Sala Set</span>
                                                    <span class="text-dark text-end me-3"
                                                        style="width: 170px;">(<?php echo $sala ?>)</span>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="d-flex m-2 py-2 rounded-pill nav-text" data-bs-toggle="pill"
                                                    href="#tab-8"><img class="ms-2 me-2" width="20" height="20"
                                                        src="https://img.icons8.com/ios-filled/50/tv.png"
                                                        alt="chair" /><span>Tv Stand</span>
                                                    <span class="text-dark text-end me-3"
                                                        style="width: 163px;">(<?php echo $tvs ?>)</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="position-relative">
                                        <img src="img/gilid 1.jpg" class="img-fluid w-100 rounded" alt="">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane fade show p-0 active">
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="row g-4">

                                                <?php
                                                while ($row = mysqli_fetch_assoc($furResult)) {
                                                    $number = $row['cost'];
                                                    $fID = $row['fID'];
                                                    $formattedNumber = number_format($number, 0, '.', ',');
                                                    $cost = $formattedNumber;


                                                    $csold = "SELECT COUNT(orderID) AS count FROM checkout WHERE (status = 'Completed' OR status = 'Delivered') AND fID = '$fID'";
                                                    $soldres = mysqli_query($conn, $csold);

                                                    $sold = mysqli_fetch_assoc($soldres);
                                                    $count = $sold['count'];

                                                    $totQtySql = "SELECT SUM(quantity) FROM checkout WHERE (status = 'Completed' OR status = 'Delivered') AND fID = '$fID'";
                                                    $totQtyResult = mysqli_query($conn, $totQtySql);
                                                    $totQtyRow = mysqli_fetch_assoc($totQtyResult);

                                                    $totSold = $totQtyRow['SUM(quantity)'] ?? 0;

                                                    if ($row['fQuantity'] !== 0) {
                                                        ?>

                                                        <div class="col-md-6 col-lg-6 col-xl-4 mt-5 ">
                                                            <div class="rounded position-relative fruite-item border fia"
                                                                data-image="./up/<?php echo $row['image']; ?>"
                                                                data-name="<?php echo $row['fName']; ?>"
                                                                data-cost="&#8369;<?php echo $cost; ?>"
                                                                data-count="<?php echo $totSold; ?>"
                                                                data-des="<?php echo $row['fDes']; ?>">

                                                                <form method="POST" action="functions.php">
                                                                    <div class="fruite-img">
                                                                        <a href="shop-detail.php?id=<?php echo $row['fID']; ?>">
                                                                            <img src="./up/<?php echo $row['image']; ?>"
                                                                                class="img-fluid w-100 rounded-top" alt=""></a>

                                                                    </div>

                                                                    <!-- <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Fruits</div> -->
                                                                    <!-- hotFunction -->
                                                                    <?php
                                                                    $one_week_ago = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                            
                                                                    if ($row['date'] >= $one_week_ago) { ?>
                                                                        <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                            style="top: 10px; right: 10px;">New!</div>
                                                                    <?php } ?>

                                                                    <?php
                                                                    if ($totSold >= 10) { ?>
                                                                        <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                            style="top: 10px; right: 10px;">Hot!</div>
                                                                    <?php } ?>


                                                                    <!-- hotFunction -->

                                                                    <div class="p-4 rounded-bottom">
                                                                        <h4><?php echo $row['fName']; ?></h4>

                                                                        <div
                                                                            class="d-flex justify-content-between flex-lg-wrap">
                                                                            <p class="text-dark fs-5 fw-bold mb-0">
                                                                                &#8369;<?php echo $cost; ?></p>
                                                                        </div>

                                                                        <div
                                                                            class="d-flex justify-content-between flex-lg-wrap">
                                                                            <button type="submit"
                                                                                class=" btn border border-secondary rounded-pill px-2 text-primary mt-4"
                                                                                name="add"><i class="fa fa-shopping-cart"
                                                                                    aria-hidden="true"></i> Add to cart</button>

                                                                            <input type="hidden"
                                                                                value="<?php echo $row['fID']; ?>" name="id">

                                                                            <input type="hidden" value="1" name="quantity">

                                                                            <a data-id='<?php echo $row['fID']; ?>'
                                                                                type="submit"
                                                                                class="btn check border d-flex align-items-center border-secondary rounded-pill px-2 text-primary mt-4"
                                                                                name="check"
                                                                                value="<?php echo $row['fQuantity']; ?>"><i
                                                                                    class="fa fa-shopping-bag me-2"></i>Check
                                                                                Out</a>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                                <div class=" col-12 pagination d-flex justify-content-center mt-5">
                                                    <a href="?page-nr=1" class="rounded">First</a>
                                                    <?php
                                                    if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) {
                                                        ?>

                                                        <a href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>"
                                                            class="rounded">&laquo;</a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a class="rounded">&laquo;</a>
                                                        <?php
                                                    }

                                                    ?>
                                                    <div class="page-numbers d-flex justify-content-center">
                                                        <?php
                                                        for ($counter = 1; $counter <= $pages; $counter++) {
                                                            ?>
                                                            <a href="?page-nr=<?php echo $counter ?>"
                                                                class="rounded"><?php echo $counter ?></a>
                                                            <?php
                                                        }

                                                        ?>
                                                    </div>
                                                    <?php
                                                    if (!isset($_GET['page-nr'])) {
                                                        ?>
                                                        <a href="?page-nr=2" class="rounded">&raquo;</a>
                                                        <?php
                                                    } else {
                                                        if ($_GET['page-nr'] >= $pages) {
                                                            ?>
                                                            <a class="rounded">&raquo;</a>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <a href="?page-nr=<?php echo $_GET['page-nr'] + 1 ?>"
                                                                class="rounded">&raquo;</a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <a href="?page-nr=<?php echo $pages; ?>" class="rounded">Last</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="detail-box" class="rounded border p-3 bg-light shadow"
                                    style="display: none; position: absolute; z-index: 1000;">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-4">
                                            <img id="detail-image" src="" class="img-fluid rounded" alt="" />
                                        </div>
                                        <div class="col-8">
                                            <h4 id="detail-name" class="mb-1"></h4>
                                            <p id="detail-cost" class="fw-bold mb-1"></p>
                                            <p class="mt-2 mb-0 mx-3" style="font-size:12px;">(<span
                                                    id="detail-count"></span> sold)</p>
                                            <p id="detail-des" class="text-center mb-2" style="font-size:14px;"></p>
                                        </div>
                                    </div>
                                </div>


                                <div id="tab-2" class="tab-pane fade show p-0">
                                    <div class="row g-4">
                                        <?php
                                        while ($row = mysqli_fetch_assoc($mirror)) {
                                            $number = $row['cost'];
                                            $formattedNumber = number_format($number, 0, '.', ',');
                                            $cost = $formattedNumber;

                                            $totQtySql = "SELECT SUM(quantity) FROM checkout WHERE (status = 'Completed' OR status = 'Delivered') AND fID = '$fID'";
                                            $totQtyResult = mysqli_query($conn, $totQtySql);
                                            $totQtyRow = mysqli_fetch_assoc($totQtyResult);

                                            $totSold = $totQtyRow['SUM(quantity)'] ?? 0;

                                            if ($row['fQuantity'] !== 0) {
                                                ?>
                                                <div class="col-md-6 col-lg-6 col-xl-4 mt-5 ">
                                                    <form method="POST" action="functions.php">
                                                        <div class="rounded position-relative fruite-item border">
                                                            <div class="fruite-img">
                                                                <a href="shop-detail.php?id=<?php echo $row['fID']; ?>">
                                                                    <img src="./up/<?php echo $row['image']; ?>"
                                                                        class="img-fluid w-100 rounded-top" alt=""></a>

                                                            </div>
                                                            <!-- <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Fruits</div> -->
                                                            <?php
                                                            $one_week_ago = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                    
                                                            if ($row['date'] >= $one_week_ago) { ?>
                                                                <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                    style="top: 10px; right: 10px;">New!</div>
                                                            <?php } ?>

                                                            <?php
                                                            $one_week_ago = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                    
                                                            if ($totSold >= 10) { ?>
                                                                <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                    style="top: 10px; right: 10px;">Hot!</div>
                                                            <?php } ?>

                                                            <div class="p-4 rounded-bottom">
                                                                <h4><?php echo $row['fName']; ?></h4>
                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                    <p class="text-dark fs-5 fw-bold mb-0">
                                                                        &#8369;<?php echo $cost; ?></p>
                                                                </div>
                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                    <button type="submit"
                                                                        class=" btn border border-secondary rounded-pill px-2 text-primary mt-4"
                                                                        name="add"><i class="fa fa-shopping-cart"
                                                                            aria-hidden="true"></i> Add to cart</button>
                                                                    <input type="hidden" value="<?php echo $row['fID']; ?>"
                                                                        name="id">
                                                                    <input type="hidden" value="1" name="quantity">
                                                                    <button data-id='<?php echo $row['fID']; ?>' type="button"
                                                                        class="btn check border d-flex align-items-center border-secondary rounded-pill px-2 text-primary mt-4"
                                                                        name="check"><i
                                                                            class="fa fa-shopping-bag me-2"></i>Check
                                                                        Out</button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div id="tab-3" class="tab-pane fade show p-0">
                                    <div class="row g-4">
                                        <?php
                                        while ($row = mysqli_fetch_assoc($cabinet)) {
                                            $number = $row['cost'];
                                            $formattedNumber = number_format($number, 0, '.', ',');
                                            $cost = $formattedNumber;

                                            $totQtySql = "SELECT SUM(quantity) FROM checkout WHERE (status = 'Completed' OR status = 'Delivered') AND fID = '$fID'";
                                            $totQtyResult = mysqli_query($conn, $totQtySql);
                                            $totQtyRow = mysqli_fetch_assoc($totQtyResult);

                                            $totSold = $totQtyRow['SUM(quantity)'] ?? 0;

                                            if ($row['fQuantity'] !== 0) {
                                                ?>
                                                <div class="col-md-6 col-lg-6 col-xl-4 mt-5 ">
                                                    <form method="POST" action="functions.php">
                                                        <div class="rounded position-relative fruite-item border">
                                                            <div class="fruite-img">
                                                                <a href="shop-detail.php?id=<?php echo $row['fID']; ?>">
                                                                    <img src="./up/<?php echo $row['image']; ?>"
                                                                        class="img-fluid w-100 rounded-top" alt=""></a>

                                                            </div>
                                                            <!-- <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Fruits</div> -->
                                                            <?php
                                                            $one_week_ago = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                    
                                                            if ($row['date'] >= $one_week_ago) { ?>
                                                                <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                    style="top: 10px; right: 10px;">New!</div>
                                                            <?php } ?>

                                                            <?php
                                                            $one_week_ago = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                    
                                                            if ($totSold >= 10) { ?>
                                                                <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                    style="top: 10px; right: 10px;">Hot!</div>
                                                            <?php } ?>

                                                            <div class="p-4 rounded-bottom">
                                                                <h4><?php echo $row['fName']; ?></h4>
                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                    <p class="text-dark fs-5 fw-bold mb-0">
                                                                        &#8369;<?php echo $cost; ?></p>
                                                                </div>
                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                    <button type="submit"
                                                                        class=" btn border border-secondary rounded-pill px-2 text-primary mt-4"
                                                                        name="add"><i class="fa fa-shopping-cart"
                                                                            aria-hidden="true"></i> Add to cart</button>
                                                                    <input type="hidden" value="<?php echo $row['fID']; ?>"
                                                                        name="id">
                                                                    <input type="hidden" value="1" name="quantity">
                                                                    <a data-id='<?php echo $row['fID']; ?>' type="submit"
                                                                        class="btn check border d-flex align-items-center border-secondary rounded-pill px-2 text-primary mt-4"
                                                                        name="check"><i
                                                                            class="fa fa-shopping-bag me-2"></i>Check Out</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div id="tab-4" class="tab-pane fade show p-0">
                                    <div class="row g-4">
                                        <?php
                                        while ($row = mysqli_fetch_assoc($chair)) {
                                            $number = $row['cost'];
                                            $formattedNumber = number_format($number, 0, '.', ',');
                                            $cost = $formattedNumber;

                                            $totQtySql = "SELECT SUM(quantity) FROM checkout WHERE (status = 'Completed' OR status = 'Delivered') AND fID = '$fID'";
                                            $totQtyResult = mysqli_query($conn, $totQtySql);
                                            $totQtyRow = mysqli_fetch_assoc($totQtyResult);

                                            $totSold = $totQtyRow['SUM(quantity)'] ?? 0;

                                            if ($row['fQuantity'] !== 0) {
                                                ?>
                                                <div class="col-md-6 col-lg-6 col-xl-4 mt-5 ">
                                                    <form method="POST" action="functions.php">
                                                        <div class="rounded position-relative fruite-item border">
                                                            <div class="fruite-img">
                                                                <a href="shop-detail.php?id=<?php echo $row['fID']; ?>">
                                                                    <img src="./up/<?php echo $row['image']; ?>"
                                                                        class="img-fluid w-100 rounded-top" alt=""></a>

                                                            </div>
                                                            <!-- <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Fruits</div> -->
                                                            <?php
                                                            $one_week_ago = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                    
                                                            if ($row['date'] >= $one_week_ago) { ?>
                                                                <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                    style="top: 10px; right: 10px;">New!</div>
                                                            <?php } ?>

                                                            <?php
                                                            $one_week_ago = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                    
                                                            if ($totSold >= 10) { ?>
                                                                <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                    style="top: 10px; right: 10px;">Hot!</div>
                                                            <?php } ?>

                                                            <div class="p-4 rounded-bottom">
                                                                <h4><?php echo $row['fName']; ?></h4>
                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                    <p class="text-dark fs-5 fw-bold mb-0">
                                                                        &#8369;<?php echo $cost; ?></p>
                                                                </div>
                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                    <button type="submit"
                                                                        class=" btn border border-secondary rounded-pill px-2 text-primary mt-4"
                                                                        name="add"><i class="fa fa-shopping-cart"
                                                                            aria-hidden="true"></i> Add to cart</button>
                                                                    <input type="hidden" value="<?php echo $row['fID']; ?>"
                                                                        name="id">
                                                                    <input type="hidden" value="1" name="quantity">
                                                                    <a data-id='<?php echo $row['fID']; ?>' type="submit"
                                                                        class="btn check border d-flex align-items-center border-secondary rounded-pill px-2 text-primary mt-4"
                                                                        name="check"><i
                                                                            class="fa fa-shopping-bag me-2"></i>Check Out</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div id="tab-5" class="tab-pane fade show p-0">
                                    <div class="row g-4">
                                        <?php
                                        while ($row = mysqli_fetch_assoc($table)) {
                                            $number = $row['cost'];
                                            $formattedNumber = number_format($number, 0, '.', ',');
                                            $cost = $formattedNumber;

                                            $totQtySql = "SELECT SUM(quantity) FROM checkout WHERE (status = 'Completed' OR status = 'Delivered') AND fID = '$fID'";
                                            $totQtyResult = mysqli_query($conn, $totQtySql);
                                            $totQtyRow = mysqli_fetch_assoc($totQtyResult);

                                            $totSold = $totQtyRow['SUM(quantity)'] ?? 0;

                                            if ($row['fQuantity'] !== 0) {
                                                ?>
                                                <div class="col-md-6 col-lg-6 col-xl-4 mt-5 ">
                                                    <form method="POST" action="functions.php">
                                                        <div class="rounded position-relative fruite-item border">
                                                            <div class="fruite-img">
                                                                <a href="shop-detail.php?id=<?php echo $row['fID']; ?>">
                                                                    <img src="./up/<?php echo $row['image']; ?>"
                                                                        class="img-fluid w-100 rounded-top" alt=""></a>

                                                            </div>
                                                            <!-- <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Fruits</div> -->
                                                            <?php
                                                            $one_week_ago5 = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                    
                                                            if ($row['date'] >= $one_week_ago5) { ?>
                                                                <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                    style="top: 10px; right: 10px;">New!</div>
                                                            <?php } ?>

                                                            <?php
                                                            $one_week_ago = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                    
                                                            if ($totSold >= 10) { ?>
                                                                <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                    style="top: 10px; right: 10px;">Hot!</div>
                                                            <?php } ?>

                                                            <div class="p-4 rounded-bottom">
                                                                <h4><?php echo $row['fName']; ?></h4>
                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                    <p class="text-dark fs-5 fw-bold mb-0">
                                                                        &#8369;<?php echo $cost; ?></p>
                                                                </div>
                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                    <button type="submit"
                                                                        class=" btn border border-secondary rounded-pill px-2 text-primary mt-4"
                                                                        name="add"><i class="fa fa-shopping-cart"
                                                                            aria-hidden="true"></i> Add to cart</button>
                                                                    <input type="hidden" value="<?php echo $row['fID']; ?>"
                                                                        name="id">
                                                                    <input type="hidden" value="1" name="quantity">
                                                                    <a data-id='<?php echo $row['fID']; ?>' type="submit"
                                                                        class="btn check border d-flex align-items-center border-secondary rounded-pill px-2 text-primary mt-4"
                                                                        name="check"><i
                                                                            class="fa fa-shopping-bag me-2"></i>Check Out</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div id="tab-6" class="tab-pane fade show p-0">
                                    <div class="row g-4">
                                        <?php
                                        while ($row = mysqli_fetch_assoc($bedframe)) {
                                            $number = $row['cost'];
                                            $formattedNumber = number_format($number, 0, '.', ',');
                                            $cost = $formattedNumber;

                                            $totQtySql = "SELECT SUM(quantity) FROM checkout WHERE (status = 'Completed' OR status = 'Delivered') AND fID = '$fID'";
                                            $totQtyResult = mysqli_query($conn, $totQtySql);
                                            $totQtyRow = mysqli_fetch_assoc($totQtyResult);

                                            $totSold = $totQtyRow['SUM(quantity)'] ?? 0;

                                            if ($row['fQuantity'] !== 0) {
                                                ?>
                                                <div class="col-md-6 col-lg-6 col-xl-4 mt-5 ">
                                                    <form method="POST" action="functions.php">
                                                        <div class="rounded position-relative fruite-item border">
                                                            <div class="fruite-img">
                                                                <a href="shop-detail.php?id=<?php echo $row['fID']; ?>">
                                                                    <img src="./up/<?php echo $row['image']; ?>"
                                                                        class="img-fluid w-100 rounded-top" alt=""></a>

                                                            </div>
                                                            <!-- <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Fruits</div> -->
                                                            <?php
                                                            $one_week_ago = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                    
                                                            if ($row['date'] >= $one_week_ago) { ?>
                                                                <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                    style="top: 10px; right: 10px;">New!</div>
                                                            <?php } ?>

                                                            <?php
                                                            $one_week_ago = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                    
                                                            if ($totSold >= 10) { ?>
                                                                <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                    style="top: 10px; right: 10px;">Hot!</div>
                                                            <?php } ?>

                                                            <div class="p-4 rounded-bottom">
                                                                <h4><?php echo $row['fName']; ?></h4>
                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                    <p class="text-dark fs-5 fw-bold mb-0">
                                                                        &#8369;<?php echo $cost; ?></p>
                                                                </div>
                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                    <button type="submit"
                                                                        class=" btn border border-secondary rounded-pill px-2 text-primary mt-4"
                                                                        name="add"><i class="fa fa-shopping-cart"
                                                                            aria-hidden="true"></i> Add to cart</button>
                                                                    <input type="hidden" value="<?php echo $row['fID']; ?>"
                                                                        name="id">
                                                                    <input type="hidden" value="1" name="quantity">
                                                                    <a data-id='<?php echo $row['fID']; ?>' type="submit"
                                                                        class="btn check border d-flex align-items-center border-secondary rounded-pill px-2 text-primary mt-4"
                                                                        name="check"><i
                                                                            class="fa fa-shopping-bag me-2"></i>Check Out</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div id="tab-7" class="tab-pane fade show p-0">
                                    <div class="row g-4">
                                        <?php
                                        while ($row = mysqli_fetch_assoc($salaResult)) {
                                            $number = $row['cost'];
                                            $formattedNumber = number_format($number, 0, '.', ',');
                                            $cost = $formattedNumber;

                                            $totQtySql = "SELECT SUM(quantity) FROM checkout WHERE (status = 'Completed' OR status = 'Delivered') AND fID = '$fID'";
                                            $totQtyResult = mysqli_query($conn, $totQtySql);
                                            $totQtyRow = mysqli_fetch_assoc($totQtyResult);

                                            $totSold = $totQtyRow['SUM(quantity)'] ?? 0;

                                            if ($row['fQuantity'] !== 0) {
                                                ?>
                                                <div class="col-md-6 col-lg-6 col-xl-4 mt-5 ">
                                                    <form method="POST" action="functions.php">
                                                        <div class="rounded position-relative fruite-item border">
                                                            <div class="fruite-img">
                                                                <a href="shop-detail.php?id=<?php echo $row['fID']; ?>">
                                                                    <img src="./up/<?php echo $row['image']; ?>"
                                                                        class="img-fluid w-100 rounded-top" alt=""></a>

                                                            </div>
                                                            <!-- <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Fruits</div> -->
                                                            <?php
                                                            $one_week_ago = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                    
                                                            if ($row['date'] >= $one_week_ago) { ?>
                                                                <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                    style="top: 10px; right: 10px;">New!</div>
                                                            <?php } ?>

                                                            <?php
                                                            $one_week_ago = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                    
                                                            if ($totSold >= 10) { ?>
                                                                <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                    style="top: 10px; right: 10px;">Hot!</div>
                                                            <?php } ?>

                                                            <div class="p-4 rounded-bottom">
                                                                <h4><?php echo $row['fName']; ?></h4>
                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                    <p class="text-dark fs-5 fw-bold mb-0">
                                                                        &#8369;<?php echo $cost; ?></p>
                                                                </div>
                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                    <button type="submit"
                                                                        class=" btn border border-secondary rounded-pill px-2 text-primary mt-4"
                                                                        name="add"><i class="fa fa-shopping-cart"
                                                                            aria-hidden="true"></i> Add to cart</button>
                                                                    <input type="hidden" value="<?php echo $row['fID']; ?>"
                                                                        name="id">
                                                                    <input type="hidden" value="1" name="quantity">
                                                                    <a data-id='<?php echo $row['fID']; ?>' type="submit"
                                                                        class="btn check border d-flex align-items-center border-secondary rounded-pill px-2 text-primary mt-4"
                                                                        name="check"><i
                                                                            class="fa fa-shopping-bag me-2"></i>Check Out</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div id="tab-8" class="tab-pane fade show p-0">
                                    <div class="row g-4">
                                        <?php
                                        while ($row = mysqli_fetch_assoc($tv)) {
                                            $number = $row['cost'];
                                            $formattedNumber = number_format($number, 0, '.', ',');
                                            $cost = $formattedNumber;

                                            $totQtySql = "SELECT SUM(quantity) FROM checkout WHERE (status = 'Completed' OR status = 'Delivered') AND fID = '$fID'";
                                            $totQtyResult = mysqli_query($conn, $totQtySql);
                                            $totQtyRow = mysqli_fetch_assoc($totQtyResult);

                                            $totSold = $totQtyRow['SUM(quantity)'] ?? 0;

                                            if ($row['fQuantity'] !== 0) {
                                                ?>
                                                <div class="col-md-6 col-lg-6 col-xl-4 mt-5 ">
                                                    <form method="POST" action="functions.php">
                                                        <div class="rounded position-relative fruite-item border">
                                                            <div class="fruite-img">
                                                                <a href="shop-detail.php?id=<?php echo $row['fID']; ?>">
                                                                    <img src="./up/<?php echo $row['image']; ?>"
                                                                        class="img-fluid w-100 rounded-top" alt=""></a>

                                                            </div>
                                                            <!-- <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Fruits</div> -->
                                                            <?php
                                                            $one_week_ago = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                    
                                                            if ($row['date'] >= $one_week_ago) { ?>
                                                                <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                    style="top: 10px; right: 10px;">New!</div>
                                                            <?php } ?>

                                                            <?php
                                                            $one_week_ago = date('Y-m-d', strtotime('-7 days')); // Get the date one week ago
                                                    
                                                            if ($totSold >= 10) { ?>
                                                                <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                                                    style="top: 10px; right: 10px;">Hot!</div>
                                                            <?php } ?>

                                                            <div class="p-4 rounded-bottom">
                                                                <h4><?php echo $row['fName']; ?></h4>
                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                    <p class="text-dark fs-5 fw-bold mb-0">
                                                                        &#8369;<?php echo $cost; ?></p>
                                                                </div>
                                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                                    <button type="submit"
                                                                        class=" btn border border-secondary rounded-pill px-2 text-primary mt-4"
                                                                        name="add"><i class="fa fa-shopping-cart"
                                                                            aria-hidden="true"></i> Add to cart</button>
                                                                    <input type="hidden" value="<?php echo $row['fID']; ?>"
                                                                        name="id">
                                                                    <input type="hidden" value="1" name="quantity">
                                                                    <a data-id='<?php echo $row['fID']; ?>' type="submit"
                                                                        class="btn check border d-flex align-items-center border-secondary rounded-pill px-2 text-primary mt-4"
                                                                        name="check"><i
                                                                            class="fa fa-shopping-bag me-2"></i>Check Out</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-lg" style="margin-right: 610px; margin-top: 100px;">
            <div class="modal-content rounded-0">

                <div class="container modal-body">

                </div>

            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer mt-5" id="footer">
        <div class="container py-5">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                <!-- <a href="#" class="navbar-brand"><img class="logo" src="logo.png" alt="Bootstrap" style="width: 150px"></a>  -->
            </div>
            <div class="row g-5 justify-content-between">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">About us!</h4>
                        <p class="mb-4">typesetting, remaining essentially unchanged. It was
                            popularised in the 1960s with the like Aldus PageMaker including of Lorem Ipsum.typesetting,
                            remaining essentially unchanged. It was
                            popularised in the 1960s with the like Aldus</p>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Contact</h4>
                        <div class="d-flex">
                            <p>Facebook:</p>&ensp;
                            <a href="https://www.facebook.com/profile.php?id=100095051198984">Joynes Furniture</a>
                        </div>
                        <p>Address: Tigbao, Loboc, Philippines</p>
                        <p>Email: marangenestor@gmail.com</p>
                        <p>Phone: 0993 893 4771</p>
                        <p>Payment Accepted</p>
                        <img src="img/payment.png" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Link</h4>
                        <a class="btn-link" href="profile.php">My Account</a>
                        <a class="btn-link" href="shop.php">Shop</a>
                        <a class="btn-link" href="cart.php">Shopping Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <center>
                    <div class="col-md-6 text-center  mb-3 mb-md-0">
                        <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Your Site
                                Name</a>, All right reserved.</span>
                    </div>
                </center>
            </div>
        </div>
    </div>
    <!-- Copyright End -->



    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script type="text/javascript">
        let links = document.querySelectorAll('.page-numbers > a');
        let bodyId = parseInt(document.body.id) - 1;
        links[bodyId].classList.add("active");
    </script>
    <script type='text/javascript'>
        $(document).ready(function () {
            $('.check').click(function () {
                var userid = $(this).data('id');
                $.ajax({
                    url: 'checkoutmodal.php',
                    type: 'post',
                    data: { userid: userid },
                    success: function (response) {
                        $('.modal-content').html(response);
                        $('#checkoutModal').modal('show');
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            const detailBox = document.getElementById("detail-box");
            const detailImage = document.getElementById("detail-image");
            const detailName = document.getElementById("detail-name");
            const detailCost = document.getElementById("detail-cost");
            const detailDes = document.getElementById("detail-des");
            const detailCount = document.getElementById("detail-count");
            const detailQuantity = document.getElementById("detail-quantity");

            document.querySelectorAll(".fia").forEach(item => {
                item.addEventListener("mouseenter", function () {
                    const rect = item.getBoundingClientRect();

                    detailImage.src = this.dataset.image;
                    detailName.textContent = this.dataset.name;
                    detailCost.textContent = this.dataset.cost;
                    detailDes.textContent = this.dataset.des;
                    detailCount.textContent = this.dataset.count;

                    const detailBoxWidth = detailBox.offsetWidth;
                    const detailBoxHeight = detailBox.offsetHeight;

                    let left = rect.left - detailBoxWidth - 100;

                    if (left < 0) {
                        left = rect.left + rect.width + 100;
                    }

                    const top = rect.top + window.scrollY + rect.height / 4 - detailBoxHeight / 2;

                    detailBox.style.left = `${left}px`;
                    detailBox.style.top = `${top}px`;
                    detailBox.style.display = "block";
                });

                item.addEventListener("mouseleave", function () {
                    if (!detailBox.matches(":hover")) {
                        detailBox.style.display = "none";
                    }
                });
            });

            detailBox.addEventListener("mouseenter", function () {
                detailBox.style.display = "block";
            });

            detailBox.addEventListener("mouseleave", function () {
                detailBox.style.display = "none";
            });
        });






    </script>
</body>

</html>