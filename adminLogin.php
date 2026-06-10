<?php
session_start();
include 'database.php';

if($_POST){

$email = $_POST['email'];

$password = $_POST['password'];

$sql = "SELECT * FROM users
WHERE email='$email'
AND role='admin'";

$result = $conn->query($sql);

if($result->num_rows > 0){

$row = $result->fetch_assoc();

if(password_verify(
$password,
$row['password']
)){

$_SESSION['user_id'] =
$row['id'];

$_SESSION['role'] =
$row['role'];

header("Location: adminDashboard.php");

exit();

}else{

$error = "Wrong Password";
}

}else{

$error = "Admin Not Found";
}
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Login</title>

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
 padding:15px 60px; }

.logo-section{
 display:flex;
 align-items:center; }

.logo{
 width:150px; }

.logo-text{
 margin-left:10px; }

.logo-text p{
 margin:0;
 color:black;
 font-size:14px; }

nav a{
 margin-left:20px;
 color:black;
 font-weight:bold;
 text-decoration:none; }

nav a:hover{
 color:blue; }

.main{
 display:flex;
 height:85vh; }

.left{
 width:50%;
 display:flex;
 justify-content:center;
 align-items:center;
 padding:40px; }

.left h2{
 font-size:65px;
 line-height:1.1;
 color:black; }

.right{
 width:50%;
 display:flex;
 justify-content:center;
 align-items:center; }

.form-box{
 background:white;
 width:70%;
 padding:40px;
 border-radius:20px; }

.form-box h2{
 margin-bottom:30px; }

input{
 width:100%;
 padding:18px;
 margin-top:15px;
 border-radius:30px;
 border:1px solid gray;
 font-size:16px;
 box-sizing:border-box; }

button{
 width:100%;
 padding:18px;
 margin-top:25px;
 border-radius:30px;
 background:blue;
 color:white;
 font-size:18px;
 border:none; }

button:hover{
 background:darkblue; }

.error{
 background:red;
 color:white;
 padding:15px;
 border-radius:10px;
 margin-bottom:20px;
 text-align:center; }

@media screen and (max-width:768px){

.main{
 flex-direction:column; }

.left,
.right{
 width:100%; }

.left h2{
 font-size:40px;
 text-align:center; }

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

<h1>UShop</h1>

<h3>Buy and Sell what U want</h3>

</div>

</div>

<nav>

<a href="index.php">Home</a>

<a href="login.php">User Login</a>

</nav>

</header>

<div class="main">

<div class="left">

<h2>Admin Control Panel Login</h2>

</div>

<div class="right">

<div class="form-box">

<h2>Admin Login</h2>

<?php if(isset($error)): ?>

<div class="error">

<?php echo $error; ?>

</div>

<?php endif; ?>

<form method="POST" autocomplete="off">

<input type="email" name="email" placeholder="Admin Email" required>

<input type="password" name="password" placeholder="Password" autocomplete="new-password" required>

<button>Login</button>

</form>

</div>

</div>

</div>

</body>
</html>