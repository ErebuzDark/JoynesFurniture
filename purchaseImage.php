<!-- filepath: c:\xampp\htdocs\php\JoynesFurniture2.0\purchaseImage.php -->
<?php
if (isset($_GET['image'])) {
    $images = explode(',', $_GET['image']);
} else {
    echo "No image provided.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Images</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h2 class="text-center mb-4">Purchase Image</h2>

        <div class="row">

            <?php foreach ($images as $image): ?>
                <center><img src="<?php echo htmlspecialchars(trim($image)); ?>" class="img-fluid border rounded" alt="Purchase Image"></center>
            <?php endforeach; ?>

        </div>
        <br>

        <div class="text-center">
            <a href="profile.php" class="btn btn-primary">Back to Profile</a>
        </div>
    </div>
</body>
</html>