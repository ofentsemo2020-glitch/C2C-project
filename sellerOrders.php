<?php
session_start();
include 'database.php';

if(!isset($_SESSION['user_id'])){

header("Location: login.php");
exit();
}

$uid = $_SESSION['user_id'];

$orders = $conn->query("SELECT orders.*, products.title,
products.image, users.username
FROM orders 
JOIN products
ON orders.product_id = products.id
JOIN users ON orders.buyer_id = users.id
WHERE orders.seller_id='$uid' ORDER BY orders.id DESC");
?>

<!DOCTYPE html>
<html>

<head>

<title>Seller Orders</title>
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

.orders{
display:grid;
grid-template-columns:repeat(2,1fr);
gap:20px; }

.card{
background:white;
padding:20px;
border-radius:15px; }

.card img{
width:100%;
height:220px;
object-fit:cover;
border-radius:10px; }

.status{
font-weight:bold;
color:green; }

.btn{
display:inline-block;
margin-top:10px;
padding:10px 15px;
background:blue;
color:white;
border-radius:10px;
text-decoration:none;
font-weight:bold; }
    
.refund-btn{
display:inline-block;
margin-top:10px;
padding:10px 15px;
background:red;
color:white;
border-radius:10px;
text-decoration:none;
font-weight:bold;}

@media screen and (max-width:768px){

.orders{
grid-template-columns:1fr;
}

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
margin-top:15px;
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

<h3>Seller Orders</h3>

</div>

</div>

<nav>

<a href="dashboard.php"> Dashboard </a>
<a href="help.php"> Help </a>
<a href="logout.php"> Logout </a>

</nav>

</header>

<div class="content">

<h1> Orders On Your Products </h1>

<div class="orders">

<?php while($row = $orders->fetch_assoc()): ?>

<div class="card">

<img src="uploads/<?php echo $row['image']; ?>">

<h2> <?php echo $row['title']; ?> </h2>

<p>
Buyer:
<b> <?php echo $row['username']; ?> </b>
</p>

<p>
Phone:
<b> <?php echo $row['phone']; ?> </b>
</p>

<p>
Address:
<b> <?php echo $row['address']; ?> </b>

</p>

<p>City:
<b> <?php echo $row['city']; ?> </b></p>

<p> Postal Code:
<b> <?php echo $row['postal_code']; ?> </b></p>

<p class="payment">
Payment Method:
<b><?php echo $row['payment_method']; ?></b>
</p>  
<p class="payment">
Payment Status:
<b>PAID ✓</b>
</p>

<p class="status">
Status:
<?php echo $row['status']; ?> </p>

<a href="updateOrder.php?id=<?php echo $row['id']; ?>&status=Shipped" class="btn"> Mark Shipped</a>
<a href="updateOrder.php?id=<?php echo $row['id']; ?>&status=Delivered" class="btn"> Mark Delivered </a>
<a href="refundOrder.php?id=<?php echo $row['id']; ?>"
class="refund-btn" onclick="return confirm('Refund this order?');"> Refund Buyer </a>
<a href="deleteSellerOrder.php?id=<?php echo $row['id']; ?>" class="btn delete"
onclick="return confirm('Remove this order from seller orders?');">Remove Order </a><br>

Refund Status:
<b> <?php echo $row['refund_status']; ?> </b>

<?php

if($row['refund_status'] == 'Requested'){

?>

<a
href="refundOrder.php?id=<?php echo $row['id']; ?>"
class="refund-btn"> Approve Refund </a>

<a
href="rejectRefund.php?id=<?php echo $row['id']; ?>"
class="btn"> Reject Refund </a>

<?php } ?>

</div>

<?php endwhile; ?>

</div>
</div>

</body>
</html>