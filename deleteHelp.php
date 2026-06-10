<?php
session_start();
include 'database.php';

$id = $_GET['id'];

$conn->query("DELETE FROM help
WHERE id='$id'");

header("Location: adminDashboard.php#help");
exit();
?>