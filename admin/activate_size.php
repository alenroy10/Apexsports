<?php
session_start();

// Check if size_id is provided in the URL
if(isset($_GET['size_id'])) {
    // Retrieve the size_id from the URL
    $size_id = $_GET['size_id'];

    // Include the database connection file
    include "database.php";

    // Prepare an UPDATE statement to set size_status to 0 (active)
    $stmt = $conn->prepare("UPDATE tbl_size SET size_status = 0 WHERE size_id = ?");

    // Bind the parameter
    $stmt->bind_param("i", $size_id);

    // Execute the statement
    $stmt->execute();

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();

    // Redirect back to the page from where the activate request came
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
} else {
    // Set error message in session if size_id is not provided
    $_SESSION['activate_error'] = "Size ID not provided";
    // Redirect back to the page from where the activate request came
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
?>
