<?php
session_start();
require_once 'connection.php';

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $name = htmlspecialchars($_POST['name']);
    $category = htmlspecialchars($_POST['category']);
    $sub_category = htmlspecialchars($_POST['sub-category']);
    $brand = htmlspecialchars($_POST['brand']);
    $color = htmlspecialchars($_POST['color']);
    $years_used = floatval($_POST['yearsUsed']);
    $condition = htmlspecialchars($_POST['condition']);
    $price = floatval($_POST['price']);
    $description = htmlspecialchars($_POST['description']);
    $phone = floatval($_POST['phone']);
    $city = htmlspecialchars($_POST['city']); // New field
    $town = htmlspecialchars($_POST['town']); // New field

    // File upload
    $file_names = array();
    $file_count = count($_FILES['images']['name']);
    for ($i = 0; $i < $file_count; $i++) {
        $file_name = $_FILES['images']['name'][$i];
        $temp_name = $_FILES['images']['tmp_name'][$i];
        $folder = 'uploads/' . $file_name;
        if (move_uploaded_file($temp_name, $folder)) {
            $file_names[] = $file_name;
        }
    }

    // Insert listing with all photos
    $photos = implode(',', $file_names); // Convert array of file names to a comma-separated string

    // Retrieve the user's ID from the session
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Update the user's category to 'seller'
        $update_query = "UPDATE users SET category = 'seller' WHERE UserId = ?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        

        // Insert the listing into the database, including the user's ID as the seller_id
        $insert_query = "INSERT INTO listings (name, category, sub_category, brand, color, years_used, `condition`, price, description, photos, phone_number, city, town, seller_id) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt, "sssssssdsssssi", $name, $category, $sub_category, $brand, $color, $years_used, $condition, $price, $description, $photos, $phone, $city, $town, $userId);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<h2>Listing uploaded successfully</h2>";
        } else {
            echo "<h2>Listing failed to upload</h2>";
        }
    } else {
        echo "<h2>User not logged in</h2>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/listing.js"></script>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/listing.css">
    <script src="https://kit.fontawesome.com/661ba5765b.js" crossorigin="anonymous"></script>
    <title>Add Listing</title>
</head>

<body>

    <section class="sticky-nav">
        <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
        <nav>
            <a href="index.php" class="logo">
                <img src="./images/declutterLogo.png" class="icon">
                <b><span>Declutter</span> Ke</b>
            </a>
            <a href="#home">Home</a>
            <a href="store.php">Store</a>
            <a href="about.php">About</a>
            <a href="#contact">Contact</a>
            <a href="listing.php" class="cta active">Add a Listing</a>
            <div class="credentials">
                <a href="logout.php"><i class="icon fa-solid fa-right-to-bracket "></i> Logout</a>
            </div>

        </nav>
    </section>

    <form id="listingForm" method="post" enctype="multipart/form-data">

        <div class="listing-container">
            <h2>Add a listing</h2>
            <div class="details-container">
                <div class="details" id="productDetails">
                    <!-- Your form fields -->
                </div>
                <!-- Rest of your form -->
            </div>
        </div>
    </form>

    <!-- Page dots -->
    <div class="page-dots">
        <span class="dot" id="dot1"></span>
        <span class="dot" id="dot2"></span>
    </div>
</body>

</html>
