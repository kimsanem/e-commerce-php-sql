<?php
session_start();
include 'auth/database.php';

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

// DELETE ITEM
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);

    $del = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $del->bind_param("ii", $delete_id, $user_id);
    $del->execute();

    header("Location: cart.php");
    exit();
}

// GET ALL CART ITEMS
$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
$subtotal = 0;

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $subtotal += $row['product_price'] * 1; // quantity is fixed at 1 now
}

$total = $subtotal;  // You can add delivery/discount later

// CHECKOUT → ADD BOOKING
if (isset($_POST['checkout'])) {

    // get all cart items
    $stmt = $conn->prepare("SELECT product_name, product_price FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $total_price = 0;
        $product_list = [];

        while ($row = $result->fetch_assoc()) {
            $product_list[] = $row['product_name'];
            $total_price += $row['product_price'];
        }

        // Convert items to string
        $product_names = implode(", ", $product_list);

        // Insert into booking table
        $book = $conn->prepare("INSERT INTO booking (user_id, product_name, total_price) VALUES (?, ?, ?)");
        $book->bind_param("isi", $user_id, $product_names, $total_price);
        $book->execute();

        // Clear cart
        $clear = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $clear->bind_param("i", $user_id);
        $clear->execute();
    }
    header("Location: cart.php");
    exit();
}
?>


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
				<li class="nav-item cart"><a href="cart.php" class="nav-link"><span class="icon icon-shopping_cart"></span></a>
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
            	<h1 class="mb-3 mt-5 bread">Cart</h1>
	            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Cart</span></p>
            </div>

          </div>
        </div>
      </div>
    </section>
		
	<section class="ftco-section ftco-cart">
		<div class="container">
			<div class="row">
			<div class="col-md-12 ftco-animate">
				<div class="cart-list">
					<table class="table">
						<thead class="thead-primary">
							<tr class="text-center">
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th>Product</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Total</th>
							</tr>
						</thead>
						<tbody>
                            <?php if (count($items) === 0): ?>
                                <tr class="text-center">
                                    <td colspan="6">
                                        <h4>Your cart is empty</h4>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($items as $item): ?>
                                    <tr class="text-center">
                                        <td class="product-remove"><a href="cart.php?delete=<?= $item['id'] ?>"><span class="icon-close"></span></a></td>

                                        <td class="image-prod"><div class="img" style="background-image:url(<?= $item['product_image'] ?>);"></div></td>

                                        <td class="product-name">
                                            <h3><?= $item['product_name'] ?></h3>
                                        </td>

                                        <td class="price">$4.90</td>

                                        <td>
                                            <div class="input-group mb-3">
                                                <input disabled type="text" name="quantity" class="quantity form-control input-number" value="1" min="1" max="100">
                                                </div>
                                        </td>

                                        <td class="total">៛<?= number_format($total) ?></td>
                                    </tr><!-- END TR-->
                                <?php endforeach; ?>
                            <?php endif; ?>
						</tbody>
						</table>
					</div>
			</div>
		</div>
		<div class="row justify-content-end">
			<div class="col col-lg-3 col-md-6 mt-5 cart-wrap ftco-animate">
				<div class="cart-total mb-3">
					<h3>Cart Totals</h3>
					<p class="d-flex">
						<span>Subtotal</span>
						<span>៛<?= number_format($subtotal) ?></span>
					</p>
					<p class="d-flex">
						<span>Delivery</span>
						<span>៛0</span>
					</p>
					<p class="d-flex">
						<span>Discount</span>
						<span>៛0</span>
					</p>
					<hr>
					<p class="d-flex total-price">
						<span>Total</span>
						<span>៛<?= number_format($total) ?></span>
					</p>
				</div>
                <form action="cart.php" method="POST" class="text-center">
                    <button type="submit" name="checkout" class="btn btn-outline-primary py-3 px-4">
                        Proceed to Checkout
                    </button>
                </form>
<!--				<p class="text-center"><a href="checkout.html" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>-->
			</div>
		</div>
		</div>
	</section>

,
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