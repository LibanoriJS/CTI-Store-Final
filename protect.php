<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    die("You cannot access this page because you are not logged in.<p><a href=\"login.php\">Login</a></p>");
}

?>
