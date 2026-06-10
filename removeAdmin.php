<?php
session_start();

include 'database.php';

if($_SESSION['role'] != 'admin'){

die("Access Denied");
}

$id = intval($_GET['id']);

$conn->query("UPDATE users SET role='user' WHERE id=$id");

header("Location: adminDashboard.php");

exit();
?>