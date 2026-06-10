<?php
session_start();
include 'database.php';

if(!isset($_SESSION['user_id'])){

header("Location: login.php");

exit();
}

if($_SESSION['role'] != 'admin'){

die("Access Denied");
}

$users = $conn->query("SELECT * FROM users");

$products = $conn->query("SELECT products.*, users.username

FROM products JOIN users ON products.user_id = users.id");

$orders = $conn->query("SELECT orders.*, products.title
FROM orders
JOIN products
ON orders.product_id = products.id");

$help =
$conn->query("SELECT help.*, users.username
FROM help
JOIN users
ON help.user_id = users.id
ORDER BY help.id DESC");

$reviews = $conn->query("SELECT reviews.*, users.username,
products.title
FROM reviews
JOIN users
ON reviews.user_id = users.id
JOIN products
ON reviews.product_id = products.id
ORDER BY reviews.id DESC");

$totalUsers =
$conn->query("SELECT * FROM users")->num_rows;

$totalProducts =
$conn->query("SELECT * FROM products")->num_rows;

$totalOrders =
$conn->query("SELECT * FROM orders")->num_rows;

$pendingOrders =
$conn->query("SELECT * FROM orders
WHERE status='Pending'")->num_rows;

$totalReviews =
$conn->query("SELECT * FROM reviews")->num_rows;
?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Dashboard</title>
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

.content{
 flex:1;
 padding:30px; }

.stats{
 display:grid;
 grid-template-columns:repeat(5,1fr);
 gap:20px;
 margin-bottom:30px; }

.stat-card{
 background:white;
 padding:20px;
 border-radius:10px;
 text-align:center; }

.stat-card h1{
 margin:0;
 color:blue;
 font-size:40px; }

.section{
 background:white;
 padding:25px;
 border-radius:15px;
 margin-bottom:30px; }

table{
 width:100%;
 border-collapse:collapse;
 margin-top:20px; }

table th{
 background:blue;
 color:white;
 padding:15px;
 text-align:left; }

table td{
 padding:15px;
 border-bottom:1px solid lightgray; }

table img{
 width:80px;
 height:80px;
 object-fit:cover;
 border-radius:10px; }

.btn{
 display:inline-block;
 padding:10px 15px;
 border-radius:10px;
 color:white;
 text-decoration:none;
 font-weight:bold;
 margin-right:5px;
 margin-top:5px; }

.delete{
 background:red; }

.delete:hover{
 background:darkred; }

.verify{
 background:green; }

.verify:hover{
 background:darkgreen; }

.admin-badge{
 background:green;
 color:white;
 padding:6px 12px;
 border-radius:20px;
 font-size:14px;
 font-weight:bold; }

.user-badge{
 background:gray;
 color:white;
 padding:6px 12px;
 border-radius:20px;
 font-size:14px;
 font-weight:bold; }

@media screen and (max-width:768px){

.main{
 flex-direction:column; }

.sidebar{
 width:100%;
 min-height:auto; }

.stats{
 grid-template-columns:1fr; }

table{
 font-size:14px; }

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

<h3>Admin Dashboard</h3>

</div>

</div>

<nav>

<a href="index.php">Marketplace</a>
<a href="logout.php">Logout</a>

</nav>

</header>

<div class="main">

<div class="sidebar">

<h3>Admin Panel</h3>

<a href="#users">Users</a>
<a href="#products">Products</a>
<a href="#orders">Orders</a>
<a href="#reviews">Reviews</a>
<a href="#help">Help</a>

</div>

<div class="content">

<h1> Welcome Admin </h1>

<p> Manage users, products, reviews and orders.</p>

<div class="stats">

<div class="stat-card">

<h1>

<?php echo $totalUsers; ?>

</h1>

<p>Total Users</p>
</div>

<div class="stat-card">

<h1>

<?php echo $totalProducts; ?>

</h1>

<p>Total Products</p>

</div>

<div class="stat-card">

<h1> <?php echo $totalOrders; ?>
</h1>

<p>Total Orders</p>

</div>

<div class="stat-card">

<h1>
<?php echo $pendingOrders; ?> </h1>

<p>Pending Orders</p>

</div>

<div class="stat-card">

<h1>
<?php echo $totalReviews; ?>
</h1>

<p>Total Reviews</p>

</div>

</div>

<div class="section" id="users">

<h2>Users</h2>

<table>

<tr>

<th>ID</th>

<th>Username</th>

<th>Email</th>

<th>Verification</th>

<th>Role</th>

<th>Action</th>

</tr>

<?php while($user = $users->fetch_assoc()): ?>

<tr>

<td>

<?php echo $user['id']; ?>

</td>

<td>

<?php echo $user['username']; ?>

</td>

<td>

<?php echo $user['email']; ?>

</td>

<td>

<?php echo $user['verification_number']; ?>

</td>

<td>

<?php
if($user['role'] == 'admin'){

 echo "<span class='admin-badge'>
 ADMIN
 </span>";

}else{

  echo "<span class='user-badge'>
 USER
</span>";
}
?>

</td>

<td>

<a href="adminCreation.php?id=<?php echo $user['id']; ?>"
class="btn verify"> Make Admin </a>

<a href="removeAdmin.php?id=<?php echo $user['id']; ?>"
class="btn verify"> Remove Admin </a>

<a href="deleteUser.php?id=<?php echo $user['id']; ?>"
class="btn delete"> Delete </a>

</td>

</tr>
<?php endwhile; ?>

</table>

</div>

<div class="section" id="products">

<h2>Products</h2>

<table>

<tr>

<th>Image</th>

<th>Title</th>

<th>Price</th>

<th>Category</th>

<th>Owner</th>

<th>Action</th>

</tr>

<?php while($product = $products->fetch_assoc()): ?>

<tr>

<td>

<img src="uploads/<?php echo $product['image']; ?>">

</td>

<td>
<?php echo $product['title']; ?>
</td>

<td>
R<?php echo $product['price']; ?>
</td>

<td>
<?php echo $product['category']; ?> </td>

<td>

<?php echo $product['username']; ?>

</td>

<td>
<a href="deleteProduct.php?id=<?php echo $product['id']; ?>"
class="btn delete"> Delete </a>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

<div class="section" id="orders">

<h2>Orders</h2>

<table>

<tr>

<th>Product</th>

<th>Payment</th>

<th>Status</th>

<th>Phone</th>

<th>City</th>

<th>Actions</th>

</tr>

<?php while($order = $orders->fetch_assoc()): ?>

<tr>

<td>
<?php echo $order['title']; ?>
</td>

<td>
<?php echo $order['payment_method']; ?>
</td>

<td>
<?php echo $order['status']; ?>
</td>

<td>
<?php echo $order['phone']; ?>
</td>

<td>
<?php echo $order['city']; ?>
</td>

<td>

<a href="updateOrder.php?id=<?php echo $order['id']; ?>&status=Shipped"
class="btn verify">Ship</a>

<a href="updateOrder.php?id=<?php echo $order['id']; ?>&status=Delivered"
class="btn verify"> Deliver </a>

<a href="deleteOrder.php?id=<?php echo $order['id']; ?>"
class="btn delete"> Delete </a>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

<div class="section" id="reviews">
    
<h2>Refund Requests</h2>

<table border="1" cellpadding="10">

<tr>

<th>Order ID</th>
<th>Product</th>
<th>Buyer</th>
<th>Refund Status</th>
<th>Reason</th>

</tr>

<?php while($row = $refunds->fetch_assoc()): ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['username']; ?></td>

<td><?php echo $row['refund_status']; ?></td>

<td><?php echo $row['refund_reason']; ?></td>

</tr>

<?php endwhile; ?>

</table>    

<h2>Product Reviews</h2>

<table>

<tr>

<th>User</th>

<th>Product</th>

<th>Rating</th>

<th>Comment</th>

<th>Action</th>

</tr>

<?php while($review = $reviews->fetch_assoc()): ?>

<tr>

<td>

<?php echo $review['username']; ?>

</td>

<td>

<?php echo $review['title']; ?>

</td>

<td>

<?php
for($i=0; $i<$review['rating']; $i++){
echo "⭐";
}
?>

</td>

<td>
<?php echo $review['comment']; ?>
</td>

<td>

<a href="deleteReview.php?id=<?php echo $review['id']; ?>"
class="btn delete"> Delete

</a>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

<div class="section" id="help">

<h2>Help Requests</h2>

<table>

<tr>

<th>User</th>

<th>Subject</th>

<th>Message</th>

<th>Status</th>
<th>Date</th>
<th>Actions</th>

</tr>
<?php while($helpRow = $help->fetch_assoc()): ?>
<tr>

<td>

<?php echo $helpRow['username']; ?>

</td>

<td>
<?php echo $helpRow['subject']; ?>
</td>

<td>
<?php echo $helpRow['message']; ?>
</td>

<td>
<?php echo $helpRow['status']; ?>
</td>

<td>
<?php echo $helpRow['created_at']; ?>
</td>

<td>

<a href="updateHelp.php?id=<?php echo $helpRow['id']; ?>&status=Resolved"
class="btn verify"> Resolved </a>

<a href="deleteHelp.php?id=<?php echo $helpRow['id']; ?>"
class="btn delete"> Delete </a>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</div>

</body>
</html>