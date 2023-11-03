<?php
    include('connection.php');
    include('protect.php');
    $pageStyle = 'cart.css';
    require_once 'header.php';
?>

    <section id="cart">
        <div class="container j-center">
            <div class="cart-content">
                <div class="courses">
                    <?php
                        if(!isset($_SESSION)) {
                            session_start();
                        }

                        // Check if the user is logged in and get their user ID if available.
                        if(isset($_SESSION['id'])) {
                            $id_user = $_SESSION['id'];   
                        }

                        // Retrieve the latest cart associated with the user.
                        $sql_code = "SELECT * FROM cart WHERE user_id_user = {$id_user} ORDER BY id_cart DESC LIMIT 1";
                        $res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);

                        // If a cart is found, retrieve the details of the courses in the cart.
                        if($res->num_rows > 0){
                            $id_cart = $res->fetch_assoc()['id_cart'];
                            $sql_code = "SELECT c.id_course, c.name_course, c.image_course, c.price, c.author 
                                            FROM courses c 
                                            INNER JOIN item_cart ic ON c.id_course = ic.courses_id_course 
                                            WHERE ic.cart_id_cart = '{$id_cart}';
                                            ";
                        }

                        // Check if a specific course is requested and retrieve its details.
                        if(isset($_GET['id'])) {
                            $id = $mysqli->real_escape_string($_GET['id']);
                            $sql_code = "SELECT * FROM courses WHERE id_course = '{$id}'";
                        }

                        // Execute the SQL query and get the number of retrieved rows.
                        $res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);
                        $quantity = $res->num_rows;

                        if($quantity >= 1) { 
                            echo '<ul class="courses-list">';
                            // Loop through the retrieved courses and display them.
                            while($row = $res->fetch_object()){
                                echo '
                                    <li class="course">
                                        <div class="image-course">
                                            <a href="course.php?id='.$row->id_course.'">
                                                <img src="'.$row->image_course.'" alt="course cover">
                                            </a>
                                        </div>
                                        <div class="description-course">
                                            <a href="course.php?id='.$row->id_course.'">
                                                <div class="data">
                                                    <h4>'.$row->name_course.'</h4>
                                                    <p>'.$row->author.'</p>
                                                    <h3>$'.$row->price.'</h3>
                                                </div>
                                            </a>
                                ';

                                if(!isset($_GET['id'])) {
                                    // Display a remove button for each course in the cart (if not in the course view).
                                    echo '
                                        <button class="rem-cart" id="'.$row->id_course.'">
                                            <img class="trash-icon" src="./assets/icons/trash.svg" alt="remove">
                                        </button>';
                                }
                                echo '
                                        </div>
                                    </li>
                                ';      
                            }
                            echo '</ul>';
                        }
                    ?>
                </div>
                <div class="cart-details">
                    <h3>Total</h3>
                    <?php
                        // Retrieve the latest cart associated with the user.
                        $sql_code = "SELECT * FROM cart WHERE user_id_user = {$id_user} ORDER BY id_cart DESC LIMIT 1";
                        $res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);

                        // If a cart is found, retrieve the details of the courses in the cart.
                        if($res->num_rows > 0){
                            $id_cart = $res->fetch_assoc()['id_cart'];
                            $sql_code = "SELECT c.name_course, c.image_course, c.price, c.author 
                                            FROM courses c 
                                            INNER JOIN item_cart ic ON c.id_course = ic.courses_id_course 
                                            WHERE ic.cart_id_cart = '{$id_cart}';
                                            ";
                        }

                        // Check if a specific course is requested and retrieve its details.
                        if(isset($_GET['id'])) {
                            $id = $mysqli->real_escape_string($_GET['id']);
                            $sql_code = "SELECT * FROM courses WHERE id_course = '{$id}'";
                        }

                        // Execute the SQL query and get the number of retrieved rows.
                        $res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);
                        $quantity = $res->num_rows;
                        $total = 0;

                        // If courses are found, display them and calculate the total price.
                        if($quantity >= 1) { 
                            echo '<ul class="cart-items">';
                            while($row = $res->fetch_object()){
                                echo '
                                    <li class="item">
                                        <h5>'.$row->name_course.'</h5>
                                        <p>$'.$row->price.'</p>
                                    </li>
                                ';
                                $total += $row->price;      
                            }
                            echo '</ul>';
                        }

                        // Display the total price.
                        echo '
                            <div class="total">
                                <h5>Total:</h5>
                                <p>$'.$total.'</p>
                            </div>';

                        // Determine which "Finalize purchase" link to display based on the context.
                        if(!isset($_GET['id']) && $res->num_rows == 0 ) {
                            echo '
                                <a class="btn-purchase disabled-link">
                                    Finalize purchase
                                </a>
                            ';
                        } elseif (isset($_GET['id'])) {
                            echo '
                                <a class="btn-purchase" href="finished.php">
                                    Finalize purchase
                                </a>
                            ';
                        } else {
                            echo '
                                <a class="btn-purchase" href="finished.php?id_cart='.$id_cart.'">
                                    Finalize purchase
                                </a>
                            ';
                        }
                    ?>       
                </div>
            </div>
        </div>
    </section>
    <script src="./assets/js/cart.js"></script>
<?php
    require_once 'footer.php';
?>


