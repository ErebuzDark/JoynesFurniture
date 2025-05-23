<?php
session_start();
include("database.php");

if (isset($_POST['selected_products'])) {
  $selectedProducts = $_POST['selected_products'];
  $placeholders = implode(',', array_fill(0, count($selectedProducts), '?'));

  $sql = "SELECT * FROM addcart WHERE ID IN ($placeholders)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(str_repeat('i', count($selectedProducts)), ...$selectedProducts);
  $stmt->execute();
  $result = $stmt->get_result();

  $totalCost = 0;
  echo '<form action="cartOrder.php" method="POST" enctype="multipart/form-data">';

  echo ' <div class="card-header p-4">
              <div class="d-flex justify-content-between align-items-center">
                <p style="font-size: 17px;">
                  <b>Name: </b> ' . $_SESSION['fullName'] . '
                  <br>
                  <b>Address: </b> ' . $_SESSION['address'] . '
                  <br>
                  <b>Contact: </b> ' . $_SESSION['cpNum'] . '
                </p>
              </div>
          </div>';

  while ($row = $result->fetch_assoc()) {
    $cost = $row['cost'];
    $totalCost += $cost;

    echo '<div class="card-body p-3">';
    echo '<div class="d-flex flex-row mb-3 pb-2">';
    echo '<div class="col-md-10 col-lg-10 col-xl-10 flex-fill ms-4">';
    echo '<h5>' . $row['prodName'] . '</h5>';
    echo '<p>Quantity: ' . $row['quantity'] . '</p>';
    echo '<h5>Total: &#8369; ' . number_format($cost) . '</h5>';

    echo '<input type="hidden" name="prodIDs[]" value="' . $row['ID'] . '">';
    echo '<input type="hidden" name="prodNames[]" value="' . $row['prodName'] . '">';
    echo '<input type="hidden" name="prodCosts[]" value="' . $row['cost'] . '">';
    echo '<input type="hidden" name="balance" value="' . $row['cost'] . '">';
    echo '<input type="hidden" name="userID" value="' . $_SESSION['userID'] . '"> ';
    echo '<input type="hidden" name="fullName" value="' . $_SESSION['fullName'] . '"> ';
    echo '<input type="hidden" name="quantity" value="' . $row['quantity'] . '"> ';
    echo '<input type="hidden" name="address" value="' . $_SESSION['address'] . '"> ';
    echo '<input type="hidden" name="cpNum" value="' . $_SESSION['cpNum'] . '"> ';
    echo '<input type="hidden" name="tblImage[]" value="' . $row['image'] . '">';
    echo '<input type="hidden" name="prodWidth[]" value="' . $row['width'] . '">';
    echo '<input type="hidden" name="prodLength[]" value="'.$row['length'].'">';
    echo '<input type="hidden" name="prodHeight[]" value="'.$row['height'].'">';
    echo '<input type="hidden" name="payment" value="Full Payment">';

    echo '</div>';
    echo '<div class="col-md-2 col-lg-2 col-xl-2 flex-fill me-5">';
    echo '<img class="img-fluid" src="./up/' . $row['image'] . '" width="100">';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  }

  // Payment Method (shown once outside the loop)
  echo '<div class="card-body p-3">';
  echo '<h6>Payment Method:</h6>';
  echo '<p class="fw-bold d-flex align-items-center" style="color:#0d6efd;">
            <img src="img/gcash.png" width="25px" height="25px"> GCash 
        </p>';

  // QR Code shown by default (no toggle)
  echo '<div class="qr-container" style="margin-left:60px;">
            <img src="img/qr.jpg" width="150px" height="150px" alt="QR Code">
        </div>';

  echo '<label for="qrImage" class="mt-4">Upload Proof of Payment (JPG/PNG only): <br>Pay the exact amount of  &#8369;' . number_format($totalCost) . ':</label>';
  echo '<input type="file" name="qrImage" class="form-control form-control-sm" id="qrImage" accept=".jpg,.jpeg,.png" required>';

  echo '<div id="imagePreviewContainer" style="margin-top: 10px;">
            <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 200px; display: none;">
        </div>';
  echo '</div>';

  echo '<div class="card-footer">';
  echo '<h3 class="mt-3 mb-5">Total: &#8369; ' . number_format($totalCost) . '</h3>';
  echo '<div class="d-flex justify-content-between mb-2">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-warning" onclick="validateAndSubmit()">Place Order</button>';
  echo '</div>';
  echo '</div>';
  echo '</form>';
}
?>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function previewImage(event) {
    const file = event.target.files[0];
    const allowedTypes = ['image/jpeg', 'image/png'];

    if (file && allowedTypes.includes(file.type)) {
      const reader = new FileReader();
      reader.onload = function () {
        const preview = document.getElementById('imagePreview');
        preview.src = reader.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      event.target.value = '';
      Swal.fire({
        icon: 'error',
        title: 'Invalid File Type',
        text: 'Only JPG and PNG images are allowed.',
      });
      document.getElementById('imagePreview').style.display = 'none';
    }
  }

  function validateAndSubmit() {
    const fileInput = document.getElementById('qrImage');
    const file = fileInput.files[0];

    if (!file) {
      Swal.fire({
        icon: 'warning',
        title: 'No Image Uploaded',
        text: 'Please upload a proof of payment before submitting.',
      });
      return;
    }

    const allowedTypes = ['image/jpeg', 'image/png'];
    if (!allowedTypes.includes(file.type)) {
      Swal.fire({
        icon: 'error',
        title: 'Invalid File Type',
        text: 'Only JPG and PNG images are allowed.',
      });
      return;
    }

    fileInput.form.submit(); // manually submit the form
  }
</script>
