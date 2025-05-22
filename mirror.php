<?php
include("category.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Fruitables - Vegetable Website Template</title>
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
        .btn-side:hover {
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
    </style>

</head>
<?php
if (isset($_GET['page-nr'])) {

    $id = $_GET['page-nr'];
} else {

    $id = 1;

}


?>

<body id="<?php echo $id; ?>">

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
                <img class="logo" src="logo1.png" alt="Bootstrap" style="width: 200px">
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                    </div>
                    <div class="d-flex m-3 me-0">
                        <a href="cart.php" class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                            <span
                                class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                                style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?php echo $i; ?></span>
                        </a>
                        <div class="nav-item dropdown">
                            <i class="fas fa-user fa-2x"></i>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
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
        <h1 class="text-center text-white display-6">Furniture Shop</h1>
    </div>
    <!-- Single Page Header End -->


    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4 class="text-center">Categories</h4>
                                        <ul class="list-unstyled fruite-categorie">
                                            <li>
                                                <div class="d-flex justify-content-between fruite-name">
                                                    <a href="shop.php" class="btn btn-side  text-dark"><img class="me-2"
                                                            width="20" height="20"
                                                            src="https://img.icons8.com/ios-filled/50/chair.png"
                                                            alt="chair" /><span class="">All Products</span><span
                                                            style="margin-left: 130px">(<?php echo $q; ?>)</span></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex justify-content-between fruite-name">
                                                    <a href="category.php" class="btn btn-side  text-dark"><img
                                                            class="me-2" width="20" height="20"
                                                            src="https://img.icons8.com/ios-filled/50/chair.png"
                                                            alt="chair" /><span class="">Chairs</span><span
                                                            style="margin-left: 175px">(8)</span></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex justify-content-between fruite-name">
                                                    <a href="#" class="btn btn-side text-dark"><img class="me-2"
                                                            width="20" height="20"
                                                            src="https://img.icons8.com/ios-filled/50/table.png"
                                                            alt="table" />Tables<span
                                                            style="margin-left: 175px">(8)</span></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex justify-content-between fruite-name">
                                                    <a href="cabinet.php" class="btn btn-side text-dark"><img
                                                            class="me-2" width="20" height="20"
                                                            src="https://img.icons8.com/ios-glyphs/30/wardrobe.png"
                                                            alt="wardrobe" />Cabinets<span
                                                            style="margin-left: 158px">(8)</span></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div
                                                    class="d-flex justify-content-between fruite-name bg-secondary active rounded-pill">
                                                    <a href="#" class="btn btn-side active text-white"><img class="me-2"
                                                            width="20" height="20"
                                                            src="https://img.icons8.com/ios-filled/50/dressing-table.png"
                                                            alt="dressing-table" />Mirror
                                                        <span style="margin-left: 170px">(8)</span></a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="position-relative">
                                        <img src="img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                        <div class="position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%);">
                                            <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-4 justify-content-center">
                                <?php
                                while ($row = mysqli_fetch_assoc($mirror)) {
                                    $number = $row['cost'];
                                    $formattedNumber = number_format($number, 2, '.', ',');
                                    $cost = $formattedNumber;
                                    ?>
                                    <div class="col-md-6 col-lg-6 col-xl-4 mt-5 ">

                                        <div class="rounded position-relative fruite-item border">
                                            <form method="POST" action="functions.php">
                                                <div class="fruite-img">
                                                    <a href="shop-detail.php?id=<?php echo $row['fID']; ?>">
                                                        <img src="./up/<?php echo $row['image']; ?>"
                                                            class="img-fluid w-100 rounded-top" alt=""></a>

                                                </div>
                                                <!-- <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Fruits</div> -->
                                                <?php if ($row['fQuantity'] < 10) { ?>
                                                    <div class="text-white bg-danger px-2  py-2 rounded-pill position-absolute"
                                                        style="top: 10px; right: 10px;">Hot!</div>
                                                <?php } ?>

                                                <div class="p-4 rounded-bottom">
                                                    <h4><?php echo $row['fName']; ?></h4>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">&#8369;<?php echo $cost; ?>
                                                        </p>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <button type="submit"
                                                            class=" btn border border-secondary rounded-pill px-2 text-primary mt-4"
                                                            name="add"><i class="fa fa-shopping-cart"
                                                                aria-hidden="true"></i> Add to cart</button>
                                                        <input type="hidden" value="<?php echo $row['fID']; ?>" name="id">
                                                        <input type="hidden" value="1" name="quantity">
                                                        <button type="submit"
                                                            class="btn border d-flex align-items-center border-secondary rounded-pill px-2 text-primary mt-4"
                                                            name="check"><i class="fa fa-shopping-bag me-2"></i>Check
                                                            Out</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                    <?php
                                }

                                ?>
                                <div class=" col-12 pagination d-flex justify-content-center mt-5">
                                    <?php
                                    if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) {
                                        ?>

                                        <a href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>" class="rounded">&laquo;</a>
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
                                            <a href="?page-nr=<?php echo $_GET['page-nr'] + 1 ?>" class="rounded">&raquo;</a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
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
</body>

</html>