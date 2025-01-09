<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Category</title>
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
            margin-top: 50px;
            max-width: 500px;
        }
        h2 {
            margin-bottom: 30px;
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-check-input {
            margin-right: 10px;
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
<?php
 include 'adminheader.php';
 include 'adminmenu.php';
?>
<div class="container">
    <h2>Edit Category</h2>
    <?php
    // Check if cat_id is provided in the URL
    if (isset($_GET['cat_id'])) {
        // Retrieve the cat_id from the URL
        $cat_id = $_GET['cat_id'];

        // Include database connection
        include "database.php";

        // Fetch category details from the database
        $sql = "SELECT * FROM tbl_category WHERE cat_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cat_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch category details
            $row = $result->fetch_assoc();
            $cat_name = $row["cat_name"];
            $cat_desc = $row["cat_desc"];
            $cat_status = $row["cat_status"];
        } else {
            // Handle the case where category is not found
            echo "Category not found";
            exit; // Stop further execution
        }

        // Close prepared statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        // Handle the case where cat_id is not provided
        echo "Category ID not provided";
        exit; // Stop further execution
    }
    ?>

    <form action="update_cat.php" method="post">
        <div class="form-group">
            <label for="catName">Category Name:</label>
            <input type="text" class="form-control" id="catName" name="catName" value="<?php echo $cat_name; ?>">
        </div>
        <div class="form-group">
            <label for="catDesc">Category Description:</label>
            <input type="text" class="form-control" id="catDesc" name="catDesc" value="<?php echo $cat_desc; ?>">
        </div>
        <div class="form-group">
            <label for="catStatus">Category Status:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="catStatus" id="active" value="0" <?php echo ($cat_status == 0) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="active">
                    Active
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="catStatus" id="inactive" value="1" <?php echo ($cat_status == 1) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="inactive">
                    Inactive
                </label>
            </div>
        </div>
        <input type="hidden" name="catId" value="<?php echo $cat_id; ?>">
        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
</div>

</body>
</html>
