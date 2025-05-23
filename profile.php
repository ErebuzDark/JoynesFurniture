<?php

include("database.php");
include("functions.php");

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Require PHPMailer library files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$i = 0;

$sql5 = "SELECT COUNT(*) FROM addcart WHERE userID = '$userID'";
$result5 = mysqli_query($conn, $sql5);
$row5 = mysqli_fetch_assoc($result5);
$i = $row5['COUNT(*)'];

$sql = "SELECT image, fullName, address, cpNum, email FROM usertbl WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->bind_result($image, $fullName, $address, $cpNum, $email);
$stmt->fetch();
$stmt->close();

if ($image == NULL || $image == '') {
    $displayContent = '<i class="bi bi-person-circle" style="font-size: 190px;"></i>';
} else {
    $displayContent = '<img class="img-fluid rounded-circle" src="' . $image . '" alt="profile" style="width: 190px; height: 190px; object-fit: cover;"/>';
}

$defaultImage = "https://img.icons8.com/sf-black/64/737373/add-image.png";
$userImage = ($image) ? $image : $defaultImage;

$userSql = "SELECT * FROM usertbl WHERE ID = '$userID'";
$userResult = mysqli_query($conn, $userSql);
$userRow = mysqli_fetch_assoc($userResult);
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

  <!-- html2canvas -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

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

        .nav-link:hover {
            color: #ffc107 !important;
        }

        .nav-link:hover .no {
            color: #343a40 !important;
        }

        .nav-link.active {
            font-weight: bold;
            color: #fd7e14 !important;
        }

        .nav-link.active.pur {
            font-weight: bold;
            background-color: #fd7e14 !important;
            color: black !important;
            border-radius: 5px;
        }

        .form-control {
            border-radius: 0.25rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .col-form-label {
            font-weight: bold;
        }
          .invoice {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            width: 100%;
            min-height: 110mm;
            background: #fff;
            border: 1px solid #ccc;
            padding: 10mm;
            margin-bottom: 1rem;
            white-space: pre-line;
        }
        .invoice h3 {
            line-height: 0%;
            font-family: 'Courier New', Courier, monospace;
        }

        .invoice h4, h5 {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
            line-height: 0%;
            font-family: 'Courier New', Courier, monospace;
        }

        .invoice p {
            margin: 0 0 5px;
            line-height: 0%;
        }

        .invoice hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 10px 0;
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
                <a href="shop.php" class="navbar-brand"><img class="logo" src="./img/logo1.png" alt="Bootstrap" style="width: 200px"></a>

                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
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
                            <a href="profile.php" class="dropdown-item">My Profile</a>
                            <a href="logout.php" class="dropdown-item"><i class="fa fa-sign-out"></i>Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>


    <!-- Single Product Start -->
    <br>
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row py-5">
                <div class="col-3" style="line-height:20px;">
                    <div class="d-flex justify-content-center">
                        <?php echo $displayContent; ?>
                    </div>
                    <h5 class="text-center my-3"><?php echo $fullName; ?></h5>
                    <div class="my-3">
                        <ul class="nav flex-column">
                            <li class="nav-item ms-3">
                                <a class="nav-link py-0 text-dark" id="profile-tab" data-bs-toggle="tab"
                                    href="#profile">
                                    <span class="fs-5 fw-bold d-block my-2 no" style="margin-left:-35px;">
                                        <span><i class="bi bi-person"></i></span> My Account
                                    </span>
                                    <span class="d-block">● Profile</span>
                                </a>
                            </li>
                            <li class="nav-item ms-3">
                                <a class="nav-link py-0 text-dark" id="change-password-tab" data-bs-toggle="tab"
                                    href="#change-password">
                                    ● Change Password
                                </a>
                            </li>
                            <li class="nav-item mt-3" style="margin-left:-15px;">
                                <a class="nav-link text-dark active fw-bold py-0 fs-5" id="purchase-tab"
                                    data-bs-toggle="tab" href="#purchase">
                                    <span><i class="bi bi-clipboard"></i></span> My Purchase
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content">
                        <div class="tab-pane fade" id="profile">
                            <h4 class="text-center bg-light p-2">My Profile</h4>
                            <form action="profileUpdate.php" method="POST" enctype="multipart/form-data"
                                id="updateProfileForm">
                                <div class="row mx-2">
                                    <div class="col-4">
                                        <div class="d-flex justify-content-center">
                                            <div class="border rounded bg-light">
                                                <div class="container drop px-0">
                                                    <div class="drop-area text-center">
                                                        <!-- Image preview will span the entire width of the column -->
                                                        <img id="image-preview" class="img-fluid rounded"
                                                            src="<?php echo $userImage; ?>" alt="add-image" />
                                                        <input type="file" id="input-file" name="image" hidden required>

                                                        <!-- Text elements that will be hidden if an image is previewed -->
                                                        <h5 id="image-text" style="font-size:16px;">Drag and drop or
                                                            click here to select image</h5>
                                                        <p id="image-size-text" style="font-size:12px;">Image size must
                                                            be less than <span>2MB</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center py-2">
                                            <button type="button" class="btn btn-primary" id="updateImageBtn">Update
                                                Image</button>
                                        </div>
                                    </div>
                                    <div class="col-8 bg-light">
                                        <div class="py-5">
                                            <div class=" py-1 d-flex justify-content-center align-items-center">
                                                <label for="fullName" class=" col-2">Full Name: </label>
                                                <input type="text" id="fullName" name="fullName"
                                                    class="form-control form-control-sm w-50"
                                                    value="<?php echo $fullName; ?>">
                                            </div>
                                            <div class=" py-1 d-flex justify-content-center align-items-center">
                                                <label for="email" class=" col-2">Email: </label>
                                                <input type="email" id="email" name="email"
                                                    class="form-control form-control-sm w-50"
                                                    value="<?php echo $email; ?>">
                                            </div>
                                            <div class=" py-1 d-flex justify-content-center align-items-center">
                                                <label for="cpNum" class=" col-2">Phone No.: </label>
                                                <input type="text" id="cpNum" name="cpNum"
                                                    class="form-control form-control-sm w-50"
                                                    value="<?php echo $cpNum; ?>">
                                            </div>
                                            <div class=" py-1 d-flex justify-content-center align-items-center">
                                                <label for="address" class=" col-2">Address: </label>
                                                <input type="text" id="address" name="address"
                                                    class="form-control form-control-sm w-50"
                                                    value="<?php echo $address; ?>">
                                            </div>
                                            <input type="hidden" name="userID" value="<?php echo $userID; ?>">
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-success" id="updateDetailsBtn">Update
                                                Details</button>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>

                        <div class="tab-pane fade" id="change-password">
                            <h4 class="text-center bg-light p-2">Change Password</h4>

                            <form action="" method="POST">
                                <div class="row mx-2">
                                    <div class="col-12 bg-light py-5">
                                        <div class="mb-3 row justify-content-center">
                                            <label for="newPassword" class="col-2 col-form-label">New Password:</label>

                                            <div class="col-6">
                                                <input type="password" id="newPassword" name="newPassword"
                                                    class="form-control" required>
                                            </div>

                                        </div>

                                        <div class="mb-3 row justify-content-center">
                                            <label for="confirmPassword" class="col-2 col-form-label">Confirm
                                                Password:</label>

                                            <div class="col-6">
                                                <input type="password" id="confirmPassword" name="confirmPassword"
                                                    class="form-control" required>
                                            </div>

                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <button type="submit" name="changePassSubmit" class="btn btn-primary">Change
                                                Password</button>
                                        </div>

                                    </div>
                                </div>
                            </form>

                            <?php
                            if (isset($_POST['changePassSubmit'])) {
                                $email = $userRow['email'];
                                $pass = $_POST['newPassword'];
                                $conPass = $_POST['confirmPassword'];

                                if ($pass === $conPass) {
                                    $hashPass = password_hash($pass, PASSWORD_DEFAULT);
                                    $rand = random_int(111111, 999999);

                                    $mail = new PHPMailer(true);

                                    try {
                                        // Server settings
                                        $mail->isSMTP();
                                        $mail->Host = 'smtp.gmail.com';
                                        $mail->SMTPAuth = true;
                                        $mail->Username = 'aniamaesantos0@gmail.com'; // Replace with your email
                                        $mail->Password = 'eskmnqzpoblrpruw'; // Replace with your email password or app password
                                        $mail->SMTPSecure = 'ssl';
                                        $mail->Port = 465;

                                        // Sender and recipient settings
                                        $mail->setFrom('aniamaesantos0@gmail.com', 'Joyness Furniture'); // Replace with your email and name
                                        $mail->addAddress($email);

                                        // Email content settings
                                        $mail->isHTML(true);
                                        $mail->Subject = 'Reset Password';
                                        $mail->Body = '<div style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
                                        <p><b>Hello!</b></p>
                                        <p>You are receiving this email because we received a password reset request for your account.</p>
                                        <br>
                                        <div style="text-align: center;">
                                            <p style="
                                                background-color: #512da8;
                                                color: #fff;
                                                padding: 12px 40px;
                                                font-size: 14px;
                                                border-radius: 8px;
                                                text-decoration: none;
                                                font-weight: bold;
                                                letter-spacing: 1px;
                                                display: inline-block;
                                                margin: 15px 0;">
                                                ' . $rand . '
                                            </p>
                                        </div>
                                        <br>
                                        <p>If you did not request a password reset, no further action is required.</p>
                                        <hr style="border: none; border-top: 1px solid #ddd;">
                                        <footer style="text-align: center; margin-top: 20px;">
                                            <p style="font-size: 12px; color: #999;">&copy; 2025 Joyness Furniture. All rights reserved.</p>
                                        </footer>
                                        </div>';

                                        // Send the email
                                        $mail->send();

                                        // Display success message
                                        echo "<script>Swal.fire({
                                        title:'OTP Send',
                                        text:'The otp has been send to your email',
                                        icon:'success'
                                        }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href='profileChangePass.php?pass=$hashPass&otp=$rand&userID=$userID';
                                        }
                                        })</script>";
                                    } catch (Exception $e) {
                                        // Display error message if email fails to send
                                        echo "<script>Swal.fire({
                                        title:'Error!', 
                                        text:'There was an error sending the email. Please try again later.', 
                                        icon:'error'
                                        });</script>";
                                    }
                                } else {
                                    echo "<script>Swal.fire({
                                    title:'Password Not Match',
                                    text:'Your password is not match please try again',
                                    icon:'error'
                                    }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href='./profile.php';
                                    }
                                    })</script>";
                                }
                            }
                            ?>

                        </div>

                        <div class="tab-pane fade show active" id="purchase">
                            <h4 class="text-center p-2 bg-light">My Purchases</h4>
                            <ul class="nav d-flex justify-content-center bg-light">
                                <li class="nav-item py-3">
                                    <a class="nav-link py-0 pur text-dark active" id="overview-tab" data-bs-toggle="tab"
                                        href="#overview">Overview</a>
                                </li>
                                <li class="nav-item py-3">
                                    <a class="nav-link py-0 pur text-dark" id="on-queue-tab" data-bs-toggle="tab"
                                        href="#on-queue">Pending Approval</a>
                                </li>
                                <li class="nav-item py-3">
                                    <a class="nav-link py-0 pur text-dark" id="on-progress-tab" data-bs-toggle="tab"
                                        href="#on-progress">On Progress</a>
                                </li>
                                <li class="nav-item py-3">
                                    <a class="nav-link py-0 pur text-dark" id="completed-tab" data-bs-toggle="tab"
                                        href="#completed">Completed</a>
                                </li>
                            </ul>
                            <div class="tab-content m-3 mt-0 p-3">
                                <div class="tab-pane fade show active" id="overview">
                                    <?php
                                    $sql = "
