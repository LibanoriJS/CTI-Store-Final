<?php
include('connection.php');

// Check if either email or password fields are set.
if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);

    // Check if the email is empty.
    if (empty($email)) {
        echo "Fill in your email";
    } 
    // Check if the password is empty.
    elseif (empty($password)) {
        echo "Fill in your password";
    } 
    else {
        // Create an SQL query to retrieve user data based on the provided email and password.
        $sql_code = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $sql_query = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);

        $quantity = $sql_query->num_rows;

        // Check if a single user was found with the given email and password.
        if ($quantity == 1) {
            $user = $sql_query->fetch_assoc();

            // Start a new session if not already set.
            if (!isset($_SESSION)) {
                session_start();
            }

            // Set session variables with user information.
            $_SESSION['id'] = $user['id_user'];
            $_SESSION['name'] = $user['name_user'];

            // Redirect to the index page after successful login.
            header("Location: index.php");
        } 
        else {
            // Display an error message for incorrect email or password.
            echo "Failed to log in! Incorrect email or password";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canterbury Courses</title>

    <!-- importing styles -->
     <link rel="stylesheet" href="./assets/css/global.css">
     <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <section id="container-login">
        <div class="image-login">

        </div>
        <div class="login-content">
            <h2>Login</h2>
            <form class="form-login" method="POST">
                <div class="form-email">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        placeholder="Type your e-mail..."
                        required
                    >
                </div>
                <div class="form-password">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        placeholder="Type your password..." 
                        required   
                    >
                </div>
                <button 
                    type="submit"
                    class="login-btn"
                >
                    Login
                </button>
            </form>
            <p>Don't have an account? <a href="./signin.php">Register</a> </p>
        </div>
    </section>
</body>
</html>