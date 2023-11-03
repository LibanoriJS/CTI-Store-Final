<?php
// Include the database connection
include('connection.php');

// Set the page style and require the header
$pageStyle = 'courses.css';
require_once 'header.php';

// Define the number of results per page and the current page
$results_per_page = 5;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// Calculate the start index
$start_index = ($page - 1) * $results_per_page;

// Search variable
$search = isset($_GET['search']) ? $mysqli->real_escape_string($_GET['search']) : '';

// Sorting
$order = isset($_GET['order']) ? $mysqli->real_escape_string($_GET['order']) : 'name'; // Default sorting is by name

// Filtering
$filter = isset($_GET['others']) ? $mysqli->real_escape_string($_GET['others']) : 'all'; // Default filter is "All"

// Checking the total quantity of courses
$sql = "SELECT id_course FROM courses WHERE name_course LIKE '%$search'";

$res = $mysqli->query($sql);
$qtdCourses = $res->num_rows;

// SQL query with LIMIT and ORDER BY
$sql = "SELECT * FROM courses WHERE name_course LIKE '%$search'";

// Filter: Highlights
if ($filter === 'highlights') {
    $sql .= " ORDER BY views DESC"; // Sort by views
} elseif ($filter === 'releases') {
    $sql .= " AND is_release = TRUE"; // Filter by releases
    $sql .= " ORDER BY name_course ASC"; // Can be changed as needed
} else {
    $sql .= " ORDER BY ";
    if ($order === 'lowest') {
        $sql .= "price ASC";
    } elseif ($order === 'highest') {
        $sql .= "price DESC";
    } else {
        $sql .= "name_course ASC"; // Default sorting
    }
}
$sql .= " LIMIT $start_index, $results_per_page";
$res = $mysqli->query($sql);
$qtd = $res->num_rows;
?>


<section id="courses">
    <div class="container">
        <div class="filter">
        <form class="form-filter" action="" method="GET">
                <div class="filter-select">
                    <select id="order" name="order" onchange="this.form.submit()">
                        <option value="" <?php if ($order === '') echo 'selected'; ?>>Order by</option>
                        <option value="lowest" <?php if ($order === 'lowest') echo 'selected'; ?>>Lowest price</option>
                        <option value="highest" <?php if ($order === 'highest') echo 'selected'; ?>>Highest price</option>
                    </select>

                    <select id="others" name="others" onchange="this.form.submit()">
                        <option value="" <?php if ($filter === '') echo 'selected'; ?>>All</option>
                        <option value="highlights" <?php if ($filter === 'highlights') echo 'selected'; ?>>Highlights</option>
                        <option value="releases" <?php if ($filter === 'releases') echo 'selected'; ?>>Releases</option>
                    </select>
                </div>
                <div class="search">
                    <button type="submit">
                        <img src="./assets/icons/search.svg" alt="search">
                    </button>
                    <input type="search" name="search" id="search" value="<?php echo $search; ?>">
                </div>
            </form>

        </div>
        <div class="courses-content">
            <div class="card-list-content">
                <ul class="card-list">
                    <?php
                        if ($qtd > 0) {
                            while ($row = $res->fetch_object()) {
                                echo '
                                    <li class="card">
                                        <a href="course.php?id=' . $row->id_course . '">
                                            <div class="card-image">
                                                <img src="' . $row->image_course . '" alt="course cover">
                                            </div>
                                            <div class="card-description">
                                                <h4>' . $row->name_course . '</h4>
                                                <p>' . $row->author . '</p>
                                                <div class="rating">
                                                    <ul class="stars-list">';

                                // Query to retrieve course ratings
                                $sql = "SELECT stars FROM assessment WHERE courses_id_course = " . $row->id_course . "";
                                $resAss = $mysqli->query($sql);
                                $qtdAss = $resAss->num_rows;
                                $sum = 0;
                                $mean = 0;

                                if ($qtdAss > 0) {
                                    while ($rowAss = $resAss->fetch_object()) {
                                        $sum = $sum + $rowAss->stars;
                                    }
                                    $mean = round($sum / $qtdAss, 1, PHP_ROUND_HALF_DOWN);
                                }
                                $rounded =  $mean - ($mean - (int)$mean);

                                // Loop to display star ratings
                                for ($i = 0; $i < 5; $i++) {
                                    if ($i >= $rounded || $qtdAss <= 0) {
                                        if ($i == $rounded && ($mean - $rounded) > 0) {
                                            echo '
                                                <li class="star">
                                                    <img src="./assets/icons/half-star.svg" alt="star">
                                                </li>
                                            ';
                                        } else {
                                            echo '
                                                <li class="star">
                                                    <img src="./assets/icons/star.svg" alt="star">
                                                </li>
                                            ';
                                        }
                                    } else {
                                        echo '                   
                                            <li class="star">
                                                <img src="./assets/icons/star-solid.svg" alt="star">
                                            </li>';
                                    }
                                }
                                echo '                                                                       
                                    </ul>
                                    <p>' . $mean . ' <span>(' . $qtdAss . ')</span></p>
                                </div>                        
                                <h4>$' . $row->price . '</h4>
                            </div>
                        </a>
                        </li>';
                        }
                        }
                    ?>
                </ul>
            </div>
        </div>
        <div class="pagination">
            <?php
                $total_pages = ceil($qtdCourses / $results_per_page); // Calculate the total number of pages

                // Display previous and next page buttons
                if ($page > 1) {
                    echo '<a href="?page=1&order=' . $order . '&others=' . $filter . '"><<</a>';
                    echo '<a href="?page=' . ($page - 1) . '&order=' . $order . '&others=' . $filter . '"><</a>';
                }

                // Loop to generate page links
                for ($i = max(1, $page - 5); $i <= min($page + 5, $total_pages); $i++) {
                    echo '<a href="?page=' . $i . '&order=' . $order . '&others=' . $filter . '&search=' . $search . '"';
                    
                    if ($i == $page) {
                        echo ' class="active"'; // Mark the current page as active
                    }
                    echo '>' . $i . '</a>';
                }

                // Display next and last page buttons
                if ($page < $total_pages) {
                    echo '<a href="?page=' . ($page + 1) . '&order=' . $order . '&others=' . $filter . '">></a>';
                    echo '<a href="?page=' . $total_pages . '&order=' . $order . '&others=' . $filter . '">>></a>';
                }
            ?>
        </div>
    </div>
    </section>
<?php
    require_once 'footer.php';
?>

