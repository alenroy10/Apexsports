<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stock</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            max-width: 500px;
            margin: auto;
            
        }
        .container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .product-option {
            display: flex;
            align-items: center;
        }.invalid-feedback {
            color: #dc3545;
            margin-top: 5px;
            display: none;
        }
        .product-image {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }
        .invalid-feedback {
            color: #dc3545;
        }
        .hii{
           width: 500px;
           height:600px;
        }
    </style>
</head>
<body>
    <?php
        include 'adminheader.php';
        include 'adminmenu.php';
    ?>
    <div class="container mt-5">
        <div class="hii">
        <h2 class="text-center mb-4">Add Stock</h2>
        <form action="add_stock.php" method="POST" id="stockForm">
            <div class="form-group">
                <label for="product">Product:</label>
                <select class="form-control" id="product" name="product">
                    <?php
                        // Include database connection
                        include "database.php";

                        // Query to fetch products from tbl_product
                        $sql = "SELECT pro_id, pro_name, pro_img FROM tbl_product";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Output data of each row as options
                            while ($row = $result->fetch_assoc()) {
                                // Check if the image path is not empty
                                $imagePath = !empty($row["pro_img"]) ? $row["pro_img"] : 'placeholder_image.jpg';
                                
                                echo "<option value='" . $row["pro_id"] . "' class='product-option' data-image='" . $imagePath . "'>";
                                echo "<img src='" . $imagePath . "' class='product-image'>";
                                echo $row["pro_name"] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No products found</option>";
                        }

                        // Close database connection
                        $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="size">Size:</label>
                <select class="form-control" id="size" name="size">
                    <?php
                        // Include database connection
                        include "database.php";

                        // Query to fetch sizes from tbl_size
                        $sql = "SELECT size_id, size_value FROM tbl_size";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Output data of each row as options
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["size_id"] . "'>" . $row["size_value"] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No sizes found</option>";
                        }

                        // Close database connection
                        $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" class="form-control" id="stock" name="stock" onkeyup="validateStock()" required>
                <span class="invalid-feedback" id="stockError">Stock cannot be negative.</span>
            </div>
            <button type="submit" class="btn btn-primary">Add Stock</button>
            <?php
// Check if a message is set in the URL
if (isset($_GET["message"])) {
    $message = $_GET["message"];
    echo "<p>{$message}</p>";
}
?>

        </form>
    </div>    </div>


    <!-- Script to dynamically add product images to select options -->
    <script>
        // Get all product options
        const productOptions = document.querySelectorAll('#product option');

        // Loop through each option and add image before text
        productOptions.forEach(option => {
            const productId = option.value;
            const productImage = option.getAttribute('data-image');
            option.innerHTML = `<img src="${productImage}" class="product-image"> ${option.textContent}`;
        });

        // Validate stock field on keyup
        function validateStock() {
            const stockInput = document.getElementById('stock');
            const stockError = document.getElementById('stockError');

            if (parseInt(stockInput.value) < 0) {
                stockInput.classList.add('is-invalid');
                stockError.style.display = 'block';
            } else {
                stockInput.classList.remove('is-invalid');
                stockError.style.display = 'none';
            }
        }

        // Validate form on submit
        document.getElementById('stockForm').addEventListener('submit', function(event) {
            const stockInput = document.getElementById('stock');
            if (!stockInput.checkValidity() || parseInt(stockInput.value) < 0) {
                event.preventDefault();
                event.stopPropagation();
                stockInput.classList.add('is-invalid');
                document.getElementById('stockError').style.display = 'block';
            }
            stockInput.classList.add('was-validated');
        });
    </script>
</body>
</html>