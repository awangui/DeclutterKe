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

// Query to fetch all users
$sqlFetchUsers = "SELECT * FROM users";
$resultFetchUsers = mysqli_query($con, $sqlFetchUsers);

//count of users who have posted listings
$sqlCountUsersWithListings = "SELECT COUNT(DISTINCT l.seller_id) AS totalUsersWithListings 
                              FROM listings l 
                              JOIN users u ON l.seller_id = u.UserId";
$resultCountUsersWithListings = mysqli_query($con, $sqlCountUsersWithListings);

if ($resultCountUsersWithListings) {
    $row = mysqli_fetch_assoc($resultCountUsersWithListings);
    $totalUsersWithListings = $row['totalUsersWithListings'];
} else {
    // Handle error if the query fails
}

// Calculate the percentage of sellers
$sellersPercentage = ($totalUsersWithListings / $totalUsers) * 100;

// Query to fetch all sellers
$sqlFetchSellers = "SELECT u.*, l.seller_name
FROM users u
JOIN listings l ON u.UserId = l.seller_id
GROUP BY u.UserId";
$resultFetchSellers = mysqli_query($con, $sqlFetchSellers);

if (!$resultFetchSellers) {
    // Handle the case where the query failed
    die("Error fetching sellers: " . mysqli_error($con));
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
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<header>
    <a href="index.php" class="logo">
        <img src="./images/Logo maker project (1).png" class="icon">
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
                <li><a class="nav-item active" >Dashboard</a>
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
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="display">Users</h2>
                        </div>
                        <div class="user-analytics">
                        <div class="user-count">
                            <h3>Total Users</h3>
                            <p><?php
                            // Display the total number of users
                            echo $totalUsers;
                            ?>
                            </p>
                        </div>
                        <div class="user-count">
                            <h3>Total Sellers</h3>
                            <p><?php
                            // Display the total number of users
                            echo $totalUsersWithListings;
                            ?>
                            </p>
                        </div>
                        <div class="set-size charts-container">
                          <div class="pie-wrapper progress-<?php echo $sellersPercentage; ?>">
                            <span class="label"><?php echo $sellersPercentage; ?><span class="smaller">%</span></span>
                            <div class="pie">
                              <div class="left-side half-circle"></div>
                              <div class="right-side half-circle"></div>
                            </div>
                          </div>
                        </div>
                        </div>
                        <div class="card-body">
                            <h3>All users</h3>
                            <table>
                                <tr class="table-header">
                                    <th>User ID</th>
                                    <th>First Name</th>
                                    <th>Email</th>
                                    <th>Date Joined</th>
                                    <th>Operations</th>
                                </tr>
                                <?php
                                while($row = mysqli_fetch_assoc($resultFetchUsers)) {
                                    $id = $row['UserId'];
                                    ?>
                                    <tr>
                                        <td><?= $id ?></td>
                                        <td><?php echo $row['firstName'];?></td>
                                        <td><?php echo $row['surname'];?></td>
                                        <td><?php echo $row['email'];?></td>
                                        <td><?php echo $row['date'];?></td>
                                        <td><a href="update.php?editId=<?= $id ?>" class="btn btn-primary">Edit</a><a href="delete.php?deleteid=<?= $id ?>" class="btn btn-danger">Delete</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        
                        <div class="card-body">
                            <h3>All sellers</h3>
                            <table>
                                <tr class="table-header">
                                    <th>User ID</th>
                                    <th>Seller Name</th>
                                    <th>Email</th>
                                    <th>Date Joined</th>
                                    <th>Operations</th>
                                </tr>
                                <?php
                                while($row = mysqli_fetch_assoc($resultFetchSellers)) {
                                    $id = $row['UserId'];
                                    ?>
                                    <tr>
                                        <td><?= $id ?></td>
                                        <td><?php echo $row['seller_name'];?></td>
                                        <td><?php echo $row['email'];?></td>
                                        <td><?php echo $row['date'];?></td>
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
// Example usage
const totalUsers = <?php echo $totalUsers; ?>;
const totalSellers = <?php echo $totalUsersWithListings; ?>;
const sellersPercentage = (totalSellers / totalUsers) * 100;

updateProgress(sellersPercentage, '.progress-sellers');
</script>
</body>
</html>
