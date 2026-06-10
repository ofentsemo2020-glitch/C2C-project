<?php
session_start();

include 'database.php';

if($_SESSION['role'] != 'admin'){

die("Access Denied");
}

$id = intval($_GET['id']);

$error = "";

if($_POST){

$password = $_POST['password'];

$adminId = $_SESSION['user_id'];

$admin =
$conn->query("SELECT * FROM users
WHERE id=$adminId");

$adminRow =
$admin->fetch_assoc();

if(password_verify($password, $adminRow['password'])){

$conn->query("UPDATE users SET role='admin' WHERE id=$id");

header("Location: adminDashboard.php");

exit();

}else{
$error = "Wrong Password";
}
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Confirm Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">   
<style>

body{
margin:0;
font-family:Arial;
background:lightblue;
display:flex;
justify-content:center;
align-items:center;
height:100vh; }

.box{
background:white;
padding:40px;
border-radius:20px;
width:400px; }

input{
width:100%;
padding:15px;
margin-top:20px;
border-radius:10px;
border:1px solid gray;
box-sizing:border-box; }

button{
width:100%;
padding:15px;
margin-top:20px;
background:green;
color:white;
border:none;
border-radius:10px;
font-size:18px; }

.error{
background:red;
color:white;
padding:10px;
border-radius:10px;
margin-top:15px; }

</style>

</head>

<body>

<div class="box">

<h2> Confirm Admin Password </h2>

<p> Enter your current admin password to continue. </p>

<?php if($error != ""): ?>

<div class="error">

<?php echo $error; ?>

</div>

<?php endif; ?>

<form method="POST">

<input type="password"name="password" placeholder="Current Admin Password" required>

<button> Confirm </button>

</form>

</div>

</body>

</html>