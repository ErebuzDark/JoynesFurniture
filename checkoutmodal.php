<?php
session_start();
include("database.php");

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
  header("Location: login.php");
  exit();
}

$userID = $_SESSION['userID'];

// Validate and sanitize POST data
$userid = filter_input(INPUT_POST, 'userid', FILTER_VALIDATE_INT);
if (!$userid) {
  die("Invalid product ID.");
}

// Use prepared statements to avoid SQL Injection
$sqls = "SELECT * FROM furnituretbl WHERE fID = ?";
$stmt = $conn->prepare($sqls);
$stmt->bind_param("i", $userid);
$stmt->execute();
$resu = $stmt->get_result();

if ($resu->num_rows === 0) {
  die("Product not found.");
}

$rows = $resu->fetch_assoc();
$stmt->close();

$cost = (float) $rows['cost'];
$formattedCost = number_format($cost, 2, '.', ',');

$dateToday = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Joynes Furniture</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="css/bootstrap.min.css" rel="stylesheet" />

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .text-danger {
      font-size: 0.9em;
    }
  </style>
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
                  <b>Name: </b> <?php echo htmlspecialchars($_SESSION['fullName']); ?><br />
                  <b>Address: </b> <?php echo htmlspecialchars($_SESSION['address']); ?><br />
                  <b>Contact: </b> <?php echo htmlspecialchars($_SESSION['cpNum']); ?>
                </p>

                <p class="text-muted mb-2">
                  Order ID: <span class="fw-bold text-body"><?php echo $rows['fID']; ?></span><br />
                  Place On: <span class="fw-bold text-body"><?php echo $dateToday; ?></span>
                </p>
              </div>
            </div>

            <div class="card-body p-3">
              <div class="d-flex flex-row md1 mb-3 pb-2">
                <div class="flex-fill">
                  <h5 class="bold"><?php echo htmlspecialchars($rows['fName']); ?></h5>
                  <p class="text-muted">Qt: 1 item</p>
                  <h4 class="mb-3">&#8369;<?php echo $formattedCost; ?></h4>
                </div>

                <div class="col-md-2 col-lg-2 col-xl-2 flex-fill">
                  <img class="align-self-center img-fluid" src="./up/<?php echo htmlspecialchars($rows['image']); ?>"
                    width="100" alt="Product Image" />
                </div>
              </div>

              <h6 class="mt-5">Payment Method:</h6>
              <p class="fw-bold d-flex align-items-center" style="color:#0d6efd;">
                <img src="img/gcash.png" width="25px" height="25px" alt="GCash" /> GCash
              </p>

              <div class="qr-container" style="margin-left:60px;">
                <img src="img/qr.jpg" width="150px" height="150px" alt="QR Code" />
              </div>

              <!-- Upload Image Field -->
              <div class="mt-3">
                <label for="receiptImage"><b>Upload Payment Receipt:<br>Pay the exact amount
                    &#8369;<?php echo $formattedCost; ?></b></label>
                <input type="file" id="receiptImage" name="image" class="form-control" accept=".jpg,.jpeg,.png"
                  required />
                <small id="receiptError" class="text-danger"></small>
              </div>

              <!-- Amount Paid Input -->
              <div class="mt-3">
                <label for="amountPaid"><b>Amount Paid:</b></label>
                <input type="number" id="amountPaid" name="amountPaid" class="form-control" step="0.01" min="0.01"
                  max="<?php echo $cost; ?>" value="<?php echo $cost; ?>" readonly />
                <small id="amountError" class="text-danger"></small>
              </div>

              <!-- Reference Number Input -->
              <div class="mt-3">
                <label for="refNo"><b>Reference Number:</b></label>
                <input type="text" id="refNo" name="refNo" class="form-control" minlength="5"
                  placeholder="Enter reference number" required />
                <small id="refError" class="text-danger"></small>
              </div>

            </div>

            <input type="hidden" name="orderID" value="<?php echo $rows['fID']; ?>" />
            <input type="hidden" name="fullName" value="<?php echo htmlspecialchars($_SESSION['fullName']); ?>" />
            <input type="hidden" name="address" value="<?php echo htmlspecialchars($_SESSION['address']); ?>" />
            <input type="hidden" name="cpNum" value="<?php echo htmlspecialchars($_SESSION['cpNum']); ?>" />
            <input type="hidden" name="prodName" value="<?php echo htmlspecialchars($rows['fName']); ?>" />
            <input type="hidden" name="prodImage" value="<?php echo htmlspecialchars($rows['image']); ?>" />
            <input type="hidden" name="cost" value="<?php echo $cost; ?>" />
            <input type="hidden" name="date" value="<?php echo $dateToday; ?>" />
            <input type="hidden" name="status" value="Pending Approval" />
            <input type="hidden" name="quantity" value="1" />
            <input type="hidden" name="width" value="<?php echo htmlspecialchars($rows['width']); ?>" />
            <input type="hidden" name="length" value="<?php echo htmlspecialchars($rows['length']); ?>" />
            <input type="hidden" name="height" value="<?php echo htmlspecialchars($rows['height']); ?>" />

            <div class="card-footer p-4">
              <div class="d-flex justify-content-between">
                <h3 class="d-flex textp">Total: &#8369;<?php echo $formattedCost; ?></h3>
              </div>
              <br />

              <div class="d-flex justify-content-between">
                <!-- Cancel Button: sends name="cancel" to server -->
                <button type="submit" name="cancel" class="btn btn-warning btn-block btn-lg">Cancel</button>

                <div class="border-start h-100"></div>

                <!-- Place Order Button: triggers JS validation -->
                <button type="button" onclick="validateForm()" class="btn btn-warning btn-block btn-lg">Place
                  Order</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <script>
    window.onload = function () {
      <?php if (isset($_SESSION['error_refNo'])): ?>
        const refErrorEl = document.getElementById('refError');
        if (refErrorEl) {
          refErrorEl.textContent = <?php echo json_encode($_SESSION['error_refNo']); ?>;
        }
        <?php unset($_SESSION['error_refNo']); ?>
      <?php endif; ?>
    };
  </script>

  <script>
    function clearErrors() {
      ['receiptError', 'amountError', 'refError'].forEach(id => {
        document.getElementById(id).textContent = '';
      });
    }

    function validateForm() {
      clearErrors();

      const amountPaidEl = document.getElementById('amountPaid');
      const refNoEl = document.getElementById('refNo');
      const receiptImageEl = document.getElementById('receiptImage');

      const amountPaid = parseFloat(amountPaidEl.value);
      const cost = parseFloat(<?php echo json_encode($cost); ?>);
      const refNo = refNoEl.value.trim();
      const receiptFilesCount = receiptImageEl.files.length;

      let valid = true;

      // Validate receipt image
      if (receiptFilesCount === 0) {
        document.getElementById('receiptError').textContent = "Please upload a payment receipt image.";
        valid = false;
      } else {
        const file = receiptImageEl.files[0];
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
          document.getElementById('receiptError').textContent = "Invalid file type. Only JPG and PNG allowed.";
          valid = false;
        }
      }

      // Validate amount paid
      if (isNaN(amountPaid) || amountPaid <= 0) {
        document.getElementById('amountError').textContent = "Please enter a valid amount paid.";
        valid = false;
      } else if (amountPaid !== cost) {
        document.getElementById('amountError').textContent = `Amount paid must be exactly ₱${cost.toFixed(2)}.`;
        valid = false;
      }

      // Validate refNo
      if (refNo.length < 5) {
        document.getElementById('refError').textContent = "Reference number must be at least 5 characters.";
        valid = false;
      }

      if (!valid) return;

      // Add hidden input "place" if not exist to indicate form submission
      if (!document.querySelector('input[name="place"]')) {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'place';
        hiddenInput.value = 'true';
        document.getElementById('orderForm').appendChild(hiddenInput);
      }

      document.getElementById('orderForm').submit();
    }
  </script>
</body>

</html>