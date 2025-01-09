<?php
// Start session
session_start();

// Check if session email is set
if (!isset($_SESSION['email'])) {
    // Redirect the user back to the forgot password page if session email is not set
    header("Location: forgotpass.php");
    exit();
}

include "database.php";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize $stmt
$stmt = null;

if (isset($_POST['change'])) {
    $new_password = $_POST['pass'];
    $confirm_password = $_POST['re_pass'];
    $email = isset($_GET['email']) ? $_GET['email'] : $_SESSION['email']; // Use session email here

    // Check if passwords match
    if ($new_password === $confirm_password) {
        // Validate password strength
        if (strlen($new_password) < 8 || !preg_match('/[A-Z]/', $new_password) || !preg_match('/[a-z]/', $new_password) || !preg_match('/\d/', $new_password)) {
            echo "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.";
            exit();
        }
        
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Prepare statement
        $stmt = $conn->prepare("UPDATE tbl_registration SET reg_password = ? WHERE reg_email = ?");
        if (!$stmt) {
            echo "Error preparing statement: " . $conn->error;
            exit();
        }
        
        // Bind parameters
        $stmt->bind_param("ss", $hashed_password, $email);
        
        // Execute statement
        if ($stmt->execute()) {
           // Password updated successfully
          $_SESSION['password_changed'] = true;
          header("Location: login.php");
exit();

        } else {
            // Error updating password
            echo "Error updating password: " . $stmt->error;
        }
    } else {
        // Passwords don't match
        echo "Passwords don't match.";
    }
}

// Close statement if it's not null
if ($stmt !== null) {
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Change Password</h2>
                        <form action="#" id="change-password-form" method="post">
                            <div class="form-group">
                                <label for="pass">Password</label>
                                <div class="input-group">
                                    <input type="password" name="pass" id="pass" class="form-control" placeholder="Password" onkeyup="validatePasswords()">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" id="togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <span style="color:red;" id="password-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="re_pass">Repeat Password</label>
                                <div class="input-group">
                                    <input type="password" name="re_pass" id="re_pass" class="form-control" placeholder="Repeat your password" onkeyup="validatePasswords()">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" id="toggleConfirmPassword"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <span style="color:red;" id="password-match-error" class="error-message"></span>
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" name="change" class="btn btn-primary" value="Change Password">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
document.getElementById("togglePassword").addEventListener("click", function () {
    var passwordInput = document.getElementById("pass");
    var passwordFieldType = passwordInput.getAttribute("type");

    if (passwordFieldType === "password") {
        passwordInput.setAttribute("type", "text");
        this.querySelector("i").classList.remove("fa-eye");
        this.querySelector("i").classList.add("fa-eye-slash");
    } else {
        passwordInput.setAttribute("type", "password");
        this.querySelector("i").classList.remove("fa-eye-slash");
        this.querySelector("i").classList.add("fa-eye");
    }
});

document.getElementById("toggleConfirmPassword").addEventListener("click", function () {
    var confirmPasswordInput = document.getElementById("re_pass");
    var confirmPasswordFieldType = confirmPasswordInput.getAttribute("type");

    if (confirmPasswordFieldType === "password") {
        confirmPasswordInput.setAttribute("type", "text");
        this.querySelector("i").classList.remove("fa-eye");
        this.querySelector("i").classList.add("fa-eye-slash");
    } else {
        confirmPasswordInput.setAttribute("type", "password");
        this.querySelector("i").classList.remove("fa-eye-slash");
        this.querySelector("i").classList.add("fa-eye");
    }
});

function validatePasswords() {
    var password = document.getElementById('pass').value.trim();
    var confirmPassword = document.getElementById('re_pass').value.trim();
    var passwordError = document.getElementById('password-error');
    var passwordMatchError = document.getElementById('password-match-error');

    if (password === '') {
        passwordError.textContent = 'Password is required';
    } else if (password.length < 8 || !/\d/.test(password) || !/[a-z]/.test(password) || !/[A-Z]/.test(password)) {
        passwordError.textContent = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number';
    } else {
        passwordError.textContent = '';
    }

    if (confirmPassword !== password) {
        passwordMatchError.textContent = 'Passwords do not match';
    } else {
        passwordMatchError.textContent = '';
    }
}
</script>
<script>
    document.getElementById("change-password-form").addEventListener("submit", function (event) {
    var password = document.getElementById('pass').value.trim();
    var confirmPassword = document.getElementById('re_pass').value.trim();
    var passwordError = document.getElementById('password-error');
    var passwordMatchError = document.getElementById('password-match-error');

    if (password === '' || confirmPassword === '') {
        passwordError.textContent = 'Password fields cannot be empty';
        event.preventDefault(); // Prevent form submission
    } else if (password.length < 8 || !/\d/.test(password) || !/[a-z]/.test(password) || !/[A-Z]/.test(password)) {
        passwordError.textContent = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number';
        event.preventDefault(); // Prevent form submission
    } else if (confirmPassword !== password) {
        passwordMatchError.textContent = 'Passwords do not match';
        event.preventDefault(); // Prevent form submission
    }
});

    </script>
<style>
.toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 1;
}

.toggle-password i {
    color: #555; 
}

.toggle-password:hover i {
    color: #6b38e8 !important; 
}
    body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f8f8f8;
}

.main {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.change-password {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-title {
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 16px;
    color: #555;
    margin-bottom: 5px;
}

.form-group input[type="password"] {
    width: calc(100% - 40px); /* Adjust based on the width of the eye icon and padding */
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.password-input-container {
    position: relative;
}

.form-submit {
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #6b38e8;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.form-submit:hover {
    background-color: #542ee5;
}

    </style>