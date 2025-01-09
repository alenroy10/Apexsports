<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Apexsports</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body class="goto-here">
  <?php
	require"header.php"
	?>
    <section class="ftco-section">
    	<div class="container">
    		<div class="row"><?php
    // Include database connection
    include "database.php";

    // Fetch product details from the tbl_product table
    $product_id = $_GET['id']; // Assuming you're passing product id through GET parameter
    $product_sql = "SELECT * FROM tbl_product WHERE pro_id = $product_id";
    $product_result = $conn->query($product_sql);

    if ($product_result->num_rows > 0) {
        // Product found, fetch its details
        $product_row = $product_result->fetch_assoc();
        $product_name = $product_row['pro_name'];
        $product_image = $product_row['pro_img'];
        $product_price = $product_row['pro_price'];
        $product_desc = $product_row['pro_desc'];
		$cat_id = $product_row['cat_id'];
    } else {
        // Product not found
        $product_name = "Product Not Found";
        $product_image = ""; // You can set a default image here
        $product_price = 0;
        $product_desc = "Sorry, the product you are looking for is not available.";
    }
	$category_sql = "SELECT cat_name FROM tbl_category WHERE cat_id = $cat_id";
	$category_result = $conn->query($category_sql);

	if ($category_result->num_rows > 0){
		$category_row = $category_result->fetch_assoc();
		$product_category = $category_row['cat_name']; // Total stock for all sizes
	}
	else {
        // Quantity not found
        $product_category = 0;
    }


	$size_quantity_sql = "SELECT sd.stock, s.size_value FROM tbl_size_details sd 
	INNER JOIN tbl_size s ON sd.size_id = s.size_id
	WHERE sd.pro_id = $product_id";
$size_quantity_result = $conn->query($size_quantity_sql);
if ($size_quantity_result->num_rows > 0){
	$size_row = $size_quantity_result->fetch_assoc();
	$stock = $size_row['stock']; // Total stock for all sizes
}
else {
	// Quantity not found
	$stock = 0;
}
$size_stock_sql = "SELECT sum(sd.stock) AS stockk, s.size_value FROM tbl_size_details sd 
INNER JOIN tbl_size s ON sd.size_id = s.size_id
WHERE sd.pro_id = $product_id";
$size_stock_result = $conn->query($size_stock_sql);
if ($size_stock_result->num_rows > 0){
$sizedet_row = $size_stock_result->fetch_assoc();
$stockk = $sizedet_row['stockk']; // Total stock for all sizes

}
else {
// Quantity not found
$stockk = 0;
}$size_quantity_sql = "SELECT sd.stock, s.size_value FROM tbl_size_details sd 
INNER JOIN tbl_size s ON sd.size_id = s.size_id
WHERE sd.pro_id = $product_id";
$size_quantity_result = $conn->query($size_quantity_sql);
if ($size_quantity_result->num_rows > 0) {
// Reset the pointer to the beginning of the result set
$size_quantity_result->data_seek(0);
$stock = 0; // Initialize total stock for all sizes
while ($size_row = $size_quantity_result->fetch_assoc()) {
	$stock += $size_row['stock']; // Add stock for each size
}
} else {
// Quantity not found
$stock = 0;
}
    // Close database connection
    $conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
<div class="hero-wrap hero-bread" >
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          </div>
        </div>
      </div>
    </div>
    <title><?php echo $product_name; ?></title>
    <!-- Include your meta tags, CSS links, and other headers here -->
