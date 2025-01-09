<?php
// Include database connection
include "database.php";

// Check if product ID is provided in the URL
if(isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Update product status to 1 (deactivated)
    $sql = "UPDATE tbl_product SET pro_status = 1 WHERE pro_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        // Deactivation successful, redirect to manage product page
        header("Location: manageproduct.php");
        exit();
    } else {
        // Error occurred, handle accordingly (e.g., display error message)
        echo "Error: " . $conn->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Product ID not provided, redirect to manage product page
    header("Location: manageproduct.php");
    exit();
}
?>
