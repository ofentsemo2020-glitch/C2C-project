<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {

header("Location: login.php");
exit();
}

$uid = $_SESSION['user_id'];

if(isset($_GET['category'])){

$cat = $_GET['category'];

$result = $conn->query("
SELECT * FROM products WHERE user_id = '$uid'
AND category = '$cat'
ORDER BY id DESC ");

}else{

$result = $conn->query("
SELECT *
FROM products
WHERE user_id = '$uid'
ORDER BY id DESC ");
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">   
<style>

body{
margin:0;
font-family:Arial;
background:lightblue;
}

header{

background:white;
display:flex;
justify-content:space-between;
align-items:center;
padding:15px 40px;
border-bottom:1px solid gray;
}

.logo-section{
display:flex;
align-items:center; }

.logo{ width:120px; }

.logo-text{ margin-left:10px; }

.logo-text p{ margin:0; }

nav a{

margin-left:20px;
color:black;
font-weight:bold;
text-decoration:none;
font-weight:bold; }

nav a:hover{ color:blue; }

.main{ display:flex; }

.sidebar{
width:250px;
background:black;
height:100vh;
padding:20px;
border-right:1px solid gray; }

.sidebar h3{
margin-top:0; }

.sidebar a{
display:block;
margin-top:20px;
color:white;
font-weight:bold;
text-decoration:none; }

.content{
flex:1;
padding:30px; }
.products{
display:grid;
grid-template-columns:repeat(3, 1fr);
gap:20px; }

.card{
background:white;
padding:20px;
border-radius:10px; }

.card img{

width:100%;
height:220px;
object-fit:cover;
border-radius:10px; }

.card h3{
margin-top:15px; }

.card a{
margin-right:15px;
color:blue;
font-weight:bold; }


@media screen and (max-width:768px){

.main{
flex-direction:column; }

.sidebar{
width:100%;
height:auto; }

.products{
grid-template-columns:1fr; }

header{
flex-direction:column;
}

nav{
display:flex;
flex-wrap:wrap;
justify-content:center;
gap:10px;
margin-top:15px; }
  nav a{
 margin-left:20px;
 color:green;
 font-weight:bold;
 text-decoration:none;
 transition:0.3s; }
    
nav a:hover{
 color:darkblue; }

nav a{
    margin:0;
    font-size:15px;
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

<h3>Buy and Sell what U want</h3>

</div>

</div>

<nav>

<a href="marketplace.php">Marketplace</a>
<a href="addproduct.php">Add Product</a>
<a href="sellerOrders.php">

Seller Orders

</a>

<a href="orders.php">Orders</a>

<a href="help.php"> Help </a>
<a href="logout.php">Logout</a>

</nav>

</header>

<div class="main">

<div class="sidebar" style="color:white">

<h3>Categories</h3>

<a href="dashboard.php?category=Electronics">Electronics</a>
<a href="dashboard.php?category=Clothing">Clothing</a>
<a href="dashboard.php?category=Furniture">Furniture</a>
<a href="dashboard.php?category=Food">Food</a>
<a href="dashboard.php?category=Other">Other</a>
<a href="dashboard.php">Show All</a>

</div>

<div class="content">

<h2><u><b>Your Products:</b></u></h2>

<div class="products">

<?php while($row = $result->fetch_assoc()): ?>

<div class="card">

<img src="uploads/<?php echo $row['image']; ?>">

<h3> <?php echo $row['title']; ?> </h3>

<p> <?php echo $row['description']; ?> </p>

<p> R<?php echo $row['price']; ?> </p>

<?php

$productId = $row['id'];

$avg = $conn->query("SELECT AVG(rating) as avgRating

FROM reviews

WHERE product_id='$productId'");

$avgRow = $avg->fetch_assoc();

$count = $conn->query("SELECT * FROM reviews

WHERE product_id='$productId'")->num_rows;

?>

<p style="color:orange;
font-weight:bold;">

⭐
<?php echo round($avgRow['avgRating'],1); ?>/5

(<?php echo $count; ?> Reviews)

</p>

<p>Category:

<b><?php echo $row['category']; ?> </b>
</p>

<a href="editProduct.php?id=<?php echo $row['id']; ?>"> Edit </a>
<a href="deleteProduct.php?id=<?php echo $row['id']; ?>"> Delete </a>
</div>

<?php endwhile; ?>

 </div>
 </div>

</div>

</body>
</html>