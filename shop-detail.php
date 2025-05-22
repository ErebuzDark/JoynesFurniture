<?php

include("database.php");
include("functions.php");

$i = 0;

$sql5 = "SELECT COUNT(*) FROM addcart WHERE userID = '$userID'";
$result5 = mysqli_query($conn, $sql5);
$row5 = mysqli_fetch_assoc($result5);
$i = $row5['COUNT(*)'];

$id = $_GET['id'];
$sql = "SELECT * FROM furnituretbl WHERE fID= $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$number = $row['cost'];
$formattedNumber = number_format($number, 0, '.', ',');
$cost = $formattedNumber;

$cat = $row['category'];
$sqlcat = "SELECT * FROM furnituretbl WHERE category = '$cat'";
$resultcat = mysqli_query($conn, $sqlcat);

$sqlrev = "SELECT * FROM reviewtbl";
$resultrev = mysqli_query($conn, $sqlrev);



if (isset($_POST['post'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    $date = date('Y-m-d');


    $sql_insert = "INSERT INTO reviewtbl (fullName, email, comment,  date) 
                           VALUES (?, ?, ?, ?)";

    if ($stmt_insert = $conn->prepare($sql_insert)) {
        $stmt_insert->bind_param("ssds", $name, $email, $comment, $date);

        if ($stmt_insert->execute()) {
            header("Location: shop-detail.php?id=$id");
            exit();
        } else {
            echo "Error: " . $stmt_insert->error;
        }
    }
}



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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
        a {
            color: black;
            !important;

        }

        a:hover {
            color: #e47011 !important;

        }

        .page-header {
            background-image: url(./img/1.jpg) !important;

        }
    </style>
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="container topbar d-none d-lg-block">
        </div>
        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="shop.php" class="navbar-brand"><img class="logo" src="./img/logo1.png" alt="Bootstrap"
                        style="width: 200px"></a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                    </div>
                    <div class="d-flex m-3 me-0">
                        <a href="customize.php" class="position-relative me-3 my-auto">
                            <img width="40" height="40" src="https://img.icons8.com/ios-filled/50/737373/hammer.png"
                                alt="hammer" /></a>
                        <a href="cart.php" class="position-relative me-4 my-auto text-muted">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                            <span
                                class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                                style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?php echo $i; ?></span>
                        </a>
                    </div>
                    <div class="nav-item dropdown">
                        <i class="fas fa-user fa-2x"></i>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="logout.php" class="dropdown-item"><i class="fa fa-sign-out"></i>Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Product Details</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="shop.php">Home</a></li>
            <li class="breadcrumb-item active text-white">Product Details</li>
            <li class="breadcrumb-item"><a href="customizecart.php">Customized Cart</a></li>
        </ol>
    </div>
    <!-- Navbar End -->


    <!-- Single Product Start -->
    <br>
    <div class="container-fluid py-5">
        <div class="container py-5">
            <form action="functions.php" method="POST">
                <div class="col-lg-12 col-xl-12">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="border rounded">
                                <a href="#">
                                    <img src="./up/<?php echo $row['image']; ?>" class="img-fluid rounded" alt="Image">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold"><?php echo $row['fName']; ?></h4>
                            <h5 class="fw-bold mb-3">&#8369;<?php echo $cost; ?></h5>
                            <p class="mb-2">Available: (<?php echo $row['fQuantity']; ?>)</p>
                            <p class="mb-3">Category: <span
                                    class="text-uppercase"><?php echo $row['category']; ?></span></p>
                            <p>W: <?php echo $row['width']; ?></p>
                            <p>L: <?php echo $row['length']; ?></p>
                            <p>H: <?php echo $row['height']; ?></p>
                            <div class="d-flex mb-4">
                            </div>
                            <p class="mb-5"><?php echo $row['fDes']; ?></p>
                            <div class="input-group quantity mb-3 d-flex align-items-center" style="width: 100px;">
                                <div class="input-group-btn">
                                    <a class="btn btn-sm btn-minus rounded-circle bg-light border">
                                        <i class="fa fa-minus"></i>
                                    </a>
                                </div>
                                <input type="text" name="quantity" id="quantity"
                                    class="form-control form-control-sm text-center border-0 bg-transparent" readonly
                                    value="1">
                                <div class="input-group-btn">
                                    <a class="btn btn-sm btn-plus rounded-circle bg-light border">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $row['fID']; ?>">
                            <div>
                                <button type="submit"
                                    class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary mt-4"
                                    name="add"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</button>
                                <a href="customshop.php?id=<?php echo $row['fID']; ?>" type="submit"
                                    class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary mt-4">Customize</a>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
            <h1 class="fw-bold mb-0 mt-5">Related products</h1>
            <div class="vesitable">
                <div class="owl-carousel vegetable-carousel justify-content-center">

                    <?php while ($rowcat = mysqli_fetch_assoc($resultcat)) {

                        $number = $rowcat['cost'];
                        $formattedNumber = number_format($number, 0, '.', ',');
                        $costt = $formattedNumber;

                        ?>
                        <div class="border border-dark rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <a href="?id=<?php echo $rowcat['fID']; ?>">
                                    <img src="./up/<?php echo $rowcat['image']; ?>" class="img-fluid w-100 rounded-top"
                                        alt="">
                                </a>
                            </div>
                            <!-- <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div> -->
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4><?php echo $rowcat['fName']; ?></h4>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">&#8369;<?php echo $costt; ?></p>
                                    <a href="#"
                                        class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i
                                            class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class="col-lg-12">
                <nav>
                    <div class="nav nav-tabs mb-3">
                        <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                            id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                            aria-controls="nav-mission" aria-selected="false">Reviews</button>
                    </div>
                </nav>

                <div class="tab-content mb-5">
                    <?php while ($row = mysqli_fetch_assoc($resultrev)) {

                        ?>
                        <div class="tab-pane active" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                            <div class="d-flex">
                                <img src="img/avatar.jpg" class="img-fluid rounded-circle p-3"
                                    style="width: 100px; height: 100px;" alt="">
                                <div class="">
                                    <p class="mb-2" style="font-size: 14px;"><?php
                                    $date = $row['date'];
                                    $formatted_date = new DateTime($date);
                                    echo $formatted_date->format('F j, Y'); ?></p>
                                    <div class="d-flex justify-content-between">
                                        <h5><?php echo $row['fullName']; ?></h5>
                                    </div>
                                    <p><?php echo $row['comment']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <form action="" method="POST">
                <h4 class="mb-5 fw-bold">Leave a Reply</h4>
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="border-bottom rounded">
                            <input type="text" class="form-control border-0 me-4" name="name"
                                placeholder="Your Full Name *" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="border-bottom rounded">
                            <input type="email" class="form-control border-0" name="email" placeholder="Your Email *">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="border-bottom rounded my-4">
                            <textarea name="comment" id="" class="form-control border-0" cols="30" rows="8"
                                placeholder="Your Review *" spellcheck="false"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between py-3 mb-5">
                            <button type="submit" name="post"
                                class="btn border border-secondary text-primary rounded-pill px-4 py-3"> Post Comment
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Single Product End -->


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
        const btnMinus = document.querySelector('.btn-minus');
        const btnPlus = document.querySelector('.btn-plus');
        const inputField = document.querySelector('.form-control');

        btnMinus.addEventListener('click', function () {
            let currentValue = parseInt(inputField.value, 10);
            if (currentValue > 1) {
                inputField.value = currentValue - 1;
            }
        });

        btnPlus.addEventListener('click', function () {
            let currentValue = parseInt(inputField.value, 10);
            inputField.value = currentValue + 1;
        });
    </script>
</body>

</html>