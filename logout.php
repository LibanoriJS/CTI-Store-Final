<?php
// Start a new session if it is not already set.
if (!isset($_SESSION)) {
    session_start();
}

// Destroy the current session (log out the user).
session_destroy();

// Redirect the user to the index page.
header("Location: index.php");
?>
