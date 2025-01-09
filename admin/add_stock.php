<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include "database.php";

    // Get form data
    $productId = $_POST["product"];
    $sizeId = $_POST["size"];
    $stockToAdd = $_POST["stock"];

    // Query to retrieve current stock value from tbl_size_details
    $sqlSelect = "SELECT stock FROM tbl_size_details WHERE pro_id = ? AND size_id = ?";
    $stmtSelect = $conn->prepare($sqlSelect);
    $stmtSelect->bind_param("ii", $productId, $sizeId);
    $stmtSelect->execute();
    $stmtSelect->store_result();

    if ($stmtSelect->num_rows > 0) {
        // If record exists, update stock value
        $stmtSelect->bind_result($currentStock);
        $stmtSelect->fetch();
        $newStock = $currentStock + $stockToAdd;

        // Prepare and bind parameters for update
        $stmtUpdate = $conn->prepare("UPDATE tbl_size_details SET stock = ? WHERE pro_id = ? AND size_id = ?");
        $stmtUpdate->bind_param("iii", $newStock, $productId, $sizeId);

        // Execute the update statement
        if ($stmtUpdate->execute()) {
            // Close statements and database connection
            $stmtSelect->close();
            $stmtUpdate->close();
            $conn->close();

            // Redirect back to managestock.php with success message
            header("Location: managestock.php?message=Stock added successfully");
            exit();
        } else {
            echo "Error updating stock: " . $stmtUpdate->error;
        }
    } else {
        // If no record exists, insert a new one
        $stmtSelect->close();

        // Prepare and bind parameters for insert
        $stmtInsert = $conn->prepare("INSERT INTO tbl_size_details (pro_id, size_id, stock) VALUES (?, ?, ?)");
        $stmtInsert->bind_param("iii", $productId, $sizeId, $stockToAdd);

        // Execute the insert statement
        if ($stmtInsert->execute()) {
            // Close statements and database connection
            $stmtInsert->close();
            $conn->close();

            // Redirect back to managestock.php with success message
            header("Location: managestock.php?message=Stock added successfully");
            exit();
        } else {
            echo "Error inserting stock: " . $stmtInsert->error;
        }
    }

    // Close database connection
    $conn->close();
}
?>
