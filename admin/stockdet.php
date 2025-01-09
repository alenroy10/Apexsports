<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 5px;
            overflow: hidden;
        }
        table, th, td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <?php
        // Include database connection
        include "database.php";
        include "adminheader.php";
        include "adminmenu.php";
    ?>
    <div class="container">
        <h2>Stock Details</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Size Name</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Query to fetch stock details from tbl_size_details, tbl_product, and tbl_size
                        $sql = "SELECT p.pro_name, s.size_value, sd.stock
                                FROM tbl_size_details sd
                                INNER JOIN tbl_product p ON sd.pro_id = p.pro_id
                                INNER JOIN tbl_size s ON sd.size_id = s.size_id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["pro_name"] . "</td>";
                                echo "<td>" . $row["size_value"] . "</td>";
                                echo "<td>" . $row["stock"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No stock details found</td></tr>";
                        }

                        // Close database connection
                        $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