(SELECT 'checkout' AS source, prodName, image, proofPay, cost AS totalCost, orderID, quantity, date, status, balance FROM checkout WHERE userID = '$userID')
UNION
(SELECT 'checkoutcustom' AS source, pName AS prodName, image, proofPay, totalCost, orderID, quantity, date, status, balance FROM checkoutcustom WHERE userID = '$userID')
ORDER BY date DESC
                                            ";

                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        echo '<table class="table table-borderless">';


                                        while ($row = $result->fetch_assoc()) {
                                            $prodNames = explode(',', $row['prodName']);
                                            $images = explode(',', $row['image']);
                                            $quantities = explode(',', $row['quantity']);
                                            $maxItems = max(count($prodNames), count($images), count($quantities));
                                            $balance = $row['balance'];

                                            if ($row['status'] == 'Rejected') {
                                                $reject = "Invalid Payment";
                                            } else {
                                                $reject = "";
                                            }

                                            echo '<tr class="bg-light" style="border-top: solid white 20px;">';
                                            echo '<td style="width:40%;">';
                                            for ($i = 0; $i < $maxItems; $i++) {
                                                $image = isset($images[$i]) ? trim($images[$i]) : trim($images[0]);
                                                echo '<img class="image-fluid border rounded m-2" height="80px" width="80px" src="' . htmlspecialchars($image) . '" alt="Product Image">';
                                            }
                                            echo '</td>';
                                            echo '<td class="align-middle" style="width:30%;">';
                                            for ($i = 0; $i < $maxItems; $i++) {
                                                $prodName = isset($prodNames[$i]) ? trim($prodNames[$i]) : trim($prodNames[0]);
                                                $quantity = isset($quantities[$i]) ? trim($quantities[$i]) : 1;
                                                echo '<h6>' . htmlspecialchars($prodName) . ' (Qty: ' . htmlspecialchars($quantity) . ')</h6>';
                                            }
                                            echo '</td>';
                                            echo '<td class="fw-bold align-middle" style="line-height:10px;width:30%;">';
                                            echo '<p class="text-dark my-2 ">' . htmlspecialchars($row['status']) . ' <br><br><span style="font-size:12px;">' . $reject . '</span></p><br>';
                                            echo '<p class="text-dark my-2">Balance: ₱' . number_format($balance, 2, '.', ',') . '</p>';
                                            echo '<p class="text-dark my-2">Total: ₱' . number_format($row['totalCost'], 2, '.', ',') . '</p>';
                                            if ($balance > 0) {
                                                echo '<button class="btn btn-success pay-balance-btn" 
                                                    style="font-size:13px; color:white;" 
                                                    data-balance="' . htmlspecialchars($balance) . '" 
                                                    data-source="' . htmlspecialchars($row['source']) . '" 
                                                    data-prodname="' . htmlspecialchars($row['prodName']) . '" 
                                                    data-orderid="' . htmlspecialchars($row['orderID']) . '" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#balancePaymentModal">
                                                    Upload Another Payment
                                                </button>';
                                            }

                                            echo '<button 
                                                class="btn btn-primary see-payment-images-btn mt-2" 
                                                style="font-size:13px; color:white;" 
                                                data-orderid="' . htmlspecialchars($row['orderID']) . '" 
                                                data-source="' . htmlspecialchars($row['source']) . '">
                                                See All Payment Images
                                            </button>';
                                            echo '<button 
                                                class="btn btn-primary mt-2 view-invoice-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#invoiceModal" 
                                                style="font-size:13px; color:white;" 
                                                data-orderid="' . htmlspecialchars($row['orderID']) . '" 
                                                data-source="' . htmlspecialchars($row['source']) . '">
                                                View All Invoice
                                            </button>';


                                            // echo '<button class="btn btn-primary see-payment-image-btn" style="font-size:13px; color:white;" data-image="' . htmlspecialchars($row['proofPay']) . '">See Payment Image</button>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }

                                        echo '</table>';
                                    } else {
                                        echo "No in-process order.";
                                    }
                                    ?>
                                </div>

                                <div class="tab-pane fade" id="on-queue">
                                    <?php
                                    $sql = "
