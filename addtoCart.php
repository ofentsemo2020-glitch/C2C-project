<?php
session_start();
include 'database.php';

if(!isset($_SESSION['user_id'])){

header("Location: login.php");
exit();
}

$user_id = $_SESSION['user_id'];

$product_id = $_GET['id'];

$check = $conn->query("SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");

if($check->num_rows > 0){
 $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id='$user_id' AND product_id='$product_id'");

}else{

$conn->query("INSERT INTO cart

(user_id,product_id)

VALUES
('$user_id','$product_id')");
}

header("Location: cart.php");
?>