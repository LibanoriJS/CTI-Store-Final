<?php
include('connection.php');

if (isset($_POST['email']) && isset($_POST['password'])) {
    // Check if email and password fields have been submitted.

    if (empty($_POST['email'])) {
        echo "Please fill in the email field";
        // Display an error message if the email field is empty.
    } elseif (empty($_POST['password'])) {
        echo "Please fill in the password field";
        // Display an error message if the password field is empty.
    } elseif ($_POST['password'] !== $_POST['c-password']) {
        echo "Password and confirmation password do not match";
        // Display an error message if the password and confirmation password do not match.
    } else {
        $email = $mysqli->real_escape_string($_POST['email']);

        // Check if the email already exists in the database.
        $checkEmailQuery = "SELECT email FROM users WHERE email = '$email'";
        $result = $mysqli->query($checkEmailQuery);

        if ($result->num_rows > 0) {
            echo "Email already exists in the database. Please choose a different email.";
            // Display an error message if the email is already registered in the database.
        } else {
            $name = $mysqli->real_escape_string($_POST['name']);
            $last_name = $mysqli->real_escape_string($_POST['last-name']);
            $password = $mysqli->real_escape_string($_POST['password']);

            $sql_code = "INSERT INTO users (name_user, last_name_user, email, password) VALUES ('$name', '$last_name', '$email', '$password')";
            $res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);

            if ($res === true) {
                echo "<script>alert('Registration successful!');</script>";
                header("Location: login.php");
                // Insert user data into the database if all conditions are met, and redirect to the login page.
            } else {
                echo "<script>alert('Registration failed!');</script>";
                header("Location: login.php");
                // Display an error message and redirect to the login page if registration fails.
            }
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
     <link rel="stylesheet" href="assets/css/signin.css">
</head>
<body>
    <section id="container-signin">
        <div class="image-signin">

        </div>
        <div class="signin-content">
            <h2>Sign-in</h2>
            <form class="form-signin" action="" method="POST">
                <div class="form-name">
                    <label for="name">Name</label>
                    <input 
                        type="name" 
                        name="name" 
                        id="name"
                        placeholder="Type your name..."
                        required
                    >
                </div>
                <div class="form-last-name">
                    <label for="last-name">Last name</label>
                    <input 
                        type="last-name" 
                        name="last-name" 
                        id="last-name"
                        placeholder="Type your last name..."
                        required
                    >
                </div>
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
                <div class="form-c-password">
                    <label for="c-password">Confirm your password</label>
                    <input 
                        type="password" 
                        name="c-password" 
                        id="c-password"
                        placeholder="Type your password again..." 
                        required   
                    >
                </div>
                <button 
                    type="submit"
                    class="signin-btn"
                >
                    Sign-in
                </button>
            </form>
            <p>Already have an account? <a href="./login.php">Login</a> </p>
        </div>
    </section>
</body>
</html>