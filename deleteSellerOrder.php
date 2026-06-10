<?php

session_start();
include 'database.php';

if(!isset($_SESSION['user_id'])){

header("Location: login.php");
exit();
}

$id = $_GET['id'];

$conn->query("DELETE FROM orders WHERE id='$id'");

header("Location: sellerOrders.php");
exit();

?>