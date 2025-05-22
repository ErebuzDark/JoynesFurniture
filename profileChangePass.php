<?php include('./database.php');?>

<?php 
if (isset($_GET['pass'])&&isset($_GET['otp'])&&isset($_GET['userID'])) {
    $pass = $_GET['pass'];
    $otp = $_GET['otp'];
    $userID = $_GET['userID'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* General Body Styling */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f7fa;
            font-family: Arial, sans-serif;
        }

        /* OTP Container */
        .otp-container {
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0px 8px 24px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 380px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Fade-in Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Heading */
        .otp-container h4 {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        /* Subtext */
        .otp-container p {
            font-size: 14px;
            color: #888;
            margin-bottom: 20px;
        }

        /* OTP Input Styling */
        .otp-input {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .otp-input input {
            width: 48px;
            height: 55px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            outline: none;
            transition: all 0.3s ease;
            background: #f9f9f9;
        }

        .otp-input input:focus {
            border-color: #4a90e2;
            box-shadow: 0px 4px 10px rgba(74, 144, 226, 0.2);
            background: #ffffff;
        }

        /* Verify Button */
        .btn-verify {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            background-color: #4a90e2;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .btn-verify:hover {
            background-color: #3b7ec9;
            box-shadow: 0px 5px 15px rgba(74, 144, 226, 0.3);
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <h4>Enter OTP</h4>
        <p>Please enter the 6-digit code sent to your email</p>
        <form action="" method="POST">
            <input type="hidden" name="hashPass" value="<?php echo $hashPass; ?>">
            <div class="otp-input">
                <input type="text" name="otp1" maxlength="1" required>
                <input type="text" name="otp2" maxlength="1" required>
                <input type="text" name="otp3" maxlength="1" required>
                <input type="text" name="otp4" maxlength="1" required>
                <input type="text" name="otp5" maxlength="1" required>
                <input type="text" name="otp6" maxlength="1" required>
            </div>
            <button type="submit" name="submit" class="btn btn-verify">Verify OTP</button>
        </form>

        <?php 
        if (isset($_POST['submit'])) {
            $otpCompare = $_POST['otp1'].$_POST['otp2'].$_POST['otp3'].$_POST['otp4'].$_POST['otp5'].$_POST['otp6'];

            if ($otp === $otpCompare) {
                $updatePassSql = "UPDATE usertbl SET password = '$pass' WHERE ID = '$userID'";

                if (mysqli_query($conn, $updatePassSql)) {
                    echo "<script>Swal.fire({
                    title:'Password Updated',
                    text:'Your password has been updated successfully',
                    icon:'success'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href='./profile.php';
                    }
                    })</script>";
                }
            }

            else {
                echo "<script>Swal.fire({
                title:'Wrong OTP',
                text:'The OTP you have enter is wrong please try again',
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
</body>
</html>
