<?php
include 'database.php';

$id = $_GET['id'];

$conn->query("DELETE FROM reviews

WHERE id='$id'");

header("Location: adminDashboard.php");
?>