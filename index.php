<?php
session_start();

if(isset($_SESSION['user_id'])){

    header("Location: marketplace.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<title>UShop</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">   
<style>

body{
margin:0;
font-family:Arial;
background:lightblue;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.box{
background:white;
padding:50px;
border-radius:20px;
text-align:center;
width:400px;
}

.logo{
width:150px;
margin-bottom:20px;
}

h1{
margin-bottom:10px;
}

p{
margin-bottom:30px;
}

.btn{
display:block;
padding:15px;
margin-top:15px;
background:blue;
color:white;
text-decoration:none;
border-radius:10px;
font-weight:bold;
}

.btn:hover{
background:darkblue;
}

</style>

</head>

<body>

<div class="box">

<img src="c2c_Logo.png" class="logo">

<h1>Welcome to UShop</h1>

<p>Buy and Sell what U want</p>

<a href="login.php" class="btn">Login</a>

<a href="registration.php" class="btn">Register</a>

</div>

</body>
</html>