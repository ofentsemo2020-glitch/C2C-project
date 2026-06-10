<?php
include 'database.php';

$message = "";

if($_POST){

$email = $_POST['email'];
$newPassword = $_POST['new_password'];

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
$check = $conn->query("SELECT * FROM users

WHERE email='$email'");

if($check->num_rows > 0){

$conn->query("UPDATE users
SET password='$hashedPassword'
WHERE email='$email'");

$message = "Password Updated Successfully!";

}else{
$message = "Email Not Found!"; }
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Forgot Password</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">   
<style>

body{
margin:0;
font-family:Arial;
background:lightblue;
}

.container{
width:40%;
margin:80px auto;
background:white;
padding:40px;
border-radius:20px; }

input{
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
background:darkblue;
}

.message{
margin-top:20px;
font-weight:bold;
color:green; }

.back{
display:inline-block;
margin-top:20px;
color:blue;
font-weight:bold;
text-decoration:none; }

@media screen and (max-width:768px){

.container{
width:90%;
}
}

</style>

</head>

<body>

<div class="container">

<h1> Reset Password </h1>

<p> Enter your email and new password.</p>

<form method="POST">

<input type="email" name="email" placeholder="Enter Email" required>

<input type="password" name="new_password" placeholder="Enter New Password" required>

<button> Reset Password </button>

</form>

<div class="message">

<?php echo $message; ?>

</div>

<a href="login.php" class="back"> Back to Login </a>

</div>

</body>
</html>