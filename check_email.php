<?php
$hostname = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "apexsports";
$conn = mysqli_connect($hostname, $dbuser, $dbpassword, $dbname);

if (!$conn) {
    die("not connected");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Sanitize user input to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);

    // Query to check if email exists
    $query = "SELECT * FROM `tbl_registration` WHERE `reg_email`='$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "exists";
        } else {
            echo "available";
        }
    } else {
        echo "error";
    }

    mysqli_close($conn);
}
?>
