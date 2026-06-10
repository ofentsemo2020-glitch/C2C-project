<?php
session_start();
include 'database.php';

if(!isset($_SESSION['user_id'])){

header("Location: login.php");

exit();
}

$uid = $_SESSION['user_id'];

$cart = $conn->query("SELECT cart.*, products.title,
products.price, products.image

FROM cart

JOIN products

ON cart.product_id = products.id

WHERE cart.user_id='$uid'");

$total = 0;
?>

<!DOCTYPE html>
<html>

<head>

<title>Cart</title>
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

.cart-box{
 background:white;
 padding:25px;
 border-radius:15px; }

.item{
 display:flex;
 align-items:center;
 gap:20px;
 border-bottom:1px solid lightgray;
 padding:20px 0; }

.item img{
 width:120px;
 height:120px;
 object-fit:cover;
 border-radius:10px; }

.remove{
 background:red;
 color:white;
 padding:10px 15px;
 border-radius:10px;
 text-decoration:none;
 font-weight:bold; }

.checkout{
 display:inline-block;
 margin-top:20px;
 padding:15px 25px;
 background:green;
 color:white;
 border-radius:10px;
 text-decoration:none;
 font-weight:bold; }

@media screen and (max-width:768px){

.item{
 flex-direction:column;
 align-items:flex-start; }

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

<h3>Your Cart</h3>

</div>

</div>

<nav>

<a href="index.php">Marketplace</a>
<a href="orders.php">Orders</a>
<a href="help.php"> Help </a>
<a href="logout.php">Logout</a>

</nav>

</header>

<div class="content">

<div class="cart-box">

<h1>Shopping Cart</h1>

<?php while($row = $cart->fetch_assoc()): ?>

<?php

$itemTotal =
$row['price'] * $row['quantity'];

$total += $itemTotal;

?>

<div class="item">

<img src="uploads/<?php echo $row['image']; ?>">

<div>

<h2><?php echo $row['title']; ?></h2>

<p>
Price:
R<?php echo $row['price']; ?>
</p>

<p>
Quantity:
<?php echo $row['quantity']; ?> </p>

<p>Total:
R<?php echo $itemTotal; ?> </p>

<a href="removeCart.php?id=<?php echo $row['id']; ?>"
class="remove"> Remove </a>

</div>
</div>

<?php endwhile; ?>

<h2> Grand Total:
R<?php echo $total; ?> </h2>

<a href="checkout.php" class="checkout"> Proceed To Checkout </a>

</div>

</div>

</body>
</html>