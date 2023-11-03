<?php
    include('connection.php');
    $pageStyle = 'home.css';
    require_once 'header.php';
?>

    <section id="banner">
        <div class="container-full">
            <div class="content">
                <div class="banner-text">
                    <h1>Welcome to our store, in here you can find all kinds of courses to help yourself inside your work environment.</h1>
                </div>
                <div class="banner-image">
                    <img src="./assets/img/students.png" alt="banner">  
                </div>
            </div>
        </div>
    </section>

    <section id="highlights">
        <div class="container">
            <h3>Highlights</h3>
            <div class="list-card-content">
                <ul class="card-list">
                    <?php
                        $sql = "SELECT * FROM courses ORDER BY views DESC LIMIT 5";
                        // Retrieve the top 5 courses ordered by views from the 'courses' table.
                        $res = $mysqli->query($sql);
                        // Execute the SQL query and store the result.
                        $qtd = $res->num_rows;
                        // Get the number of rows in the query result.

                        if($qtd > 0){
                            // Check if there are rows in the query result.
                            while($row = $res->fetch_object()){
                                // Iterate through each course in the result.
                                echo '
                                <li class="card">
                                    <a href="course.php?id='.$row->id_course.'">
                                        <div class="card-image">
                                            <img src="'.$row->image_course.'" alt="course cover">
                                        </div>
                                        <div class="card-description">
                                            <h4>'.$row->name_course.'</h4>
                                            <p>'.$row->author.'</p>
                                            <div class="rating">
                                                <ul class="stars-list">';

                                $sql = "SELECT stars FROM assessment WHERE courses_id_course = ".$row->id_course."";
                                // Retrieve the star ratings for the course from the 'assessment' table.
                                $resAss = $mysqli->query($sql);
                                // Execute the SQL query and store the result.
                                $qtdAss = $resAss->num_rows;
                                // Get the number of rows in the assessment result.
                                $sum = 0;
                                $mean = 0;
                                if($qtdAss > 0){
                                    // Check if there are assessment records for the course.
                                    while($rowAss = $resAss->fetch_object()){
                                        // Iterate through each assessment.
                                        $sum = $sum + $rowAss->stars;
                                        // Calculate the sum of star ratings.
                                    }
                                    $mean = round($sum/$qtdAss, 1, PHP_ROUND_HALF_DOWN);
                                    // Calculate the mean rating for the course.
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
                                    <h4>$'.$row->price.'</h4>
                                </div>
                            </a>
                        </li>';
                        // Display course information with ratings, price, and other details.
                            }
                        }
                    ?>
                </ul>
                <a class="more" href="./courses.php?others=highlights">
                    <p>Show more</p>
                </a>
            </div>
        </div>    
    </section>

    <section id="releases">
        <div class="container">
            <h3>Releases</h3>
            <div class="list-card-content">
                <ul class="card-list">
                    <?php
                        $sql = "SELECT * FROM courses WHERE is_release = true ORDER BY views DESC LIMIT 5";
                        // Retrieve the top 5 released courses ordered by views from the 'courses' table.
                        $res = $mysqli->query($sql);
                        // Execute the SQL query and store the result.
                        $qtd = $res->num_rows;
                        // Get the number of rows in the query result.

                        if($qtd > 0){
                            // Check if there are rows in the query result.
                            while($row = $res->fetch_object()){
                                // Iterate through each released course in the result.
                                echo '
                                <li class="card">
                                    <a href="course.php?id='.$row->id_course.'">
                                        <div class="card-image">
                                            <img src="'.$row->image_course.'" alt="course cover">
                                        </div>
                                        <div class="card-description">
                                            <h4>'.$row->name_course.'</h4>
                                            <p>'.$row->author.'</p>
                                            <div class="rating">
                                                <ul class="stars-list">';

                                $sql = "SELECT stars FROM assessment WHERE courses_id_course = ".$row->id_course."";
                                // Retrieve the star ratings for the course from the 'assessment' table.
                                $resAss = $mysqli->query($sql);
                                // Execute the SQL query and store the result.
                                $qtdAss = $resAss->num_rows;
                                // Get the number of rows in the assessment result.
                                $sum = 0;
                                $mean = 0;
                                if($qtdAss > 0){
                                    // Check if there are assessment records for the course.
                                    while($rowAss = $resAss->fetch_object()){
                                        // Iterate through each assessment.
                                        $sum = $sum + $rowAss->stars;
                                        // Calculate the sum of star ratings.
                                    }
                                    $mean = round($sum/$qtdAss, 1, PHP_ROUND_HALF_DOWN);
                                    // Calculate the mean rating for the course.
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
                                    <h4>$'.$row->price.'</h4>
                                </div>
                            </a>
                        </li>';
                        // Display released course information with ratings, price, and other details.
                            }
                        }
                    ?>
                </ul>
                <a class="more" href="./courses.php?others=releases">
                    <p>Show more</p>
                </a>
            </div>
        </div>    
    </section>

<?php
    require_once 'footer.php';
?>
