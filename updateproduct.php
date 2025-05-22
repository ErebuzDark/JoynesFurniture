<?php
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fID = mysqli_real_escape_string($conn, $_POST['fID']);
    $fName = mysqli_real_escape_string($conn, $_POST['fName']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $fQuantity = mysqli_real_escape_string($conn, $_POST['fQuantity']);
    $cost = mysqli_real_escape_string($conn, $_POST['cost']);
    $fDes = mysqli_real_escape_string($conn, $_POST['fDes']);

    $image = NULL;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        $file_info = pathinfo($_FILES['image']['name']);
        $file_extension = strtolower($file_info['extension']);

        if (in_array($file_extension, $allowed_extensions)) {
            $new_image_name = uniqid() . '.' . $file_extension;
            $upload_dir = './up/';
            $target_file = $upload_dir . $new_image_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image = $new_image_name;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Invalid file type. Only jpg, jpeg, png, and gif are allowed.";
        }
    }

    if ($image) {
        $update_sql = "UPDATE furnituretbl 
                       SET fName = '$fName', category = '$category', fQuantity = '$fQuantity', 
                           cost = '$cost', fDes = '$fDes', image = '$image' 
                       WHERE fID = '$fID'";
    } else {
        $update_sql = "UPDATE furnituretbl 
                       SET fName = '$fName', category = '$category', fQuantity = '$fQuantity', 
                           cost = '$cost', fDes = '$fDes' 
                       WHERE fID = '$fID'";
    }

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Furniture updated successfully.'); window.location.href = 'tables.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>