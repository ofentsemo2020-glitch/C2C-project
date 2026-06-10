<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {

header("Location: login.php");
exit();
}

$uid = $_SESSION['user_id'];

if(isset($_POST['sellerReviewBtn'])){

$buyer = $_SESSION['user_id'];
$seller = $_POST['seller_id'];
$rating = $_POST['seller_rating'];
$comment = $_POST['seller_comment'];
$conn->query("INSERT INTO seller_reviews

(seller_id,buyer_id,rating,comment)

VALUES

('$seller','$buyer','$rating','$comment')");

echo "Seller Review Added!"; }

$result = $conn->query("SELECT orders.*, 
products.title, products.price, products.image, products.user_id

FROM orders
JOIN products
ON orders.product_id = products.id
WHERE orders.buyer_id='$uid'
ORDER BY orders.id DESC");
?>

<!DOCTYPE html>
<html>

<head>

<title>Orders</title>
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
text-decoration:none;
}

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
height:250px;
object-fit:cover;
border-radius:10px; }

.status{
font-weight:bold;
color:green;
}

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

.cancel-btn{
display:inline-block;
margin-top:15px;
padding:10px 20px;
background:red;
color:white;
border-radius:10px;
text-decoration:none;
font-weight:bold; }

.cancel-btn:hover{
background:darkred; }

@media screen and (max-width:768px){

.orders{
grid-template-columns:1fr;
}

header{
flex-direction:column;
}
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

<h3>Buy and Sell what U want</h3>

</div>

</div>

<nav>

<a href="marketplace.php"> Marketplace </a>
<a href="dashboard.php"> Dashboard </a>
<a href="help.php"> Help </a>
<a href="logout.php"> Logout </a>

</nav>

</header>

<div class="content">

<h1> My Orders </h1>

<div class="orders">

<?php while($row = $result->fetch_assoc()): ?>

<div class="card">

<img src="uploads/<?php echo $row['image']; ?>">

<h2> <?php echo $row['title']; ?> </h2>

<h3> R<?php echo $row['price']; ?></h3>

<p>
Payment Method:
<b>
<?php echo $row['payment_method']; ?></b></p>
    
<p>
Phone:
<b>
<?php echo $row['phone']; ?></b></p>

<p>
Shipping Address:
<b>
<?php echo $row['address']; ?></b></p>

<p>
City:
<b>
<?php echo $row['city']; ?> </b></p>

<p>
Postal Code:
<b> <?php echo $row['postal_code']; ?> </b> </p>

<p class="status">

Status:
<?php echo $row['status']; ?> </p>

<h3> Rate Seller </h3>

<form method="POST">

<input type="hidden" name="seller_id" value="<?php echo $row['seller_id']; ?>">

<select name="seller_rating" required>

<option value=""> Select Rating </option>
<option value="1"> ⭐ 1 Star </option>
<option value="2"> ⭐ 2 Stars </option>
<option value="3"> ⭐ 3 Stars</option>
<option value="4"> ⭐ 4 Stars </option>

<option value="5"> ⭐ 5 Stars </option>

</select>

<textarea name="seller_comment" placeholder="Review this seller" required></textarea>

<button name="sellerReviewBtn"> Submit Seller Review </button>

</form>

<a
href="deleteOrder.php?id=<?php echo $row['id']; ?>"
class="cancel-btn"> Cancel Order </a>
    
<?php if($row['refund_status'] == 'None'): ?>

<a href="requestRefund.php?id=<?php echo $row['id']; ?>"
class="btn"> Request Refund </a>

<?php endif; ?>

<p>
Refund Status:

<b> <?php echo $row['refund_status']; ?> </b>
</p>

</div>

<?php endwhile; ?>

</div>

</div>

</body>
</html>