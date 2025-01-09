<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            max-width: 500px;
            margin: auto;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .container form {
            max-width: 400px;
            margin: auto;
        }
        .container form label {
            font-weight: bold;
            color: #333;
        }
        .container form input[type="text"],
        .container form input[type="number"],
        .container form textarea {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .container form input[type="checkbox"] {
            margin-top: 10px;
        }
        .container form input[type="file"] {
            margin-top: 10px;
        }
        .container form input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .container form input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: #dc3545;
            margin-top: 5px;
        }
        .success-message {
            color: #28a745;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<?php
    include 'adminheader.php';
    include 'adminmenu.php';
?>
<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include "database.php";

    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO tbl_product (pro_name, cat_id, pro_price, pro_discount, pro_desc, pro_featured, pro_img) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siidsis", $productName, $categoryId, $price, $discount, $description, $featured, $imagePath);

    // Set parameters
    $productName = $_POST["pro_name"];
    $categoryId = $_POST["cat_id"];
    $price = $_POST["pro_price"];
    $discount = $_POST["pro_discount"];
    $description = $_POST["pro_desc"];
    $featured = isset($_POST["pro_featured"]) ? 1 : 0; // Convert checkbox value to 1 if checked, otherwise 0
    
    // Upload image file
    $targetDirectory = "../uploads/"; // Specify the directory where images will be uploaded
    $targetFile = $targetDirectory . basename($_FILES["pro_image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file is an actual image
    $check = getimagesize($_FILES["pro_image"]["tmp_name"]);
    if ($check !== false) {
        // Check file size
        if ($_FILES["pro_image"]["size"] > 5000000) { // Adjust the maximum file size as needed
            echo '<div class="error-message">Sorry, your file is too large.</div>';
            exit();
        }

        // Allow certain file formats
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo '<div class="error-message">Sorry, only JPG, JPEG, PNG, and GIF files are allowed.</div>';
            exit();
        }

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["pro_image"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
        } else {
            echo '<div class="error-message">Sorry, there was an error uploading your file.</div>';
            exit();
        }
    } else {
        echo '<div class="error-message">File is not an image.</div>';
        exit();
    }

    // Execute the SQL statement
    if ($stmt->execute()) {
        echo '<div class="success-message">New product added successfully</div>';
    } else {
        echo '<div class="error-message">Error: ' . $stmt->error . '</div>';
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add New Product</title>
<style>
/* Paste your CSS code here */
body {
  font-family: "Roboto", sans-serif;
  background-color: #efefef;
  line-height: 1.9;
  color: #8c8c8c;
  position: relative;
  align-items: centre;
  text-align: centre;
}

h2 {
  font-family: "Roboto", sans-serif;
  color: #000;
}

label {
  color: #000;
  font-size: 13px;
}

.input-field {
  border: none;
  border-bottom: 1px solid #ccc;
  padding-left: 0;
  padding-right: 0;
  border-radius: 0;
  background: none;
}

.input-field:active, .input-field:focus {
  outline: none;
  box-shadow: none;
  border-color: #000;
}

.select-field:active, .select-field:focus {
  outline: none;
  box-shadow: none;
  border-color: #000;
}

.textarea-field:active, .textarea-field:focus {
  outline: none;
  box-shadow: none;
  border-color: #000;
}

.checkbox-field {
  margin: 0;
}

.file-field {
  margin: 0;
}

.submit-button {
  border: none;
  border-radius: 0;
  font-size: 12px;
  letter-spacing: .2rem;
  text-transform: uppercase;
  background: #35477d;
  color: #fff;
  padding: 15px 20px;
}

.submit-button:hover {
  color: #fff;
}

.submit-button:active, .submit-button:focus {
  outline: none;
  box-shadow: none;
}

.error-message {
  font-size: 12px;
  color: red;
}

.success-message {
  color: #55a44e;
  font-size: 18px;
  font-weight: bold;
}

.submitting {
  float: left;
  width: 100%;
  padding: 10px 0;
  display: none;
  font-weight: bold;
  font-size: 12px;
  color: #000;
}
</style>
</head>
<body>

<div class="container mt-5">
    <h2>Add New Product</h2>
    <form action="#" method="POST" id="productForm" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div id="errorMessage" class="error-message"></div>
        <label for="pro_name">Product Name:</label><br>
        <input type="text" id="pro_name" name="pro_name" class="input-field" onkeyup="validateName()"><br><br>

        <label for="cat_id">Category:</label><br>
        <select id="cat_id" name="cat_id" class="select-field" onkeyup="validateCategory()">
            <?php
                // Include database connection
                include "database.php";

                // Query to fetch categories from tbl_category
                $sql = "SELECT * FROM tbl_category WHERE cat_status = 0 ORDER BY cat_name ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row as options
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["cat_id"] . "'>" . $row["cat_name"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No categories found</option>";
                }

                // Close database connection
                $conn->close();
            ?>
        </select><br><br>

        <label for="pro_price">Price:</label><br>
        <input type="number" id="pro_price" name="pro_price" class="input-field" onkeyup="validatePrice()"><br><br>

        <label for="pro_discount">Discount:</label><br>
        <input type="number" id="pro_discount" name="pro_discount" class="input-field" onkeyup="validateDiscount()"><br><br>

        <label for="pro_desc">Description:</label><br>
        <textarea id="pro_desc" name="pro_desc" rows="4" class="textarea-field" onkeyup="validateDescription()"></textarea><br><br>

        <label for="pro_featured">Featured:</label>
        <input type="checkbox" id="pro_featured" name="pro_featured" class="checkbox-field"><br><br>

        <label for="pro_image">Product Image:</label>
        <input type="file" id="pro_image" name="pro_image" class="file-field" accept="image/*"><br><br>

        <input type="submit" value="Add Product" class="submit-button">
    </form>
</div>

</body>
</html>


<script>
    function validateForm() {
        var productName = document.getElementById("pro_name").value;
        var categoryId = document.getElementById("cat_id").value;
        var price = document.getElementById("pro_price").value;
        var discount = document.getElementById("pro_discount").value;
        var description = document.getElementById("pro_desc").value;
        var image = document.getElementById("pro_image").value;

        // Check if any field is empty
        if (productName === "" || categoryId === "" || price === "" || discount === "" || description === "" || image === "") {
            // Display error message
            document.getElementById("errorMessage").innerText = "All fields are required";
            return false;
        }

        // Check if price is negative
        if (parseFloat(price) < 0) {
            document.getElementById("errorMessage").innerText = "Price cannot be negative";
            return false;
        }

        // Check if discount is negative
        if (parseFloat(discount) < 0) {
            document.getElementById("errorMessage").innerText = "Discount cannot be negative";
            return false;
        }

        // Clear error message if all validations pass
        document.getElementById("errorMessage").innerText = "";
        return true;
    }

    // Validation functions for individual fields
    function validateName() {
        var productName = document.getElementById("pro_name").value;
        if (productName === "") {
            document.getElementById("errorMessage").innerText = "Product Name is required";
        } else {
            document.getElementById("errorMessage").innerText = "";
        }
    }
    function validateName() {
        var pname = document.getElementsByName('pro_name')[0].value;
        var nameerror = document.getElementById('errorMessage');

        nameerror.innerHTML = ""; // Clear previous error messages

        // Presence check
        if (pname.trim() === "") {
            nameerror.innerHTML = "Product name is required";
            return false;
        }
        if (pname.charAt(0) === " ") {
            nameerror.innerHTML = "cannot start with a space";
        return false;
    }

        // Check for invalid characters
        var invalidCharsRegex = /[^a-zA-Z0-9\s]/;
        if (invalidCharsRegex.test(pname)) {
            nameerror.innerHTML = "Invalid characters entered";
            return false;
        }
        var consecutiveSpacesRegex = /\s{2,}/;
        if (consecutiveSpacesRegex.test(pname)) {
            nameerror.innerHTML = "Product name should only contain single spaces";
            return false;
        }
        // All validations passed
        return true;
    }

    function validateCategory() {
        var categoryId = document.getElementById("cat_id").value;
        if (categoryId === "") {
            document.getElementById("errorMessage").innerText = "Category is required";
        } else {
            document.getElementById("errorMessage").innerText = "";
        }
    }

    function validatePrice() {
        var price = document.getElementById("pro_price").value;
        if (price === "") {
            document.getElementById("errorMessage").innerText = "Price is required";
        } else if (parseFloat(price) < 0) {
            document.getElementById("errorMessage").innerText = "Price cannot be negative";
        } else {
            document.getElementById("errorMessage").innerText = "";
        }
    }

    function validateDiscount() {
        var discount = document.getElementById("pro_discount").value;
        if (discount === "") {
            document.getElementById("errorMessage").innerText = "Discount is required";
        } else if (parseFloat(discount) < 0) {
            document.getElementById("errorMessage").innerText = "Discount cannot be negative";
        } else {
            document.getElementById("errorMessage").innerText = "";
        }
    }

    function validateDescription() {
        var description = document.getElementById("pro_desc").value;
        if (description === "") {
            document.getElementById("errorMessage").innerText = "Description is required";
        } else {
            document.getElementById("errorMessage").innerText = "";
        }
    }
</script>
</body>
</html>
