<?php
session_start();
require_once 'connection.php';
if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 1)){
    header("Location: login.html");
    exit();
}

// Get the current script name
$current_page = basename($_SERVER['PHP_SELF']);

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
    <script src="./js/admin.js" crossorigin="anonymous"></script>
</head>

<body>
<section class="sticky-nav">
        <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
        <nav>
            <a href="index.php" class="logo">
                <img src="./images/declutterLogo.png" class="icon">
                <b><span>Declutter</span> Ke</b>
            </a>
            <a href="admin.php" class="nav-link" data-page="admin.php">Dashboard</a>
            <a href="users.php" class="nav-link" data-page="users.php">Users</a>
            <a href="categories.php" class="nav-link" data-page="categories.php">Categories</a>
            <a href="listings.php" class="nav-link" data-page="listings.php">Listings</a>
            <a href="brands.php" class="nav-link" data-page="brands.php">Brands</a>
                <div class="credentials">
                    <a href="profile.php"><i class="icon fa-regular fa-user"></i><?php echo $_SESSION['name']; ?></a>
                    <a href="logout.php"><i class="icon fa-solid fa-right-to-bracket "></i> Logout</a>
                </div>
        </nav>
</section>
<script>
// Function to handle adding active class based on current URL
function setActiveClass() {
    var navLinks = document.querySelectorAll('.nav-link');
    var currentPage = "<?php echo $current_page; ?>";
    navLinks.forEach(link => {
        if (link.getAttribute('data-page') === currentPage) {
            link.classList.add('active');
        }
        link.addEventListener('click', function() {
            navLinks.forEach(link => link.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

// Call the setActiveClass function when the DOM content is loaded
document.addEventListener('DOMContentLoaded', function() {
    setActiveClass();
});
</script>
</body>
</html>
