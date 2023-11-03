<?php 
include('../connection.php');

// Retrieve the latest cart's ID
$sql_code = "SELECT * FROM cart ORDER BY id_cart DESC LIMIT 1";
$res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);

// Check if a cart exists
if ($res->num_rows > 0) {
    $id_cart = $res->fetch_assoc()['id_cart'];

    // Check if the course is already in the cart
    $sql_code = "SELECT c.id_course 
        FROM courses c 
        INNER JOIN item_cart ic ON c.id_course = ic.courses_id_course 
        WHERE ic.cart_id_cart = '{$id_cart}';";

    $res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);
    $qtd = $res->num_rows;
    $equal = '';

    // Loop through courses in the cart to check for equality
    if ($qtd > 0) {
        while ($row = $res->fetch_object()) {
            if ($row->id_course == $_GET['id']) {
                $equal = 'true';
                break;
            }
        }
    }

    // If the course is not already in the cart, add it
    if ($equal != 'true') {
        $sql_code = "INSERT INTO item_cart VALUES (null, {$_GET['id']}, {$id_cart})";
        $res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);
    }
} else {
    // Create a new cart if one doesn't exist
    $sql_code = "INSERT INTO cart VALUES (null, 0)";
    $res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);

    // Retrieve the ID of the newly created cart
    $sql_code = "SELECT id_cart FROM cart ORDER BY id_cart DESC LIMIT 1";
    $res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);
    $id_cart = $res->fetch_assoc()['id_cart'];
    echo $id_cart;

    // Add the selected course to the new cart
    $sql_code = "INSERT INTO item_cart VALUES (null, {$_GET['id']}, {$id_cart})";
    $res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);
}
?>