(SELECT 'checkout' AS source, orderID, status, prodName, image, cost AS totalCost, quantity, date FROM checkout WHERE userID = '$userID' AND status = 'Pending Approval')
UNION
(SELECT 'checkoutcustom' AS source, orderID, status, pName AS prodName, image, totalCost, quantity, date FROM checkoutcustom WHERE userID = '$userID' AND status = 'Pending Approval')
ORDER BY date DESC
                                            ";

                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        echo '<table class="table table-borderless">';


                                        while ($row = $result->fetch_assoc()) {
                                            $prodNames = explode(',', $row['prodName']);
                                            $images = explode(',', $row['image']);
                                            $quantities = explode(',', $row['quantity']);
                                            $maxItems = max(count($prodNames), count($images), count($quantities));

                                            echo '<tr class="bg-light" style="border-top: solid white 20px;">';
                                            echo '<td style="width:50%;">';
                                            for ($i = 0; $i < $maxItems; $i++) {
                                                $image = isset($images[$i]) ? trim($images[$i]) : trim($images[0]);
                                                echo '<img class="image-fluid border rounded m-2" height="80px" width="80px" src="' . htmlspecialchars($image) . '" alt="Product Image">';
                                            }
                                            echo '</td>';
                                            echo '<td class="align-middle" style="width:30%;">';
                                            for ($i = 0; $i < $maxItems; $i++) {
                                                $prodName = isset($prodNames[$i]) ? trim($prodNames[$i]) : trim($prodNames[0]);
                                                $quantity = isset($quantities[$i]) ? trim($quantities[$i]) : 1;
                                                echo '<h6>' . htmlspecialchars($prodName) . ' (Qty: ' . htmlspecialchars($quantity) . ')</h6>';
                                            }
                                            echo '</td>';
                                            echo '<td class="fw-bold align-middle" style="width:20%;">';
                                            echo '<button name="cancel"  class="btn btn-sm btn-danger text-white btn-outline-dark rounded-0 py-0" 
                                                        data-status="Cancelled"
                                                        data-orderid="' . $row['orderID'] . '" 
                                                        data-source="' . $row['source'] . '">Cancel Order</button>';
                                            echo '<p class="text-dark my-2">Total: ₱' . htmlspecialchars(number_format($row['totalCost'], 2, '.', ',')) . '</p>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }

                                        echo '</table>';
                                    } else {
                                        echo "No in-process order.";
                                    }
                                    ?>
                                </div>
                                <div class="tab-pane fade" id="on-progress">
                                    <?php
                                    $sql = "
