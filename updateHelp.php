<?php
session_start();
include 'database.php';

$id = $_GET['id'];
$status = $_GET['status'];

$conn->query("UPDATE help SET status='$status' WHERE id='$id'");

header("Location: adminDashboard.php#help");
exit();
?>