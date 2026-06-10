<?php
session_start();
include 'database.php';

if ($_POST) {

$e = $_POST['email'];
$p = $_POST['password'];

$result = $conn->query("SELECT * FROM users WHERE email='$e'");

if ($result->num_rows > 0) {

 $user = $result->fetch_assoc();

 if (password_verify($p, $user['password'])) {

 $_SESSION['user_id'] = $user['id'];
 
 $_SESSION['role'] = $row['role'];

 header("Location: dashboard.php");
 exit();

} else {echo "Wrong Password";}
} else { echo "User Not Found";}
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Login</title>
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
text-decoration:none;
 font-weight:bold; }

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
font-size:70px;
line-height:1.1;}

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
border:1px solid #ccc;
font-size:16px;
box-sizing:border-box; }

button{
width: 100%;
padding:18px;
margin-top:25px;
border-radius:30px;
background:blue;
color:white;
font-size:18px; }

button:hover{
background:blue; }

.login-link{
text-align:center;
margin-top:20px; }

@media screen and (max-width:768px){

.main{
flex-direction:column; }

.left,
.right{
width:100%; }

.left h2{
font-size:32px;
text-align:left;
padding:0 15px; }

.form-box{
width:98%;
max-width:none;
padding:20px 15px;
box-sizing:border-box; }

input,
textarea,
select{
width:100%;
font-size:16px;
box-sizing:border-box; }

header{
flex-direction:column; }

nav{
margin-top:15px;
display:flex;
flex-wrap:wrap;
justify-content:center;
gap:10px; }
    nav a{
 margin-left:20px;
 color:green;
 font-weight:bold;
 text-decoration:none;
 transition:0.3s; }
nav a:hover{
color:darkblue; }
nav a{
margin:5px; }
    
</style>

</head>

<body>

<header>

<div class="logo-section">

<img src="c2c_Logo.png" class="logo">

<div class="logo-text">

<h1>UShop</h1>

<p>Buy and Sell what U want</p>

</div>
</div>

<nav>
<a href="index.php">Home</a>
<a href="help.php"> Help </a>
<a href="registration.php">Sign Up</a>
</nav>

</header>

<div class="main">

<div class="left">

<h2> Login and continue shopping with UShop. </h2>

</div>

<div class="right">

<div class="form-box">

<h2>Login</h2>

<form method="POST">

<input type="email" name="email" placeholder="Email">
<input type="password" name="password" placeholder="Password">

<button>login</button>

<div style="text-align:center; margin-top:20px;">

<a href="forgotPassword.php"> Forgot Password? </a>

</div>

</form>

<div class="login-link"> Don't have an account? <a href="registration.php"> Sign Up </a>

</div>
</div>
</div>

</div>

</body>
</html>