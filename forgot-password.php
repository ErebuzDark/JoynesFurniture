<?php
$msg = "hide";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Forgot Password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style type="text/css">
        .hide {
            visibility: hidden;
        }
    </style>

</head>

<body>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block"><img src="./img/chairss.jpg" width="100%"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form class="user" action="" method="POST">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <center><input type="submit" value="Enter" name="submit"
                                                class="submit btn btn-primary btn-block"></center>
                                    </form>

                                    <?php 
                                    if (isset($_POST["submit"])) {

                                        session_start();
                                    
                                        $email = $_POST['email'];
                                    
                                        //preparing for connections
                                        $server = "localhost";
                                        $username = "root";
                                        $password = "";
                                        $dbname = "joynes_db";
                                    
                                        //connection
                                        $conn = mysqli_connect($server, $username, $password, $dbname);
                                    
                                        $sql = "SELECT * FROM usertbl WHERE email='$email'";
                                    
                                        $result = mysqli_query($conn, $sql);
                                    
                                        if (mysqli_num_rows($result) === 1) {
                                            $row = mysqli_fetch_assoc($result);
                                            //Check the row of the email and password and identify if it right
                                            if ($row['email'] === $email) {
                                                $_SESSION['reset'] = $email;
                                    
                                                $mail = new PHPMailer(true);
                                    
                                                $mail->isSMTP();
                                                $mail->Host = 'smtp.gmail.com';
                                                $mail->SMTPAuth = true;
                                                $mail->Username = 'aniamaesantos0@gmail.com';
                                                $mail->Password = 'eskmnqzpoblrpruw';
                                                $mail->SMTPSecure = 'ssl';
                                                $mail->Port = 465;
                                    
                                                $mail->setFrom('aniamaesantos0@gmail.com');
                                    
                                                $mail->addAddress($_POST["email"]);
                                    
                                                $mail->isHTML(true);
                                    
                                                $mail->Subject = 'Reset Password';
                                                $mail->Body = '<div style="font-family: Arial, sans-serif; color: #333;">
                                                        <p><b>Hello!</b></p>
                                                        <p>You are receiving this email because we received a password reset request for your account.</p>
                                                        <br>
                                                        <p><a href="http://localhost/JoynesFurniture2.0/reset.php?email='.$email.'" style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Reset Password</a></p>
                                                        <br>
                                                        <p>If you did not request a password reset, no further action is required.</p>
                                                        <p>Thank you,<br>Joynes Furniture Team</p>
                                                        </div>';
                                    
                                                $mail->send();
                                    
                                                echo "<script>Swal.fire({
                                                title:'Email Link Send',
                                                text:'The reset password email link has been send successfully',
                                                icon:'success'
                                                }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href='./forgot-password.php';
                                                }
                                                })</script>";
                                            }
                                        } else {
                                            //Pop up when password or email are wrong
                                            echo "<script>Swal.fire({
                                            title:'Email Not Registered',
                                            text:'Your email is not registered please try again',
                                            icon:'error'
                                            }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href='./forgot-password.php';
                                            }
                                            })</script>";
                                        }
                                    
                                    }
                                    ?>

                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="sample.php">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="index.php">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <h1 class="<?php echo $msg; ?>">There's a link has been send please check your email!</h1>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>