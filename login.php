<?php
session_start();
include("database.php");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    function validate($data)
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $email = validate($_POST['email']);
    $pass = validate($_POST['password']);

    if (empty($email)) {
        echo "<script>window.location.href='./index.php?error=emailRequired'</script>";
    }
    if (empty($pass)) {
        echo "<script>window.location.href='./index.php?error=passwordRequired'</script>";
    }
    if ($email == "Admin" && $pass == "pass") {
        header("Location: admin.php");
        exit();
    }

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM usertbl WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Verify the password
        if (password_verify($pass, $row['password'])) {
            // Password is correct; set session variables
            $_SESSION["loggedIn"] = true;
            $_SESSION['fullName'] = $row['fullName'];
            $_SESSION['address'] = $row['address'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['cpNum'] = $row['cpNum'];
            $_SESSION['userID'] = $row['ID'];
            header("Location: shop.php");
            exit();
        } else {
            // Incorrect password
            echo "<script>window.location.href='./index.php?error=invalidPassword'</script>";
        }
    } else {
        // No user found
        echo "<script>window.location.href='./index.php?error=invalidEmail';</script>";
    }
}
?>