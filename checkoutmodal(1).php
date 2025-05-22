<?php
session_start();
include("database.php");


$userid = $_GET['userid'];
$sqls = "SELECT * FROM furnituretbl WHERE fID = '$userid'";
$resu = mysqli_query($conn, $sqls);
$rows = mysqli_fetch_assoc($resu);
$number = $rows['cost'];
$formattedNumber = number_format($number, 0, '.', ',');
$cost = $formattedNumber;

$userID = $_SESSION['userID'];

$sqlu = "SELECT * FROM usertbl WHERE ID = '$userID'";
$resultu = mysqli_query($conn, $sqlu);

$msg = "hide";
$i = 0;

$sqlc = "SELECT * FROM furnituretbl WHERE fID = '$userid'";
$resus = mysqli_query($conn, $sqlc);
$rows = mysqli_fetch_assoc($resus);


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Fruitables - Vegetable Website Template</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
    rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">


  <!-- Libraries Stylesheet -->
  <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link type="image/png" sizes="16x16" rel="icon" href=".../icons8-wardrobe-ios11-16.png">
  <meta name="msapplication-square70x70logo" content=".../icons8-wardrobe-ios11-70.png">

  <!-- Customized Bootstrap Stylesheet -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Core theme CSS (includes Bootstrap)-->
  <style type="text/css"></style>

</head>

<body>
  <form action="#" method="POST">
    <div class="container  container-fluid">
      <div class="row d-flex justify-content-center h-100 align-items-center">
        <div class="col-md-10 col-lg-10 col-xl-12 px-0 rounded">
          <div class="card card-stepper" style="border-radius: 16px;">
            <div class="card-header p-4">
              <div class="d-flex justify-content-between align-items-center">
                <p style="font-size: 17px;">
                  <b>Name: </b> <?php echo $_SESSION['fullName']; ?>
                  <br>
                  <b>Address: </b> <?php echo $_SESSION['address']; ?>
                  <br>
                  <b>Contact: </b> <?php echo $_SESSION['cpNum']; ?>
                </p>
                <p class="text-muted mb-2"> Furniture ID: <span
                    class="fw-bold text-body"><?php echo $rows['fID']; ?></span><br>Place On: <span
                    class="fw-bold text-body"><?php echo $rows['date']; ?></span> </p>

              </div>
            </div>
            <div class="card-body p-3">

              <div class="d-flex flex-row md1 mb-3 pb-2 ">
                <div class="flex-fill">
                  <input type="hidden" name="" value="<?php echo $rows['fName']; ?>" />
                  <h5 class="bold"><?php echo $rows['fName']; ?></h5>
                  <p class="text-muted"> Qt: 1 item </p>
                  <h4 class="mb-3">&#8369;<?php echo $cost; ?></h4>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2 flex-fill">
                  <img class="align-self-center img-fluid" src="./up/<?php echo $rows['image']; ?>" width="100">
                </div>
                <br><br>
              </div>
            </div>

            <div class="card-footer p-4">
              <div class="d-flex justify-content-between">
                <input type="hidden" name="" value="<?php echo $cost; ?>" />
                <h3 class="d-flex textp">Total: &#8369;<?php echo $cost; ?></h3>
              </div>
              <br>
              <div class="d-flex justify-content-between">
                <h5 class="fw-normal mb-0"><button data-dismiss="modal"
                    class="btn btn-warning btn-block btn-lg">Cancel</button></h5>
                <div class="border-start h-100"></div>
                <h5 class="fw-normal mb-0"><input type="submit" name="submit" class="btn btn-warning btn-block btn-lg"
                    value="Place Order" /></h5>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </form>
</body>

</html>