(SELECT 'checkout' AS source, prodName, image, cost AS totalCost, quantity, date FROM checkout WHERE userID = '$userID' AND status = 'In Progress')
UNION
(SELECT 'checkoutcustom' AS source, pName AS prodName, image, totalCost, quantity, date FROM checkoutcustom WHERE userID = '$userID' AND status = 'In Progress')
ORDER BY date DESC
                                            ";

                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        echo '<table class="table table-borderless">';


                                        while ($row = $result->fetch_assoc()) {
                                            $prodNames = explode(',', $row['prodName']);
                                            $images = explode(',', $row['image']);
                                            $quantities = explode(',', $row['quantity']);
                                            $maxItems = max(count($prodNames), count($images), count($quantities));

                                            echo '<tr class="bg-light" style="border-top: solid white 20px;">';
                                            echo '<td style="width:50%;">';
                                            for ($i = 0; $i < $maxItems; $i++) {
                                                $image = isset($images[$i]) ? trim($images[$i]) : trim($images[0]);
                                                echo '<img class="image-fluid border rounded m-2" height="80px" width="80px" src="' . htmlspecialchars($image) . '" alt="Product Image">';
                                            }
                                            echo '</td>';
                                            echo '<td class="align-middle" style="width:30%;">';
                                            for ($i = 0; $i < $maxItems; $i++) {
                                                $prodName = isset($prodNames[$i]) ? trim($prodNames[$i]) : trim($prodNames[0]);
                                                $quantity = isset($quantities[$i]) ? trim($quantities[$i]) : 1;
                                                echo '<h6>' . htmlspecialchars($prodName) . ' (Qty: ' . htmlspecialchars($quantity) . ')</h6>';
                                            }
                                            echo '</td>';
                                            echo '<td class="fw-bold align-middle" style="line-height:10px;width:20%;">';
                                            echo '<p>On Progress</p>';
                                            echo '<p class="text-dark my-2">Total: ₱' . htmlspecialchars(number_format($row['totalCost'], 2, '.', ',')) . '</p>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }

                                        echo '</table>';
                                    } else {
                                        echo "No in-process order.";
                                    }
                                    ?>
                                </div>
                                <div class="tab-pane fade" id="completed">
                                    <?php
                                    $sql = "
