<?php
session_start();
include 'database.php';

if(!isset($_SESSION['user_id'])){

header("Location: login.php");

exit();
}

$id = $_GET['id'];

$uid = $_SESSION['user_id'];

$product = $conn->query("SELECT * FROM products

WHERE id=$id

AND user_id=$uid")->fetch_assoc();

if(!$product){

die("Product not found");
}

if($_POST){

$t = $_POST['title'];

$d = $_POST['description'];

$p = $_POST['price'];

$c = $_POST['category'];

if($_FILES['image']['name']){

$imageName =
$_FILES['image']['name'];

$tempName =
$_FILES['image']['tmp_name'];

move_uploaded_file(
$tempName,
"uploads/".$imageName);

}else{

$imageName =
$product['image'];
}

$conn->query("UPDATE products

SET

title='$t',
description='$d',
price='$p',
category='$c',
image='$imageName'

WHERE id=$id");

echo "<div id='msg'>
Product Updated!
</div>";

$product = $conn->query("SELECT * FROM products

WHERE id=$id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Product</title>
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

.logo-text p{
 margin:0; }

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
 height:100vh;
 padding:20px; }

.sidebar a{
 display:block;
 margin-top:20px;
 color:white;
 font-weight:bold;
 text-decoration:none; }  

.content{
 flex:1;
 padding:30px; }

.form-box{
 background:white;
 width:60%;
 padding:30px;
 border-radius:10px; }

.product-image{
 width:100%;
 height:300px;
 object-fit:cover;
 border-radius:10px;
 margin-bottom:20px; }

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

#msg{
 background:green;
 color:white;
 padding:15px;
 margin-bottom:20px;
 border-radius:10px;
 font-weight:bold; }

@media screen and (max-width:768px){

.main{
 flex-direction:column; }

.sidebar{
 width:100%;
 height:auto; }

.form-box{
 width:90%; }

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
<a href="marketplace.php">Marketplace</a>
<a href="orders.php">Orders</a>
<a href="support.php">Help</a>
<a href="logout.php">Logout</a>

</nav>

</header>

<div class="main">

<div class="sidebar">

<h3 style="color:white"> Edit Product </h3>

<a href="dashboard.php"> Back to Dashboard </a>

</div>

<div class="content">

<div class="form-box">

<h2>Edit Product</h2>

<img src="uploads/<?php echo $product['image']; ?>" class="product-image">

<form method="POST" enctype="multipart/form-data">

<input name="title" value="<?php echo $product['title']; ?>"
required>

<textarea name="description" required> <?php echo $product['description']; ?></textarea>

<input name="price" value="<?php echo $product['price']; ?>" 
required>

<select name="category">

<option>

<?php echo $product['category']; ?>

</option>

<option>Electronics</option>

<option>Clothing</option>

<option>Furniture</option>

<option>Food</option>

<option>Other</option>

</select>

<input type="file" name="image">

<button>Update Product</button>

</form>

</div>

</div>

</div>

<script>

setTimeout(function(){

let msg =
document.getElementById("msg");

if(msg){

msg.style.display = "none";
}

},3000);

</script>

</body>
</html>