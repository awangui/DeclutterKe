<?php
require_once 'navbar.php';


// Get total number of users
$sql = "SELECT COUNT(*) AS totalUsers FROM users";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalUsers = $row['totalUsers'];
} else {
    $totalUsers = 0;
}

// Get total number of categories
$sql = "SELECT COUNT(*) AS totalCategories FROM categories";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalCategories = $row['totalCategories'];
} else {
    $totalCategories = 0;
}

//get total number of listings

$sql = "SELECT COUNT(*) AS totalListings FROM listings";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalListings = $row['totalListings'];
} else {
    $totalListings = 0;
}
//get number of sellers 
$sql = "SELECT COUNT(*) AS totalSellers FROM users WHERE role = 2";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalSellers = $row['totalSellers'];
} else {
    $totalSellers = 0;
}
//get number of admins
$sql = "SELECT COUNT(*) AS totalAdmins FROM users WHERE role = 1";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $admins = $row['totalAdmins'];
} else {
    $admins = 0;
}
//get number of buyers
$sql = "SELECT COUNT(*) AS totalBuyers FROM users WHERE role = 3";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalBuyers = $row['totalBuyers'];
} else {
    $totalBuyers = 0;
}
//get number of brands
$sql = "SELECT COUNT(*) AS totalBrands FROM brands";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalBrands = $row['totalBrands'];
} else {
    $totalBrands = 0;
}
$sellersPercentage = ($totalSellers / $totalUsers) * 100;

// Fetch data for bar chart
$sqlFetchUsersByMonth = "SELECT MONTH(date) AS month, YEAR(date) AS year, COUNT(*) AS totalUsers
                         FROM users
                         GROUP BY YEAR(date), MONTH(date)
                         ORDER BY year DESC, month DESC";
$resultFetchUsersByMonth = mysqli_query($con, $sqlFetchUsersByMonth);

// Check for query errors
if (!$resultFetchUsersByMonth) {
    // Handle error
    die("Error fetching data: " . mysqli_error($con));
}

// Initialize arrays to store labels and data for chart
$labels = [];
$data = [];

// Fetch data and populate arrays
while ($row = mysqli_fetch_assoc($resultFetchUsersByMonth)) {
    // Generate label in "Month Year" format
    $label = date('M Y', mktime(0, 0, 0, $row['month'], 1, $row['year']));
    $labels[] = $label;
    // Store total users for the month
    $data[] = $row['totalUsers'];
}
// Get category with the most listings
$sql = "SELECT category_name, COUNT(listing_id) as total_listings FROM categories JOIN listings ON categories.category_id = listings.category_id GROUP BY category_name ORDER BY total_listings DESC LIMIT 1";
$result = $con->query($sql);
$most_listings = $result->fetch_assoc();

// Get the top 3 categories with the most listings
$sql = "SELECT category_name, COUNT(listing_id) as total_listings FROM categories JOIN listings ON categories.category_id = listings.category_id GROUP BY category_name ORDER BY total_listings DESC LIMIT 3";
$result = $con->query($sql);
$top_categories = $result->fetch_all(MYSQLI_ASSOC);
// Get listing categories
$sql_categories = "SELECT category_id, category_name FROM categories";
$result_categories = $con->query($sql_categories);
$categories = [];
if ($result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $categories[$row['category_id']] = $row['category_name'];
    }
}

// Get category chart data
$sql = "SELECT category_name, COUNT(listing_id) as total_listings FROM categories JOIN listings ON categories.category_id = listings.category_id GROUP BY category_name ORDER BY total_listings DESC";
$result = $con->query($sql);
$chart_labels = [];
$chart_values = [];
while ($row = $result->fetch_assoc()) {
    $chart_labels[] = $row['category_name'];
    $chart_values[] = $row['total_listings'];
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
?>
<style>
    .widget {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-left: 6px solid #ffb610;
    }

    .widget h4,
    .widget h3 {
        margin-bottom: 10px;
        font-size: 18px;
    }

    .widget p {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }
</style>
<style>
    .grid-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
    }

    .widget {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-left: 6px solid #ffb610;
        margin: 20px;
    }

    .widget h4,
    .widget h3 {
        margin-bottom: 10px;
        font-size: 18px;
    }

    .widget p {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }
    .main-content{
        width: 90%;
        margin: 0 auto;
        margin-top:8%;
    }
    .main-content h1, .main-content h2{
        text-align: center;
    }   
