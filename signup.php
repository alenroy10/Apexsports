<?php
session_start();
include "database.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'C:\Xampp\composer\vendor\autoload.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['signup'])) {
    // Retrieve form data
    $_SESSION['name'] = $_POST['name'];
    $password = $_POST['pass']; // Don't hash the password here

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $_SESSION['pass'] = $hashed_password; // Store the hashed password
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['mobile'] = $_POST['mobile'];
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
        header("Location: checkotp.php");
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    // If email sending fails, you can display an error message here
    // Or you can redirect to a different page if desired
}

// Close connection
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Apex-Sports</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.3/components/logins/login-12/assets/css/login-12.css">
 
</head>
<body class="goto-here">
<?php
require "header.php";
?>

<div class="main">
    <section class="signup">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title">REGISTRATION</h2>
                    <?php if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) { ?>
                        <span style='color:green; align-text:centre;'>Registration successful! <a style='color: red;' href='login.php'>Login</a></span>
                    <?php 
                        unset($_SESSION['registration_success']);
                    }
                    session_destroy();
                    ?>
                    <?php if (isset($_SESSION['email_exists']) && $_SESSION['email_exists']) { ?>
                        <div style='color: red;'>Email already exists.</div>
                        <?php 
                        unset($_SESSION['email_exists']); // Clear the session variable
                    }
                    ?>
                   <form action="#" class="register-form" id="register-form" onsubmit="return validateForm()" name="signup" method="post">
                        <div class="form-group">
                            <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="name" id="name" placeholder="Your Name" onkeyup="validateName()">
                            <span style="color:red;" id="name-error" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="email"><i class="zmdi zmdi-email"></i></label>
                            <input type="email" name="email" id="email" placeholder="Your Email" required onkeyup="validateEmail()">
                            <span style="color:red;" id="email-error" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                            <div class="password-input-container">
                                <input type="password" name="pass" id="pass" placeholder="Password" onkeyup="validatePassword()">
                                <span class="toggle-password" id="togglePassword">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </span>
                            </div>
                            <span style="color:red;" id="password-error" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="re_pass"><i class="zmdi zmdi-lock-outline"></i></label>
                            <div class="password-input-container">
                                <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password" onkeyup="validatePasswordMatch()">
                                <span class="toggle-password" id="toggleConfirmPassword">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </span>
                            </div>
                            <span style="color:red;" id="password-match-error" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="Mobile Number"><i class="zmdi zmdi-email"></i></label>
                            <input type="text" name="mobile" id="mobile" placeholder="Your Phone Number" onkeyup="validateMobile()">
                            <span style="color:red;" id="mobile-error" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <div style="color:red;" id="validation-message"></div>
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                        </div>
                       <p class="text-center m-0"> Already a member?<a href="login.php" style="color:blue;"  onsubmit=validatefun()>Log In</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
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
</script>

<script>
function validateForm() {
    // Perform all validation checks
    var isNameValid = validateName();
    var isEmailValid = validateEmail();
    var isPasswordValid = validatePassword();
    var doPasswordsMatch = validatePasswordMatch();
    var isMobileValid = validateMobile();

    // If any validation fails, return false to prevent form submission
    if (!isNameValid || !isEmailValid || !isPasswordValid || !doPasswordsMatch || !isMobileValid) {
        return false;
    }

    // All validations passed, allow form submission
    return true;
}

function validateName() {
        var pname = document.getElementsByName('name')[0].value;
        var nameerror = document.getElementById('name-error');

        nameerror.innerHTML = ""; // Clear previous error messages

        // Presence check
        if (pname.trim() === "") {
            nameerror.innerHTML = " Name is required";
            return false;
        }
        if (pname.charAt(0) === " ") {
            nameerror.innerHTML = "Cannot start with a space";
        return false;
    }

        // Check for invalid characters
        var invalidCharsRegex = /[^a-zA-Z\s]/;
        if (invalidCharsRegex.test(pname)) {
            nameerror.innerHTML = "Invalid characters entered";
            return false;
        }
        var consecutiveSpacesRegex = /\s{2,}/;
        if (consecutiveSpacesRegex.test(pname)) {
            nameerror.innerHTML = "Your name should only contain single spaces";
            return false;
        }
        // All validations passed
        return true;
    }




 
   
function validateMobile() {
    var mobile = document.getElementById("mobile");
    var errorSpan = document.getElementById("mobile-error");
    // Clear any previous error messages
    errorSpan.innerHTML = "";
    if (mobile.value.trim() === "") {
        errorSpan.innerHTML = "phone number is required";
        return false;
    }
    // Regular expression for a valid Indian phone number
    var phoneNumberRegex = /^[6-9](?:(?!(\d)\1{3})\d){9}$/;

    if (!phoneNumberRegex.test(mobile.value)) {
        errorSpan.innerHTML = "Enter a valid phone number";
        return false;
    }

    // If the phone number is valid, clear the error message
    return true;
}

    function validateEmail() {
        var email = document.getElementById('email').value.trim();
        var emailRegex = /^(?!\.)(?!.*\.\.)(?=.*[a-zA-Z])[^\s@]{3,}(?<!\d{5,})@(gmail\.com|yahoo\.com|outlook\.com|hotmail\.com|icloud\.com|aol\.com|mail\.com|protonmail\.com|yandex\.com|gmx\.com|zoho\.com)$/;

        if (email === '') {
            document.getElementById('email-error').innerHTML = 'Email is required';
            return false;

        } else if (!emailRegex.test(email)) {
            document.getElementById('email-error').innerHTML = 'Enter a valid email address';
            return false;

        } else {
            document.getElementById('email-error').innerHTML = '';
            return true;

        }
        return true;


    }
  
    function validatePassword() {
        var password = document.getElementById('pass').value.trim();
        var minPasswordLength = 8;
        var uppercaseRegex = /[A-Z]/;
        var lowercaseRegex = /[a-z]/;
        var numberRegex = /\d/;

        if (password === '') {
            document.getElementById('password-error').innerHTML = 'Password is required';
            return false;

        } else if (password.length < minPasswordLength) {
            document.getElementById('password-error').innerHTML = 'Password must be at least 8 characters long';
            return false;

        }else  if (!uppercaseRegex.test(password) || !lowercaseRegex.test(password) || !numberRegex.test(password)) {
            document.getElementById('password-error').innerHTML = 'Password must contain at least one uppercase letter, one lowercase letter, and at least one number';
            return false;

        }
        else {
            document.getElementById('password-error').innerHTML = '';
            return true;

        }
        return true;

    }

    function validatePasswordMatch() {
        var password = document.getElementById('pass').value.trim();
        var confirmPassword = document.getElementById('re_pass').value.trim();

        if (password !== confirmPassword) {
            document.getElementById('password-match-error').innerHTML = 'Passwords do not match';
            return false;

        } else {
            document.getElementById('password-match-error').innerHTML = '';
            return true;

        }
        return true;

    }

</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#email').blur(function(){
        var email = $(this).val();
        $.ajax({
            type: "POST",
            url: "check_email.php",
            data: {'email': email},
            success: function(response){
                if(response == 'exists'){
                    $('#email-error').text('Email already exists');
                } else if(response == 'available'){
                    $('#email-error').text('');
                } else {
                    $('#email-error').text('Error occurred while checking email');
                }
            }
        });
    });
});
</script>

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



</style>



</body>
</html>

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




