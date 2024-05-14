<?php
require_once 'navbar.php';

// Check if the 'id' parameter is set in the URL
if(isset($_GET['id'])) {
    $brand_id = $_GET['id'];

    // Delete brand from the database
    $sql = "DELETE FROM brands WHERE brand_id = '$brand_id'";
    if ($con->query($sql) === TRUE) {
        // Redirect back to brands.php after successful deletion
        header("Location: brands.php");
        exit();
    } else {
        // Handle deletion error
        echo "Error deleting brand: " . $con->error;
    }
}

// Get brand with the most listings
$sql = "SELECT brand_name, COUNT(listing_id) as total_listings FROM brands JOIN listings ON brands.brand_id = listings.brand_id GROUP BY brand_name ORDER BY total_listings DESC LIMIT 1";
$result = $con->query($sql);
$most_listings = $result->fetch_assoc();

// Get the top 3 brands with the most listings
$sql = "SELECT brand_name, COUNT(listing_id) as total_listings FROM brands JOIN listings ON brands.brand_id = listings.brand_id GROUP BY brand_name ORDER BY total_listings DESC LIMIT 3";
$result = $con->query($sql);
$top_brands = $result->fetch_all(MYSQLI_ASSOC);

// Get brand chart data
$sql = "SELECT brand_name, COUNT(listing_id) as total_listings FROM brands JOIN listings ON brands.brand_id = listings.brand_id GROUP BY brand_name ORDER BY total_listings DESC";
$result = $con->query($sql);
$chart_labels = [];
$chart_values = [];
while ($row = $result->fetch_assoc()) {
    $chart_labels[] = $row['brand_name'];
    $chart_values[] = $row['total_listings'];
}

// Process search query
$search_results = [];
if(isset($_GET['brand']) && !empty($_GET['brand'])) {
    $search_brand = $_GET['brand'];
    // Search for brands containing the search term
    $sql_search = "SELECT * FROM brands WHERE brand_name LIKE '%$search_brand%'";
    $result_search = $con->query($sql_search);
    if ($result_search->num_rows > 0) {
        // Display search results
        $search_results = $result_search->fetch_all(MYSQLI_ASSOC);
    }
}

// Process add brand form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_name = $_POST['brand_name'];
    
    // Check if the brand already exists
    $sql_check_duplicate = "SELECT * FROM brands WHERE brand_name = '$brand_name'";
    $result_check_duplicate = $con->query($sql_check_duplicate);
    if ($result_check_duplicate->num_rows > 0) {
        echo "Brand already exists.";
    } else {
        // Insert new brand into the database
        $sql_insert_brand = "INSERT INTO brands (brand_name) VALUES ('$brand_name')";
        if ($con->query($sql_insert_brand) === TRUE) {
            echo "Brand added successfully.";
        } else {
            echo "Error adding brand: " . $con->error;
        }
    }
}

?>

<div class="main-content">
    <h1>Brands</h1>
    <div class="header">
        <div class="widget">
            <!-- most popular brand -->
            <h2>Most popular Brand</h2>
            <p><?php echo $most_listings['brand_name']; ?></p>
        </div>
        <!-- top 3 brands -->
        <div class="widget">
            <h2>Top 3 Brands</h2>
            <ul>
                <?php foreach ($top_brands as $brand) { ?>
                    <li><?php echo $brand['brand_name']; ?> - <?php echo $brand['total_listings']; ?> listings</li>
                <?php } ?>
            </ul>  
        </div>
        <div class="widget">
            <h3>Number of listings per brand</h3>
            <canvas id="brandChart"></canvas>
        </div>
    </div>
    <!-- Add Brand -->
    <h2>Add Brand</h2>
    <form method="POST" action="">
        <input type="text" name="brand_name" placeholder="Brand Name" required>
        <button type="submit">Add</button>
    </form>
    <!-- Search Brand -->
    <h2>Search Brand</h2>
    <form method="GET" action="">
        <input type="text" name="brand" placeholder="Search Brand" required>
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
                // Display search results or all brands
                if(isset($search_results) && !empty($search_results)) {
                    foreach ($search_results as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["brand_id"] . "</td><td>" . $row["brand_name"] . "</td>";
                        echo "<td><a href='brands.php?id=".$row['brand_id']."' onclick='return confirm(\"Are you sure you want to delete this brand?\")'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    // Display all brands
                    $sql = "SELECT * FROM brands";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["brand_id"] . "</td><td>" . $row["brand_name"] . "</td>";
                            echo "<td><a href='brands.php?id=".$row['brand_id']."' onclick='return confirm(\"Are you sure you want to delete this brand?\")'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No brands found.</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </section>
</div>

<script>
    // Function to reset the form fields
    function resetForm() {
        // Redirect back to the brands page to reset the search
        window.location.href = "brands.php";
    }

    var ctx = document.getElementById('brandChart').getContext('2d');
    var brandChart = new Chart(ctx, {
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
