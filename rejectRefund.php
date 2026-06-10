<?php

session_start();
include 'database.php';

$id = $_GET['id'];

$conn->query("UPDATE orders

SET refund_status='Rejected'

WHERE id='$id'");

header("Location: sellerOrders.php");
exit();

?>