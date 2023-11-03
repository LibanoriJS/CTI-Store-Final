<?php
    include('connection.php');
    include('protect.php');
    $pageStyle = 'finished.css';
    require_once 'header.php';
?>

    <section id="finished">
        <div class="container">
            <?php
                if(isset($_GET['id_cart'])) {
                    // Check if 'id_cart' is set in the URL parameters.
                    $id_cart = $mysqli->real_escape_string($_GET['id_cart']);
                    // Retrieve and sanitize 'id_cart' from the URL.
                    $sql_code = "DELETE FROM cart WHERE id_cart = '{$id_cart}'";
                    // Create an SQL query to delete a record from the 'cart' table based on 'id_cart'.
                    $res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);
                    // Execute the SQL query and handle errors if any.
                }
            ?>
            <div class="content">
                <img src="./assets/icons/purchase.svg" alt="purchase image">
                <div class="description">
                    <h3>Purchase completed!</h3>
                    <p>Your course(s) will be sent to the following email:</p>
                    <?php
                        $id = $mysqli->real_escape_string($_SESSION['id']);
                        // Get user id
                        $sql_code = "SELECT email FROM users WHERE id_user = '{$id}'";
                        // Create an SQL query to select the 'email' from the 'users' table based on 'id_user'.
                        $res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);
                        // Execute the SQL query and handle errors if any.
                        $user_email = $res->fetch_assoc()['email'];
                        // Retrieve the user's email from the query result.
                        echo '<span>'.$user_email.'</span>';
                        // Display the user's email within a HTML 'span' element.
                    ?>
                </div>
            </div>
        </div>
    </section>

<?php
    require_once 'footer.php';
?>


