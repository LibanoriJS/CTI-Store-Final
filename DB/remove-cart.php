<?php
include('../connection.php');

// Retrieve the latest cart's ID
$sql_code = "SELECT * FROM cart ORDER BY id_cart DESC LIMIT 1";
$res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);

// Get the ID of the latest cart
$id_cart = $res->fetch_assoc()['id_cart'];
echo $id_cart;

// Delete the selected course from the cart
$sql_code = "DELETE FROM item_cart WHERE courses_id_course = {$_GET['id']} AND cart_id_cart = {$id_cart}";
$res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);
?>
