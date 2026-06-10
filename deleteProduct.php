<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$conn->query("DELETE FROM products WHERE id=$id");

header("Location: dashboard.php");
exit();
?>