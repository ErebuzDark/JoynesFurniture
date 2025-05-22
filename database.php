<?php

$conn = mysqli_connect("localhost", "root", "", "joynes_db");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
