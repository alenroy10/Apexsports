<?php
session_start();
include "database.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'C:\Xampp\composer\vendor\autoload.php';

// Initialize the error message variable
$login_error_message = "";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['reset'])) {
    // Retrieve form data
    $email = $_POST['email'];

    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT * FROM tbl_registration WHERE reg_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['email'] = $email;
        $_SESSION['otp'] = mt_rand(100000, 999999);
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth   = true;               // Enable SMTP authentication
            $mail->Username   = 'alenroy1001@gmail.com'; // SMTP username
            $mail->Password   = 'wiwl kdws kmtd jhon';    // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
    
            // Recipients
            $mail->setFrom('alenroy1001@gmail.com', 'Mailer');
            $mail->addAddress($_POST['email']); // Add a recipient, using the email from the form
    
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Apex Sports';
            $mail->Body    = 'Your OTP is: ' . $_SESSION['otp'];
    
            $mail->send();
            echo 'Message has been sent';
            header("Location: checkotpp.php");
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Email does not exist, set an error message
        $login_error_message = "Account with this Email does not exist.";
    }
}

// Close connection
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add your meta tags and other headers here -->
</head>
<body>
    <!-- Your HTML content for the forgot password page goes here -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Forgot Password</h2>
                        <form action="#" method="post">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="reset" class="btn btn-primary btn-block">Reset Password</button>
                            </div>
                            <?php if(!empty($login_error_message)): ?>
                            <div class="alert alert-danger" role="alert"><?php echo $login_error_message; ?></div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


<script>
    document.getElementById("toggleConfirmPassword").addEventListener("click", function () {
        var confirmPasswordInput = document.getElementById("re_pass");
        var confirmPasswordFieldType = confirmPasswordInput.getAttribute("type");

        if (confirmPasswordFieldType === "password") {
            confirmPasswordInput.setAttribute("type", "text");
            this.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
        } else {
            confirmPasswordInput.setAttribute("type", "password");
            this.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
        }
    });
</script>

<script>
    document.getElementById("togglePassword").addEventListener("click", function () {
        var passwordInput = document.getElementById("pass");
        var passwordFieldType = passwordInput.getAttribute("type");

        if (passwordFieldType === "password") {
            passwordInput.setAttribute("type", "text");
            this.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
        } else {
            passwordInput.setAttribute("type", "password");
            this.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
        }
    });



    function validateEmail() {
        var email = document.getElementById('email').value.trim();
        var emailRegex = /^(?!\.)(?!.*\.\.)(?=.*[a-zA-Z])[^\s@]{3,}(?<!\d{3,})@(gmail\.com|yahoo\.com|outlook\.com|hotmail\.com|icloud\.com|aol\.com|mail\.com|protonmail\.com|yandex\.com|gmx\.com|zoho\.com)$/;

        if (email === '') {
            document.getElementById('email-error').innerHTML = 'Email is required';
        } else if (!emailRegex.test(email)) {
            document.getElementById('email-error').innerHTML = 'Enter a valid email address';
        } else {
            document.getElementById('email-error').innerHTML = '';
        }
    }
  
    function validatePassword() {
        var password = document.getElementById('pass').value.trim();
        var minPasswordLength = 8;
        var uppercaseRegex = /[A-Z]/;
        var lowercaseRegex = /[a-z]/;
        var numberRegex = /\d/;

        if (password === '') {
            document.getElementById('password-error').innerHTML = 'Password is required';
        } else if (password.length < minPasswordLength) {
            document.getElementById('password-error').innerHTML = 'Password must be at least 8 characters long';
        }else  if (!uppercaseRegex.test(password) || !lowercaseRegex.test(password) || !numberRegex.test(password)) {
            document.getElementById('password-error').innerHTML = 'Password must contain at least one uppercase letter, one lowercase letter, and at least one number';
        }
        else {
            document.getElementById('password-error').innerHTML = '';
        }
    }

</script>

<style>
    .password-input-container {
        position: relative;
    }
    
    .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>


<style>
  body {
    margin: 0;
    font-family: "Open Sans", sans-serif;
    background: #f8f8f8;
  }

  .main {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .signup-content {
    display: flex;
    align-items: stretch; /* Align items vertically */
    justify-content: center;
    width: 100%;
  }

  .signup-form {
    background: #fff;
    padding: 30px;
    width: 100%;
    max-width: 400px;
    border-radius: 10px;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
  }

  .form-title {
    text-align: center;
    color:#000000;
    font-size: 40px;
    font-weight: 700!important;
  }

  .form-group {
    position: relative;
    margin-bottom: 25px;
  }

  .form-group input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
  }

  .form-group label {
    position: absolute;
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
    color: #999;
    font-size: 16px;
    pointer-events: none;
    transition: 0.3s;
  }

  .form-group input:focus + label,
  .form-group input:not(:placeholder-shown) + label {
    top: 10px;
    font-size: 12px;
    color: #6b38e8;
  }

  .form-submit {
    background: #6b38e8;
    color: #fff;
    border: none;
    padding: 15px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
  }

  .signup-image {
    margin-left: 20px;
  }

  .signup-image img {
    width: 100%;
    border-radius: 10px;
  }

  .signup-image-link {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #6b38e8;
    text-decoration: none;
    font-size: 16px;
  }

  @media (max-width: 768px) {
    .signup-content {
      flex-direction: column; /* Stack items vertically on small screens */
      align-items: center;
    }

    .signup-form {
      margin-top: 20px;
    }

    .signup-image {
      margin-left: 0;
      margin-top: 20px;
    }
  }
    .password-input-container {
        position: relative;
    }
    
    .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>




</body>
</html>

