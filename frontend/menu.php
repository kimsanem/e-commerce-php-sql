<?php
// Start the current user session (required for login system)
session_start();
// Include your database connection file
//include 'auth/database.php';
$conn = new mysqli('localhost', 'root', '', 'php_ecommerce');


//  ADD TO CART HANDLER
if (isset($_POST['add_to_cart'])) {

    // Redirect if not logged in
    if (!isset($_SESSION['user'])) {
        header("Location: auth/login.php");
        exit();
    }

    // Logged-in user's ID
    $user_id = $_SESSION['user']['id'];

    // Get product data sent from the form
    $name    = $_POST['product_name'];
    $price   = $_POST['product_price'];
    $image   = $_POST['product_image'];

    // Insert new cart row (no quantity column)
    // Prepare an SQL statement to avoid SQL injection
    $stmt = $conn->prepare("
        INSERT INTO cart (user_id, product_name, product_price, product_image) 
        VALUES (?, ?, ?, ?)
    ");

    // Bind values to SQL statement (i = integer, s = string)
    $stmt->bind_param("isis", $user_id, $name, $price, $image);

    // Execute and show SQL error if something fails
    if (!$stmt->execute()) {
        echo "<pre>SQL ERROR: " . $stmt->error . "</pre>";
        exit();
    }

    // Redirect back to menu after adding to cart
    header("Location: menu.php?added=1");
    exit();
}
?>



<!-- HIDDEN ADD TO CART FORM -->
<form id="cartForm" method="POST" action="menu.php" style="display:none;">
    <input type="hidden" name="add_to_cart" value="1">
    <input type="hidden" name="product_name" id="product_name">
    <input type="hidden" name="product_price" id="product_price">
    <input type="hidden" name="product_image" id="product_image">
</form>

<script>
    function addToCart(name, price, image) {
        document.getElementById("product_name").value = name;
        document.getElementById("product_price").value = price;
        document.getElementById("product_image").value = image;
        document.getElementById("cartForm").submit();
    }
</script>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Kimsan Grocery Store</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">

    <link rel="stylesheet" href="assets/css/aos.css">

    <link rel="stylesheet" href="assets/css/ionicons.min.css">

    <link rel="stylesheet" href="assets/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="assets/css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/icomoon.css">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
  	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
          <a class="navbar-brand" href="index.html">Kimsan<small>Grocery</small></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active"><a href="index.html" class="nav-link">Home</a></li>
				<li class="nav-item"><a href="menu.php" class="nav-link">Menu</a></li>
				<li class="nav-item"><a href="services.html" class="nav-link">Services</a></li>
				<li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
			   
				<li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
                <li class="nav-item cart"><a href="cart.php" class="nav-link"><span class="icon icon-shopping_cart"></span></a></li>
                <li class="nav-item"><a href="auth/logout.php" class="nav-link">Logout</a></li>
  
			  </ul>
	      </div>
		  </div>
	  </nav>
    <!-- END nav -->

    <section class="home-slider owl-carousel">

      <div class="slider-item" style="background-image: url(assets/img/bg.jpg);" data-stellar-background-ratio="0.5">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center">

            <div class="col-md-7 col-sm-12 text-center ftco-animate">
            	<h1 class="mb-3 mt-5 bread">Our Menu</h1>
	            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Menu</span></p>
            </div>

          </div>
        </div>
      </div>
    </section>


    <section class="ftco-section">
    	<div class="container">
        <div class="row">
        	<div class="col-md-6">
        		<h3 class="mb-5 heading-pricing ftco-animate">Beverages</h3>
        		<div class="pricing-entry d-flex ftco-animate">
        			<div class="img" style="background-image: url(assets/img/drink1.avif);"></div>
        			<div class="desc pl-3">
	        			<div class="d-flex text align-items-center">
	        				<h3><span>Monster Energy Drink</span></h3>
	        				<span class="price">៛10000</span>
	        			</div>
        			</div>
        		</div>
        		<div class="pricing-entry d-flex ftco-animate">
        			<div class="img" style="background-image: url(assets/img/drink2.avif);"></div>
        			<div class="desc pl-3">
	        			<div class="d-flex text align-items-center">
	        				<h3><span>Red Bull Energy Drink (250 ml)</span></h3>
	        				<span class="price">៛8000</span>
	        			</div>
	        		</div>
        		</div>
        		<div class="pricing-entry d-flex ftco-animate">
        			<div class="img" style="background-image: url(assets/img/drink3.avif);"></div>
        			<div class="desc pl-3">
	        			<div class="d-flex text align-items-center">
	        				<h3><span>Appy Fizz Sparkling Drink (Apple Flavoured)</span></h3>
	        				<span class="price">៛2500</span>
	        			</div>
	        		</div>
        		</div>
        		<div class="pricing-entry d-flex ftco-animate">
        			<div class="img" style="background-image: url(assets/img/drink4.avif);"></div>
        			<div class="desc pl-3">
	        			<div class="d-flex text align-items-center">
	        				<h3><span>Coca-Cola Soft Drink</span></h3>
	        				<span class="price">$2000</span>
	        			</div>
	        		</div>
        		</div>
        	</div>

        	<div class="col-md-6">
        		<h3 class="mb-5 heading-pricing ftco-animate">Personal Care</h3>
        		<div class="pricing-entry d-flex ftco-animate">
        			<div class="img" style="background-image: url(assets/img/shampoo1.avif);"></div>
        			<div class="desc pl-3">
	        			<div class="d-flex text align-items-center">
	        				<h3><span>Lux Lavender & Vitamin C Brightening Body Wash</span></h3>
	        				<span class="price">៛25000</span>
	        			</div>
	        		</div>
        		</div>
        		<div class="pricing-entry d-flex ftco-animate">
        			<div class="img" style="background-image: url(assets/img/shampoo2.avif);"></div>
        			<div class="desc pl-3">
	        			<div class="d-flex text align-items-center">
	        				<h3><span>Tresemme Keratin Smooth Shampoo</span></h3>
	        				<span class="price">៛17500</span>
	        			</div>
	        		</div>
        		</div>
        		<div class="pricing-entry d-flex ftco-animate">
        			<div class="img" style="background-image: url(assets/img/shampoo5.avif);"></div>
        			<div class="desc pl-3">
	        			<div class="d-flex text align-items-center">
	        				<h3><span>MCaffeine Tan Removal Coffee Body Scrub</span></h3>
	        				<span class="price">៛22000</span>
	        			</div>
	        		</div>
        		</div>
        		<div class="pricing-entry d-flex ftco-animate">
        			<div class="img" style="background-image: url(assets/img/shampoo4.avif);"></div>
        			<div class="desc pl-3">
	        			<div class="d-flex text align-items-center">
	        				<h3><span>Parachute 100% Pure Coconut Oil</span></h3>
	        				<span class="price">៛18000</span>
	        			</div>
	        		</div>
        		</div>
        	</div>

            <div class="col-md-6">
                <h3 class="mb-5 heading-pricing ftco-animate">Fruit and Vegetable</h3>
                <div class="pricing-entry d-flex ftco-animate">
                    <div class="img" style="background-image: url(assets/img/veg1.avif);"></div>
                    <div class="desc pl-3">
                        <div class="d-flex text align-items-center">
                            <h3><span>Garlic</span></h3>
                            <span class="price">៛1000</span>
                        </div>
                    </div>
                </div>
                <div class="pricing-entry d-flex ftco-animate">
                    <div class="img" style="background-image: url(assets/img/veg2.avif);"></div>
                    <div class="desc pl-3">
                        <div class="d-flex text align-items-center">
                            <h3><span>Lemon</span></h3>
                            <span class="price">៛2000</span>
                        </div>
                    </div>
                </div>
                <div class="pricing-entry d-flex ftco-animate">
                    <div class="img" style="background-image: url(assets/img/veg4.avif);"></div>
                    <div class="desc pl-3">
                        <div class="d-flex text align-items-center">
                            <h3><span>Potato</span></h3>
                            <span class="price">៛2000</span>
                        </div>
                    </div>
                </div>
                <div class="pricing-entry d-flex ftco-animate">
                    <div class="img" style="background-image: url(assets/img/veg6.avif);"></div>
                    <div class="desc pl-3">
                        <div class="d-flex text align-items-center">
                            <h3><span>Mango</span></h3>
                            <span class="price">៛2000</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <h3 class="mb-5 heading-pricing ftco-animate">Cleaning Essentials</h3>
                <div class="pricing-entry d-flex ftco-animate">
                    <div class="img" style="background-image: url(assets/img/clean1.avif);"></div>
                    <div class="desc pl-3">
                        <div class="d-flex text align-items-center">
                            <h3><span>Comfort Perfume Deluxe Mystique Fabric Conditioner</span></h3>
                            <span class="price">៛13000</span>
                        </div>
                    </div>
                </div>
                <div class="pricing-entry d-flex ftco-animate">
                    <div class="img" style="background-image: url(assets/img/clean2.avif);"></div>
                    <div class="desc pl-3">
                        <div class="d-flex text align-items-center">
                            <h3><span>Surf Excel Easy Wash Detergent Powder - 7 kg</span></h3>
                            <span class="price">៛9000</span>
                        </div>
                    </div>
                </div>
                <div class="pricing-entry d-flex ftco-animate">
                    <div class="img" style="background-image: url(assets/img/clean3.avif);"></div>
                    <div class="desc pl-3">
                        <div class="d-flex text align-items-center">
                            <h3><span>Vim Lemon Dishwash Gel (500 ml)</span></h3>
                            <span class="price">៛8000</span>
                        </div>
                    </div>
                </div>
                <div class="pricing-entry d-flex ftco-animate">
                    <div class="img" style="background-image: url(assets/img/clean4.avif);"></div>
                    <div class="desc pl-3">
                        <div class="d-flex text align-items-center">
                            <h3><span>Harpic Disinfectant Liquid Toilet Cleaner - (Original)</span></h3>
                            <span class="price">៛17500</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    	</div>
    </section>

    <section class="ftco-menu mb-5 pb-5">
    	<div class="container">
    		<div class="row justify-content-center mb-5">
          <div class="col-md-7 heading-section text-center ftco-animate">
          	<span class="subheading">Discover</span>
            <h2 class="mb-4">Our Products</h2>
            <p>Every product is sourced responsibly and vetted for quality. We partner with trusted suppliers to ensure freshness, consistency, and top-tier standards. You get products that meet real-world expectations, not marketing hype.</p>
          </div>
        </div>
    		<div class="row d-md-flex">
	    		<div class="col-lg-12 ftco-animate p-md-5">
		    		<div class="row">
		          <div class="col-md-12 nav-link-wrap mb-5">
		            <div class="nav ftco-animate nav-pills justify-content-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">

		              <a class="nav-link active" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Drinks</a>

		              <a class="nav-link" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">Personal Care</a>

                      <a class="nav-link" id="v-pills-4-tab" data-toggle="pill" href="#v-pills-4" role="tab" aria-controls="v-pills-3" aria-selected="false">Vegetable</a>

                      <a class="nav-link" id="v-pills-5-tab" data-toggle="pill" href="#v-pills-5" role="tab" aria-controls="v-pills-3" aria-selected="false">Cleaning</a>
		            </div>
		          </div>
		          <div class="col-md-12 d-flex align-items-center">
		            
		            <div class="tab-content ftco-animate" id="v-pills-tabContent">
		              <div class="tab-pane fade show active" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
		                <div class="row">
                            <div class="col-md-4 text-center">
                                <form action="menu.php" method="POST">
                                    <div class="menu-wrap">
                                        <a class="menu-img img mb-4" style="background-image: url(assets/img/drink1.avif);"></a>
                                        <div class="text">
                                            <h3>Monster Energy Drink</h3>
                                            <p class="price"><span>៛10000</span></p>
<!--                                            <p><a class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                            <input type="hidden" name="product_name" value="Monster Energy Drink">
                                            <input type="hidden" name="product_price" value="10000">
                                            <input type="hidden" name="product_image" value="assets/img/drink1.avif">

                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-4 text-center">
                                <form action="menu.php" method="POST">
                                    <div class="menu-wrap">
                                        <a class="menu-img img mb-4" style="background-image: url(assets/img/drink2.avif);"></a>
                                        <div class="text">
                                            <h3>Red Bull Energy Drink</h3>
                                            <p class="price"><span>៛8000</span></p>
<!--                                            <p><a class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                            <input type="hidden" name="product_name" value="Red Bull Energy Drink">
                                            <input type="hidden" name="product_price" value="8000">
                                            <input type="hidden" name="product_image" value="assets/img/drink2.avif">

                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-4 text-center">
                                <div action="menu.php" method="POST">
                                    <div class="menu-wrap">
                                        <a class="menu-img img mb-4" style="background-image: url(assets/img/drink3.avif);"></a>
                                        <div class="text">
                                            <h3>Appy Fizz Sparkling Drink</h3>
                                            <p class="price"><span>៛2500</span></p>
    <!--                                        <p><a onclick="addToCart('Appy Fizz Sparkling Drink','2500','drink3.avif')" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                            <input type="hidden" name="product_name" value="Appy Fizz Sparkling Drink">
                                            <input type="hidden" name="product_price" value="2500">
                                            <input type="hidden" name="product_image" value="assets/img/drink3.avif">

                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

		              		<div class="col-md-4 text-center">
                                <form action="menu.php" method="POST">
                                    <div class="menu-wrap">
                                        <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/drink4.avif);"></a>
                                        <div class="text">
                                            <h3><a href="#">Coca-Cola Soft Drink</a></h3>
                                            <p class="price"><span>៛2000</span></p>
    <!--		              					<p><a onclick="addToCart('Coca-Cola Soft Drink','2000', 'drink4.avif')" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                            <input type="hidden" name="product_name" value="Coca-Cola Soft Drink">
                                            <input type="hidden" name="product_price" value="2000">
                                            <input type="hidden" name="product_image" value="assets/img/drink4.avif">

                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
		              			</form>
		              		</div>

		              		<div class="col-md-4 text-center">
                                <form action="menu.php" method="POST">
                                    <div class="menu-wrap">
                                        <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/drink5.avif);"></a>
                                        <div class="text">
                                            <h3><a href="#">Pepsi Soft Drink</a></h3>
                                            <p class="price"><span>៛2000</span></p>
    <!--		              					<p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                            <input type="hidden" name="product_name" value="Pepsi Soft Drink">
                                            <input type="hidden" name="product_price" value="2000">
                                            <input type="hidden" name="product_image" value="assets/img/drink5.avif">

                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
		              		</div>

		              		<div class="col-md-4 text-center">
                                <form action="menu.php" method="POST">
                                    <div class="menu-wrap">
                                        <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/drink6.avif);"></a>
                                        <div class="text">
                                            <h3><a href="#">Milk</a></h3>
                                            <p class="price"><span>៛3000</span></p>
    <!--		              					<p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                            <input type="hidden" name="product_name" value="Milk">
                                            <input type="hidden" name="product_price" value="3000">
                                            <input type="hidden" name="product_image" value="assets/img/drink6.avif">

                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
		              		</div>
		              	</div>
		              </div>

		              <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-3-tab">
		                <div class="row">
		              		<div class="col-md-4 text-center">
                                <form action="menu.php" method="POST">
                                    <div class="menu-wrap">
                                        <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/shampoo1.avif);"></a>
                                        <div class="text">
                                            <h3><a href="#">Lux Lavender & Vitamin C Brightening Body Wash</a></h3>
                                            <p class="price"><span>៛25000</span></p>
    <!--		              					<p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                            <input type="hidden" name="product_name" value="Lux Lavender & Vitamin C Brightening Body Wash">
                                            <input type="hidden" name="product_price" value="25000">
                                            <input type="hidden" name="product_image" value="assets/img/shampoo1.avif">

                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
		              		</div>
		              		<div class="col-md-4 text-center">
                                <form action="menu.php" method="POST">
                                    <div class="menu-wrap">
                                        <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/shampoo2.avif);"></a>
                                        <div class="text">
                                            <h3><a href="#">Tresemme Keratin Smooth Shampoo</a></h3>
                                            <p class="price"><span>៛17500</span></p>
    <!--		              					<p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                            <input type="hidden" name="product_name" value="Tresemme Keratin Smooth Shampoo">
                                            <input type="hidden" name="product_price" value="17500">
                                            <input type="hidden" name="product_image" value="assets/img/shampoo2.avif">

                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
		              		</div>
		              		<div class="col-md-4 text-center">
                                <form action="menu.php" method="POST">
                                    <div class="menu-wrap">
                                        <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/shampoo3.avif);"></a>
                                        <div class="text">
                                            <h3><a href="#">L'Oreal Paris Hyaluron Pure 72H Purifying Shampoo</a></h3>
                                            <p class="price"><span>៛24000</span></p>
    <!--		              					<p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                            <input type="hidden" name="product_name" value="L'Oreal Paris Hyaluron Pure 72H Purifying Shampoo">
                                            <input type="hidden" name="product_price" value="24000">
                                            <input type="hidden" name="product_image" value="assets/img/shampoo3.avif">

                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
		              		</div>
		              		<div class="col-md-4 text-center">
                                <form action="menu.php" method="POST">
                                    <div class="menu-wrap">
                                        <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/shampoo4.avif);"></a>
                                        <div class="text">
                                            <h3><a href="#">Parachute 100% Pure Coconut Oil</a></h3>
                                            <p class="price"><span>៛18000</span></p>
    <!--		              					<p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                            <input type="hidden" name="product_name" value="Parachute 100% Pure Coconut Oil">
                                            <input type="hidden" name="product_price" value="18000">
                                            <input type="hidden" name="product_image" value="assets/img/shampoo4.avif">

                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
		              		</div>
		              		<div class="col-md-4 text-center">
                                <form action="menu.php" method="POST">
                                    <div class="menu-wrap">
                                        <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/shampoo5.avif);"></a>
                                        <div class="text">
                                            <h3><a href="#">MCaffeine Tan Removal Coffee Body Scrub</a></h3>
                                            <p class="price"><span>៛22000</span></p>
    <!--		              					<p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                            <input type="hidden" name="product_name" value="MCaffeine Tan Removal Coffee Body Scrub">
                                            <input type="hidden" name="product_price" value="22000">
                                            <input type="hidden" name="product_image" value="assets/img/shampoo5.avif">

                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
		              		</div>
		              		<div class="col-md-4 text-center">
                                <form action="menu.php" method="POST">
                                    <div class="menu-wrap">
                                        <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/shampoo6.avif)"></a>
                                        <div class="text">
                                            <h3><a href="#">Dove Exfoliating Body Polish Body Wash Scrub (Pomegranate and Shea Butter)</a></h3>
                                            <p class="price"><span>៛21000</span></p>
    <!--		              					<p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                            <input type="hidden" name="product_name" value="Dove Exfoliating Body Polish Body Wash Scrub (Pomegranate and Shea Butter)">
                                            <input type="hidden" name="product_price" value="21000">
                                            <input type="hidden" name="product_image" value="assets/img/shampoo6.avif">

                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
		              		</div>
		              	</div>
		              </div>

                      <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-4-tab">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <form action="menu.php" method="POST">
                                        <div class="menu-wrap">
                                            <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/veg1.avif)"></a>
                                            <div class="text">
                                                <h3><a href="#">Organically Grown Garlic - 100 g</a></h3>
                                                <p class="price"><span>៛1000</span></p>
    <!--                                            <p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                                <input type="hidden" name="product_name" value="Organically Grown Garlic - 100 g">
                                                <input type="hidden" name="product_price" value="1000">
                                                <input type="hidden" name="product_image" value="assets/img/veg1.avif">

                                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4 text-center">
                                    <form action="menu.php" method="POST">
                                        <div class="menu-wrap">
                                            <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/veg2.avif)"></a>
                                            <div class="text">
                                                <h3><a href="#">Lemon</a></h3>
                                                <p class="price"><span>៛2000</span></p>
    <!--                                            <p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                                <input type="hidden" name="product_name" value="Lemon">
                                                <input type="hidden" name="product_price" value="2000">
                                                <input type="hidden" name="product_image" value="assets/img/veg2.avif">

                                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4 text-center">
                                    <form action="menu.php" method="POST">
                                        <div class="menu-wrap">
                                            <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/veg3.avif);"></a>
                                            <div class="text">
                                                <h3><a href="#">Button Mushroom</a></h3>
                                                <p class="price"><span>៛3500</span></p>
    <!--                                            <p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                                <input type="hidden" name="product_name" value="Button Mushroom">
                                                <input type="hidden" name="product_price" value="3500">
                                                <input type="hidden" name="product_image" value="assets/img/veg3.avif">

                                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4 text-center">
                                    <form action="menu.php" method="POST">
                                        <div class="menu-wrap">
                                            <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/veg4.avif);"></a>
                                            <div class="text">
                                                <h3><a href="#">Potato</a></h3>
                                                <p class="price"><span>៛2000</span></p>
    <!--                                            <p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                                <input type="hidden" name="product_name" value="Potato">
                                                <input type="hidden" name="product_price" value="2000">
                                                <input type="hidden" name="product_image" value="assets/img/veg4.avif">

                                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4 text-center">
                                    <form action="menu.php" method="POST">
                                        <div class="menu-wrap">
                                            <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/veg5.avif);"></a>
                                            <div class="text">
                                                <h3><a href="#">Organically Grown Lady Finger - 250 g</a></h3>
                                                <p class="price"><span>៛1500</span></p>
    <!--                                            <p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                                <input type="hidden" name="product_name" value="Organically Grown Lady Finger - 250 g">
                                                <input type="hidden" name="product_price" value="1500">
                                                <input type="hidden" name="product_image" value="assets/img/veg5.avif">

                                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4 text-center">
                                    <form action="menu.php" method="POST">
                                        <div class="menu-wrap">
                                            <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/veg6.avif);"></a>
                                            <div class="text">
                                                <h3><a href="#">Mango</a></h3>
                                                <p class="price"><span>៛2000</span></p>
    <!--                                            <p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                                <input type="hidden" name="product_name" value="Mango">
                                                <input type="hidden" name="product_price" value="2000">
                                                <input type="hidden" name="product_image" value="assets/img/veg6.avif">

                                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                      <div class="tab-pane fade" id="v-pills-5" role="tabpanel" aria-labelledby="v-pills-5-tab">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <form action="menu.php" method="POST">
                                        <div class="menu-wrap">
                                            <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/clean1.avif);"></a>
                                            <div class="text">
                                                <h3><a href="#">Comfort Perfume Deluxe Mystique Fabric Conditioner</a></h3>
                                                <p class="price"><span>៛13000</span></p>
    <!--                                            <p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                                <input type="hidden" name="product_name" value="Comfort Perfume Deluxe Mystique Fabric Conditioner">
                                                <input type="hidden" name="product_price" value="13000">
                                                <input type="hidden" name="product_image" value="assets/img/clean1.avif">

                                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4 text-center">
                                    <form action="menu.php" method="POST">
                                        <div class="menu-wrap">
                                            <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/clean2.avif);"></a>
                                            <div class="text">
                                                <h3><a href="#">Surf Excel Easy Wash Detergent Powder - 7 kg</a></h3>
                                                <p class="price"><span>៛9000</span></p>
    <!--                                            <p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                                <input type="hidden" name="product_name" value="Surf Excel Easy Wash Detergent Powder - 7 kg">
                                                <input type="hidden" name="product_price" value="9000">
                                                <input type="hidden" name="product_image" value="assets/img/clean2.avif">

                                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4 text-center">
                                    <form action="menu.php" method="POST">
                                        <div class="menu-wrap">
                                            <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/clean3.avif);"></a>
                                            <div class="text">
                                                <h3><a href="#">Vim Lemon Dishwash Gel (500 ml)</a></h3>
                                                <p class="price"><span>៛8000</span></p>
    <!--                                            <p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                                <input type="hidden" name="product_name" value="Vim Lemon Dishwash Gel (500 ml)">
                                                <input type="hidden" name="product_price" value="8000">
                                                <input type="hidden" name="product_image" value="assets/img/clean3.avif">

                                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="menu-wrap">
                                        <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/clean4.avif);"></a>
                                        <div class="text">
                                            <h3><a href="#">Harpic Disinfectant Liquid Toilet Cleaner - (Original)</a></h3>
                                            <p class="price"><span>៛17500</span></p>
