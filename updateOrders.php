<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {

header("Location: login.php");
exit();
}

$id = $_GET['id'];

$status = $_GET['status'];

$conn->query("UPDATE orders SET status='$status' WHERE id=$id");

header("Location: orders.php");
exit();
?>