<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .active {
            color: green;
        }
        .inactive {
            color: red;
        }
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
            text-align: center; /* Center align table contents horizontally */
        }
        table, th, td {
            border: 1px solid #dee2e6;
            padding: 12px;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        img {
            max-width: 100px;
            height: auto;
        }
        .btn {
            margin-right: 5px;
        }
        /* Adjusted width for description column */
        .desc-col {
            width: 200px;
        }
    </style>
</head>
<body>
<?php
    include 'adminheader.php';
    include 'adminmenu.php';
?>
<div class="container">
    <h2>View Products</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr >
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Product Discount Status</th>
                    <th class="desc-col">Description</th> <!-- Adjusted width for description column -->
                    <th>Featured</th>
                    <th>Image</th>
                    <th>Action</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include database connection
                include "database.php";

                // Fetch products with category names from tbl_product and tbl_category
                $sql = "SELECT p.pro_id, p.pro_name, p.pro_status, p.pro_price, p.pro_discount, p.pro_desc, p.pro_featured,p.pro_dis_status, p.pro_img, c.cat_name
                        FROM tbl_product p
                        INNER JOIN tbl_category c ON p.cat_id = c.cat_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["pro_name"] . "</td>";
                        echo "<td>" . $row["cat_name"] . "</td>";
                        echo "<td>" . $row["pro_price"] . "</td>";
                        echo "<td>" . $row["pro_discount"] . "</td>";
                        echo "<td class='" . ($row["pro_dis_status"] == 0 ? 'active' : 'inactive') . "'>" . ($row["pro_dis_status"] == 0 ? 'Active' : 'Inactive') . "</td>";
                        echo "<td style=width:500px';>" . $row["pro_desc"] . "</td>"; 
                        echo "<td>" . ($row["pro_featured"] == 1 ? 'Yes' : 'No') . "</td>";
                        echo "<td><img src='" . $row["pro_img"] . "' alt='Product Image'></td>";
                        echo "<td>
                        <button class='btn btn-danger' onclick='deleteProduct(" . $row["pro_id"] . ")'>Delete</button>
                                <a href='editpro.php?id=" . $row["pro_id"] . "' class='btn btn-primary'>Edit</a>
                              </td>";
                        echo "<td class='" . ($row["pro_status"] == 0 ? 'active' : 'inactive') . "'>" . ($row["pro_status"] == 0 ? 'Active' : 'Inactive') . "</td>";                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No products found</td></tr>";
                }

                // Close database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function deleteProduct(productId) {
        if (confirm("Are you sure you want to delete this product?")) {
            window.location.href = "delete_product.php?id=" + productId;
        }
    }
</script>
</body>
</html>
