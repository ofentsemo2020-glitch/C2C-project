<?php
session_start();
include 'database.php';

if(isset($_GET['search'])){

$search = $_GET['search'];

$result = $conn->query("SELECT * FROM products

WHERE title LIKE '%$search%'

OR description LIKE '%$search%'

OR category LIKE '%$search%' ORDER BY id DESC");

}else{

$result = $conn->query("SELECT * FROM products

ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Marketplace</title>

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
 display:flex; }

.sidebar{
 width:250px;
 background:black;
 min-height:100vh;
 padding:20px; }

.sidebar h3{
 color:white; }

.sidebar a{
 display:block;
 margin-top:20px;
 color:white;
 font-weight:bold;
 text-decoration:none; }

.sidebar a:hover{
 color:lightblue; }

.content{
 flex:1;
 padding:30px; }

.search-box{
 display:flex;
 justify-content:flex-end;
 margin-bottom:30px; }

.search-box input{
 width:300px;
 padding:15px;
 border-radius:10px;
 border:1px solid gray;
 font-size:16px; }

.search-box button{
 padding:15px 25px;
 background:blue;
 color:white;
 border:none;
 border-radius:10px;
 font-size:16px;
 margin-left:10px; }

.search-box button:hover{
 background:darkblue; }

.products{
 display:grid;
 grid-template-columns:repeat(3,1fr);
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

.btn{
 display:inline-block;
 margin-top:15px;
 padding:12px 20px;
 background:blue;
 color:white;
 border-radius:10px;
 text-decoration:none;
 font-weight:bold; }

.btn:hover{
 background:darkblue; }

.rating{
 color:orange;
 font-weight:bold; }

.seller-rating{
 color:green;
 font-weight:bold; }

@media screen and (max-width:768px){

.main{
 flex-direction:column; }

.sidebar{
 width:100%;
 min-height:auto; }

.products{
 grid-template-columns:1fr; }

.search-box{
 justify-content:center; }

.search-box input{
 width:100%; }

header{
 flex-direction:column; }

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

<a href="dashboard.php">Dashboard</a>
<a href="cart.php">Cart</a>
<a href="orders.php">Orders</a>
<a href="addProduct.php">Add Product</a>
<a href="help.php"> Help </a>
<a href="logout.php">Logout</a>

</nav>

</header>

<div class="main">

<div class="sidebar">

<h3>Categories</h3>

<a href="marketplace.php?category=Electronics">Electronics</a>
<a href="marketplace.php?category=Clothing">Clothing</a>
<a href="marketplace.php?category=Furniture">Furniture</a>
<a href="marketplace.php?category=Food">Food</a>
<a href="marketplace.php?category=Other">Other</a>

</div>

<div class="content">

<h1>Marketplace</h1>

<div class="search-box">

<form method="GET">

<input type="text" name="search" placeholder="Search products...">

<button>Search</button>

</form>

</div>

<div class="products">

<?php while($row = $result->fetch_assoc()): ?>

<div class="card">

<img src="uploads/<?php echo $row['image']; ?>">

<h2><?php echo $row['title']; ?></h2>

<p><?php echo $row['description']; ?></p>

<h3>R<?php echo $row['price']; ?></h3>

<?php

$productId = $row['id'];

$avg = $conn->query("SELECT AVG(rating) as avgRating FROM reviews WHERE product_id='$productId'");

$avgRow = $avg->fetch_assoc();

$count = $conn->query("SELECT * FROM reviews WHERE product_id='$productId'")->num_rows;

?>

<p class="rating">

⭐ <?php echo round($avgRow['avgRating'],1); ?>/5

(<?php echo $count; ?> Reviews)

</p>

<?php

$sellerId = $row['user_id'];

$sellerAvg = $conn->query("SELECT AVG(rating)
as avgSellerRating FROM seller_reviews
WHERE seller_id='$sellerId'"); $sellerRow = $sellerAvg->fetch_assoc();

?>

<p class="seller-rating">

Trusted Seller ⭐

<?php echo round($sellerRow['avgSellerRating'],1); ?>/5

</p>

<a href="buyProduct.php?id=<?php echo $row['id']; ?>"
class="btn"> Buy Now </a>

</div>

<?php endwhile; ?>

</div>
</div>
</div>

</body>
</html>