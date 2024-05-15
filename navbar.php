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
            <a href="admin.php" class="nav-link">Dashboard</a>
            <a href="users.php" class="nav-link">Users</a>
            <a href="categories.php" class="nav-link">Categories</a>
            <a href="listings.php" class="nav-link">Listings</a>
            <a href="brands.php" class="nav-link">Brands</a>
            <a href="listings.php" class="cta nav-link">Manage Listings</a>
                <div class="credentials">
                    <a href="profile.php"><i class="icon fa-regular fa-user"></i><?php echo $_SESSION['name']; ?></a>
                    <a href="logout.php"><i class="icon fa-solid fa-right-to-bracket "></i> Logout</a>
                </div>
        </nav>
</section>
<script>
// Function to handle click event on navigation links and add active class
function activeClass() {
    var navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            console.log('Clicked:', this.textContent); // Log the clicked link text
            navLinks.forEach(link => link.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

// Call the activeClass function when the DOM content is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Document loaded'); // Log when the document is loaded
    activeClass();
});
</script>
