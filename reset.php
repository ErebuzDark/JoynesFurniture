<?php include('./database.php');?>

<?php 
if (isset($_GET['email'])) {
    $email = $_GET['email'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block"><img src="./img/chairss.jpg" width="100%"></div>

                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Reset Your Password</h1>
                                        <p class="mb-4">Enter your new password below.</p>
                                    </div>

                                    <form class="user" action="" method="POST">
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" placeholder="Enter New Password">
                                        </div>

                                        <div class="form-group">
                                            <input type="password" name="confirmPassword" class="form-control form-control-user" placeholder="Confirm Password">
                                        </div>

                                        <center><input type="submit" value="Reset Password" name="resetSubmit" class="btn btn-primary btn-block"></center>
                                    </form>

                                    <?php 
                                    if (isset($_POST['resetSubmit'])) {
                                        $password = $_POST['password'];
                                        $confirmPassword = $_POST['confirmPassword'];

                                        if ($password === $confirmPassword) {
                                            $hashPass = password_hash($password, PASSWORD_DEFAULT);

                                            $resetSql = "UPDATE usertbl SET password = '$hashPass' WHERE email = '$email'";

                                            if (mysqli_query($conn, $resetSql)) {
                                                echo "<script>Swal.fire({
                                                title:'Password Updated',
                                                text:'Your password has been updated successfully',
                                                icon:'success'
                                                }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href='./index.php';
                                                }
                                                })</script>";
                                            }
                                        }

                                        else {
                                            echo "<script>Swal.fire({
                                            title:'Password Not Match',
                                            text:'Your password is not match please try again!',
                                            icon:'error'
                                            }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href='./reset.php?email=$email';
                                            }
                                            })</script>";
                                        }
                                    }
                                    ?>

                                    <hr>

                                    <div class="text-center">
                                        <a class="small" href="index.php">Back to Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>