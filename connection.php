<?php
$usuario = 'root'; // Database username.
$senha = ''; // Database password.
$database = 'canterbury'; // Database name.
$host = 'localhost'; // Database host.

$mysqli = new mysqli($host, $usuario, $senha, $database);

if($mysqli->connect_error) {
    // Check if there is a connection error to the database.
    die("Failed to connect to the database: " . $mysqli->connect_error);
    // Display an error message and the reason for the connection failure.
}
?>
