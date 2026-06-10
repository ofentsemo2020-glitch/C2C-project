<?php
session_start();
include 'database.php';

if($_POST){

$username = $_POST['username'];

$email = $_POST['email'];

$password = $_POST['password'];

$verification =
$_POST['verification_number'];

$hashedPassword =
password_hash($password, PASSWORD_DEFAULT);

 $verified = 0;

 if(

 empty($username) || empty($email) || empty($password) ||  empty($verification)

 ){ die("Please fill all fields"); }

$sql = "INSERT INTO users
(username,email,password, verification_number,verified)

VALUES

('$username','$email','$hashedPassword','$verification','$verified')";

if($conn->query($sql)){

header("Location: login.php");

exit();

}else{

echo $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
<title> Ushop registration</title>
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
line-height:1.1; }

.right{
width:50%;
display:flex;
justify-content:center;
align-items:flex-start;
padding-top:50px; }

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
box-sizing:border-box;
}

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
flex-direction:column;
}

.left,
.right{
width:100%;
}

.left h2{
font-size:22px;
text-align:left;
padding:0 15px;
}

.form-box{
width:98%;
max-width:none;
padding:20px 15px;
box-sizing:border-box;
}

input,
textarea,
select{
width:100%;
font-size:16px;
box-sizing:border-box;
}

header{
flex-direction:column; }

nav{
margin-top:15px;
display:flex;
flex-wrap:wrap;
justify-content:center;
gap:10px;
}
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
<h3>Buy and Sell what U want</h3>
</div>

</div>

<nav>
<a href="index.php">Home</a>
<a href="help.php"> Help </a>
<a href="login.php">Login</a>
</nav>

</header>
<div class="main">

<div class="left">
	
<h2>Create your account and start buying and selling U want! </h2>

</div>

<div class="right">
<div class="form-box">

<h2>Create Account</h2>
 
<form method="POST" enctype="multipart/form-data">
<form method="POST" autocomplete="off">

<label style="display:block; margin-top:20px; font-weight:bold;">
Enter ONE of the following:
<br><br>

• ID Document   
• Student Card

</label>

<input
type="text"
name="verification_number"
placeholder="Enter verification number"
required>

<input name="username" placeholder="Username" required>

<input name="email" placeholder="Email" autocomplete="off" required>

<input name="password" placeholder="Password" autocomplete="new-password" required>

<button>sign Up</button>

</form>

<div class="login-link">

already have an account?

<a href="login.php"> Login </a>

</div>
</div>
</div>
</div>

</body>
</html>