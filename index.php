<?php
include("database.php");

$furnituredis = "SELECT * FROM furnituretbl LIMIT 0, 8";
$furResultdis = mysqli_query($conn, $furnituredis);

$furniturenew = "SELECT * FROM furnituretbl ORDER BY fID DESC LIMIT 0, 8";
$furResultnew = mysqli_query($conn, $furniturenew);

$furniturenew1 = "SELECT * FROM furnituretbl ORDER BY fID DESC LIMIT 0, 8";
$furResultnew1 = mysqli_query($conn, $furniturenew1);


$normalizeQuery = "CREATE TEMPORARY TABLE normalized_checkout AS
                    SELECT TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(fID, ',', n.n), ',', -1)) AS fID FROM checkout
                    JOIN (SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5) n
                        ON CHAR_LENGTH(fID) - CHAR_LENGTH(REPLACE(fID, ',', '')) + 1 >= n.n";
mysqli_query($conn, $normalizeQuery);

$topFIDsQuery = "CREATE TEMPORARY TABLE top_fIDs AS SELECT fID, COUNT(*) AS count FROM normalized_checkout
                GROUP BY fID
                ORDER BY count DESC
                LIMIT 5";
mysqli_query($conn, $topFIDsQuery);

$finalQuery = "SELECT f.* FROM furnituretbl f
                JOIN top_fIDs t ON f.fID = t.fID";
$furResultbest = mysqli_query($conn, $finalQuery);

$best = "
SELECT f.*
FROM furnituretbl f
JOIN (
    SELECT fid
    FROM (
        SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(c.fid, ',', numbers.n), ',', -1) AS fid
        FROM checkout c
        INNER JOIN (
            SELECT 1 AS n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5
            UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10
        ) numbers ON CHAR_LENGTH(c.fid) - CHAR_LENGTH(REPLACE(c.fid, ',', '')) >= numbers.n - 1
         WHERE c.status = 'Completed'
    ) AS split_fids
    GROUP BY fid
    ORDER BY COUNT(*) DESC
    LIMIT 8
) AS best_fids ON f.fid = best_fids.fid";

