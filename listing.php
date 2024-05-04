<?php
include 'connection.php';

// Check if the user is not logged in, redirect to the login page
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.html");
//     exit();
// }

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
    session_start();
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        
        // Insert the listing into the database, including the user's ID as the seller_id
        $query = "INSERT INTO listings (name, category, sub_category, brand, color, years_used, `condition`, price, description, photos, phone_number, city, town, seller_id) 
                  VALUES ('$name', '$category', '$sub_category', '$brand', '$color', $years_used, '$condition', $price, '$description', '$photos', '$phone', '$city', '$town', $userId)";
        
        if (mysqli_query($con, $query)) {
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
    <script src="listing.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="listing.css">
    <script src="https://kit.fontawesome.com/661ba5765b.js" crossorigin="anonymous"></script>
    <title>Add Listing</title>
</head>

<body>

<section class="sticky-nav">
<button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
<nav>
    <a href="index.php" class="logo">
        <img src="./images/Logo maker project (1).png" class="icon">
        <b><span>Declutter</span> Ke</b>
    </a>
    <a href="#home">Home</a>
    <a href="store.php">Store</a>
    <a href="about.html">About</a>
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
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="photos">Photos:</label>
            <input type="file" id="photos" name="images[]" multiple accept="image/*" required>
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="furniture">Furniture</option>
                <option value="electronics">Electronics</option>
                <option value="Appliances">Appliances</option>
                <option value="Kitchenware">Kitchenware</option>
                <option value="other">Other</option>
            </select>

            <label for="sub-category">Sub-Category:</label>
            <select id="sub-category" name="sub-category" required>
                <option value="fridges">Fridges</option>
                <option value="phones">Phones</option>
                <option value="tables">Tables</option>
                <option value="phones">Phones</option>
                <option value="Speakers">Speakers</option>
                <option value="TVs">TVs</option>
                <option value="Microwaves">Microwaves</option>
                <option value="other">Other</option>
            </select>

            <label for="brand">Brand:</label>
            <select id="brand" name="brand" required>
                <option value="">Select a brand</option>
                <option value="Samsung">Samsung</option>
                <option value="LG">LG</option>
                <option value="Mika">Mika</option>
                <option value="Hisense">Hisense</option>
                <option value="Ramtons">Ramtons</option>
                <option value="Hotpoint">Hotpoint</option>
                <option value="otherbrand">Other</option>
            </select>
        </div>
            <div id="rightDetails">
            <label for="color">Color:</label>
            <select id="color" name="color" required>
                <option value="Black">Black</option>
                <option value="Silver">Silver</option>
                <option value="Bronze">Bronze</option>
                <option value="Brown">Brown</option>
                <option value="White">White</option>
                <option value="Red">Red</option>
                <option value="other">Other</option>
            </select>

            <label for="yearsUsed">Number of Years Used:</label>
            <input type="number" id="yearsUsed" name="yearsUsed" required>
               

            <label for="condition">Condition:</label>
            <select id="condition" name="condition" required>
                <option value="">Select the condition</option>
                <option value="new">Barely Used i.e almost new</option>
                <option value="fairly used">Fairly used</option>
                <option value="used">Used</option>
            </select>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" style="width: 100%;" placeholder="provide any more details necessary"></textarea>
            <div id="nextButtonContainer">
            <button id="nextButton" type="button">Next</button>  
        </div>
            </div>
        <div class="details" id="contactDetails" style="display: none;">
            <label for="city">Pickup City:</label>
            <input type="text" id="city" name="city" required placeholder="e.g Nairobi">
            <label for="town">Location:</label>
            <input type="text" id="town" name="town" required placeholder="e.g Ruiru">
            <label for="phone">Phone number:</label>
            <input type="number" id="phone" name="phone" required placeholder="provide the phone number you want to be contacted with">
        </div>
        <div class="details" id="submitButtonContainer" style="display: none;">
        <button id="backButton" type="button" style="display: none;">Back</button><br>
            <button class="btn btn-submit" name="submit" type="submit">Submit</button>
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
