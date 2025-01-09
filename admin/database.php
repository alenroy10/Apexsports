<?php
    $hostname="localhost";
    $dbuser="root";
    $dbpassword="";
    $dbname="apexsports";
    $conn=mysqli_connect($hostname,$dbuser,$dbpassword,$dbname);
    if(!$conn)
    {
        die("not connected");
    }
?>