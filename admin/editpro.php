<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
        form {
            max-width: 600px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php
    include 'adminheader.php';
    include 'adminmenu.php';

    // Include database connection
    include "database.php";

    // Check if product ID is provided in the URL
    if(isset($_GET['id'])) {
        $productId = $_GET['id'];

        // Fetch product details from the database based on the provided product ID
        $sql = "SELECT p.pro_name, p.cat_id, p.pro_price, p.pro_discount, p.pro_desc, p.pro_featured, p.pro_status,p.pro_dis_status, p.pro_img, c.cat_name
                FROM tbl_product p
                INNER JOIN tbl_category c ON p.cat_id = c.cat_id
                WHERE p.pro_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Display the product details in the form fields for editing
            ?>
            <div class="container">
                <h2>Edit Product</h2>
                <form action="update_product.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="pro_name">Product Name:</label>
                        <input type="text" id="pro_name" name="pro_name" value="<?php echo $row['pro_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="cat_id">Category:</label>
                        <select id="cat_id" name="cat_id">
                            <?php
                                // Fetch categories from tbl_category
                                $sql_categories = "SELECT * FROM tbl_category";
                                $result_categories = $conn->query($sql_categories);
                                if ($result_categories->num_rows > 0) {
                                    while ($category = $result_categories->fetch_assoc()) {
                                        echo "<option value='" . $category['cat_id'] . "'";
                                        if ($category['cat_id'] == $row['cat_id']) {
                                            echo " selected";
                                        }
                                        echo ">" . $category['cat_name'] . "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pro_price">Price:</label>
                        <input type="number" id="pro_price" name="pro_price" value="<?php echo $row['pro_price']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="pro_discount">Discount:</label>
                        <input type="number" id="pro_discount" name="pro_discount" value="<?php echo $row['pro_discount']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="pro_desc">Description:</label>
                        <textarea id="pro_desc" name="pro_desc" rows="4"><?php echo $row['pro_desc']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pro_featured">Featured:</label>
                        <input type="checkbox" id="pro_featured" name="pro_featured" <?php if($row['pro_featured'] == 1) echo 'checked'; ?>>
                    </div>
                    <div class="form-group">
                        <label for="pro_status">Status:</label>
                        <select id="pro_status" name="pro_status">
                            <option value="0" <?php if ($row['pro_status'] == 0) echo 'selected'; ?>>Active</option>
                            <option value="1" <?php if ($row['pro_status'] == 1) echo 'selected'; ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pro_dis_status">Product Discount Status:</label>
                        <select id="pro_dis_status" name="pro_dis_status">
                            <option value="0" <?php if ($row['pro_dis_status'] == 0) echo 'selected'; ?>>Active</option>
                            <option value="1" <?php if ($row['pro_dis_status'] == 1) echo 'selected'; ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pro_img">Image:</label>
                        <input type="file" id="pro_img" name="pro_img">
                    </div>
                    <input type="hidden" name="pro_id" value="<?php echo $productId; ?>">
                    <input type="submit" value="Update Product">
                </form>
            </div>
            <?php
        } else {
            echo "Product not found.";
        }

        // Close statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Product ID not provided.";
    }
?>
</body>
</html>
