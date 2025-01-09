<?php
// Include header and menu here
include 'adminheader.php';
include 'adminmenu.php';


// Check if the user is not logged in, then redirect to logout page
if (!isset($_SESSION['user_name'])) {
    header("Location: adminlogout.php");
    exit(); // Ensure subsequent code is not executed after redirection
}


// Include database connection file
include 'database.php';

// Initialize variables to store total products and total users
$totalProducts = 0;
$totalUsers = 0;

// Query to get total products
$sqlProducts = "SELECT COUNT(*) AS total FROM tbl_product";
$resultProducts = $conn->query($sqlProducts);
if ($resultProducts->num_rows > 0) {
    $rowProducts = $resultProducts->fetch_assoc();
    $totalProducts = $rowProducts['total'];
}

// Query to get total users
$sqlUsers = "SELECT COUNT(*) AS total FROM tbl_registration";
$resultUsers = $conn->query($sqlUsers);
if ($resultUsers->num_rows > 0) {
    $rowUsers = $resultUsers->fetch_assoc();
    $totalUsers = $rowUsers['total'];
}
$sqlcat = "SELECT COUNT(*) AS total FROM tbl_category";
$resultcategory = $conn->query($sqlcat);
if ($resultcategory->num_rows > 0) {
    $rowcat = $resultcategory->fetch_assoc();
    $totalcat = $rowcat['total'];
}


// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS */
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .card-value {
            font-size: 36px;
            font-weight: bold;
        }
        .bg-primary {
            background-color: #4e73df !important;
        }
        .bg-secondary {
            background-color: #858796 !important;
        }
        .bg-info {
            background-color: #36b9cc !important;
        }
        .bg-success {
            background-color: #1cc88a !important;
        }
        .bg-danger {
            background-color: #e74a3b !important;
        }
        .text-white {
            color: #fff !important;
        }
        .heading {
            text-align: center;
            margin-bottom: 30px;
            font-size: 36px;
            font-weight: bold;
            color: #333;
        }
        .stats-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        .stats-card {
            flex: 1;
            margin: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="heading">Admin Dashboard</h1>
    <div class="stats-container">
        <div class="stats-card">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h3 class="card-title">Total Products</h3>
                    <p class="card-value"><?php echo $totalProducts; ?></p>
                </div>
            </div>
        </div>
        <div class="stats-card">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h3 class="card-title">Total Users</h3>
                    <p class="card-value"><?php echo $totalUsers; ?></p>
                </div>
            </div>
        </div>
        <div class="stats-card">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h3 class="card-title">Total Category</h3>
                    <p class="card-value"><?php echo $totalcat; ?></p>
                </div>
            </div>
        </div>
        <!-- Add more cards for other statistics -->
    </div>
</div>

<script>
window.onload = function() {
    if (!sessionStorage.getItem('loadedBefore')) {
        sessionStorage.setItem('loadedBefore', true);
        // Use the desired URL without any hash fragment
        window.history.pushState('forward', null, 'admin.php');
    }

    window.onpopstate = function(event) {
        if (event.state === 'forward') {
            window.location.href = 'adminlogout.php';
        }
    };
};
</script>

</body>
</html>
