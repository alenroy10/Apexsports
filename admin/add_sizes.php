
<?php
session_start();
include 'adminheader.php';
include 'adminmenu.php';

?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Sizes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            margin-bottom: 30px;
            text-align: center;
            color: #333;
        }
        .card {
            margin-bottom: 30px;
            box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Sizes</h2>
    <?php include 'database.php';

if (isset($_POST['add'])) {
    // Validate input
    $sizeValue = $_POST['sizeValue'];
    if (empty($sizeValue)) {
        // Handle empty input error
        echo "<div class='alert alert-danger'>Size value is required.</div>";
    } else {
        // Prepare and execute SQL statement to insert size value into the database
        $sql = "INSERT INTO tbl_size (size_value) VALUES ('$sizeValue')";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Size added successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }

        // Close connection
        $conn->close();
    }
}
?>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <!-- Form for adding a new size -->
                    <form id="sizeForm" method="post" action="#">
                        <div class="form-group">
                            <label for="sizeValue">Size Value:</label>
                            <input type="text" class="form-control" id="sizeValue" name="sizeValue" placeholder="Size Value" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="add">Add Size</button>
                    </form>
                </div>
            </div>
            <!-- Success and failure messages will appear here -->
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
