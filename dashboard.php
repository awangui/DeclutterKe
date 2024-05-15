<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('connection.php');

session_start();
include "connection.php";

// Check if the user is logged in as an admin (you may need to adjust this condition based on your authentication mechanism)
// if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
//     // Redirect to login page or display an error message
//     header("Location: login.php");
//     exit();
// }

// Fetch all distinct categories
// Query to count the total number of users
$sqlCountUsers = "SELECT COUNT(DISTINCT UserId) AS totalUsers FROM users";
$resultCountUsers = mysqli_query($con, $sqlCountUsers);

// Check if the query to count users was successful
if ($resultCountUsers) {
    // Fetch the result row as an associative array
    $rowCountUsers = mysqli_fetch_assoc($resultCountUsers);
    // Retrieve the total number of users
    $totalUsers = $rowCountUsers['totalUsers'];
} else {
    // Handle the case where the query failed
    $totalUsers = "Unknown";
}

// Query to count the total number of sellers (users with listings)
$sqlCountUsersWithListings = "SELECT COUNT(DISTINCT l.seller_id) AS totalUsersWithListings 
                              FROM listings l ";
$resultCountUsersWithListings = mysqli_query($con, $sqlCountUsersWithListings);

if ($resultCountUsersWithListings) {
    $row = mysqli_fetch_assoc($resultCountUsersWithListings);
    $totalUsersWithListings = $row['totalUsersWithListings'];
} else {
    // Handle error if the query fails
}

$sqlFetchCategories = "SELECT DISTINCT category FROM users";
$resultFetchCategories = mysqli_query($con, $sqlFetchCategories);

if (!$resultFetchCategories) {
    // Handle the case where the query failed
    die("Error fetching categories: " . mysqli_error($con));
}

// Define the selected category (default to all categories)
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'All';

// Query to fetch users based on the selected category
$sqlFetchUsers = "SELECT u.*, IFNULL(COUNT(l.listing_id), 0) AS totalListings 
                FROM users u 
                LEFT JOIN listings l ON u.UserId = l.seller_id ";

// If a category is selected, add a condition to filter users by category
if ($selectedCategory !== 'All') {
    $sqlFetchUsers .= "WHERE u.category = '$selectedCategory' ";
}

$sqlFetchUsers .= "GROUP BY u.UserId";

$resultFetchUsers = mysqli_query($con, $sqlFetchUsers);

if (!$resultFetchUsers) {
    // Handle the case where the query failed
    die("Error fetching users: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <header>
        <a href="index.php" class="logo">
            <img src="../images/declutterLogo.png" class="icon">
        </a>
        <b><span>Declutter</span> Ke</b>
        <div class="profile">
            <span class="notification">4</span>
            <div class="avatar">Charles Hall</div>
            <a href="logout.php"><i class="icon fa-solid fa-right-to-bracket "></i> Logout</a>
        </div>
        <div class="menu-toggle">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </header>

    <div class="container">
        <div class="side-bar">
            <nav>
                <ul>
                    <li><a class="nav-item active" href="admin.php">Dashboard</a>
                    <li><a class="nav-item" href="users.php">Users</a>
                    <li><a class="nav-item">Listings</a>
                    <li><a class="nav-item">Stats</a>
                    <li><a class="nav-item">Logout</a>
                </ul>
                <div class="tools">
                    <h4>Tools & Components</h4>
                    <ul>
                        <li><a href="#">Settings</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="main-content">
            <div class="row">
                <div class="col">
                    <div class="widget">
                        <h3>Total Users</h3>
                        <p><?php echo $totalUsers; ?></p>
                    </div>
                </div>
                <div class="col">
                    <div class="widget">
                        <h3>Total Sellers</h3>
                        <p><?php echo $totalUsersWithListings; ?></p>
                    </div>
                </div>
            </div>
            <div class="widget">
                <div class="chart-container">
                    <canvas id="sellersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="container">

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="display">Users</h2>
                        </div>
                        <div class="card-body">
                            <form method="GET">
                                <label for="category">Filter by Category:</label>
                                <select name="category" id="category">
                                    <option value="All" <?php if ($selectedCategory === 'All') echo 'selected'; ?>>All</option>
                                    <?php
                                    // Display category options
                                    while ($row = mysqli_fetch_assoc($resultFetchCategories)) {
                                        $category = $row['category'];
                                        echo "<option value='$category'";
                                        if ($selectedCategory === $category) echo 'selected';
                                        echo ">$category</option>";
                                    }
                                    ?>
                                </select>
                                <button type="submit">Filter</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <h3>All users</h3>
                            <table>

                                </style>
                                <tr class="table-header">
                                    <th>User ID</th>
                                    <th>First Name</th>
                                    <th>Email</th>
                                    <th>Date Joined</th>
                                    <th>Category</th>
                                    <th>Total Listings</th>
                                    <th>Operations</th>
                                </tr>
                                <?php
                                while ($row = mysqli_fetch_assoc($resultFetchUsers)) {
                                    $id = $row['UserId'];
                                ?>
                                    <tr>
                                        <td><?= $id ?></td>
                                        <td><?php echo $row['firstName']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['date']; ?></td>
                                        <td><?php echo $row['category']; ?></td>
                                        <td><?php echo $row['totalListings']; ?></td>
                                        <td><a href="update.php?editId=<?= $id ?>" class="btn btn-primary">Edit</a><a href="delete.php?deleteid=<?= $id ?>" class="btn btn-danger">Delete</a></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        // Chart.js configuration
        const totalUsers = <?php echo $totalUsers; ?>;
        const totalSellers = <?php echo $totalUsersWithListings; ?>;
        const sellersPercentage = (totalSellers / totalUsers) * 100;

        const ctx = document.getElementById('sellersChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Users', 'Sellers'],
                datasets: [{
                    label: 'Users vs Sellers',
                    data: [totalUsers - totalSellers, totalSellers],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgb(245, 172, 4,0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(245, 172, 4, 1)'
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
</body>

</html>