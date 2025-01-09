<?php
// Include database connection
include "database.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $productId = $_POST["pro_id"];
    $productName = $_POST["pro_name"];
    $categoryId = $_POST["cat_id"];
    $price = $_POST["pro_price"];
    $discount = $_POST["pro_discount"];
    $description = $_POST["pro_desc"];
    $featured = isset($_POST["pro_featured"]) ? 1 : 0;
    $status = $_POST["pro_status"];
    $disstatus = $_POST["pro_dis_status"];


    // Prepare and bind parameters for the update query
    $stmt = $conn->prepare("UPDATE tbl_product SET pro_name=?, cat_id=?, pro_price=?, pro_discount=?, pro_desc=?, pro_featured=?, pro_status=?, pro_dis_status=? WHERE pro_id=?");
    $stmt->bind_param("siidsiiii", $productName, $categoryId, $price, $discount, $description, $featured, $status, $disstatus, $productId);

    // Execute the update query
    if ($stmt->execute()) {
        // Redirect back to the manageproduct.php page
        header("Location: manageproduct.php");
        exit();
    } else {
        echo "Error updating product: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>