(SELECT 'checkout' AS source, prodName, orderID, image, cost AS totalCost, quantity, date, status FROM checkout WHERE userID = '$userID' AND (status = 'Completed' OR status = 'Delivered'))
UNION
(SELECT 'checkoutcustom' AS source, pName AS prodName, orderID, image, totalCost, quantity, date, status FROM checkoutcustom WHERE userID = '$userID' AND (status = 'Completed' OR status = 'Delivered'))
ORDER BY date DESC
                                            ";

                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        echo '<table class="table table-borderless">';


                                        while ($row = $result->fetch_assoc()) {
                                            $prodNames = explode(',', $row['prodName']);
                                            $images = explode(',', $row['image']);
                                            $quantities = explode(',', $row['quantity']);
                                            $maxItems = max(count($prodNames), count($images), count($quantities));

                                            echo '<tr class="bg-light" style="border-top: solid white 20px;">';
                                            echo '<td style="width:50%;">';
                                            for ($i = 0; $i < $maxItems; $i++) {
                                                $image = isset($images[$i]) ? trim($images[$i]) : trim($images[0]);
                                                echo '<img class="image-fluid border rounded m-2" height="80px" width="80px" src="' . htmlspecialchars($image) . '" alt="Product Image">';
                                            }
                                            echo '</td>';
                                            echo '<td class="align-middle" style="width:30%;">';
                                            for ($i = 0; $i < $maxItems; $i++) {
                                                $prodName = isset($prodNames[$i]) ? trim($prodNames[$i]) : trim($prodNames[0]);
                                                $quantity = isset($quantities[$i]) ? trim($quantities[$i]) : 1;
                                                echo '<h6>' . htmlspecialchars($prodName) . ' (Qty: ' . htmlspecialchars($quantity) . ')</h6>';
                                            }
                                            echo '</td>';
                                            echo '<td class="fw-bold align-middle" style="line-height:10px;width:20%;">';
                                            if ($row['status'] == 'Delivered') {
                                                echo '<p class="my-2">Completed</p>';
                                            } else {
                                                echo '<button name="complete" class="btn btn-sm text-white btn-outline-dark rounded-0 py-0" 
                                                        style="background-color:#e47011;" 
                                                        data-status="Delivered"
                                                        data-orderid="' . $row['orderID'] . '" 
                                                        data-source="' . $row['source'] . '">Order Complete</button>';
                                            }
                                            echo '<p class="text-dark my-3">Total: ₱' . htmlspecialchars(number_format((float) $row['totalCost'], 2, '.', ',')) . '</p>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }

                                        echo '</table>';
                                    } else {
                                        echo "No in-process order.";
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
        $(document).ready(function() {
            $("button[name='complete']").click(function() {
                var orderID = $(this).data("orderid");
                var source = $(this).data("source");
                var status = $(this).data("status");

                var button = $(this);

                $.ajax({
                    url: 'profileUpdateOrder.php',
                    type: 'POST',
                    data: {
                        orderID: orderID,
                        source: source,
                        status: status
                    },
                    success: function(response) {
                        if (response === 'success') {
                            alert("Order status updated to Delivered!");
                            button.text('Delivered').prop('disabled', true);
                        } else {
                            alert("Error updating order status.");
                        }
                    },
                    error: function() {
                        alert("Error with AJAX request.");
                    }
                });
            });

            $("button[name='cancel']").click(function() {
                var orderID = $(this).data("orderid");
                var source = $(this).data("source");
                var status = $(this).data("status");

                var button = $(this);

                $.ajax({
                    url: 'profileUpdateOrder.php',
                    type: 'POST',
                    data: {
                        orderID: orderID,
                        source: source,
                        status: status
                    },
                    success: function(response) {
                        if (response === 'success') {
                            alert("Order cancelled!");
                            button.text('Cancelled').prop('disabled', true);
                            location.reload();
                        } else {
                            alert("Error updating order status.");
                        }
                    },
                    error: function() {
                        alert("Error with AJAX request.");
                    }
                });
            });
        });

        const dropArea = document.querySelector('.drop-area');
        const inputFile = document.getElementById('input-file');
        const imageText = document.getElementById('image-text');
        const imageSizeText = document.getElementById('image-size-text');

        dropArea.addEventListener('click', function() {
            inputFile.click();
        });

        inputFile.addEventListener('change', function() {
            const file = this.files[0];

            if (file.type.startsWith('image/')) {
                if (file.size < 2000000) {
                    updatePreview(file);
                    hideText();
                } else {
                    alert('Image size must be less than 2MB');
                }
            } else {
                alert('Must be an image');
            }
        });

        dropArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderStyle = 'solid';
            const h3 = this.querySelector('h3');
            h3.textContent = 'Release here to upload image';
        });

        dropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            inputFile.files = e.dataTransfer.files;
            const file = e.dataTransfer.files[0];

            if (file.type.startsWith('image/')) {
                if (file.size < 2000000) {
                    updatePreview(file);
                    hideText();
                } else {
                    alert('Image size must be less than 2MB');
                }
            } else {
                alert('Must be an image');
            }
        });

        const command = ['dragleave', 'dragend'];
        command.forEach(item => {
            dropArea.addEventListener(item, function() {
                this.style.borderStyle = 'dashed';
                const h3 = this.querySelector('h3');
                h3.textContent = 'Drag and drop or click here to select image';
            });
        });

        function updatePreview(file) {
            const reader = new FileReader();
            reader.onload = function() {
                const url = reader.result;
                const preview = document.getElementById('image-preview');
                preview.src = url;
            };
            reader.readAsDataURL(file);
        }

        function hideText() {
            imageText.style.display = 'none';
            imageSizeText.style.display = 'none';
        }

        function showText() {
            imageText.style.display = 'block';
            imageSizeText.style.display = 'block';
        }


        document.getElementById('updateImageBtn').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('updateProfileForm'));
            formData.append('updateType', 'image');

            fetch('profileUpdate.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Image updated successfully');
                        location.reload();
                    } else {
                        alert('Failed to update image');
                    }
                })
                .catch(error => {
                    alert('Error: ' + error);
                });
        });

        document.getElementById('updateDetailsBtn').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('updateProfileForm'));
            formData.append('updateType', 'details');

            fetch('profileUpdate.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Profile details updated successfully');
                        location.reload();
                    } else {
                        alert('Failed to update details');
                    }
                })
                .catch(error => {
                    alert('Error: ' + error);
                });
        });
    </script>

    <!-- Payment Image Modal -->
    <div class="modal fade" id="paymentImageModal" tabindex="-1" aria-labelledby="paymentImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 shadow" style="background-color: white;">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="paymentImageModalLabel">Payment Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <img id="paymentImageModalImg" src="" alt="Payment Image" class="img-fluid rounded" style="max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>
    <!-- new images for resibo -->
     <!-- Modal to display all receipts for an order -->
    <div class="modal fade" id="paymentImagesModal" tabindex="-1" aria-labelledby="paymentImagesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content bg-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentImagesModalLabel">Payment Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="paymentImagesContainer">
                    <!-- Images will be injected here -->
                </div>
            </div>
        </div>
    </div>


    <!-- Balance Payment Modal -->
    <div class="modal fade" id="balancePaymentModal" tabindex="-1" aria-labelledby="balancePaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title" id="balancePaymentModalLabel">Upload Payment Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="upload_balance_payment.php" enctype="multipart/form-data">
                <div class="modal-body">
                <p><strong>Remaining Balance:</strong> ₱<span id="balanceAmountDisplay"></span></p>

                <label for="paymentImage">Upload Payment Receipt</label>
                <input type="file" name="paymentImage" class="form-control" required>

                <input type="hidden" name="orderID" id="orderid">
                <input type="hidden" name="userID" value="<?php echo $userID; ?>">
                <input type="hidden" name="source" id="paymentSource">
                <input type="hidden" name="prodName" id="paymentProdName">
                <input type="hidden" name="balanceAmount" id="balanceAmountField">
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit Payment</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- modal for invoice -->
    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content bg-white">
            <div class="modal-header">
            <h5 class="modal-title" id="invoiceModalLabel">All Invoices</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="invoices-container">

            <!-- Invoices -->
            <!-- <div class="invoice" id="invoice1">
                <h3 class="text-center fw-bold">PAYMENT RECEIPT</h3>
                <h5 class="text-center">Joynes Furniture</h5>
                <h4 id="ref-number">Ref. Number: </h4>
                <hr>
                <p id="date-confirmed">Date: </p>
                <p id="order-id">Order ID: </p>
                <p id="amount-paid">Amount Paid: </p>
                <hr>
                <button class="btn btn-sm btn-outline-secondary" onclick="downloadInvoice('invoice1')">Download</button>
            </div> -->


            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS to download invoice -->
  <script>
  function downloadInvoice(invoiceId) {
    const invoice = document.getElementById(invoiceId);
    const button = invoice.querySelector('button');

    // Hide button before capture
    button.style.visibility = 'hidden';

    html2canvas(invoice, {
      scale: 2,
      useCORS: true
    }).then(canvas => {
      // Show button again
      button.style.visibility = 'visible';

      const link = document.createElement('a');
      link.download = invoiceId + ".png";
      link.href = canvas.toDataURL("image/png");
      link.click();
    }).catch(() => {
      // Ensure button is shown even if something goes wrong
      button.style.visibility = 'visible';
    });
  }
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  document.querySelectorAll('.view-invoice-btn').forEach(button => {
    button.addEventListener('click', function() {
      const orderId = this.getAttribute('data-orderid');

      fetch('fetch_invoice.php?orderID=' + encodeURIComponent(orderId))
        .then(response => response.json())
        .then(data => {
          const container = document.getElementById('invoices-container');
          container.innerHTML = ''; // Clear previous invoices

          if (data.success) {
            data.invoices.forEach((invoice, index) => {
              // Create a unique ID for each invoice for download
              const invoiceId = 'invoice' + index;

              // Create invoice HTML
              const invoiceHTML = `
                <div class="invoice mb-4 p-3 border" id="${invoiceId}">
                  <h3 class="text-center fw-bold">PAYMENT RECEIPT</h3>
                  <h5 class="text-center">Joynes Furniture</h5>
                  <h4>Ref. Number: ${invoice.reference_number}</h4>
                  <hr>
                  <p>Date: ${invoice.created_at}</p>
                  <p>Order ID: ${invoice.orderID}</p>
                  <p>Amount Paid: ${invoice.totalPaid}</p>
                  <hr>
                  <button class="btn btn-sm btn-outline-secondary" onclick="downloadInvoice('${invoiceId}')">Download</button>
                </div>
              `;
              container.insertAdjacentHTML('beforeend', invoiceHTML);
            });
          } else {
            container.innerHTML = '<p>No invoices found.</p>';
          }
        })
        .catch(error => {
          console.error("Error fetching invoice:", error);
        });
    });
  });
});

