<?php
session_start();
include("database.php");

if (isset($_POST['submit'])) {
  $fullName = trim($_POST["fullName"]);
  $email = trim($_POST["email"]);
  $address = trim($_POST["address"]);
  $cpNum = trim($_POST["phone"]);
  $password = $_POST["password"];
  $confirmPassword = $_POST["confirmPassword"];
  $recaptcha = $_POST['g-recaptcha-response'];

  if (strlen($recaptcha) >= 10) {
    if (!empty($fullName) && !empty($address) && !empty($email) && !empty($cpNum) && !empty($password) && !empty($confirmPassword)) {

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signup-modal.php?error=Invalid Email Format");
        exit();
      }

      if ($password !== $confirmPassword) {
        header("Location: signup-modal.php?error=Passwords do not match");
        exit();
      }

      // Prepared statement to prevent SQL injection
      $stmt = $conn->prepare("SELECT * FROM usertbl WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        header("Location: signup-modal.php?error=Email already exists");
        exit();
      } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $insert = $conn->prepare("INSERT INTO usertbl (fullName, address, email, cpNum, password) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("sssss", $fullName, $address, $email, $cpNum, $hash);

        if ($insert->execute()) {
          $_SESSION['userID'] = $conn->insert_id;
          $_SESSION['fullName'] = $fullName;

          header("Location: index.php?modal=loginModal");
          exit();
        } else {
          echo "Database Error: " . $conn->error;
        }
      }

      $stmt->close();
      $insert->close();
      $conn->close();
    } else {
      header("Location: index.php?error=Please fill in all required fields.");
      exit();
    }
  } else {
    header("Location: index.php?error=Invalid Captcha!");
    exit();
  }
}


?>