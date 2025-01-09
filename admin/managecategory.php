<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Categories</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 20px;
            margin-bottom: 30px;
            text-align: center;
            color: #333;
        }
        .table {
            background-color: #fff;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table th {
            background-color: #007bff;
            color: #fff;
        }
        /* Custom styles for category status */
        .status-active {
            color: green;
        }
        .status-inactive {
            color: red;
        }
    </style>
</head>
<body>
<?php
    include 'adminheader.php';
    include 'adminmenu.php';
?>
<div class="container mt-5">
    <h2>Manage Categories</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Category Description</th>
                    <th>Category Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "database.php";
                
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                // Query to fetch all categories
                $sql = "SELECT * FROM tbl_category";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["cat_id"] . "</td>";
                        echo "<td>" . $row["cat_name"] . "</td>";
                        echo "<td>" . $row["cat_desc"] . "</td>";
                        echo "<td class='" . ($row["cat_status"] == 0 ? "status-active" : "status-inactive") . "'>" . ($row["cat_status"] == 0 ? "Active" : "Inactive") . "</td>";
                        echo "<td><a href='edit_cat.php?cat_id=" . $row['cat_id'] . "'><i class='fa fa-pencil-alt'></i> Edit</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No categories found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
