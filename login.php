<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['logged_in'])) {
    header("Location: index.php"); // Redirect to index page
    exit();
}
if (isset($_SESSION['login'])) {
  header("Location: admin\admin.php"); // Redirect to index page
  exit();
}

include "database.php";

$hostname = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "apexsports";
$conn = mysqli_connect($hostname, $dbuser, $dbpassword, $dbname);
if (!$conn) {
    die("not connected");
}

$login_error_message = ""; // Initialize login error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate user input (you can add more validation as needed)
    if (empty($email) || empty($password)) {
        $login_error_message = "Please enter both email and password.";
    } else {
        // Sanitize user input to prevent SQL injection
        $email = mysqli_real_escape_string($conn, $email);

        // Query to retrieve hashed password for the given email
        $query = "SELECT * FROM `tbl_registration` WHERE `reg_email`='$email'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                // Fetch user data
                $user_data = mysqli_fetch_assoc($result);

                // Verify hashed password
                if (password_verify($password, $user_data['reg_password'])) {
                    $_SESSION['user_id'] = $user_data['reg_id'];
                    $_SESSION['user_email'] = $user_data['reg_email'];
                    $_SESSION['user_role'] = $user_data['reg_role'];
                    $_SESSION['user_name'] = $user_data['reg_name'];


                    // Set session variable to indicate user is logged in
                   

                    // Redirect based on user role
                    switch ($_SESSION['user_role']) {
                        case 1:

                            $_SESSION['login'] = true;
                            header("Location: admin\admin.php");
                            exit();
                        case 0:
                            $_SESSION['logged_in'] = true;
                            header("Location: index.php");
                            exit();
                        default:
                            $login_error_message = "Invalid user role.";
                            break;
                    }
                } else {
                    $login_error_message = "Invalid email or password.";
                }
            } else {
                $login_error_message = "Invalid email or password.";
            }
        } else {
            $login_error_message = "Error in query: " . mysqli_error($conn);
        }
    }
}
?>

    <?php
    include 'header.php';
    ?>
    <!-- Your HTML content goes here -->

    <div class="half">
        <div class="contents order-2 order-md-1">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-6">
                        <div class="form-block">
                            <form action="#" method="post" onsubmit="validateForm(event)">
                                <div class="form-group first">
                                    <div style="text-align: center; color:#000000;font-size: 40px;font-weight: 700!important;">LOGIN</div>
                                    <?php
                                    // Check if password changed successfully message is set
                                    if (isset($_SESSION['password_changed']) && $_SESSION['password_changed']) {
                                        echo "<p>Password changed successfully.</p>";
                                        // Unset the session variable to avoid showing the message again on page refresh
                                        unset($_SESSION['password_changed']);
                                    }
                                    ?>
                                    <label for="username">Email</label>
                                    <input type="email" class="form-control" placeholder="Email" id="username" name="email">
                                    <span id="email-error" style="color: red;"></span> <!-- Error message for email -->
                                </div>
                                <div class="form-group last mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                                    <span id="password-error" style="color: red;"></span> <!-- Error message for password -->
                                </div>

                                <div class="d-sm-flex mb-5 align-items-center">
                                    <label class="control control--checkbox mb-3 mb-sm-0"><span class="caption">Remember me</span>
                                        <input type="checkbox" checked="checked" />
                                        <div class="control__indicator"></div>
                                    </label>
                                    <span class="ml-auto"><a href="forgotpass.php" class="forgot-pass">Forgot Password</a></span>
                                </div>

                                <input type="submit" style="color:white; background-color:#6195C9;" value="Log In" class="btn btn-block btn-primary">
                                <p class="text-center m-0"> New member?<a href="signup.php" style="color:blue;">Register</a></p>
                                <span id="login-error" style="color: red; display: block; text-align: center;"><?php echo $login_error_message; ?></span> <!-- Error message for invalid login -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateForm(event) {
            var email = document.getElementById('username').value.trim();
            var password = document.getElementById('password').value.trim();

            if (email === "" || password === "") {
                document.getElementById('login-error').innerHTML = 'Please enter both email and password.';
                event.preventDefault();
            }
        }
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <style>
        body {
            font-family: "Roboto", sans-serif;
            background-color: #fff;
        }

        p {
            color: #b3b3b3;
            font-weight: 300;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            font-family: "Roboto", sans-serif;
        }

        a {
            -webkit-transition: .3s all ease;
            -o-transition: .3s all ease;
            transition: .3s all ease;
        }

        a:hover {
            text-decoration: none !important;
        }

        .content {
            padding: 7rem 0;
        }

        h2 {
            font-size: 20px;
        }

        .half,
        .half .container>.row {
            height: 100vh;
            min-height: 700px;
        }

        .half .bg {
            height: 200px;
        }

        @media (max-width: 991.98px) {
            .half .bg {
                height: 200px;
            }
        }

        .half .contents {
            background: #f6f7fc;
        }

        .half .contents,
        .half .bg {
            width: 100%;
        }

        @media (max-width: 1199.98px) {

            .half .contents,
            .half .bg {
                width: 100%;
            }
        }

        .half .contents .form-control,
        .half .bg .form-control {
            border: none;
            border-radius: 4px;
            height: 54px;
            background: #efefef;
        }

        .half .contents .form-control:active,
        .half .contents .form-control:focus,
        .half .bg .form-control:active,
        .half .bg .form-control:focus {
            outline: none;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .half .bg {
            background-size: cover;
            background-position: center;
        }

        .half a {
            color: #888;
            text-decoration: underline;
        }

        .half .btn {
            height: 54px;
            padding-left: 30px;
            padding-right: 30px;
        }

        .half .forgot-pass {
            position: relative;
            top: 2px;
            font-size: 14px;
        }

        .form-block {
            background: #fff;
            padding: 40px;
        }

        @media (max-width: 991.98px) {
            .form-block {
                padding: 25px;
            }
        }

        .control {
            display: block;
            position: relative;
            padding-left: 30px;
            margin-bottom: 15px;
            cursor: pointer;
            font-size: 14px;
        }

        .control .caption {
            position: relative;
            top: .2rem;
            color: #888;
        }

        .control input {
            position: absolute;
            z-index: -1;
            opacity: 0;
        }

        .control__indicator {
            position: absolute;
            top: 2px;
            left: 0;
            height: 20px;
            width: 20px;
            background: #e6e6e6;
            border-radius: 4px;
        }

        .control--radio .control__indicator {
            border-radius: 50%;
        }

        .control:hover input~.control__indicator,
        .control input:focus~.control__indicator {
            background: #ccc;
        }

        .control input:checked~.control__indicator {
            background: #fb771a;
        }

        .control:hover input:not([disabled]):checked~.control__indicator,
        .control input:checked:focus~.control__indicator {
            background: #fb8633;
        }

        .control input:disabled~.control__indicator {
            background: #e6e6e6;
            opacity: 0.9;
            pointer-events: none;
        }

        .control__indicator:after {
            font-family: 'icomoon';
            content: '\e5ca';
            position: absolute;
            display: none;
            font-size: 16px;
            -webkit-transition: .3s all ease;
            -o-transition: .3s all ease;
            transition: .3s all ease;
        }

        .control input:checked~.control__indicator:after {
            display: block;
            color: #fff;
        }

        .control--checkbox .control__indicator:after {
            top: 50%;
            left: 50%;
            margin-top: -1px;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .control--checkbox input:disabled~.control__indicator:after {
            border-color: #7b7b7b;
        }

        .control--checkbox input:disabled:checked~.control__indicator {
            background-color: #7e0cf5;
            opacity: .2;
        }
    </style>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