$restbest = mysqli_query($conn, $best);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Joynes Furniture</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style type="text/css">
        .modal-content {

            background-color: rgba(0, 0, 0, 0) !important;
            border: none;
            width: 190%;

        }

        .modal-dialog {
            margin-top: 80px !important;
            margin-left: 280px !important;
        }

        .registercon {

            width: 200%;

        }

        .hero-header {
            background: linear-gradient(rgba(248, 223, 173, 0.1), rgba(248, 223, 173, 0.1)), url(./img/bgshop.png) !important;
            background-blend-mode: ;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .fa {
            color: none !important;

        }
    </style>

</head>

<body>
    <?php
    if (isset($_GET['error'])) {
        $error = $_GET['error'];

        if ($error === "Please Enter Valid Information!") {
            echo "<script>Swal.fire({
                title:'Please Enter Valid Information!',
                text:'Please enter all valid information in the sign up',
                icon:'error'
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href='./index.php';
                }
                })</script>";
        } else if ($error === "Invalid Captcha!") {
            echo "<script>Swal.fire({
                    title:'Invalid Captcha!',
                    text:'Please enter complete the recaptcha',
                    icon:'error'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href='./index.php';
                    }
                    })</script>";
        } else if ($error === "emailRequired") {
            echo "<script>Swal.fire({
            title:'No Input Email',
            text:'Please input a email first',
            icon:'info'
            }).then((result) => {  
            if (result.isConfirmed) {
                window.location.href='./index.php';
            }
            })</script>";
        } else if ($error === "passwordRequired") {
            echo "<script>Swal.fire({
            title:'No Input Password',
            text:'Please input a password first',
            icon:'info'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href='./index.php';
            }
            })</script>";
        } else if ($error === "invalidPassword") {
            echo "<script>Swal.fire({
            title:'Invalid Password',
            text:'Your invalid password please try again',
            icon:'error'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href='./index.php';
            }
            })</script>";
        } else if ($error === "invalidEmail") {
            echo "<script>Swal.fire({
            title:'Email Not Registered',
            text:'Your email is not registered please try again',
            icon:'error'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href='./index.php';
            }
            })</script>";
        }
    }
    ?>
    <?php include('login-modal.php'); ?>
    <?php include('signup-modal.php'); ?>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="container px-0 mt-5">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <img class="logo" src="./img/logo1.png" alt="Bootstrap" style="width: 200px">
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="#shop" class="nav-item nav-link">Furniture</a>
                        <a href="#footer" class="nav-item nav-link">About Us</a>
                    </div>
                    <div class="d-flex m-3 me-0">

                        <a href="" data-bs-toggle="modal" data-bs-target="#loginModal"
                            class="position-relative me-4 my-auto">
                            <img width="30" height="30"
                                src="https://img.icons8.com/ios-filled/50/737373/shopping-bag.png" alt="shopping-bag" />
                            <span
                                class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                                style="top: -5px; left: 15px; height: 20px; min-width: 20px;">3</span>
                        </a>
                        <div class="nav-item dropdown">
                            <img width="40" height="40" src="https://img.icons8.com/ios-filled/50/737373/user.png"
                                alt="user" />
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="" data-bs-toggle="modal" data-bs-target="#loginModal" class="dropdown-item">Log
                                    In</a>
                                <a href="" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#signupModal">Sign Up</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">

                    <h1 class=" display-3 ">Find Your Best <span class="text2 ms-5 text-primary">Furniture Here!</span>
                    </h1>
                    <h4 class="mb-5 text-dark">Bringing Quality Furniture To Your Home</h4>
                    <div class=" mx-auto">
                        <a href="" type="submit"
                            class="btn border-2 border-secondary py-3 px-4 rounded-pill text-white h-100"
                            style="margin-left: 180px; background-color: #e7700c;">Shop Now</button></a>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="./img/k.jpg" class="img-fluid w-100 h-50 bg-secondary rounded"
                                    alt="First slide">
                            </div>
                            <div class="carousel-item rounded">
                                <img src="./img/t.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->


    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite pt-5" id="shop">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Furniture Products</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill"
                                    href="#tab-1">
                                    <span class="text-dark" style="width: 130px;">All Products</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2">
                                    <span class="text-dark" style="width: 130px;">Best Seller</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-3">
                                    <span class="text-dark" style="width: 130px;">New Product</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <?php
                                    while ($row = mysqli_fetch_assoc($furResultdis)) {
                                        $number = $row['cost'];
                                        $formattedNumber = number_format($number, 0, '.', ',');
                                        $cost = $formattedNumber;
                                        ?>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item border">
                                                <div class="fruite-img">
                                                    <img src="./up/<?php echo $row['image']; ?>"
                                                        class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <!-- <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Fruits</div> -->
                                                <div class="p-4 rounded-bottom">
                                                    <h4 class=""><?php echo $row['fName']; ?></h4>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">&#8369;<?php echo $cost; ?>
                                                        </p>
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"
                                                            class="btn border border-secondary rounded-pill px-3 text-primary position-relative me-4 my-auto"><i
                                                                class="fa fa-shopping-bag me-2 text-primary"></i> Add to
                                                            cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <?php
                            while ($row = mysqli_fetch_assoc($restbest)) {
                                $number = $row['cost'];
                                $formattedNumber = number_format($number, 2, '.', ',');
                                $cost = $formattedNumber;
                                ?>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item border">
                                        <div class="fruite-img">
                                            <img src="./up/<?php echo $row['image']; ?>" class="img-fluid w-100 rounded-top"
                                                alt="">
                                        </div>
                                        <div class="text-white bg-danger px-2 py-2 rounded-pill position-absolute"
                                            style="top: 20px; right: 10px;">Hot!</div>
                                        <div class="p-4 rounded-bottom">
                                            <h4><?php echo $row['fName']; ?></h4>
                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                <p class="text-dark fs-5 fw-bold mb-0">&#8369;<?php echo $cost; ?></p>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"
                                                    class="btn border border-secondary rounded-pill px-3 text-primary position-relative me-4 my-auto">
                                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <?php
                            while ($row = mysqli_fetch_assoc($furResultnew1)) {
                                $number = $row['cost'];
                                $formattedNumber = number_format($number, 2, '.', ',');
                                $cost = $formattedNumber;
                                ?>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item border">
                                        <div class="fruite-img">
                                            <img src="./up/<?php echo $row['image']; ?>" class="img-fluid w-100 rounded-top"
                                                alt="">
                                        </div>
                                        <div class="text-white bg-danger px-2  py-2 rounded-pill position-absolute"
                                            style="top: 20px; right: 10px;">New</div>
                                        <div class="p-4 rounded-bottom">
                                            <h4><?php echo $row['fName']; ?></h4>
                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                <p class="text-dark fs-5 fw-bold mb-0">&#8369;<?php echo $cost; ?></p>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"
                                                    class="btn border border-secondary rounded-pill px-3  text-primary position-relative me-4 my-auto"><i
                                                        class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->



    <!-- Banner Section Start-->
    <div class="container-fluid banner bg-light my-5">
        <div class="container py-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="py-4">
                        <h1 class="display-3 text-primary">New Furniture</h1>
                        <p class="fw-normal display-3 text-dark ms-3 mb-4">in Our Store</p>
                        <p class="mb-4 text-dark">The generated Lorem Ipsum is therefore always free from repetition
                            injected humour, or non-characteristic words etc.</p>
                        <a href="#" class="banner-btn btn border-2 border-dark rounded-pill text-dark py-3 px-5">BUY</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="img/backpic.png" class="img-fluid w-100 rounded" alt="">
                        <div class="d-flex align-items-center justify-content-center bg-danger rounded-circle position-absolute"
                            style="width: 140px; height: 140px; top: 0; left: 0;">
                            <h1 style="font-size: 30px;" class="text-white">50%</h1>
                            <div class="d-flex flex-column">
                                <span class="h4 mb-0 text-white">OFF</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Section End -->

    <!-- Vesitable Shop Start-->
    <div class="container-fluid vesitable py-5">
        <div class="container py-5">
            <h1 class="mb-0">New Collections</h1>
            <div class="owl-carousel vegetable-carousel justify-content-center">
                <?php
                while ($row = mysqli_fetch_assoc($furResultnew)) {
                    $number = $row['cost'];
                    $formattedNumber = number_format($number, 0, '.', ',');
                    $cost = $formattedNumber;
                    ?>
                    <div class="border rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="./up/<?php echo $row['image']; ?>" class="img-fluid w-100 rounded-top" alt="">
                        </div>
                        <div class="text-white bg-danger px-2  py-2 rounded-pill position-absolute"
                            style="top: 20px; right: 10px;">New</div>
                        <div class="p-4 rounded-bottom">
                            <h4><?php echo $row['fName']; ?></h4>
                            <!-- <p><?php echo $row['fDes']; ?></p> -->
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">&#8369;<?php echo $cost; ?></p>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                        class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Vesitable Shop End -->

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

    <script>
        const loginModal = document.getElementById('loginModal');
        const signupModal = document.getElementById('signupModal');

        signupModal.addEventListener('show.bs.modal', () => {
            const loginModalInstance = bootstrap.Modal.getInstance(loginModal);
            if (loginModalInstance) {
                loginModalInstance.hide();
            }
        });

        loginModal.addEventListener('show.bs.modal', () => {
            const signupModalInstance = bootstrap.Modal.getInstance(signupModal);
            if (signupModalInstance) {
                signupModalInstance.hide();
            }
        });

        function getQueryParam(param) {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        // Check if 'modal' parameter exists and matches 'loginModal'
        const modalTarget = getQueryParam('modal');
        if (modalTarget === 'loginModal') {
            const modalElement = new bootstrap.Modal(document.getElementById(modalTarget));
            modalElement.show();
        }
    </script>
</body>

</html>