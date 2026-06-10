<?php
session_start();
include 'database.php';

$id = $_GET['id'];

$conn->query("
UPDATE orders
SET status='Cancelled',
refund_status='Refunded'
WHERE id='$id'
");

header("Location: sellerOrders.php");
exit();
?>