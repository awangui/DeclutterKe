<?php
session_start();
require_once 'connection.php';
if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 1)){
    header("Location: login.html");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="./site.webmanifest">
    <link rel="stylesheet" href="./css/admin.css">
    <script src="./js/font-awesome.js" crossorigin="anonymous"></script>
</head>

<body>
<section class="sticky-nav">
        <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
        <nav>
            <a href="index.php" class="logo">
                <img src="./images/declutterLogo.png" class="icon">
                <b><span>Declutter</span> Ke</b>
            </a>
            <a href="users.php" class="active">Users</a>
           <a href="categories.php">Categories</a>
            <a href="listings.php">Listings</a>
            <a href="brands.php">Brands</a>
            <a href="listings.php" class="cta">Manage Listings</a>
                <div class="credentials">
                    <a href="profile.php"><i class="icon fa-regular fa-user"></i><?php echo $_SESSION['name']; ?></a>
                    <a href="logout.php"><i class="icon fa-solid fa-right-to-bracket "></i> Logout</a>
                </div>
        </nav>
</section>
    <!-- <div id="navigation">
        <a href="index.php" class="logo">
            <img src="./images/declutterLogo.png" class="icon">
        </a>
        <nav>
                <ul>
                    <li class="nav-item"><i class="fa-regular fa-user"></i> <a href="users.php">Users</a></li>
                    <li class="nav-item"><i class="fa-solid fa-list"></i> <a href="listings.php">Listings</a></li>
                    <li class="nav-item active"><i class="fa-solid fa-bars-staggered"></i> <a href="categories.php">Categories</a></li>
                    <li class="nav-item"><i class="fa-solid fa-ellipsis"></i> <a href="brands.php">Brands</a></li>
                    <li class="nav-item"><i class="fa-solid fa-chart-simple"></i> <a href="#">Stats</a></li>
                    <li class="nav-item"><i class="fa-solid fa-arrow-right-from-bracket"></i> <a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        <div class="profile">
            <a href="profile.php"><i class="icon fa-regular fa-user"></i><?php echo $_SESSION['name'];?></a>
            <a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
        <div class="menu-toggle">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div> 
    </div>

     <div class="container">
        <div class="side-bar">
            <nav>
                <ul>
                    <li class="nav-item"><i class="fa-regular fa-user"></i> <a href="users.php">Users</a></li>
                    <li class="nav-item"><i class="fa-solid fa-list"></i> <a href="listings.php">Listings</a></li>
                    <li class="nav-item active"><i class="fa-solid fa-bars-staggered"></i> <a href="categories.php">Categories</a></li>
                    <li class="nav-item"><i class="fa-solid fa-ellipsis"></i> <a href="brands.php">Brands</a></li>
                    <li class="nav-item"><i class="fa-solid fa-chart-simple"></i> <a href="#">Stats</a></li>
                    <li class="nav-item"><i class="fa-solid fa-arrow-right-from-bracket"></i> <a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>    -->
