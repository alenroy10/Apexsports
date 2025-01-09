<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .custom-form {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .custom-form-group {
            margin-bottom: 20px;
        }
        .custom-form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .error-message {
            color: red;
            font-size: 14px;
        }
        .custom-form-btn {
            padding: 10px 20px;
            font-size: 18px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .custom-btn-primary {
            background-color: #007bff;
        }
        .custom-btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php
session_start(); // Start session for storing success message

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input fields
    $catName = $_POST["custom-username"];
    $catDesc = $_POST["custom-email"];
    
    // Check if all required fields are filled
    if (!empty($catName) && !empty($catDesc)) {
        // Connect to MySQL database
        $servername = "localhost";
        $username = "root"; // Replace with your MySQL username
        $password = ""; // Replace with your MySQL password
        $dbname = "apexsports";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO tbl_category (cat_name, cat_desc) VALUES (?, ?)");
        $stmt->bind_param("ss", $catName, $catDesc);
        
        // Execute SQL statement
        if ($stmt->execute() === TRUE) {
            // Set session variable
            $_SESSION["insertion_success"] = true;
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Both Category Name and Category Desc are required";
    }
}
?>

<?php include 'adminheader.php'; ?>
<?php include 'adminmenu.php'; ?>

<div class="container">
    <div class="custom-form">
        <form id="categoryForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <?php
            if (isset($_SESSION["insertion_success"]) && $_SESSION["insertion_success"]) {
                echo '<div class="alert alert-success" role="alert">Insertion successful!</div>';
                // Unset the session variable after displaying the message
                unset($_SESSION["insertion_success"]);
            }
            ?>
            <div class="custom-form-group">
                <label for="custom-username">Category Name</label>
                <input type="text" class="custom-form-control" id="custom-username" name="custom-username" placeholder="Category Name" required>
                <div class="error-message" id="usernameError"></div>
            </div>
            <div class="custom-form-group">
                <label for="custom-email">Category Desc</label>
                <input type="text" class="custom-form-control" id="custom-email" name="custom-email" placeholder="Category Desc" required>
                <div class="error-message" id="emailError"></div>
            </div>
            <button type="submit" class="custom-form-btn custom-btn-primary">Add Category</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var usernameInput = document.getElementById("custom-username");
        var emailInput = document.getElementById("custom-email");

        // Attach keyup event listener to Category Name input
        usernameInput.addEventListener("keyup", function() {
            validateInput(usernameInput, "Category Name", "usernameError");
        });

        // Attach keyup event listener to Category Desc input
        emailInput.addEventListener("keyup", function() {
            validateInput(emailInput, "Category Desc", "emailError");
        });

        // Function to validate individual input field
        function validateInput(inputElement, fieldName, errorElementId) {
            var inputValue = inputElement.value.trim();
            var errorElement = document.getElementById(errorElementId);
            if (inputValue === "") {
                errorElement.innerText = fieldName + " is required";
            } else {
                errorElement.innerText = "";
            }
        }

        // Form submission validation
        document.getElementById("categoryForm").addEventListener("submit", function(event) {
            // Perform validation before submitting the form
            if (!validateForm()) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });

        // Function to perform overall form validation
        function validateForm() {
            var isValid = true;
            // Check each input field
            if (usernameInput.value.trim() === "") {
                validateInput(usernameInput, "Category Name", "usernameError");
                isValid = false;
            }
            if (emailInput.value.trim() === "") {
                validateInput(emailInput, "Category Desc", "emailError");
                isValid = false;
            }
            return isValid;
        }
    });
</script>
</body>
</html>
