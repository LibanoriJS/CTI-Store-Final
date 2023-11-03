<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canterbury Courses</title>
    <link rel="stylesheet" href="./assets/css/global.css">
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="<?= 'assets/css/' . $pageStyle ?>">
</head>
<body>
    <header id="main-header">
        <div class="container">
            <nav class="navbar">
                <a href="index.php">
                    <img src="./assets/img/logo.png" alt="logo">
                </a>
                <div class="mobile-menu">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>
                </div>
                <div class="nav-links">
                    <ul class="nav-list">
                        <li class="nav-link"><a href="index.php">Home</a></li>
                        <li class="nav-link"><a href="courses.php">Courses</a></li>
                        <li class="nav-link"><a href="about.php">About</a></li>
                    </ul>
                    <?php   
                        if(!isset($_SESSION)) {
                            // Start a new session if it's not already set.
                            session_start();
                        }

                        if(isset($_SESSION['id'])) {
                            // Check if the 'id' session variable is set, indicating that a user is logged in.
                            echo '<a class="cart-icon" href="cart.php">
                                <!-- Display a shopping cart icon -->
                                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M32 5.33333L28.6667 17H9.29452M30.3333 23.6667H10.3333L7 2H2M12 30.3333C12 31.2538 11.2538 32 10.3333 32C9.41287 32 8.66667 31.2538 8.66667 30.3333C8.66667 29.4128 9.41287 28.6667 10.3333 28.6667C11.2538 28.6667 12 29.4128 12 30.3333ZM30.3333 30.3333C30.3333 31.2538 29.5872 32 28.6667 32C27.7462 32 27 31.2538 27 30.3333C27 29.4128 27.7462 28.6667 28.6667 28.6667C29.5872 28.6667 30.3333 29.4128 30.3333 30.3333Z" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>';
                            echo '<div class="user-actions">';
                            // Display user-related actions.
                            echo '<div class="welcome-user">';
                            echo '<p>Welcome,</p>';
                            // Display a welcome message.
                            echo '<p>'.$_SESSION['name'].'!</p>';
                            // Display the user's name from the session.
                            echo '</div>';
                            echo '<a class="logout-icon" href="logout.php"><img src="./assets/icons/logout.svg" alt="logout"></a>';
                            // Display a logout icon and link to the logout page.
                            echo '</div">';
                        }
                        // If no user is logged in, display sign-up and login buttons.
                        else {
                            echo '<a class="btn btn-signin" href="./signin.php">Sign-up</a>';
                            echo '<a class="btn btn-login" href="./login.php">Login</a>';
                        }
                        ?>

                </div>
            </nav>
        </div>
    </header>

    