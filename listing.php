<?php
session_start();
require_once 'connection.php';
$message = '';
$messageClass = '';

// Function to fetch categories from the database
function getCategories($con)
{
    $categories = array();
    $query = "SELECT * FROM categories";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    return $categories;
}

// Function to fetch brands from the database
function getBrands($con)
{
    $brands = array();
    $query = "SELECT * FROM brands";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $brands[] = $row;
    }
    return $brands;
}

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Initialize variables to retain form data
$name = $category = $sub_category = $brand = $color = $years_used = $condition = $price = $description = $phone = $city = $town = "";

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
    $city = htmlspecialchars($_POST['city']);
    $town = htmlspecialchars($_POST['town']);

    // Check if any required fields are empty
    if (
        empty($name) || empty($category) || empty($sub_category) || empty($brand) || empty($color) ||
        empty($years_used) || empty($condition) || empty($price) || empty($description) || empty($phone) ||
        empty($city) || empty($town)
    ) {
        $error_message = "Please make sure all fields are filled";
    } elseif (empty($_FILES['images']['name'][0])) {
        $error_message = "Please upload at least one photo";
    } elseif (strlen($_POST['phone']) != 12) {
        $error_message = "Phone number must be 12 digits long";
    } else {
        // File upload
        $file_names = array();
        $file_count = count($_FILES['images']['name']);
        for ($i = 0; $i < $file_count; $i++) {
            $file_name = $_FILES['images']['name'][$i];
            $temp_name = $_FILES['images']['tmp_name'][$i];
            $folder = './uploads/' . $file_name;
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
            $update_query = "UPDATE users SET `role` = '2' WHERE UserId = ?";
            $stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);

            // Insert the listing into the database, including the user's ID as the seller_id
            $insert_query = "INSERT INTO listings (name, category_id, sub_category, brand_id, color, years_used, `condition`, price, description, photos, phone_number, city, town, seller_id) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $insert_query);
            mysqli_stmt_bind_param($stmt, "sssssssdsssssi", $name, $category, $sub_category, $brand, $color, $years_used, $condition, $price, $description, $photos, $phone, $city, $town, $userId);

            if (mysqli_stmt_execute($stmt)) {
                $message = "Listing uploaded successfully.";
                $messageClass = "alert-success";
            } else {
                $message = "Failed to upload listing " . $con->error;
                $messageClass = "alert-error";
            }
        } else {
            $message = "You are not logged in" . $con->error;
            $messageClass = "alert-error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/listing.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/listing.css">
    <script src="./js/font-awesome.js" crossorigin="anonymous"></script>
    <title>Add Listing</title>
    <style>
        .error-message {
            color: red;
            display: <?php echo isset($error_message) ? 'block' : 'none'; ?>;
            text-align: center;
        }
    </style>
</head>

<body>
    <section class="sticky-nav">
        <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
        <nav>
            <a href="index.php" class="logo">
                <img src="./images/declutterLogo.png" class="icon">
                <b><span>Declutter</span> Ke</b>
            </a>
            <a href="index.php">Home</a>
            <a href="store.php">Store</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            <a href="listing.php" class="cta active">Add a Listing</a>
            <a href="manage_listings.php">Manage Listings</a>
            <div class="credentials">
                <a href="profile.php"><i class="icon fa-regular fa-user"></i><?php echo $_SESSION['name']; ?></a>
                <a href="logout.php"><i class="icon fa-solid fa-right-to-bracket "></i> Logout</a>
            </div>
        </nav>
    </section>

    <form id="listingForm" method="post" enctype="multipart/form-data">
        <div class="listing-container">
            <div class="listing-container">
                <h2>Add a listing</h2>
                <?php if ($message) : ?>
            <div class="alert <?php echo $messageClass; ?>"  style="text-align:center">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
                <div id="error-message" class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></div>
                <div class="details-container">
                    <div class="details" id="productDetails">
                        <label for="name">Product Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                        <label for="photos">Photos:</label>
                        <input type="file" id="photos" name="images[]" multiple accept="image/*">
                        <!-- div to preview images -->
                        <div id="imagePreview"></div>
                        <label for="category">Category:</label>
                        <select id="category" name="category">
                            <?php
                            // Fetch categories from the database and populate the dropdown
                            $categories = getCategories($con);
                            foreach ($categories as $category) {
                                echo "<option value=\"" . $category['category_id'] . "\" " . ($category['category_id'] == $category ? "selected" : "") . ">" . $category['category_name'] . "</option>";
                            }
                            ?>
                        </select>
                        <label for="sub-category">Sub-Category:</label>
                        <select id="sub-category" name="sub-category">
                            <option value="fridges" <?php echo ($sub_category == 'fridges') ? 'selected' : ''; ?>>Fridges</option>
                            <option value="phones" <?php echo ($sub_category == 'phones') ? 'selected' : ''; ?>>Phones</option>
                            <option value="tables" <?php echo ($sub_category == 'tables') ? 'selected' : ''; ?>>Tables</option>
                            <option value="Speakers" <?php echo ($sub_category == 'Speakers') ? 'selected' : ''; ?>>Speakers</option>
                            <option value="beds" <?php echo ($sub_category == 'beds') ? 'selected' : ''; ?>>Beds</option>
                            <option value="TVs" <?php echo ($sub_category == 'TVs') ? 'selected' : ''; ?>>TVs</option>
                            <option value="sofas" <?php echo ($sub_category == 'sofas') ? 'selected' : ''; ?>>Sofas</option>
                            <option value="Microwaves" <?php echo ($sub_category == 'Microwaves') ? 'selected' : ''; ?>>Microwaves</option>
                            <option value="other" <?php echo ($sub_category == 'other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                        <label for="brand">Brand:</label>
                        <select id="brand" name="brand">
                            <?php
                            // Fetch brands from the database and populate the dropdown
                            $brands = getBrands($con);
                            foreach ($brands as $brand) {
                                echo "<option value=\"" . $brand['brand_id'] . "\" " . ($brand['brand_id'] == $brand ? "selected" : "") . ">" . $brand['brand_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div id="rightDetails">
                        <label for="color">Color:</label>
                        <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($color); ?>">
                        <label for="yearsUsed">Number of Years Used:</label>
                        <input type="number" id="yearsUsed" name="yearsUsed" value="<?php echo htmlspecialchars($years_used); ?>">
                        <label for="condition">Condition:</label>
                        <select id="condition" name="condition">
                            <option value="">Select the condition</option>
                            <option value="new" <?php echo ($condition == 'new') ? 'selected' : ''; ?>>Barely Used i.e almost new</option>
                            <option value="fairly used" <?php echo ($condition == 'fairly used') ? 'selected' : ''; ?>>Fairly used</option>
                            <option value="used" <?php echo ($condition == 'used') ? 'selected' : ''; ?>>Used</option>
                        </select>
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" rows="4" style="width: 100%;" placeholder="provide any more details necessary"><?php echo htmlspecialchars($description); ?></textarea>
                        <div id="nextButtonContainer">
                            <button id="nextButton" type="button">Next</button>
                        </div>
                    </div>
                    <div class="details" id="contactDetails" style="display: none;">
                        <label for="city">Pickup City:</label>
                        <input type="text" id="city" name="city" placeholder="e.g Nairobi" value="<?php echo htmlspecialchars($city); ?>">
                        <label for="town">Location:</label>
                        <input type="text" id="town" name="town" placeholder="e.g Ruiru" value="<?php echo htmlspecialchars($town); ?>">
                        <label for="phone">Phone number:</label>
                        <input type="number" id="phone" name="phone" placeholder="provide the phone number you want to be contacted with" value="<?php echo htmlspecialchars($phone); ?>">
                    </div>
                    <div class="details" id="submitButtonContainer" style="display: none;">
                        <button id="backButton" type="button" style="display: none;">Back</button><br>
                        <button class="btn btn-submit" name="submit" type="submit">Submit</button>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <!-- Page dots -->
    <div class="page-dots">
        <span class="dot" id="dot1"></span>
        <span class="dot" id="dot2"></span>
    </div>

    <script>
        document.getElementById('photos').addEventListener('change', function(event) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = ''; // Clear any existing previews

            Array.from(event.target.files).forEach(file => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Image Preview';
                    img.style.maxWidth = '100px'; // Set the maximum width of the preview images
                    img.style.margin = '10px'; // Add some margin between images
                    imagePreview.appendChild(img);
                };

                reader.readAsDataURL(file);
            });
        });

        document.getElementById('nextButton').addEventListener('click', function() {
            document.getElementById('productDetails').style.display = 'none';
            document.getElementById('contactDetails').style.display = 'block';
            document.getElementById('submitButtonContainer').style.display = 'block';
            document.getElementById('backButton').style.display = 'inline';
        });

        document.getElementById('backButton').addEventListener('click', function() {
            document.getElementById('productDetails').style.display = 'block';
            document.getElementById('contactDetails').style.display = 'none';
            document.getElementById('submitButtonContainer').style.display = 'none';
            document.getElementById('backButton').style.display = 'none';
        });
    </script>
</body>

</html>
