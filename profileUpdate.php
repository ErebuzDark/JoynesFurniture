<?php
session_start();
include("database.php");

if (isset($_POST['userID'])) {
    $userID = $_POST['userID'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $cpNum = $_POST['cpNum'];
    $address = $_POST['address'];
    $response = ['status' => 'error', 'message' => 'Something went wrong'];

    if (isset($_POST['updateType']) && $_POST['updateType'] === 'image' && $_FILES['image']['size'] > 0) {
        $image = $_FILES['image']['name'];
        $target_dir = "up/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("UPDATE usertbl SET image = ? WHERE ID = ?");
            $stmt->bind_param("si", $target_file, $userID);
            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Image updated successfully';
            }
        } else {
            $response['message'] = "Image upload failed";
        }
    }

    if (isset($_POST['updateType']) && $_POST['updateType'] === 'details') {
        $stmt = $conn->prepare("UPDATE usertbl SET fullName = ?, email = ?, cpNum = ?, address = ? WHERE ID = ?");
        $stmt->bind_param("ssssi", $fullName, $email, $cpNum, $address, $userID);
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Profile details updated successfully';
        }
    }

    echo json_encode($response);
    exit();
}

?>