</script>




    <script>
        $(document).ready(function () {
            $('.pay-balance-btn').click(function () {
                var balance = $(this).data('balance');
                var orderid = $(this).data('orderid');
                var source = $(this).data('source');
                var prodName = $(this).data('prodname');

                $('#balanceAmountDisplay').text(balance);
                $('#balanceAmountField').val(balance);
                $('#orderid').val(orderid); // ✅ Set this!
                $('#paymentSource').val(source);
                $('#paymentProdName').val(prodName);
            });
        });
    </script>



    <!-- new script for displaying resibo -->
    <script>
    $(document).ready(function () {
        // See all payment images for an order
        $('.see-payment-images-btn').click(function () {
            var orderID = $(this).data('orderid');
            var source = $(this).data('source');

            $.ajax({
                url: 'get_payment_images.php',
                type: 'POST',
                data: {
                    orderID: orderID,
                    source: source
                },
                success: function (response) {
                    $('#paymentImagesContainer').html(response);
                    var modal = new bootstrap.Modal(document.getElementById('paymentImagesModal'));
                    modal.show();
                },
                error: function () {
                    $('#paymentImagesContainer').html('<p class="text-danger">Failed to load payment images.</p>');
                }
            });
        });
    });
</script>


    <!-- <script>
        $(document).ready(function() {
            // Existing JS code...

            // Show payment image in modal
            $('.see-payment-image-btn').click(function() {
                var imageUrl = $(this).data('image');
                $('#paymentImageModalImg').attr('src', imageUrl);
                var modal = new bootstrap.Modal(document.getElementById('paymentImageModal'));
                modal.show();
            });
        });
    </script> -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const payBtns = document.querySelectorAll('.pay-balance-btn');

            payBtns.forEach(button => {
                button.addEventListener('click', () => {
                    const balance = button.getAttribute('data-balance');
                    const source = button.getAttribute('data-source');
                    const prodName = button.getAttribute('data-prodname');

                    document.getElementById('balanceAmountDisplay').innerText = parseFloat(balance).toLocaleString();
                    document.getElementById('balanceAmountField').value = balance;
                    document.getElementById('paymentProdName').value = prodName;
                    document.getElementById('paymentSource').value = source;
                });
            });
        });
    </script>


</body>

</html>