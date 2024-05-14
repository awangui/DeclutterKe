<?php

require_once 'navbar.php';

// Check if the 'id' parameter is set in the URL
if(isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Delete category from the database
    $sql = "DELETE FROM categories WHERE category_id = '$category_id'";
    if ($con->query($sql) === TRUE) {
        // Redirect back to categories.php after successful deletion
        header("Location: categories.php");
        exit();
    } else {
        // Handle deletion error
        echo "Error deleting category: " . $con->error;
    }
}

// Get category with the most listings
$sql = "SELECT category_name, COUNT(listing_id) as total_listings FROM categories JOIN listings ON categories.category_id = listings.category_id GROUP BY category_name ORDER BY total_listings DESC LIMIT 1";
$result = $con->query($sql);
$most_listings = $result->fetch_assoc();

// Get the top 3 categories with the most listings
$sql = "SELECT category_name, COUNT(listing_id) as total_listings FROM categories JOIN listings ON categories.category_id = listings.category_id GROUP BY category_name ORDER BY total_listings DESC LIMIT 3";
$result = $con->query($sql);
$top_categories = $result->fetch_all(MYSQLI_ASSOC);

// Get category chart data
$sql = "SELECT category_name, COUNT(listing_id) as total_listings FROM categories JOIN listings ON categories.category_id = listings.category_id GROUP BY category_name ORDER BY total_listings DESC";
$result = $con->query($sql);
$chart_labels = [];
$chart_values = [];
while ($row = $result->fetch_assoc()) {
    $chart_labels[] = $row['category_name'];
    $chart_values[] = $row['total_listings'];
}

// Process search query
$search_results = [];
if(isset($_GET['category']) && !empty($_GET['category'])) {
    $search_category = $_GET['category'];
    // Search for categories containing the search term
    $sql_search = "SELECT * FROM categories WHERE category_name LIKE '%$search_category%'";
    $result_search = $con->query($sql_search);
    if ($result_search->num_rows > 0) {
        // Display search results
        $search_results = $result_search->fetch_all(MYSQLI_ASSOC);
    }
}

// Process add category form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];
    
    // Check if the category already exists
    $sql_check_duplicate = "SELECT * FROM categories WHERE category_name = '$category_name'";
    $result_check_duplicate = $con->query($sql_check_duplicate);
    if ($result_check_duplicate->num_rows > 0) {
        echo "Category already exists.";
    } else {
        // Insert new category into the database
        $sql_insert_category = "INSERT INTO categories (category_name) VALUES ('$category_name')";
        if ($con->query($sql_insert_category) === TRUE) {
            echo "Category added successfully.";
        } else {
            echo "Error adding category: " . $con->error;
        }
    }
}

?>

        <div class="main-content" style="display: block;"> 
        <h1>Categories</h1>
        <div class="header">
        <div class="widget">
            <h3>Number of listings per category</h3>
            <canvas id="categoryChart"></canvas>
            </div>
            <div class="widget">
            <!-- most popular category -->
            <h2>Most popular Category</h2>
            <p><?php echo $most_listings['category_name']; ?></p>
            </div>
            <!-- top 3 categories -->
            <div class="widget">
            <h2>Top 3 Categories</h2>
            <ul>
                <?php foreach ($top_categories as $category) { ?>
                <li><?php echo $category['category_name']; ?> - <?php echo $category['total_listings']; ?> listings</li>
                <?php } ?>
            </ul>  
            </div>
          
        </div>
            <!-- Add Category -->
            <h2>Add Category</h2>
            
            <form method="POST" action="">
                <input type="text" name="category_name" placeholder="Category Name" required>
                <button type="submit">Add</button>
            </form>
            <!-- Search Category -->
            <h2>Search Category</h2>
            <form method="GET" action="">
                <input type="text" name="category" placeholder="Search Category" required>
                <button type="submit">Search</button>
                <button type="button" onclick="resetForm()">Reset</button>
            </form>
            <section class='table-display'>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display search results or all categories
                        if(isset($search_results) && !empty($search_results)) {
                            foreach ($search_results as $row) {
                                echo "<tr>";
                                echo "<td>" . $row["category_id"] . "</td><td>" . $row["category_name"] . "</td>";
                                
                                echo "<td><a href='categories.php?id=".$row['category_id']."' onclick='return confirm(\"Are you sure you want to delete this category?\")'>Delete</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            // Display all categories
                            $sql = "SELECT * FROM categories";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["category_id"] . "</td><td>" . $row["category_name"] . "</td>";
                                    echo "<td><a href='#'>Edit</a> ";
                                    echo " <a href='categories.php?id=".$row['category_id']."' onclick='return confirm(\"Are you sure you want to delete this category?\")'>Delete</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No categories found.</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>

    <script>
        // Function to reset the form fields
        function resetForm() {
            // Redirect back to the categories page to reset the search
            window.location.href = "categories.php";
        }

        var ctx = document.getElementById('categoryChart').getContext('2d');
        var categoryChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($chart_labels); ?>,
                datasets: [{
                    label: 'Number of Listings',
                    data: <?php echo json_encode($chart_values); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>
</body>
</html>
