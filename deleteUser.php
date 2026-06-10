<?php
session_start();

include 'database.php';

/* ADMIN CHECK */

if($_SESSION['role'] != 'admin'){

    die("Access Denied");
}

$id = intval($_GET['id']);

/* DELETE USER ORDERS */

$conn->query("DELETE FROM orders
WHERE buyer_id=$id");

/* DELETE USER PRODUCTS */

$conn->query("DELETE FROM products
WHERE user_id=$id");

/* DELETE USER */

$conn->query("DELETE FROM users
WHERE id=$id");

header("Location: adminDashboard.php");

exit();
?>