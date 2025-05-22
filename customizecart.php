<?php
include("database.php");
include("addcartfunction.php");
include("addQuantity.php");
$userID = $_SESSION['userID'];
$sqluse = "SELECT * FROM tbl_cartcus WHERE userID = ?";
$stmt = $conn->prepare($sqluse);
$stmt->bind_param('i', $userID);
$stmt->execute();
$resultu = $stmt->get_result();

if (isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    // Get the cost of the product
    $sql = "SELECT cost FROM tbl_cartcus WHERE cart_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $cart_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $cost = $row['cost'];

    // Update the quantity and total cost in the database
    $totalCost = $cost * $quantity;
    $update_sql = "UPDATE tbl_cartcus SET quantity = ?, totalCost = ? WHERE cart_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('idi', $quantity, $totalCost, $cart_id);
    if ($update_stmt->execute()) {
        echo "Cart updated successfully!";
    } else {
        echo "Error updating cart.";
    }
}



$usersql = "SELECT ID, fullName, address, cpNum FROM usertbl WHERE ID = ?";
$userstmnt = $conn->prepare($usersql);
$userstmnt->bind_param('i', $userID);
$userstmnt->execute();
$userresult = $userstmnt->get_result();

if ($userresult->num_rows > 0) {
    $user = $userresult->fetch_assoc();

} else {
    echo json_encode([]);
}

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
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="container topbar d-none d-lg-block">

        </div>

        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="shop.php" class="navbar-brand"><img class="logo" src="./img/logo1.png" alt="Bootstrap" style="width: 200px"></a>

                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>

                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="shop.php">Home</a></li>

                            <li class="breadcrumb-item "><a href="cart.php">Cart</a></li>

                            <li class="breadcrumb-item active text-dark">Customized Cart</li>
                        </ol>
                    </div>

                    <div class="d-flex m-3 me-0">
                        <a href="cart.php" class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x text-muted"></i>

                            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?php echo $i; ?></span>
                        </a>

                        <div class="nav-item dropdown">
                            <i class="fas fa-user fa-2x"></i>

                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="#" class="dropdown-item">My Profile</a>

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
        <h1 class="text-center text-white display-6">Customized Cart</h1>
    </div>
    <!-- Single Page Header End -->


    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <form method="POST" action="">
                    <table class="table">

                        <thead>
                            <tr>
                                <th></th>

                                <th scope="col">Products</th>

                                <th scope="col">Name</th>
                                
                                <th scope="col">Product Details</th>

                                <th scope="col">Price</th>

                                <th scope="col">Quantity</th>

                                <th scope="col">Total</th>

                                <th scope="col">Handle</th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            <?php while ($row = mysqli_fetch_assoc($resultu)) {
                                $number = $row['totalCost'];
                                $cost = $number;
                                $tot = $cost * $row['quantity']; ?>
                                <tr class="align-middle">

                                    <td>
                                        <input type="checkbox" name="selected_items[]" value="<?php echo $row['cart_id']; ?>" class="cart-checkbox" checked>
                                    </td>

                                    <td>
                                        <img src="./up/<?php echo $row['image']; ?>" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="" alt="">
                                    </td>

                                    <td>
                                        <p><?php echo $row['fName']; ?></p>
                                    </td>

                                    <td style="line-height:5px;">
                                        <p class="mt-3">L: <?php echo $row['length']; ?> ft</p>

                                        <p>W: <?php echo $row['width']; ?> ft</p>

                                        <p>H: <?php echo $row['height']; ?> ft</p>

                                        <p>Wood: <?php echo $row['pName']; ?></p>

                                        <p>Varnish: <?php echo $row['vName']; ?></p>
                                    </td>

                                    <td>
                                        <p><?php echo number_format($row['cost'], 0, '.', ','); ?></p>
                                    </td>

                                    <td>
                                        <div class="input-group quantity mb-3 d-flex align-items-center" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <a class="btn btn-sm btn-minus rounded-circle bg-light border" data-id="<?php echo $row['cart_id']; ?>" data-cost="<?php echo $row['cost']; ?>">
                                                    <i class="fa fa-minus"></i>
                                                </a>
                                            </div>

                                            <input type="text" name="quantity" id="quantity-<?php echo $row['cart_id']; ?>" class="form-control form-control-sm text-center border-0 bg-transparent" readonly value="<?php echo $row['quantity']; ?>" data-id="<?php echo $row['cart_id']; ?>" data-price="<?php echo $row['cost']; ?>">

                                            <div class="input-group-btn">
                                                <a class="btn btn-sm btn-plus rounded-circle bg-light border" data-id="<?php echo $row['cart_id']; ?>" data-cost="<?php echo $row['cost']; ?>">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <p id="total-<?php echo $row['cart_id']; ?>">
                                            <?php echo number_format($cost, 0, '.', ','); ?>
                                        </p>
                                    </td>

                                    <td>
                                        <a href="cartdelete.php?cart_id=<?php echo $row['cart_id']; ?>" class="btn btn-md rounded-circle bg-light border">
                                            <i class="fa fa-times text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>

                    </table>
                    <div class="d-flex justify-content-between mt-3">
                        <!-- Button to trigger the modal -->
                        <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button" id="proceedCheckoutBtn">
                            Proceed Checkout
                        </button>
                    </div>
                    <div class="d-flex g-4 justify-content-start bg-light">
                        <div class="col-8"></div>
                        <div class="col-3">
                            <p class=" fw-bolder px-4 py-3 text-primary text-uppercase mb-4 ms-4" style="font-size: 21px;">
                                <span>Total:</span> &#8369;<?php echo number_format($cost, 0, '.', ','); ?></p>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Checkout Preview Modal -->
            <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-white">
                        <div class="card-header p-4">
                            <div id="userDetails" class="lh-1">
                                <p><strong>Full Name:</strong> <span id="userName"><?php echo $user['fullName']; ?></span></p>

                                <p><strong>Address:</strong> <span id="userAddress"><?php echo $user['address']; ?></span></p>

                                <p><strong>Contact Number:</strong> <span id="userPhone"><?php echo $user['cpNum']; ?></span></p>
                            </div>
                        </div>

                        <div class="modal-body">
                            <form id="checkoutForm" method="POST" action="cocustom.php" enctype="multipart/form-data">
                                <!-- Preview Order Details List -->
                                <ul id="orderPreview" class="list-unstyled">
                                    <!-- Items will be dynamically inserted here -->
                                </ul>


                                <h6 class="mt-5">Payment Method:</h6>

                                <p class="fw-bold d-flex align-items-center" style="color:#0d6efd;"><img src="img/gcash.png" width="25px" height="25px"> GCash</p>

                                <!-- QR code image shown by default -->
                                <div class="qr-container" style="display:block; margin-left:60px;">
                                    <img src="img/qr.jpg" width="150px" height="150px" alt="QR Code">
                                </div>

                                <label for="payment">Select Payment:</label>

                                <select class="form-control form-control-sm w-50" name="payment" id="payment" required>
                                    <option value="" hidden disabled>Select Payment</option>

                                    <option value="Full Payment">Full Payment</option>

                                    <option value="Down Payment">Down Payment</option>
                                </select>

                                <label for="qrImage" class="mt-4">Upload Proof of Payment:<br>*Minimum required downpayment is ₱1,000*</label>

                                <input type="file" name="qrImage" class="form-control form-control-sm w-50" id="qrImage" onchange="previewImage(event)">

                                <!-- image preview -->
                                <div id="imagePreviewContainer" style="margin-top: 10px;">
                                    <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 150px; display: none;">
                                </div>

                                <hr>
                                <div class="d-flex justify-content-between px-3">
                                    <h5>Total Cost:</h5>

                                    <p class="fs-5 fw-bold" id="totalCost"></p>
                                </div>
                                <hr>

                                <input type="hidden" id="cartIds" name="cartIds">

                                <input type="hidden" id="products" name="products">

                                <input type="hidden" id="quantities" name="quantities">

                                <input type="hidden" id="images" name="images">

                                <input type="hidden" id="totalCostField" name="totalCost">

                                <input type="hidden" id="fullNameField" name="fullName">

                                <input type="hidden" id="addressField" name="address">

                                <input type="hidden" id="cpNumField" name="cpNum">

                                <input type="hidden" id="displayWidth" name="width">

                                <input type="hidden" id="displayLength" name="length">

                                <input type="hidden" id="displayHeight" name="height">

                                <input type="hidden" value="<?php echo $userID ?>" name="userID">

                                <input type="hidden" id="productDetails" name="productDetails">

                            </form>
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                            <button type="submit" form="checkoutForm" class="btn btn-secondary">Checkout</button>
                        </div>
                    </div>
                </div>
            </div>




            <!-- <div class="mt-5">
                </div>
                <div class="row g-4 justify-content-start">
                    <div class="col-6">
                    <div class="bg-light rounded">
                            <div class="p-4">
                                <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Subtotal:</h5>
                                    <p class="mb-0">$96.00</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Partial Labor</h5>
                                    <div class="">
                                        <p class="mb-0">Flat rate: $3.00</p>
                                    </div>
                                </div>
                                <p class="mb-0 text-end">Shipping to Ukraine.</p>
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Total</h5>
                                <p class="mb-0 pe-4">$99.00</p>
                            </div>
                            <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4 <?php echo ($costs > 1) ? '' : 'disabled'; ?>" type="button">Proceed Checkout</button>
                        </div>
                    </div>
                </div> -->
        </div>
    </div>
    <!-- Cart Page End -->


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
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Your Site Name</a>, All right reserved.</span>
                </div>

                <div class="col-md-6 my-auto text-center text-md-end text-white">
                    <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                    <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                    <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                    Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> Distributed By <a
                        class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->



    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            // Function to update the total cost based on quantity
            function updateTotal(cartId, cost, quantity) {
                let totalCost = cost * quantity;
                $('#total-' + cartId).text(totalCost.toLocaleString('en-US'));  // Update total column
            }

            // Handle minus button click
            $('.btn-minus').click(function () {
                let cartId = $(this).data('id');
                let cost = parseFloat($(this).data('cost')); // Ensure cost is a float
                let quantityField = $('#quantity-' + cartId);
                let currentQuantity = parseInt(quantityField.val(), 10);

                if (currentQuantity > 1) {
                    let newQuantity = currentQuantity - 1;
                    quantityField.val(newQuantity);  // Update quantity input field
                    updateTotal(cartId, cost, newQuantity);  // Update total column

                // Update the database via AJAX
                $.ajax({
                    url: '',
                    method: 'POST',
                    data: { cart_id: cartId, quantity: newQuantity },
                    success: function (response) {
                        console.log(response); // Optionally log the response
                        location.reload(); // Reload the page after update
                    }
                });
                }
            });

            // Handle plus button click
            $('.btn-plus').click(function () {
                let cartId = $(this).data('id');
                let cost = parseFloat($(this).data('cost')); // Ensure cost is a float
                let quantityField = $('#quantity-' + cartId);
                let currentQuantity = parseInt(quantityField.val(), 10);

                let newQuantity = currentQuantity + 1;
                quantityField.val(newQuantity);  // Update quantity input field
                updateTotal(cartId, cost, newQuantity);  // Update total column

                // Update the database via AJAX
                $.ajax({
                    url: '',
                    method: 'POST',
                    data: { cart_id: cartId, quantity: newQuantity },
                    success: function (response) {
                        console.log(response); // Optionally log the response
                        location.reload(); // Reload the page after update
                    }
                });
            });

            $("#proceedCheckoutBtn").click(function () {
                // Get the selected items
                let selectedItems = [];
                let totalCost = 0; // Initialize total cost

                // Arrays to collect width, length, height
                let widths = [];
                let lengths = [];
                let heights = [];

                $(".cart-checkbox:checked").each(function () {
                    let cartId = $(this).val();
                    let row = $(this).closest('tr');
                    let productDetails = row.find('td:nth-child(4)').text().trim();
                    let productName = row.find('td:nth-child(3)').text().trim();
                    let image = row.find('td:nth-child(2) img').attr('src');
                    let unitCost = parseFloat(row.find('td:nth-child(5) p').text().trim().replace(/,/g, '').replace('$', '')); // Ensure correct parsing
                    let quantity = parseInt(row.find('input[name="quantity"]').val(), 10);
                    let itemTotalCost = (unitCost * quantity); // Calculate total cost for this item

                    // Get width, length, height from the details column
                    let length = row.find('td:nth-child(4) p').eq(0).text().replace('L:', '').replace('ft', '').trim();
                    let width = row.find('td:nth-child(4) p').eq(1).text().replace('W:', '').replace('ft', '').trim();
                    let height = row.find('td:nth-child(4) p').eq(2).text().replace('H:', '').replace('ft', '').trim();

                    widths.push(width);
                    lengths.push(length);
                    heights.push(height);

                    productDetails = productDetails.replace(/\s+/g, ' ').trim();

                    selectedItems.push({
                        cartId: cartId,
                        productName: productName,
                        productDetails: productDetails,
                        image: image,
                        unitCost: unitCost,
                        quantity: quantity,
                        totalCost: itemTotalCost
                    });

                    totalCost += parseFloat(itemTotalCost); // Sum up the total cost
                });

                if (selectedItems.length > 0) {
                    // Populate the modal with selected items
                    let orderPreview = $("#orderPreview");
                    orderPreview.empty(); // Clear previous content

                    selectedItems.forEach(item => {
                        orderPreview.append(`
                    <li>
                        <h5>${item.productName}</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="ms-2" style="font-size:14px; line-height:5px;">
                                <p>Qt: ${item.quantity}</p>
                                <p>Price: &#8369; ${item.unitCost.toLocaleString('en-US')}</p>
                                <p>Total: &#8369; ${item.totalCost.toLocaleString('en-US')}</p>
                            </div>
                            <img src="${item.image}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                        </div>
                    </li>
                `);
                    });

                    // Show total cost in the modal
                    $("#totalCost").text('₱'+totalCost.toLocaleString('en-US'));

                    // Set the form fields
                    $("#cartIds").val(selectedItems.map(item => item.cartId).join(", "));
                    $("#productDetails").val(selectedItems.map(item => item.productDetails).join(", "));
                    $("#products").val(selectedItems.map(item => item.productName).join(", "));
                    $("#quantities").val(selectedItems.map(item => item.quantity).join(", "));
                    $("#images").val(selectedItems.map(item => item.image).join(", "));
                    $("#totalCostField").val(totalCost.toFixed(2));

                    // Set width, length, height fields as comma-separated string
                    $("#displayWidth").val(widths.join(", "));
                    $("#displayLength").val(lengths.join(", "));
                    $("#displayHeight").val(heights.join(", "));

                    // Fetch user data and fill form fields
                    $("#fullNameField").val($("#userName").text());
                    $("#addressField").val($("#userAddress").text());
                    $("#cpNumField").val($("#userPhone").text());

                    // Show the modal
                    $('#checkoutModal').modal('show');
                } else {
                    alert("Please select at least one item to proceed.");
                }
            });

            // Add form submission validation for image file type and presence
            $("#checkoutForm").submit(function (e) {
                var fileInput = $("#qrImage");
                var filePath = fileInput.val();
                if (!filePath) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'No Image Selected',
                        text: 'Please upload an image before submitting.',
                    });
                    return false;
                }
                var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
                if (!allowedExtensions.exec(filePath)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File Type',
                        text: 'Only JPG and PNG files are allowed.',
                    });
                    fileInput.val('');
                    return false;
                }
            });
        });



        function toggleQRCode(event) {
            var parentDiv = event.target.closest('.modal-body');

            var qrContainer = parentDiv.querySelector('.qr-container');

            if (qrContainer.style.display === "none" || qrContainer.style.display === "") {
                qrContainer.style.display = "block";
            } else {
                qrContainer.style.display = "none";
            }
        }


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