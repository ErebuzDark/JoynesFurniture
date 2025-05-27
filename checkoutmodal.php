<?php
session_start();
include("database.php");

$userid = $_POST['userid'];
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

$dateToday = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Joynes Furniture</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <form id="orderForm" action="placeOrder.php" method="POST" enctype="multipart/form-data">
    <div class="container container-fluid">
      <div class="row d-flex justify-content-center h-100 align-items-center">
        <div class="col-md-10 col-lg-10 col-xl-12 px-0 rounded">
          <div class="card card-stepper" style="border-radius: 16px;">

            <div class="card-header p-4">
              <div class="d-flex justify-content-between align-items-center">
                <p style="font-size: 17px;">
                  <b>Name: </b> <?php echo $_SESSION['fullName']; ?><br>
                  <b>Address: </b> <?php echo $_SESSION['address']; ?><br>
                  <b>Contact: </b> <?php echo $_SESSION['cpNum']; ?>
                </p>

                <p class="text-muted mb-2">
                  Order ID: <span class="fw-bold text-body"><?php echo $rows['fID']; ?></span><br>
                  Place On: <span class="fw-bold text-body"><?php echo $dateToday; ?></span>
                </p>
              </div>
            </div>

            <div class="card-body p-3">
              <div class="d-flex flex-row md1 mb-3 pb-2">
                <div class="flex-fill">
                  <h5 class="bold"><?php echo $rows['fName']; ?></h5>
                  <p class="text-muted">Qt: 1 item</p>
                  <h4 class="mb-3">&#8369;<?php echo $cost; ?></h4>
                </div>

                <div class="col-md-2 col-lg-2 col-xl-2 flex-fill">
                  <img class="align-self-center img-fluid" src="./up/<?php echo $rows['image']; ?>" width="100" alt="Product Image">
                </div>
              </div>

              <h6 class="mt-5">Payment Method:</h6>
              <p class="fw-bold d-flex align-items-center" style="color:#0d6efd;">
                <img src="img/gcash.png" width="25px" height="25px"> GCash
              </p>

              <div class="qr-container" style="margin-left:60px;">
                <img src="img/qr.jpg" width="150px" height="150px" alt="QR Code">
              </div>

              <!-- Upload Image Field -->
              <div class="mt-3">
                <label for="uploadReceipt"><b>Upload Payment Receipt:<br>Pay the exact amount <?php echo $cost ?></b></label>
                <input type="file" id="receiptImage" name="image" class="form-control" accept=".jpg,.jpeg,.png">
              </div>
            </div>

            <input type="hidden" name="orderID" value="<?php echo $rows['fID']; ?>">
            <input type="hidden" name="fullName" value="<?php echo $_SESSION['fullName']; ?>">
            <input type="hidden" name="address" value="<?php echo $_SESSION['address']; ?>">
            <input type="hidden" name="cpNum" value="<?php echo $_SESSION['cpNum']; ?>">
            <input type="hidden" name="prodName" value="<?php echo $rows['fName']; ?>">
            <input type="hidden" name="prodImage" value="<?php echo $rows['image']; ?>">
            <input type="hidden" name="cost" value="<?php echo $cost; ?>">
            <input type="hidden" name="date" value="<?php echo $dateToday ?>">
            <input type="hidden" name="status" value="Pending Approval">
            <input type="hidden" name="quantity" value="1">
            <input type="hidden" name="width" value="<?php echo $rows['width'];?>">
            <input type="hidden" name="length" value="<?php echo $rows['length'];?>">
            <input type="hidden" name="height" value="<?php echo $rows['height'];?>">

            <div class="card-footer p-4">
              <div class="d-flex justify-content-between">
                <h3 class="d-flex textp">Total: &#8369;<?php echo $cost; ?></h3>
              </div>
              <br>

              <div class="d-flex justify-content-between">
                <h5 class="fw-normal mb-0">
                  <button type="submit" name="cancel" class="btn btn-warning btn-block btn-lg">Cancel</button>
                </h5>

                <div class="border-start h-100"></div>

                <!-- Place Order Button with validation -->
                <h5 class="fw-normal mb-0">
                  <button type="button" onclick="validateForm()" class="btn btn-warning btn-block btn-lg">Place Order</button>
                </h5>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </form>

  <script>
    function validateForm() {
      const fileInput = document.getElementById('receiptImage');
      const file = fileInput.files[0];

      if (!file) {
        Swal.fire({
          icon: 'warning',
          title: 'No File Uploaded',
          text: 'Please upload your payment receipt image.',
        });
        return;
      }

      const allowedTypes = ['image/jpeg', 'image/png'];
      if (!allowedTypes.includes(file.type)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid File Type',
          text: 'Only JPG and PNG image files are allowed.',
        });
        fileInput.value = ''; // Reset file input
        return;
      }

      // Add hidden input for `name="place"`
      const hiddenInput = document.createElement('input');
      hiddenInput.type = 'hidden';
      hiddenInput.name = 'place';
      hiddenInput.value = 'true';
      document.getElementById('orderForm').appendChild(hiddenInput);

      document.getElementById('orderForm').submit(); // Submit the form
    }
  </script>
</body>

</html>