</style>
<div class="main-content" style="display: block;">
    <h2>Dashboard</h2>
    <h1>Overview</h1>
    <div class="header">


        <div class="widget">

            <canvas id="usersByMonthChart"></canvas>
        </div>




        <div class="widget">
            <h3>Number of listings per category</h3>
            <canvas id="categoryChart"></canvas>
        </div>
        <!-- <div class="widget"> -->
        <!-- most popular category -->
        <!-- <h2>Most popular Category</h2>
                <p><?php echo $most_listings['category_name']; ?></p>
            </div> -->
                <div class="widget">
            <h4>Total Users</h4>
            <p><?php echo $totalUsers; ?></p>
        </div>
        <div class="widget">
            <h4>Number of admins</h4>
            <p><?php echo $admins; ?></p>
        </div>
        <div class="widget">
            <h4>Total Listings</h4>
            <p><?php echo $totalListings ?></p>
        </div>
        <div class="widget">
            <h4>Total Sellers</h4>
            <p><?php echo $totalSellers; ?></p>
        </div>
      
        <div class="widget">
            <h4>Regular Users</h4>
            <p><?php echo $totalBuyers; ?></p>
        </div>
        <div class="widget">
            <h4>Total Brands</h4>
            <p><?php echo $totalBrands; ?></p>
        </div>
        <div class="widget">
            <h4>Total categories</h4>
            <p><?php echo $totalCategories ?></p>
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
        <div class="widget">
            <h3>Number of listings per category</h3>
            <canvas id="listingChart"></canvas>
        </div>

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
        <div class="widget">
        <h3>Number of listings per category</h3>
            <div class="chart-container">
                <canvas id="sellersChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to display bar chart of users joined by month
    const labels = <?php echo json_encode($labels); ?>;
    const data = <?php echo json_encode($data); ?>;

    const ctx = document.getElementById('usersByMonthChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Users Joined Per Month',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    //category chart
    var ctxx = document.getElementById('categoryChart').getContext('2d');
    var categoryChart = new Chart(ctxx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($chart_labels); ?>,
            datasets: [{
                label: 'Number of Listings',
                data: <?php echo json_encode($chart_values); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
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
    //listing chart
    var listingChartCtx = document.getElementById('listingChart').getContext('2d');
    var listingChart = new Chart(listingChartCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_values($categories)); ?>,
            datasets: [{
                label: 'Number of Listings',
                data: <?php echo json_encode($chart_values); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
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
    //brand chart
    var BrandChartctx = document.getElementById('brandChart').getContext('2d');
    var brandChart = new Chart(BrandChartctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($chart_labels); ?>,
            datasets: [{
                label: 'Number of Listings',
                data: <?php echo json_encode($chart_values); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
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
    //sellers chart
    const totalUsers = <?php echo $totalUsers; ?>;
    const totalSellers = <?php echo $totalSellers; ?>;
    const sellersPercentage = (totalSellers / totalUsers) * 100;

    const sellersChartctx = document.getElementById('sellersChart').getContext('2d');
    const sellerChart = new Chart(sellersChartctx, {
        type: 'doughnut',
        data: {
            labels: ['Users', 'Sellers'],
            datasets: [{
                label: 'Users vs Sellers',
                data: [totalUsers - totalSellers, totalSellers],
                backgroundColor: [
                    'rgb(245, 172, 4,0.2)',
                    'rgba(54, 162, 235, 0.2)'

                ],
                borderColor: [
                    'rgba(245, 172, 4, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Users vs Sellers'
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
</script>