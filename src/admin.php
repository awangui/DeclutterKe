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
$sellersPercentage= ($totalSellers / $totalUsers) * 100;
?>
 <div class="main-content" style="display: block;">
 <h2>Dashboard</h2>
        <h1>Overview</h1>
        <style>
            .widgets {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
            }
        </style>
        <div class="widgets">
<div class="widget">
    <h4>Total Users</h4>
    <p><?php echo $totalUsers; ?></p>
</div>
<div class="widget">
    <h4>Total categories</h4>
    <p><?php echo $totalCategories?></p>
    </div>
    <div class="widget">
    <h4>Total Listings</h4>
    <p><?php echo $totalListings?></p>
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

</div>  
</div>




