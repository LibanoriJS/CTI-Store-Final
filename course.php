<?php
    include('connection.php');
    $pageStyle = 'course.css';
    require_once 'header.php';
?>

    <section id="course">
        <div class="container">
            <div class="main-data">
                <?php
                    if(isset($_GET['id'])) {
                        $id = $mysqli->real_escape_string($_GET['id']);
                        // Get and sanitize the 'id' from the URL parameter.
                        $sql_code = "SELECT * FROM courses WHERE id_course = '{$id}'";
                        // Create an SQL query to retrieve course information by 'id_course'.
                        $res = $mysqli->query($sql_code) or die("SQL code execution failed: " . $mysqli->error);
                        // Execute the SQL query and handle errors if any.
                        $quantity = $res->num_rows;
                        // Get the number of rows in the query result.

                        if($quantity == 1) { 
                            // Check if the course exists.
                            $course = $res->fetch_assoc();
                            // Fetch course data from the query result.
                            $sql_update_views = "UPDATE courses SET views = views + 1 WHERE id_course = '{$id}'";
                            // Create an SQL query to update the course views.
                            $res = $mysqli->query($sql_update_views) or die("SQL code execution failed: " . $mysqli->error);
                            // Execute the update query and handle errors if any.
                            echo '
                                <div class="course-image">
                                    <img src="'.$course['image_course'].'" alt="course cover">
                                </div>
                                <div class="course-data">
                                    <div class="top-data">
                                        <h2>'.$course['name_course'].'</h2>
                                        <h3>'.$course['author'].'</h3>
                                    </div>
                                    <div class="rating">
                                        <ul class="stars-list">';
                            $sql = "SELECT stars FROM assessment WHERE courses_id_course = '{$id}'";
                            // Create an SQL query to get star ratings for the course.
                            $resAss = $mysqli->query($sql);
                            // Execute the SQL query and store the result.
                            $qtdAss = $resAss->num_rows;
                            // Get the number of assessment records.
                            $sum = 0;
                            $mean = 0;
                            if($qtdAss > 0){
                                // Check if there are assessment records.
                                while($rowAss = $resAss->fetch_object()){
                                    // Iterate through each assessment.
                                    $sum = $sum + $rowAss->stars;
                                }
                                $mean = round($sum/$qtdAss, 1, PHP_ROUND_HALF_DOWN);
                            }
                            $rounded =  $mean - ($mean-(int)$mean);
                            for($i = 0; $i < 5; $i ++){
                                // Iterate through 5 stars to display the course rating.
                                if($i >= $rounded || $qtdAss <= 0){
                                    // Check if the star is empty or half (if applicable).
                                    if($i == $rounded && ($mean-$rounded) > 0) {
                                        echo '
                                            <li class="star">
                                                <img src="./assets/icons/half-star.svg" alt="star">
                                            </li>
                                        ';
                                    }else{
                                        echo '
                                            <li class="star">
                                                <img src="./assets/icons/star.svg" alt="star">
                                            </li>
                                        ';
                                    }
                                }else {
                                    echo '                   
                                        <li class="star">
                                            <img src="./assets/icons/star-solid.svg" alt="star">
                                        </li>';
                                }
                            }
                            echo '                                                                       
                                    </ul>
                                    <p>'.$mean.' <span>('.$qtdAss.')</span></p>
                                </div>  
                                <h3>$'.$course['price'].'</h3>  
                                <div class="course-actions">
                                    <button class="add-cart" id="'.$id.'">
                                        <img src="./assets/icons/add_cart.svg" alt="add to cart" >
                                    </button>
                                    <a class="buy" href="cart.php?id='.$id.'">
                                        <p>BUY</p>
                                    </a>
                                </div>                    
                            </div>
                            ';
                            echo '
                                </div>
                                <div class="description">
                                    <h3>Description</h3>
                                    <p>
                                        '.$course['description'].'  
                                    </p>
                                </div>
                            ';
                        } else {
                            echo "Course not found!";
                        }
                    }    
                ?>
        </div>
    </section>
    <script src="./assets/js/course.js"></script>
    <?php
    require_once 'footer.php';
?>


