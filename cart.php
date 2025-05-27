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
    </style>
</head>

<body>

    <!-- Spinner Start -->
    <!-- <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div> -->
    <!-- Spinner End -->


    <!-- Navbar start -->
    <?php
    include("cartNav.php");
    ?>
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
                    <div class="form-check mb-3 d-flex align-items-center gap-2 mx-2">
                        <input type="checkbox" class="form-check-input mr-2" id="select-all" checked>
                        <label class="form-check-label text-dark font-weight-medium small mb-0" for="select-all"
                            style="cursor: pointer;">
                            Select All Products
                        </label>
                    </div>



                    <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>

                    <?php
                    $totalCost = 0; // initialize total cost
                    
                    while ($row = mysqli_fetch_assoc($resultu)) {
                        $number = $row['cost'];
                        $formattedNumber = number_format($number, 0, '.', ',');
                        $cost = $formattedNumber;

                        $costID = $row['ID'];
                        $costSql = "SELECT * FROM furnituretbl WHERE fID = '$costID'";
                        $costResult = mysqli_query($conn, $costSql);
                        $costRow = mysqli_fetch_assoc($costResult);

                        $unitCost = $costRow['cost'];
                        $costDisplay = number_format($unitCost, 0, '.', ',');

                        $quantity = $row['quantity'];
                        $subtotal = $unitCost * $quantity;
                        $totalCost += $subtotal;
                        ?>
                        <tbody>
                            <tr>
                                <form method="POST" action="cartQuantity.php">
                                    <!-- Product Select Checkbox -->
                                    <th scope="row" class="align-middle">
                                        <div class="form-check">
                                            <input class="form-check-input product-checkbox" type="checkbox"
                                                name="selected_products[]" value="<?= $row['ID'] ?>"
                                                data-cost="<?= $row['cost'] ?>" data-quantity="<?= $row['quantity'] ?>"
                                                id="productCheckbox<?= $row['ID'] ?>" checked>
                                        </div>
                                    </th>



                                    <!-- Product Image -->
                                    <th>
                                        <div class="d-flex align-items-center">
                                            <img src="./up/<?= $row['image'] ?>" class="img-fluid me-5 rounded-circle"
                                                style="width: 80px; height: 80px;" alt="">
                                        </div>
                                    </th>

                                    <!-- Product Name -->
                                    <td>
                                        <p class="mb-0 mt-4"><?= $row['prodName'] ?></p>
                                    </td>

                                    <!-- Product Cost -->
                                    <td>
                                        <p class="mb-0 mt-4">₱<?= $costDisplay ?></p>
                                    </td>

                                    <!-- Quantity Controls -->
                                    <td>
                                        <div class="input-group quantity mt-4" style="width: 100px;">
                                            <input type="hidden" name="ID" value="<?= $row['ID'] ?>">
                                            <input type="hidden" name="products" value="<?= $row['products'] ?>">
                                            <input type="hidden" name="quantity" value="<?= $quantity ?>">

                                            <button type="submit" name="action" value="minus"
                                                class="btn btn-sm btn-minus">-</button>
                                            <input type="text" readonly class="form-control text-center"
                                                value="<?= $quantity ?>">
                                            <button type="submit" name="action" value="plus"
                                                class="btn btn-sm btn-plus">+</button>
                                        </div>
                                    </td>

                                    <!-- Subtotal -->
                                    <td>
                                        <p class="mb-0 mt-4">₱<?= number_format($subtotal, 0, '.', ',') ?></p>
                                    </td>

                                    <!-- Delete Button -->
                                    <td class="">
                                        <a href="cartdelete.php?id=<?= $row['ID'] ?>"
                                            class="btn btn-md rounded-circle bg-light border mt-4 mx-2">
                                            <i class="fa fa-times text-danger"></i>
                                        </a>
                                    </td>
                                </form>
                            </tr>
                        </tbody>
                        <?php
                    }
                    ?>

                    <!-- Total Row -->
                    <tfoot>

                    </tfoot>

                </table>
            </div>
            <div class="container mt-5">
                <!-- Checkout Button and Total Row -->
                <div class="row align-items-center bg-light p-3 rounded">
                    <!-- Proceed Checkout Button -->
                    <div class="col-md-6 mb-3 mb-md-0">
                        <button id="checkoutBtn"
                            class="btn proc border-secondary rounded-pill px-4 py-3 text-primary text-uppercase"
                            type="button">Proceed Checkout</button>
                    </div>

                    <!-- Total Cost -->
                    <div class="col-md-6 text-md-end">
                        <p class="fw-bolder text-primary text-uppercase m-0" style="font-size: 21px;">
                            <span class="me-2">Total:</span>
                            <strong id="total-cost">₱0</strong>
                        </p>
                    </div>
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

    <script type="text/javascript">
        $(document).ready(function () {
            // Animate page load
            $('.container-fluid.py-5').addClass('page-pop-up');

            // Calculate and update total
            function updateTotal() {
                let total = 0;

                $('input.product-checkbox:checked').each(function () {
                    const cost = parseFloat($(this).data('cost'));
                    const quantity = parseInt($(this).data('quantity'));
                    total += cost * quantity;
                });

                $('#total-cost').text('₱' + total.toLocaleString());
            }

            // Initial total on page load
            updateTotal();

            // Update total when a checkbox is toggled
            $('body').on('change', 'input.product-checkbox', function () {
                updateTotal();

                // Sync Select All checkbox
                let allChecked = $('input.product-checkbox').length === $('input.product-checkbox:checked').length;
                $('#select-all').prop('checked', allChecked);
            });

            // Handle "Select All" checkbox
            $('#select-all').on('change', function () {
                let isChecked = $(this).is(':checked');
                $('input.product-checkbox').prop('checked', isChecked);
                updateTotal();
            });

            // Checkout click event
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



    <script>
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.product-checkbox').forEach((checkbox, index) => {
                const quantityInput = document.querySelectorAll('.quantity-input')[index];
                const cost = parseFloat(quantityInput.dataset.cost);
                const quantity = parseInt(quantityInput.value);

                if (checkbox.checked) {
                    total += cost * quantity;
                }
            });

            document.getElementById('total-cost').textContent = '₱' + total.toLocaleString();
        }

        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateTotal);
        });

        document.querySelectorAll('.btn-plus').forEach((btn, index) => {
            btn.addEventListener('click', () => {
                const input = document.querySelectorAll('.quantity-input')[index];
                input.value = parseInt(input.value) + 1;
                updateTotal();
            });
        });

        document.querySelectorAll('.btn-minus').forEach((btn, index) => {
            btn.addEventListener('click', () => {
                const input = document.querySelectorAll('.quantity-input')[index];
                const currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                    updateTotal();
                }
            });
        });

        // Initial total calculation
        updateTotal();
    </script>

</body>

</html>