</head>
<body class="goto-here">

    <!-- Hero Section -->
    <!-- Include your hero section code here -->

    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <!-- Product Image -->
                <div class="col-lg-6 mb-5 ftco-animate">
                    <a href="uploads/<?php echo $product_image; ?>" class="image-popup prod-img-bg">
                        <img src="uploads/<?php echo $product_image; ?>" class="img-fluid" alt="<?php echo $product_name; ?>">
                    </a>
                </div>
                <!-- Product Details -->
                <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                    <h3><?php echo $product_name; ?></h3>
                  
                    <p class="price"><span>Rs: <?php echo $product_price; ?></span></p>
                    
                    <!-- Product Size Selector -->
					<div class="row mt-4">
					<div class="col-md-6">
    <div class="form-group d-flex">
        <div class="select-wrap">
            <div class="icon"><span class="ion-ios-arrow-down"></span></div>
            <select name="size" id="size" class="form-control" onchange="updateMaxQuantity()">
                <option value="">Select Size</option>
                <?php
                // Populate the select dropdown with available sizes and their respective stock
                if ($size_quantity_result->num_rows > 0) {
                    // Reset the pointer to the beginning of the result set
                    $size_quantity_result->data_seek(0);
                    while ($size_row = $size_quantity_result->fetch_assoc()) {
                        $size_id = $size_row['size_id'];
                        $size_value = $size_row['size_value'];
                        $size_stock = $size_row['stock']; // Stock for the current size
                        echo "<option value='$size_id' data-stock='$size_stock'>$size_value (Stock: $size_stock)</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
</div>

    <div class="col-md-6">
        <div class="input-group">
            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity" min="1" max="100">
        </div>
        <span id="quantity-error" style="color: red;"></span>
    </div>
</div>

<script>
    function updateMaxQuantity() {
        var sizeDropdown = document.getElementById('size');
        var quantityInput = document.getElementById('quantity');
        var selectedOption = sizeDropdown.options[sizeDropdown.selectedIndex];
        var maxStock = parseInt(selectedOption.dataset.stock);
        quantityInput.max = maxStock;
        quantityInput.value = 1; // Reset quantity to 1 when size changes
    }
    
    // Call the function initially to set the maximum quantity based on the default selected size
    updateMaxQuantity();
</script>


                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <?php if ($stockk > 0): ?>
                                <p style="color:green;">Stock available</p>
                            <?php else: ?>
                                <p style="color:red;">Out of Stock</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                    <p><a href="cart.html" class="btn btn-black py-3 px-5 mr-2">Add to Cart</a><a href="cart.html" class="btn btn-primary py-3 px-5">Buy now</a></p>
                </div>

    		<div class="row mt-5">
          <div class="col-md-12 nav-link-wrap">
            <div class="nav nav-pills d-flex text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link ftco-animate active mr-lg-1" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Description</a>

              <a class="nav-link ftco-animate mr-lg-1" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Manufacturer</a>

              <a class="nav-link ftco-animate" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">Reviews</a>

            </div>
          </div>
          <div class="col-md-12 tab-wrap">
            
            <div class="tab-content bg-light" id="v-pills-tabContent">

              <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="day-1-tab">
              	<div class="p-4">
				  <h3 class="mb-4"><?php echo $product_name; ?></h3>
				  <p><?php echo $product_desc; ?></p>
              	</div>
              </div>


              <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-day-2-tab">
              	<div class="p-4">
	              	<h3 class="mb-4">Manufactured By Nike</h3>
	              	<p>On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
              	</div>
              </div>
              <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-day-3-tab">
              	<div class="row p-4">
						   		<div class="col-md-7">
						   			<h3 class="mb-4">23 Reviews</h3>
						   			<div class="review">
								   		<div class="user-img" style="background-image: url(images/person_1.jpg)"></div>
								   		<div class="desc">
								   			<h4>
								   				<span class="text-left">Jacob Webb</span>
								   				<span class="text-right">14 March 2018</span>
								   			</h4>
								   			<p class="star">
								   				<span>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
							   					</span>
							   					<span class="text-right"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
								   			</p>
								   			<p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrov</p>
								   		</div>
								   	</div>
								   	<div class="review">
								   		<div class="user-img" style="background-image: url(images/person_2.jpg)"></div>
								   		<div class="desc">
								   			<h4>
								   				<span class="text-left">Jacob Webb</span>
								   				<span class="text-right">14 March 2018</span>
								   			</h4>
								   			<p class="star">
								   				<span>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
							   					</span>
							   					<span class="text-right"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
								   			</p>
								   			<p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrov</p>
								   		</div>
								   	</div>
								   	<div class="review">
								   		<div class="user-img" style="background-image: url(images/person_3.jpg)"></div>
								   		<div class="desc">
								   			<h4>
								   				<span class="text-left">Jacob Webb</span>
								   				<span class="text-right">14 March 2018</span>
								   			</h4>
								   			<p class="star">
								   				<span>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
							   					</span>
							   					<span class="text-right"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
								   			</p>
								   			<p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrov</p>
								   		</div>
								   	</div>
						   		</div>
						   		<div class="col-md-4">
						   			<div class="rating-wrap">
							   			<h3 class="mb-4">Give a Review</h3>
							   			<p class="star">
							   				<span>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					(98%)
						   					</span>
						   					<span>20 Reviews</span>
							   			</p>
							   			<p class="star">
							   				<span>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					(85%)
						   					</span>
						   					<span>10 Reviews</span>
							   			</p>
							   			<p class="star">
							   				<span>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					(98%)
						   					</span>
						   					<span>5 Reviews</span>
							   			</p>
							   			<p class="star">
							   				<span>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					(98%)
						   					</span>
						   					<span>0 Reviews</span>
							   			</p>
							   			<p class="star">
							   				<span>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					(98%)
						   					</span>
						   					<span>0 Reviews</span>
							   			</p>
							   		</div>
						   		</div>
						   	</div>
              </div>
            </div>
          </div>
        </div>
    	</div>
    </section>
		



  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>

  <script>
		$(document).ready(function(){

		var quantitiy=0;
		   $('.quantity-right-plus').click(function(e){
		        
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        
		        // If is not undefined
		            
		            $('#quantity').val(quantity + 1);

		          
		            // Increment
		        
		    });

		     $('.quantity-left-minus').click(function(e){
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        
		        // If is not undefined
		      
		            // Increment
		            if(quantity>0){
		            $('#quantity').val(quantity - 1);
		            }
		    });
		    
		});
	</script>
    
  </body>
</html>