<!--                                            <p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                            <input type="hidden" name="product_name" value="Harpic Disinfectant Liquid Toilet Cleaner - (Original)">
                                            <input type="hidden" name="product_price" value="17500">
                                            <input type="hidden" name="product_image" value="assets/img/clean4.avif">

                                            <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <form action="menu.php" method="POST">
                                        <div class="menu-wrap">
                                            <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/clean5.avif);"></a>
                                            <div class="text">
                                                <h3><a href="#">Dettol Liquid Disinfectant (Menthol Cool)</a></h3>
                                                <p class="price"><span>៛10000</span></p>
    <!--                                            <p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                                <input type="hidden" name="product_name" value="Dettol Liquid Disinfectant (Menthol Cool)">
                                                <input type="hidden" name="product_price" value="10000">
                                                <input type="hidden" name="product_image" value="assets/img/clean5.avif">

                                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4 text-center">
                                    <form action="menu.php" method="POST">
                                        <div class="menu-wrap">
                                            <a href="#" class="menu-img img mb-4" style="background-image: url(assets/img/clean6.avif);"></a>
                                            <div class="text">
                                                <h3><a href="#">Dettol Original Multi-Use Skin & Surface Wet Wipes</a></h3>
                                                <p class="price"><span>៛8000</span></p>
    <!--                                            <p><a href="#" class="btn btn-primary btn-outline-primary">Add to cart</a></p>-->
                                                <input type="hidden" name="product_name" value="Dettol Original Multi-Use Skin & Surface Wet Wipes">
                                                <input type="hidden" name="product_price" value="8000">
                                                <input type="hidden" name="product_image" value="assets/img/clean6.avif">

                                                <button type="submit" name="add_to_cart" class="btn btn-primary btn-outline-primary">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
    	</div>
    </section>

    <footer class="ftco-footer ftco-section img">
        <div class="overlay"></div>
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-3 col-lg-7 mb-5 mb-md-5">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">About Us</h2>
                        <p>We’re a modern grocery brand focused on delivering fresh products, seamless service, and fast delivery. Our mission is to make everyday shopping simple, reliable, and effortless for everyone.</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-whatsapp"></span></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-5 mb-md-5">
                    <div class="ftco-footer-widget mb-4 ml-md-4">
                        <h2 class="ftco-heading-2">Services</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" class="py-2 d-block">Fast Delivery</a></li>
                            <li><a href="#" class="py-2 d-block">Fresh Products</a></li>
                            <li><a href="#" class="py-2 d-block">Easy Ordering</a></li>
                            <li><a href="#" class="py-2 d-block">Best Deals</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-5 mb-md-5">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Have a Questions?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon icon-map-marker"></span><span class="text">#5, St.128 (Kampuchea Krom Blvd) S/K Phsar Thmei II, Khan Daun Penh</span></li>
                                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+91 982 130 5966</span></a></li>
                                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">kimsan.em11@gmail.com</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Kimsan
                    </p>
                </div>
            </div>
        </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.easing.1.3.js"></script>
  <script src="assets/js/jquery.waypoints.min.js"></script>
  <script src="assets/js/jquery.stellar.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script src="assets/js/jquery.magnific-popup.min.js"></script>
  <script src="assets/js/aos.js"></script>
  <script src="assets/js/jquery.animateNumber.min.js"></script>
  <script src="assets/js/bootstrap-datepicker.js"></script>
  <script src="assets/js/jquery.timepicker.min.js"></script>
  <script src="assets/js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="assets/js/google-map.js"></script>
  <script src="assets/js/main.js"></script>
    
  </body>
</html>