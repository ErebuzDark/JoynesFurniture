<?php
include("addcartfunction.php");
include("addQuantity.php");

$userID = $_SESSION['userID'];

// Calculate the updated total cost for all items in the cart
$sqlTotal = "SELECT SUM(cost) AS total_cost FROM addcart WHERE userID = ?";
$stmtTotal = $conn->prepare($sqlTotal);
$stmtTotal->bind_param("i", $userID);
$stmtTotal->execute();
$resultTotal = $stmtTotal->get_result();
$rowTotal = $resultTotal->fetch_assoc();
$totalCost = $rowTotal['total_cost'] ?? 0;
$costs = number_format($totalCost, 0, '.', ',');

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

    <!-- Libraries Stylesheet -->
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
        a {
            color: #e47011 !important;

        }

        a:hover {
            color: white !important;

        }

        .page-header {
            background-image: url(./img/1.jpg) !important;

        }

        /* Page pop-up animation */
        @keyframes pagePopUp {
            0% {
                opacity: 0;
                transform: scale(0.50);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .page-pop-up {
            animation: pagePopUp 0.5s ease forwards;
        }
    </style>
</head>

<body>

    <!-- Spinner Start -->
    <!-- <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div> -->
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
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="shop.php">Home</a></li>
                            <li class="breadcrumb-item active text-dark">Cart</li>
                            <li class="breadcrumb-item"><a href="customizecart.php">Customized Cart</a></li>
                        </ol>
                    </div>

                    <div class="d-flex m-3 me-0">
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
        <h1 class="text-center text-white display-6">Cart</h1>
    </div>
    <!-- Single Page Header End -->

    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table">

                    <thead>
                        <tr>
                            <th></th>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    
                    <?php
                    while ($row = mysqli_fetch_assoc($resultu)) {
                        $number = $row['cost'];
                        $formattedNumber = number_format($number, 0, '.', ',');
                        $cost = $formattedNumber;

                        $costID = $row['ID'];
                        $costSql = "SELECT * FROM furnituretbl WHERE fID = '$costID'";
                        $costResult = mysqli_query($conn, $costSql);
                        $costRow = mysqli_fetch_assoc($costResult);
                        
                        $costFormat = number_format($costRow['cost'], 0, '.', ',');
                        $costDisplay = $costFormat;
                        ?>
                        <tbody>
                            <form method="POST" action="cartQuantity.php">
                                <!-- Change to method POST for form submission -->
                                <tr>
                                    <!-- Product Select Checkbox -->
                                    <th scope="row">
                                        <input type="checkbox" name="selected_products[]" value="<?php echo $row['ID']; ?>" checked>
                                    </th>

                                    <!-- Product Image -->
                                    <th scope="row">
                                        <div class="d-flex align-items-center">
                                            <img src="./up/<?php echo $row['image']; ?>"
                                                class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;"
                                                alt="">
                                        </div>
                                    </th>

                                    <!-- Product Name -->
                                    <td>
                                        <p class="mb-0 mt-4"><?php echo $row['prodName']; ?></p>
                                    </td>

                                    <!-- Product Cost -->
                                    <td>
                                        <p class="mb-0 mt-4"><?php echo $costDisplay; ?></p>
                                    </td>

                                    <!-- Quantity Controls -->
                                    <td>
                                        <div class="input-group quantity mt-4" style="width: 100px;">
                                            <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">
                                            <input type="hidden" name="action" value="">

                                            <!-- Minus Button -->
                                            <div class="input-group-btn">
                                                <button type="submit" name="action" value="minus"
                                                    class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>

                                            <!-- Quantity Input -->
                                            <input type="text" class="form-control form-control-sm text-center border-0"
                                                name="quantity" value="<?php echo $row['quantity']; ?>">

                                            <!-- Plus Button -->
                                            <div class="input-group-btn">
                                                <button type="submit" name="action" value="plus"
                                                    class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Subtotal -->
                                    <td>
                                        <p class="mb-0 mt-4"><?php echo $cost; ?></p>
                                    </td>

                                    <!-- Delete Button -->
                                    <td>
                                        <a href="cartdelete.php?id=<?php echo $row['ID']; ?>"
                                            class="btn btn-md rounded-circle bg-light border mt-4">
                                            <i class="fa fa-times text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            </form>

                        </tbody>
                        <?php
                    }
                    ?>
                </table>
            </div>
            <div class="mt-5">
                <button id="checkoutBtn" class="btn proc border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button">Proceed Checkout</button>
            </div>

            <div class="row g-4 justify-content-start bg-light">
                <div class="col-8"></div>
                <div class="col-3">
                    <p class=" fw-bolder px-4 py-3 text-primary text-uppercase mb-4 ms-4" style="font-size: 21px;"><span
                            style="margin-right: 10px;">Total:</span> &#8369;<?php echo $costs; ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->

    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-lg-scrollable" style="margin-right: 610px; margin-top: 100px;">
            <div class="modal-content rounded bg-white">

                <div class="container modal-body">

                </div>

            </div>
        </div>
    </div>

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
                <div class="col-md-6 text-center  mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Your Site
                            Name</a>, All right reserved.</span>
                </div>

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
    <script src="js/cartfunction.js"></script>

    <script type='text/javascript'>
        $(document).ready(function () {
            // $('.proc').click(function(){
            //     var userid = $(this).data('id');

            //     $.ajax({
            //         url: 'cartcheckmodal.php',
            //         type: 'post',
            //         data: {userid: userid},
            //         success: function(response){ 
            //             $('.modal-content').html(response); 
            //             $('#checkoutModal').modal('show'); 
            //         }
            //     });
            // });

            // Add page pop-up animation class on page load
            $('.container-fluid.py-5').addClass('page-pop-up');

            $('#checkoutBtn').click(function () {
                var selectedProducts = [];

                $("input[name='selected_products[]']:checked").each(function () {
                    selectedProducts.push($(this).val());
                });

                if (selectedProducts.length > 0) {
                    $.ajax({
                        url: 'cartcheckmodal.php',
                        type: 'POST',
                        data: { selected_products: selectedProducts },
                        success: function (response) {
                            $('#checkoutModal .modal-content').html(response);
                            $('#checkoutModal').modal('show');
                        }
                    });
                } else {
                    alert("Please select at least one product.");
                }
            });
        });
    </script>
</body>

</html>