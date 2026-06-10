<?php
session_start();
include 'database.php';

if(!isset($_SESSION['user_id'])){

header("Location: login.php");

exit();
}

$id = $_GET['id'];

$product = $conn->query("SELECT * FROM products WHERE id=$id");

$row = $product->fetch_assoc();

if(isset($_POST['reviewBtn'])){

$user = $_SESSION['user_id'];

$rating = $_POST['rating'];

$comment = $_POST['comment'];

$conn->query("INSERT INTO reviews

(user_id,product_id,rating,comment)

VALUES

('$user','$id','$rating','$comment')");

echo "Review Added!";
}

if($_POST && isset($_POST['buyBtn'])){

$buyer = $_SESSION['user_id'];

$seller = $row['user_id'];

$payment = $_POST['payment'];

$phone = $_POST['phone'];

$address = $_POST['address'];

$city = $_POST['city'];

$postal = $_POST['postal_code'];

$conn->query("INSERT INTO orders

(buyer_id,seller_id,product_id,
payment_method,phone,address,
city,postal_code,status)

VALUES

('$buyer','$seller','$id',
'$payment','$phone','$address',
'$city','$postal','Pending')");

echo "Order Placed!";
}

$reviews = $conn->query("SELECT reviews.*, users.username

FROM reviews

JOIN users

ON reviews.user_id = users.id

WHERE product_id='$id'

ORDER BY reviews.id DESC");

$avg = $conn->query("SELECT AVG(rating) as avgRating

FROM reviews

WHERE product_id='$id'");

$avgRow = $avg->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>

<title>Buy Product</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">   
<style>

body{
 margin:0;
 font-family:Arial;
 background:lightblue; }

header{
 background:white;
 display:flex;
 justify-content:space-between;
 align-items:center;
 padding:15px 40px;
 border-bottom:1px solid gray; }

.logo-section{
 display:flex;
 align-items:center; }

.logo{
 width:120px; }

.logo-text{
 margin-left:10px; }

nav a{
 margin-left:20px;
 color:black;
 font-weight:bold;
 text-decoration:none; }

nav a:hover{
 color:blue; }

.main{
 display:flex;
 justify-content:center;
 align-items:flex-start;
 padding:50px; }

.buy-box{
 background:white;
 width:60%;
 padding:30px;
 border-radius:20px; }

.buy-box img{
 width:100%;
 height:300px;
 object-fit:cover;
 border-radius:10px; }

input,
textarea,
select{
 width:100%;
 padding:15px;
 margin-top:15px;
 border-radius:10px;
 border:1px solid gray;
 box-sizing:border-box;
 font-size:16px; }

button{
 width:100%;
 padding:15px;
 margin-top:20px;
 background:blue;
 color:white;
 border:none;
 border-radius:10px;
 font-size:18px; }

button:hover{
 background:darkblue; }

.review{
 background:yellow;
 padding:15px;
 border-radius:10px;
 margin-top:15px; }

.back{
 display:inline-block;
 margin-top:20px;
 color:blue;
 font-weight:bold;
 text-decoration:none; }

@media screen and (max-width:768px){

.buy-box{
 width:95%; }

header{
 flex-direction:column; }

      nav a{
 margin-left:20px;
 color:green;
 font-weight:bold;
 text-decoration:none;
 transition:0.3s; }
    
nav a:hover{
 color:darkblue; }

nav{
 margin-top:15px; }
}

</style>

</head>

<body>

<header>

<div class="logo-section">

<img src="c2c_Logo.png" class="logo">

<div class="logo-text">

<h2>UShop</h2>

<h3>Buy and Sell what U want</h3>

</div>

</div>

<nav>

<a href="index.php">Marketplace</a>
<a href="cart.php">Cart</a>
<a href="orders.php">Orders</a>
<a href="help.php"> Help </a>
<a href="logout.php">Logout</a>

</nav>

</header>

<div class="main">

<div class="buy-box">

<img src="uploads/<?php echo $row['image']; ?>">

<h2>

⭐ <?php echo round($avgRow['avgRating'],1); ?>/5

</h2>

<h1><?php echo $row['title']; ?></h1>

<p><?php echo $row['description']; ?></p>

<h2>R<?php echo $row['price']; ?></h2>

<h2>Leave a Review</h2>

<form method="POST">

<select name="rating" required>

<option value="">Select Stars</option>
<option value="1">⭐ 1 Star</option>
<option value="2">⭐ 2 Stars</option>
<option value="3">⭐ 3 Stars</option>
<option value="4">⭐ 4 Stars</option>
<option value="5">⭐ 5 Stars</option>

</select>

<textarea name="comment" placeholder="Write your review" rows="5" required></textarea>

<button name="reviewBtn">Submit Review</button>

</form>

<h2>Customer Reviews</h2>

<?php while($review = $reviews->fetch_assoc()): ?>

<div class="review">

<h3><?php echo $review['username']; ?></h3>

<p>

<?php

for($i=0; $i<$review['rating']; $i++){

echo "⭐";
}

?>

</p>

<p><?php echo $review['comment']; ?></p>

</div>

<?php endwhile; ?>

<h2>Buy Product</h2>

<form method="POST">

<select name="payment" required>

<option>Card Payment</option>
<option>PayPal</option>
<option>EFT</option>

</select>

<input placeholder="Card Number">

<input placeholder="Expiry Date">

<input placeholder="CVV">

<input name="phone" placeholder="Phone Number" required>

<input name="address" placeholder="Shipping Address"required>

<input name="city" placeholder="City" required>

<input name="postal_code" placeholder="Postal Code" required>

<button name="buyBtn">Pay Now</button>

</form>

<a href="index.php" class="back"> Back to Marketplace </a>

</div>

</div>

</body>
</html>