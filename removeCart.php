<?php
include 'database.php';

$id = $_GET['id'];

$conn->query("DELETE FROM cart WHERE id='$id'");

header("Location: cart.php");
?>