<?php
session_start(); // Start the session

// Include database connection
include "database.php";

// Check if the request is made via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if userId and status parameters are set
    if (isset($_POST["userId"]) && isset($_POST["status"])) {
        // Sanitize input data
        $userId = mysqli_real_escape_string($conn, $_POST["userId"]);
        $status = mysqli_real_escape_string($conn, $_POST["status"]);

        // Update user status in the database
        $sql = "UPDATE tbl_registration SET reg_status = '$status' WHERE reg_id = '$userId'";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['update_status_message'] = "User status updated successfully";
            echo json_encode(array("status" => "success"));
        } else {
            $_SESSION['update_status_message'] = "Error updating user status: " . $conn->error;
            echo json_encode(array("status" => "error", "message" => "Error updating user status"));
        }
    } else {
        $_SESSION['update_status_message'] = "Invalid parameters";
        echo json_encode(array("status" => "error", "message" => "Invalid parameters"));
    }
} else {
    $_SESSION['update_status_message'] = "Invalid request method";
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}

// Close database connection
$conn->close();

// Refresh the page after 0 seconds
header("Refresh:0");
?>
