<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include 'database.php';

    // Escape user inputs for security
    $catId = mysqli_real_escape_string($conn, $_POST['catId']);
    $catName = mysqli_real_escape_string($conn, $_POST['catName']);
    $catDesc = mysqli_real_escape_string($conn, $_POST['catDesc']);
    $catStatus = mysqli_real_escape_string($conn, $_POST['catStatus']);

    // Update category in the database
    $sql = "UPDATE tbl_category SET cat_name='$catName', cat_desc='$catDesc', cat_status='$catStatus' WHERE cat_id='$catId'";

    if ($conn->query($sql) === TRUE) {
        // Category updated successfully
        header("Location: managecategory.php");
        exit();
    } else {
        // Error updating category
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
} else {
    // Redirect to managecategory.php if accessed directly
    header("Location: managecategory.php");
    exit();
}
?>
