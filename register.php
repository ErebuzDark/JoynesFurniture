<?php
session_start();
include("database.php");


if (isset($_POST['submit'])) {
  $fullName = $_POST["fullName"];
  $email = $_POST["email"];
  $address = $_POST["address"];
  $cpNum = $_POST["phone"];
  $password = $_POST["password"];
  $confirmPassword = $_POST["confirmPassword"];
  $recaptcha = $_POST['g-recaptcha-response'];

  if (strlen($recaptcha) >= 10) {
    if (!empty($fullName) && !empty($address) && !empty($email) && !empty($cpNum) && !empty($password) && !empty($confirmPassword)) {

      $sqlnum = "SELECT * FROM usertbl WHERE email = '$email'";
      $resultnum = mysqli_query($conn, $sqlnum);
      if (mysqli_num_rows($resultnum) > 0) {
        header("location: signup-modal.php?error=Email is Already Exist");
        exit();
      } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usertbl (fullName, address, email, cpNum, password) values('$fullName', '$address', '$email', '$cpNum', '$hash')";


        if (mysqli_query($conn, $sql)) {
          header("Location: index.php?modal=loginModal");
          exit;
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
      }
    } else {
      header("location: index.php?error=Please Enter Valid Information!");
      exit();
    }
  } else {
    echo "<script>window.location.href='./index.php?error=Invalid Captcha!'</script>";
  }


}

?>