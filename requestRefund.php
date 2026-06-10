<?php

session_start();
include 'database.php';

$id = $_GET['id'];

$conn->query("UPDATE orders

SET refund_status='Requested'

WHERE id='$id'");

header("Location: orders.php");
exit();

?>