<?php
require './css/tooltipstyle.php';
include("database.php");
include("customfunc.php");

$userID = $_SESSION['userID'];
$i = 0;

$sql5 = "SELECT COUNT(*) FROM tbl_cartcus where userID = '$userID'";
$result5 = mysqli_query($conn, $sql5);
$row5 = mysqli_fetch_assoc($result5);
$i = $row5['COUNT(*)'];

// $id = $_GET['id'];
// $sql= "SELECT * FROM furnituretbl WHERE fID= $id";
// $result = mysqli_query($conn,$sql);
// $row = mysqli_fetch_assoc($result);
// $number = $row['cost'];
// $formattedNumber = number_format($number, 2, '.', ',');
// $cost = $formattedNumber;

$furniturenew = "SELECT * FROM furnituretbl ORDER BY fID DESC LIMIT 0, 8";
$furResultnew = mysqli_query($conn, $furniturenew);

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

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link type="image/png" sizes="16x16" rel="icon" href=".../icons8-upload image-sf-black-16.png">

    <!-- Libraries Stylesheet -->
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
        .tooltip-text {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            z-index: 1;
            width: 220px;
            height: 50px;
            color: black;
            font-size: 12px;
            background-color: #f9c88e;
            border-radius: 10px;
            padding: 10px 40px 10px 15px;
            transition: opacity 0.3s ease-in-out;
        }

        .hover-text:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
            transition: opacity 0.3s ease-in-out;
        }

        #top {
            top: -60px;
            left: -80%;
        }

        #bottom {
            top: 30px;
            left: -50%;
        }

        #left {
            top: -8px;
            right: 120%;
        }

        #right {
            top: -8px;
            left: 120%;
        }

        .hover-text {
            position: relative;
            display: inline-block;
            font-family: Arial;
            text-align: center;
        }

        .img1:hover {

            border: 3px solid black;
            transition: border 0.3s ease-in-out, transform 0.3s ease-in-out;
            transform: scale(1.05);
        }
        .img1 {
            transition: border 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        a {
            color: black !important;

        }

        a:hover {
            color: #e47011 !important;

        }
        /* Add animation to quantity buttons */
        .btn-minus, .btn-plus {
            transition: transform 0.2s ease;
        }
        .btn-minus:active, .btn-plus:active {
            transform: scale(0.9);
        }

        .page-header {
            background-image: url(./img/1.jpg) !important;

        }
    </style>
    <script>
        // Add animation to drop area on drag events
        document.addEventListener('DOMContentLoaded', function () {
            const dropArea = document.querySelector('.drop-area');

            dropArea.addEventListener('dragenter', () => {
                dropArea.style.transition = 'box-shadow 0.3s ease-in-out';
                dropArea.style.boxShadow = '0 0 15px 5px #f9c88e';
            });

            dropArea.addEventListener('dragleave', () => {
                dropArea.style.boxShadow = 'none';
            });

            dropArea.addEventListener('drop', () => {
                dropArea.style.boxShadow = 'none';
            });
        });
    </script>

    <?php require './css/dropcss.php'; ?>
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
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
                
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>

                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="shop.php" class="position-relative me-3 my-auto text-dark">Home</a>

                        <a href="customize.php" class="position-relative me-3 my-auto text-primary fw-bold">Costumize</a>
                        
                        <a href="Profile.php" class="position-relative me-3 my-auto text-dark">Purchase</a>
                    </div>

                    <div class="d-flex m-3 me-0">
                        <a href="cart.php" class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x text-muted"></i>

                            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?php echo $i; ?></span>
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
        <h1 class="text-center text-white display-6" style="text-decoration: underline;">Costumize</h1>
    </div>
    <!-- Single Page Header End -->


    <!-- Single Product Start -->
    <br>
    <div class="container-fluid py-5">
        <div class="container py-2 rounded ">
            <div class="col-lg-12 col-xl-12 bg-light" style="margin-bottom: 100px;">
                <form method="POST" action="customizeadd.php" enctype="multipart/form-data">
                    <div class="row justify-content-center" style="margin-top: 50px; padding-top: 50px; padding-bottom: 50px;">
                        <div class="col-lg-4">
                            <div class="border rounded">
                                <div class="container drop">
                                    <div class="drop-area text-center mt-5">
                                        <img width="64" height="64" src="https://img.icons8.com/sf-black/64/737373/add-image.png" alt="add-image" />

                                        <input type="file" id="input-file" name="image" hidden required>
                                        
                                        <h3>Drag and drop or click here to select image</h3>
                                        
                                        <p>Image size must be less than <span>2MB</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">

                            <div class="my-2">
                                <h5>Name of Furniture</h5>

                                <input type="text" name="prodName" id="prodName" class="form-control form-control-sm w-50" required>
                            </div>
                            
                            <div class="my-2">
                                <h5>Type of Furniture</h5>

                                <select name="category" id="category" class="form-control form-control-sm w-50" required>
                                    <option value="" diabled hidden>Select Category</option>

                                    <option value="mirror">Mirror</option>

                                    <option value="cabinet">Cabinet</option>

                                    <option value="chair">Chair</option>

                                    <option value="table">Table</option>

                                    <option value="bed">Bed frame</option>

                                    <option value="sala set">Sala Set</option>

                                    <option value="tv">TV Stand</option>
                                </select>
                            </div>

                            <!-- Varnish Selection -->
                            <p class="mb-3">Type of Varnish:</p>

                            <div class="image-container">
                                <?php while ($rows = mysqli_fetch_assoc($varresult)) { ?>
                                    <label for="<?php echo $rows['ID']; ?>" class="input_var hover-text">
                                        <input class="input_hidden" type="radio" name="vName[]" value="<?php echo $rows['vName']; ?>" id="<?php echo $rows['ID']; ?>" data-cost="<?php echo $rows['cost']; ?>" required>
                                        
                                        <img class="img1" src="./up/<?php echo $rows['image']; ?>" alt="" width="40" height="40">
                                        
                                        <span class="tooltip-text top" id="top" value="">Product Name:
                                            &nbsp;<?php echo $rows['vName']; ?> <br> Price: &nbsp;<span
                                                class="litValueDisplay" data-id="<?php echo $rows['ID']; ?>">Select category
                                                first</span></span>
                                    </label>

                                    <input type="hidden" name="vcost" value="<?php echo $rows['cost']; ?>">
                                <?php } ?>
                            </div>

                            <!-- Wood Selection -->
                            <p class="mb-3">Type of Wood:</p>

                            <div class="image-container mt-2">

                                <?php while ($rows = mysqli_fetch_assoc($rawresult)) { ?>
                                    <label for="<?php echo $rows['pID']; ?>" class="input_var hover-text">
                                        <input class="input_hidden" type="radio" name="pName[]" value="<?php echo $rows['pName']; ?>" id="<?php echo $rows['pID']; ?>" data-cost="<?php echo $rows['pCost']; ?>" required>
                                        
                                        <img class="img1" src="./up/<?php echo $rows['image']; ?>" alt="" width="40" height="40">
                                        
                                        <span class="tooltip-text mt-3 bot" id="bottom" value="">Product Name:
                                            &nbsp;<?php echo $rows['pName']; ?><br>Price:
                                            &nbsp;&#8369;<?php echo $rows['pCost']; ?></span>
                                    </label>

                                    <input type="hidden" name="pcost" value="<?php echo $rows['pCost']; ?>">
                                <?php } ?>

                            </div>

                            <!-- Custom Size -->
                            <div class="custom-size mt-4">
                                <label>Note: Unit must be in feet</label>

                                <div class=" mt-2 d-flex justify-content-start">
                                    <div class="d-flex">
                                        <label for="width" class="form-label mt-2">Width:</label>

                                        <input type="number" id="width" name="width" class="form-control form-control-sm w-50 mx-1" min="1" required>
                                    </div>

                                    <div class="d-flex">
                                        <label for="length" class="form-label mt-2">Length:</label>
                                        
                                        <input type="number" id="length" name="length" class="form-control form-control-sm w-50 mx-1" min="1" required>
                                    </div>

                                    <div class="d-flex">
                                        <label for="length" class="form-label mt-2">Height:</label>
                                        
                                        <input type="number" id="height" name="height" class="form-control form-control-sm w-50 mx-1" min="1" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Quantity selection -->
                            <div class="d-flex justify-content-between col-5 mt-3">
                                <label for="">Quantity: </label>

                                <div class="input-group quantity mb-3 d-flex align-items-center" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <a class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </a>
                                    </div>

                                    <input type="text" name="quantity" id="quantity" class="form-control form-control-sm qform text-center border-0 bg-transparent" readonly value="1">
                                    
                                    <div class="input-group-btn">
                                        <a class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="submit" class="btn border border-secondary rounded-pill px-4 py-2 text-primary mt-4" name="add"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to cart</button>

                                    <a href="#" data-bs-toggle="modal" data-bs-target="#checkoutModal" class="position-relative me-4 my-auto btn border border-secondary rounded-pill px-4 py-2 text-primary mt-4" id="checkoutButton" onclick="showCheckoutModal()">Check Out</a>
                                </div>

                                <!-- Add View Cost button -->
                                <div class="d-flex justify-content-end">
                                    <div style="display: none;">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#costModal" class="position-relative me-4 my-auto btn border border-secondary rounded-pill px-4 py-2 text-primary mt-4" id="viewCostButton" onclick="checkFields()">View Cost</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </form>
            </div>

            <h2 class="mb-4">Recommended</h2>

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

                        <div class="text-white bg-danger px-2  py-2 rounded-pill position-absolute" style="top: 20px; right: 10px;">New</div>

                        <div class="p-4 rounded-bottom">
                            <h4><?php echo $row['fName']; ?></h4>

                            <!-- <p><?php echo $row['fDes']; ?></p> -->

                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">&#8369;<?php echo $cost; ?></p>

                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>

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
                        <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Your Site Name</a>, All right reserved.</span>
                    </div>
                </center>
            </div>
        </div>
    </div>
    <!-- Copyright End -->



    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

    <!-- View Cost Modal -->
    <div class="modal fade" id="costModal" tabindex="-1" aria-labelledby="costModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-white">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="costModalLabel">Furniture Cost Details</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <h4 class="text-center my-2" id="furnitureName"></h4>

                    <div class=" d-flex justify-content-center">
                        <img id="selectedImage" class="img-fluid rounded w-50" />
                    </div>

                    <div class=" d-flex justify-content-between px-5 mb-0 py-0">
                        <p>Quantity:</p>

                        <p id="quantityModal"></p>
                    </div>

                    <div class=" d-flex justify-content-between px-5 my-0 py-0">
                        <p>Length: </p>

                        <p><span id="selectedLength"></span>ft X ₱450</p>
                    </div>

                    <div class=" d-flex justify-content-between px-5 my-0 py-0">
                        <p>Width: </p>

                        <p><span id="selectedWidth"></span>ft X ₱450</p>
                    </div>

                    <div class=" d-flex justify-content-between px-5 my-0 py-0">
                        <p>Height: </p>

                        <p><span id="selectedHeight"></span>ft X ₱450</p>
                    </div>

                    <div class=" d-flex justify-content-between px-5 my-0 py-0">
                        <p>Wood Type: <span id="woodTypeModal"></span></p>

                        <p id="woodCostModal"></p>
                    </div>

                    <div class=" d-flex justify-content-between px-5 my-0 py-0">
                        <p>Varnish Type: <span id="varnishTypeModal"></span></p>

                        <p id="varnishCostModal"></p>
                    </div>

                    <div class=" d-flex justify-content-between px-5 my-0 py-0">
                        <p>Labor Fee:</p>

                        <p id="laborFeeModal"></p>
                    </div>

                    <div class=" d-flex justify-content-between px-5 border-top">
                        <h5>Total Cost:</h5>

                        <p class="fw-bold fs-5" id="totalCostModal"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkout Preview Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-white">
                <div class="card-header p-4">
                    <div id="userDetails" class="lh-1">
                        <p><strong>Full Name:</strong> <span id="userName"></span></p>

                        <p><strong>Address:</strong> <span id="userAddress"></span></p>

                        <p><strong>Contact Number:</strong> <span id="userPhone"></span></p>
                    </div>
                </div>

                <form id="checkoutForm" method="POST" action="customizeadd.php" enctype="multipart/form-data">

                    <div class="modal-body">
                        <div class="d-flex justify-content-between align-items-center px-5">
                            <ul id="orderPreview" class="list-unstyled">
                                <!-- Items will be dynamically inserted here -->
                            </ul>
                        </div>


                        <h6 class="mt-5">Payment Method:</h6>

                        <p class="fw-bold d-flex align-items-center" style="color:#0d6efd;"><img src="img/gcash.png" width="25px" height="25px"> GCash</p>

                        <!-- Removed SCAN TO PAY text and toggle -->
                        <!-- Show QR code image directly -->
                        <div class="qr-container" style="margin-left:60px;">
                            <img src="img/qr.jpg" width="150px" height="150px" alt="QR Code">
                        </div>

                        <label for="payment">Select Payment:</label>

                        <select class="form-control form-control-sm w-50" name="payment" id="payment" required>
                            <option value="" hidden disabled>Select Payment</option>

                            <option value="Full Payment">Full Payment</option>

                            <option value="Down Payment">Down Payment</option>
                        </select>

                        <label for="qrImage" class="mt-4">Upload Proof of Payment:</label>

                        <input type="file" name="qrImage" class="form-control form-control-sm w-50" id="qrImage" onchange="previewImage(event)">

                        <!-- image preview -->
                        <div id="imagePreviewContainer" style="margin-top: 10px;">
                            <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 150px; display: none;">
                        </div>


                        <div class="d-flex justify-content-between px-3 mt-4">
                            <h5>Total Cost:</h5>

                            <p class="fs-5 fw-bold" id="totalCost"></p>
                        </div>

                        <input type="hidden" id="products" name="products">

                        <input type="hidden" id="quantities" name="quantities">

                        <input type="hidden" id="totalCostField" name="totalCost">

                        <input type="hidden" id="fullNameField" name="fullName">

                        <input type="hidden" id="addressField" name="address">

                        <input type="hidden" id="cpNumField" name="cpNum">

                        <input type="hidden" id="productDetails" name="productDetails">

                        <input type="hidden" id="displayWidth" name="width">
                        
                        <input type="hidden" id="displayLength" name="length">

                        <input type="hidden" id="displayHeight" name="height">

                        <input type="hidden" id="displayPayment" name="payment">

                        <input type="file" id="modalImageInput" name="image" hidden>
                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <button type="submit" form="checkoutForm" name="checkout" class="btn btn-secondary">Checkout</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="js/dropscripts.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnMinus = document.querySelector('.btn-minus');
            const btnPlus = document.querySelector('.btn-plus');
            const inputField = document.querySelector('.qform');

            btnMinus.addEventListener('click', function () {
                let currentValue = parseInt(inputField.value, 10);
                if (currentValue > 1) {
                    inputField.value = currentValue - 1;
                    triggerAutoViewCost();
                }
            });

            btnPlus.addEventListener('click', function () {
                let currentValue = parseInt(inputField.value, 10);
                inputField.value = currentValue + 1;
                triggerAutoViewCost();
            });

            const categorySelect = document.getElementById('category');
            categorySelect.addEventListener('change', function () {
                // Set the lit value based on selected category
                let litValue = 0;

                switch (categorySelect.value.toLowerCase()) {
                    case 'chair': litValue = 150; break;
                    case 'table': litValue = 400; break;
                    case 'mirror': litValue = 200; break;
                    case 'cabinet': litValue = 400; break;
                    case 'bed': litValue = 500; break;
                    case 'tv': litValue = 400; break;
                    case 'sala set': litValue = 600; break;
                    default: litValue = 0; break;
                }

                // Update all litValueDisplay spans
                const litValueDisplays = document.querySelectorAll('.litValueDisplay');
                litValueDisplays.forEach(function (display) {
                    display.textContent = litValue;
                });
                triggerAutoViewCost();
            });

            // Add event listeners to other inputs to trigger auto view cost
            const prodNameInput = document.getElementById('prodName');
            const widthInput = document.getElementById('width');
            const lengthInput = document.getElementById('length');
            const heightInput = document.getElementById('height');
            const woodRadios = document.querySelectorAll('input[name="pName[]"]');
            const varnishRadios = document.querySelectorAll('input[name="vName[]"]');
            const quantityInput = document.getElementById('quantity');

            prodNameInput.addEventListener('input', triggerAutoViewCost);
            widthInput.addEventListener('input', triggerAutoViewCost);
            lengthInput.addEventListener('input', triggerAutoViewCost);
            heightInput.addEventListener('input', triggerAutoViewCost);

            woodRadios.forEach(radio => {
                radio.addEventListener('change', triggerAutoViewCost);
            });

            varnishRadios.forEach(radio => {
                radio.addEventListener('change', triggerAutoViewCost);
            });

            // quantity input is readonly, so changes come from plus/minus buttons already handled

            function triggerAutoViewCost() {
                // Check if all required fields are filled
                const prodName = prodNameInput.value.trim();
                const category = categorySelect.value;
                const width = parseFloat(widthInput.value);
                const length = parseFloat(lengthInput.value);
                const height = parseFloat(heightInput.value);
                const selectedWood = document.querySelector('input[name="pName[]"]:checked');
                const selectedVarnish = document.querySelector('input[name="vName[]"]:checked');
                const quantity = parseInt(quantityInput.value, 10);

                if (
                    prodName !== '' &&
                    category !== '' &&
                    !isNaN(width) && width > 0 &&
                    !isNaN(length) && length > 0 &&
                    !isNaN(height) && height > 0 &&
                    selectedWood !== null &&
                    selectedVarnish !== null &&
                    !isNaN(quantity) && quantity > 0
                ) {
                    // All fields filled, call checkFields and show modal
                    checkFields();
                    // Show the modal if not already shown
                    var costModal = new bootstrap.Modal(document.getElementById('costModal'));
                    costModal.show();
                }
            }

            //Check Out Function
            function showCheckoutModal() {
                const userName = '<?php echo $_SESSION["fullName"]; ?>';
                const userAddress = '<?php echo $_SESSION["address"]; ?>';
                const userPhone = '<?php echo $_SESSION["cpNum"]; ?>';

                document.getElementById('userName').textContent = userName;
                document.getElementById('userAddress').textContent = userAddress;
                document.getElementById('userPhone').textContent = userPhone;

                // Get selected and inputted product details
                const prodName = document.getElementById('prodName').value;
                const category = document.getElementById('category').value;
                const quantity = parseInt(document.getElementById('quantity').value, 10);
                const width = parseFloat(document.getElementById('width').value);
                const length = parseFloat(document.getElementById('length').value);
                const height = parseFloat(document.getElementById('height').value);
                const payment = document.getElementById('payment').value;


                const selectedWood = document.querySelector('input[name="pName[]"]:checked');
                const selectedVarnish = document.querySelector('input[name="vName[]"]:checked');

                const woodType = selectedWood ? selectedWood.value : 'N/A';
                const woodCost = selectedWood ? parseFloat(selectedWood.getAttribute('data-cost')) : 0;
                const varnishType = selectedVarnish ? selectedVarnish.value : 'N/A';
                const varnishCost = selectedVarnish ? parseFloat(selectedVarnish.getAttribute('data-cost')) : 0;

                let laborFee = 0;
                switch (category.toLowerCase()) {
                    case 'mirror': laborFee = 450; break;
                    case 'cabinet': laborFee = 600; break;
                    case 'chair': laborFee = 250; break;
                    case 'table': laborFee = 450; break;
                    case 'bed': laborFee = 400; break;
                    case 'sala set': laborFee = 300; break;
                    case 'tv': laborFee = 350; break;
                }

                let lit = 0;
                switch (category.toLowerCase()) {
                    case 'mirror': lit = 200; break;
                    case 'cabinet': lit = 400; break;
                    case 'chair': lit = 150; break;
                    case 'table': lit = 400; break;
                    case 'bed': lit = 400; break;
                    case 'sala set': lit = 600; break;
                    case 'tv': lit = 400; break;
                }

                const tWidth = woodCost * width;
                const tLength = woodCost * length;
                const tHeight = woodCost * height;
                const totalCost = (tWidth + tLength + tHeight + lit + laborFee) * quantity;
                const unitcost = (tWidth + tLength + tHeight + lit + laborFee);

                const orderPreviewList = document.getElementById('orderPreview');
                orderPreviewList.innerHTML = `
                    <li>
                        <h5>${prodName}</h5>
                        <div class="ms-2" style="font-size:14px; line-height:5px;">
                            <p>Qt: ${quantity}</p>
                            <p>Price: ${unitcost}</p>
                        </div>
                    </li>
                `;

                document.getElementById('totalCost').textContent = '₱' + totalCost.toLocaleString('en-US');

                const fileInput = document.getElementById('input-file');
                const imagePreviewContainer = document.getElementById('imagePreviewContainer');
                const previewImage = document.getElementById('imagePreview');

                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImage.src = e.target.result;
                        imagePreviewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                } else {
                    previewImage.src = '';
                    imagePreviewContainer.style.display = 'none';
                }

                document.getElementById('totalCostField').value = totalCost;
                document.getElementById('products').value = prodName;
                document.getElementById('quantities').value = quantity;
                document.getElementById('productDetails').value = `L: ${length}ft W: ${width}ft H: ${height}ft Wood: ${woodType} Varnish: ${varnishType}`;

                document.getElementById('fullNameField').value = userName;
                document.getElementById('addressField').value = userAddress;
                document.getElementById('cpNumField').value = userPhone;
                document.getElementById('displayWidth').value = width;
                document.getElementById('displayLength').value = length;
                document.getElementById('displayHeight').value = height;
                document.getElementById('displayPayment').value = payment;
            }

            const mainFileInput = document.getElementById('input-file');
            const modalFileInput = document.getElementById('modalImageInput');

            function copyImageToModal() {
                if (mainFileInput.files && mainFileInput.files[0]) {
                    modalFileInput.files = mainFileInput.files;
                }
            }

            checkoutButton.addEventListener('click', function () {
                copyImageToModal();
            });

            document.getElementById('checkoutButton').addEventListener('click', function () {
                showCheckoutModal();
            });
        });

        //View Cost Modal Function
        function checkFields() {
            const selectedWood = document.querySelector('input[name="pName[]"]:checked');
            const selectedVarnish = document.querySelector('input[name="vName[]"]:checked');
            const category = document.getElementById('category').value;
            const quantity = parseInt(document.getElementById('quantity').value);
            const width = parseFloat(document.getElementById('width').value);
            const length = parseFloat(document.getElementById('length').value);
            const height = parseFloat(document.getElementById('height').value);

            const woodCost = selectedWood ? parseFloat(selectedWood.getAttribute('data-cost')) : 0;
            const varnishCost = selectedVarnish ? parseFloat(selectedVarnish.getAttribute('data-cost')) : 0;

            let laborFee = 0;
            switch (category.toLowerCase()) {
                case 'mirror':
                    laborFee = 450;
                    break;
                case 'cabinet':
                    laborFee = 600;
                    break;
                case 'chair':
                    laborFee = 250;
                    break;
                case 'table':
                    laborFee = 450;
                    break;
                case 'bed':
                    laborFee = 400;
                    break;
                case 'sala set':
                    laborFee = 300;
                    break;
                case 'tv':
                    laborFee = 350;
                    break;
            }

            let lit = 0;
            switch (category.toLowerCase()) {
                case 'mirror':
                    lit = 200;
                    break;
                case 'cabinet':
                    lit = 400;
                    break;
                case 'chair':
                    lit = 150;
                    break;
                case 'table':
                    lit = 400;
                    break;
                case 'bed':
                    lit = 500;
                    break;
                case 'tv':
                    lit = 400;
                    break;
                case 'sala set':
                    lit = 600;
                    break;
                default:
                    lit = 0;
                    break;
            }

            const tWidth = woodCost * width;
            const tLength = woodCost * length;
            const tHeight = woodCost * height;
            const dWoodCost = (tWidth + tLength + tHeight) * quantity;
            const dLit = lit * quantity;
            const dLaborFee = laborFee * quantity;
            const totalCost = (tWidth + tLength + tHeight + lit + laborFee) * quantity.toLocaleString('en-US');

            document.getElementById('furnitureName').textContent = document.getElementById('prodName').value;
            document.getElementById('selectedImage').src = document.getElementById('input-file').files[0] ? URL.createObjectURL(document.getElementById('input-file').files[0]) : '';
            document.getElementById('quantityModal').textContent = quantity;
            document.getElementById('woodTypeModal').textContent = selectedWood ? selectedWood.value : 'N/A';
            document.getElementById('woodCostModal').textContent = dWoodCost ? `₱${dWoodCost.toLocaleString('en-US')}` : '₱0,000';
            document.getElementById('varnishTypeModal').textContent = selectedVarnish ? selectedVarnish.value : 'N/A';
            document.getElementById('varnishCostModal').textContent = dLit ? `₱${dLit.toLocaleString('en-US')}` : '₱0,000';
            document.getElementById('laborFeeModal').textContent = `₱${dLaborFee.toLocaleString('en-US')}`;
            document.getElementById('totalCostModal').textContent = `₱${totalCost.toLocaleString('en-US')}`;
            document.getElementById('selectedWidth').textContent = width; 
            document.getElementById('selectedLength').textContent = length;
            document.getElementById('selectedHeight').textContent = height;
        }

        // Validation for modal form image input
        document.getElementById('checkoutForm').addEventListener('submit', function (e) {
            const fileInput = document.getElementById('qrImage');
            const file = fileInput.files[0];
            if (!file) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'No Image Selected',
                    text: 'Please upload an image before submitting.',
                });
                return;
            }
            const allowedExtensions = ['image/jpeg', 'image/png'];
            if (!allowedExtensions.includes(file.type)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: 'Only JPG and PNG images are allowed.',
                });
                return;
            }
        });

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var preview = document.getElementById('imagePreview');
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }

    </script>

</body>
</html>

</html>