<?php
session_start();
include 'database.php';

if(!isset($_SESSION['user_id'])){

header("Location: login.php");
exit();
}

$uid = $_SESSION['user_id'];

$cart = $conn->query("SELECT cart.*, products.*

FROM cart

JOIN products

ON cart.product_id = products.id

WHERE cart.user_id='$uid'");

$total = 0;

while($item = $cart->fetch_assoc()){

$total += ($item['price'] * $item['quantity']);
}

$cart = $conn->query("SELECT cart.*, products.*

FROM cart

JOIN products

ON cart.product_id = products.id

WHERE cart.user_id='$uid'");

if($_POST){

$phone = $_POST['phone'];
$address = $_POST['address'];
$city = $_POST['city'];
$postal = $_POST['postal_code'];
$payment = $_POST['payment_method'];

while($item = $cart->fetch_assoc()){

$productId = $item['product_id'];

$sellerId = $item['user_id'];

$conn->query("INSERT INTO orders(
product_id, buyer_id, address, payment_method, status,
phone, city, postal_code, seller_id, payment_status
)

VALUES(
'$productId', '$uid', '$address', '$payment', 'Pending',
'$phone', '$city', '$postal', '$sellerId', 'Paid'
)");
}

$conn->query("DELETE FROM cart
WHERE user_id='$uid'");

header("Location: orders.php");
exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Checkout</title>

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

.content{
padding:40px; }

.checkout-box{
background:white;
padding:30px;
border-radius:15px;
max-width:700px;
margin:auto; }

input,
textarea,
select{

width:100%;
padding:15px;
margin-top:15px;
border:1px solid gray;
border-radius:10px;
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
font-size:18px;
font-weight:bold;
cursor:pointer; }

button:hover{
background:darkgreen; }

.total{
font-size:24px;
font-weight:bold;
color:green;
margin-bottom:20px; }

@media screen and (max-width:768px){

.content{
padding:15px; }

.checkout-box{
width:95%;
padding:20px;
}

header{
flex-direction:column; }

nav{
margin-top:15px;
display:flex;
flex-wrap:wrap;
justify-content:center;
gap:10px; }

nav a{
margin:0;
color:green;
font-weight:bold;
text-decoration:none;
}

nav a:hover{
color:darkblue;
}
}

</style>

</head>

<body>

<header>

<div class="logo-section">

<img src="c2c_Logo.png" class="logo">

<div class="logo-text">

<h2>UShop</h2>

<h3>Checkout</h3>

</div>

</div>

<nav>

<a href="cart.php">Cart</a>
<a href="orders.php">Orders</a>
<a href="help.php">Help</a>
<a href="logout.php">Logout</a>

</nav>

</header>

<div class="content">

<div class="checkout-box">

<h1>Checkout</h1>

<p class="total">

Grand Total:
R<?php echo $total; ?>

</p>

<form method="POST">

<input type="text" name="phone" placeholder="Phone Number" required>

<textarea name="address" placeholder="Delivery Address" required></textarea>

<input type="text" name="city" placeholder="City" required>

<input type="text" name="postal_code" placeholder="Postal Code" required>

<select name="payment_method" required>
<option value="">Select Payment Method</option>
<option value="Card">Card</option>
<option value="EFT">EFT</option>
<option value="Cash On Delivery"> Cash On Delivery </option>

</select>

<button> Place Order </button>

</form>

</div>

</div>

</body>
</html>