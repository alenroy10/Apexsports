<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Sizes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .btn {
            cursor: pointer;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
</head>
<body>
<?php
session_start();
include 'adminheader.php';
include 'adminmenu.php';
include 'database.php';
?>
<div class="container mt-5">
    <h2>Manage Sizes</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Size Value</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "database.php";

                // Query to fetch all sizes
                $sql = "SELECT * FROM tbl_size";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["size_value"] . "</td>";
                        echo "<td>" . ($row["size_status"] == 1 ? "Inactive" : "Active") . "</td>";
                        echo "<td>";
                        if ($row["size_status"] == 0) {
                            echo "<button type='button' class='btn btn-sm btn-danger' onclick='deactivateSize(" . $row["size_id"] . ")'>Deactivate</button>";
                        } else {
                            echo "<button type='button' class='btn btn-sm btn-success' onclick='activateSize(" . $row["size_id"] . ")'>Activate</button>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No sizes found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function deactivateSize(sizeId) {
        // AJAX request to deactivate size
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Reload the page to reflect changes
                window.location.reload();
            }
        };
        xhttp.open("GET", "deactivate_size.php?size_id=" + sizeId, true);
        xhttp.send();

        // Prevent default form submission
        return false;
    }

    function activateSize(sizeId) {
        // AJAX request to activate size
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Reload the page to reflect changes
                window.location.reload();
            }
        };
        xhttp.open("GET", "activate_size.php?size_id=" + sizeId, true);
        xhttp.send();

        // Prevent default form submission
        return false;
    }
</script>

</body>
</html>
