<?php
session_start();
include 'database.php';

if(!isset($_SESSION['user_id'])){

header("Location: login.php");

exit();
}

if($_POST){

$uid = $_SESSION['user_id'];

$subject = $_POST['subject'];

$message = $_POST['message'];

$sql = "INSERT INTO help

(user_id,subject,message)

VALUES

('$uid','$subject','$message')";

if($conn->query($sql)){

echo "<script>
alert('Help Request Sent!');
</script>";

}else{

echo $conn->error;
}
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Help Page</title>
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

.container{
 width:50%;
 margin:50px auto;
background:white;
padding:40px;
border-radius:20px; }

input,
textarea{
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

.back{
display:inline-block;
margin-top:20px;
color:blue;
font-weight:bold;
text-decoration:none; }

@media screen and (max-width:768px){

.container{
 width:90%; }

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

<h3>Help Center</h3>

</div>

</div>

<nav>

<a href="marketplace.php">Marketplace</a>
<a href="orders.php">Orders</a>
<a href="logout.php">Logout</a>

</nav>

</header>

<div class="container">

<h1> Need Help? </h1>

<p> Send a help request to the admin team </p>

<form method="POST">
<input name="subject" placeholder="Subject" required>

<textarea name="message" placeholder="Describe your issue" rows="8" required></textarea>

<button>Send Help Request</button>

</form>

<a href="index.php" class="back"> Back to Marketplace</a>

</div>

</body>
</html>