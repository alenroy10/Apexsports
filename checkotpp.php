<?php
session_start();

// Check if the email and OTP session variables are set
if (!isset($_SESSION['email']) || !isset($_SESSION['otp'])) {
    // Redirect the user back to the forgot password page if session variables are not set
    header("Location: forgotpass.php");
    exit();
}

// Initialize error message variable
$otp_error_message = "";

// Check if the form is submitted
if (isset($_POST['checkotpp'])) {
    // Retrieve form data
    $entered_otp = $_POST['otp'];

    // Verify entered OTP
    if ($_SESSION['otp'] == $entered_otp) {
        // OTP is correct, redirect to reset password page with email in session
        $_SESSION['email'] = $_SESSION['email']; // Store email in session
        header("Location: newpassword.php");
        exit();
    } else {
        // OTP is incorrect, set error message
        $otp_error_message = "Invalid OTP. Please try again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check OTP</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add your meta tags and other headers here -->
</head>

<body>
    <!-- Your HTML content for the OTP verification page goes here -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Verify OTP</h2>
                        <form action="#" method="post">
                            <div class="form-group">
                                <input type="text" name="otp" class="form-control" placeholder="Enter OTP" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="checkotpp" class="btn btn-primary btn-block">Verify OTP</button>
                            </div>
                            <?php if (!empty($otp_error_message)): ?>
                                <div class="alert alert-danger" role="alert"><?php echo $otp_error_message; ?></div>
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


    <style>
  /* OTP Box Styles */
.otp-box {
    width: 100%;
    max-width: 400px;
    padding: 30px;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    text-align: center;
    margin: 0 auto;
}

.billing-heading {
    font-size: 24px;
    color: black;
    margin-bottom: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-control {
    width: calc(100% - 30px); /* Adjust width to fit padding */
    padding: 15px;
    border: none;
    border-radius: 5px;
    background-color: white;
    color: #000000; /* Set font color to black */
    font-size: 16px;
    
}

.form-control:focus {
    outline: none;
    background-color: #ffffff;
    border-color: black;
}

#login {
    width: calc(100% - 30px); /* Adjust width to fit padding */
    padding: 15px;
    border: none;
    border-radius: 5px;
    background-color: #6b38e8;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

#login:hover {
    background-color: #5632a9;
}

</style>

</body>

</html>