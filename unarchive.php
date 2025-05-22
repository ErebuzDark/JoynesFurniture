<?php

$msg = "hide";
$conn = mysqli_connect("localhost", "root", "", "joynes_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if 'id' is passed via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare SQL to fetch data for the given ID
    $furniture = "SELECT * FROM archived WHERE ID = ?";
    if ($stmt = mysqli_prepare($conn, $furniture)) {
        // Bind parameters and execute query
        mysqli_stmt_bind_param($stmt, 'i', $id);  // Assuming fID is an integer
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Check if we got a valid row
        if ($row = mysqli_fetch_assoc($result)) {
            $furName = $row['name'];
            $filename = $row['image'];
            $quantity = $row['quantity'];
            $des = $row['description'];
            $cost = $row['cost'];
            $date = date('Y-m-d');

            // Prepare INSERT query for archived table
            $sql = "INSERT INTO furnituretbl (fName, image,fDes ,fQuantity , cost, date) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind parameters and execute insert query
                mysqli_stmt_bind_param($stmt, 'ssssss', $furName, $filename, $des, $quantity, $cost, $date);
                if (mysqli_stmt_execute($stmt)) {
                    // Prepare DELETE query to remove from furnituretbl
                    $deleteSql = "DELETE FROM archived WHERE ID = ?";
                    if ($stmt = mysqli_prepare($conn, $deleteSql)) {
                        // Bind parameter and execute delete query
                        mysqli_stmt_bind_param($stmt, 'i', $id);
                        if (mysqli_stmt_execute($stmt)) {
                            // Redirect if everything went well
                            header("Location: archiveprod.php");
                            exit();
                        } else {
                            $msg = "Error deleting record from furnituretbl.";
                        }
                    } else {
                        $msg = "Error preparing DELETE query.";
                    }
                } else {
                    $msg = "Error archiving the record.";
                }
            } else {
                $msg = "Error preparing INSERT query.";
            }
        } else {
            $msg = "No record found with the given ID.";
        }

        // Close prepared statements
        mysqli_stmt_close($stmt);
    } else {
        $msg = "Error preparing SELECT query.";
    }
}

mysqli_close($conn);  // Close database connection
?>