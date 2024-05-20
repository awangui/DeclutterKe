<?php
session_start();
require_once 'connection.php';
$message = '';
$messageClass = '';

// Check if 'editId' is set in the URL
if (isset($_GET['editId'])) {
    $id = $_GET['editId'];
    $selectQuery = "SELECT * FROM listings WHERE listing_id = ?";
    $selectStmt = mysqli_prepare($con, $selectQuery);
    mysqli_stmt_bind_param($selectStmt, "i", $id);
    mysqli_stmt_execute($selectStmt);
    $result = mysqli_stmt_get_result($selectStmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $sub_category = $row['sub_category'];
        $brand = $row['brand_id'];
        $color = $row['color'];
        $years_used = $row['years_used'];
        $condition = $row['condition'];
        $price = $row['price'];
        $description = $row['description'];
        $city = $row['city'];
        $town = $row['town'];
        $phone = $row['phone_number'];
        $photos = $row['photos']; // Fetch existing photos if needed
        mysqli_stmt_close($selectStmt);
    } else {
        $message = "Listing not found " . $con->error;
        $messageClass = "alert-error";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $sub_category = htmlspecialchars($_POST['sub-category']);
    $brand = htmlspecialchars($_POST['brand']);
    $color = htmlspecialchars($_POST['color']);
    $years_used = floatval($_POST['yearsUsed']);
    $condition = htmlspecialchars($_POST['condition']);
    $price = floatval($_POST['price']);
    $description = htmlspecialchars($_POST['description']);
    $city = htmlspecialchars($_POST['city']);
    $town = htmlspecialchars($_POST['town']);
    $phone = htmlspecialchars($_POST['phone']);

    // Handle file upload if necessary
    if (isset($_FILES['images']) && $_FILES['images']['error'][0] == 0) {
        $file_names = array();
        $file_count = count($_FILES['images']['name']);
        for ($i = 0; $i < $file_count; $i++) {
            $file_name = $_FILES['images']['name'][$i];
            $temp_name = $_FILES['images']['tmp_name'][$i];
            $folder = '../uploads/' . $file_name;
            if (move_uploaded_file($temp_name, $folder)) {
                $file_names[] = $file_name;
            }
        }

        // Insert listing with all photos
        $photos = implode(',', $file_names);
    } else {
        // Use existing photos if no new photos are uploaded
        $photos = $photos;
    }

    // Update query
    $updateQuery = "UPDATE listings SET name = ?, sub_category = ?, brand_id = ?, color = ?, years_used = ?, `condition` = ?, price = ?, description = ?, city = ?, town = ?, phone_number = ?, photos = ? WHERE listing_id = ?";
    $updateStmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "ssissisdsssii", $name, $sub_category, $brand, $color, $years_used, $condition, $price, $description, $city, $town, $phone, $photos, $id);

    if (mysqli_stmt_execute($updateStmt)) {
        $message = "Listing updated successfully.";
        $messageClass = "alert-success";
    } else {
        $message = "Error updating listing: " . mysqli_error($con);
        $messageClass = "alert-error";
    }

    mysqli_stmt_close($updateStmt);
}

// Function to fetch categories from the database
function getCategories($con) {
    $categories = array();
    $query = "SELECT * FROM categories";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    return $categories;
}

// Function to fetch brands from the database
function getBrands($con) {
    $brands = array();
    $query = "SELECT * FROM brands";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $brands[] = $row;
    }
    return $brands;
}
?>
// Function to fetch brands from the database
function getBrands($con) {
    $brands = array();
    $query = "SELECT * FROM brands";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $brands[] = $row;
    }
    return $brands;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/listing.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/listing.css">
    <script src="../js/font-awesome.js" crossorigin="anonymous"></script>
    <title>Update Listing</title>
</head>
<body>
    <section class="sticky-nav">
    <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
    <nav>
        <a href="index.php" class="logo">
            <img src="../images/declutterLogo.png" class="icon">
            <b><span>Declutter</span> Ke</b>
        </a>
        <a href="index.php">Home</a>
        <a href="store.php">Store</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="listing.php" class="cta">Add a Listing</a>
        <?php if (isset($_SESSION['user_id'])) { ?>
            <?php if ($_SESSION['user_role'] == 2) { ?>
                <a href="manage_listings.php" class="active">Manage Listings</a>
            <?php } ?>
            <div class="credentials">
                <a href="profile.php" id="myBtn"><i class="icon fa-regular fa-user"></i><?php echo $_SESSION['name']; ?></a>
                <a href="logout.php"><i class="icon fa-solid fa-right-to-bracket"></i> Logout</a>
            </div>
        <?php } else { ?>
            <div class="credentials">
                <a href="login.html"><i class="icon fa-solid fa-right-to-bracket"></i> Login</a>
                <a href="registration.php"><i class="icon fa-regular fa-user"></i> Sign Up</a>
            </div>
        <?php } ?>
    </nav>
    </section>

    <form id="listingForm" method="post" enctype="multipart/form-data">
        <div class="listing-container">
            <h2>Update a listing</h2>
            <?php if ($message) : ?>
            <div class="alert <?php echo $messageClass; ?>" style="text-align:center">
                <?php echo $message; ?>
            </div>
            <?php endif; ?>
            <div class="details-container">
                <div class="details" id="productDetails">
                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
                    
                    <label for="photos">Photos:</label>
                    <?php if (!empty($photos)) : ?>
                    <div id="imagePreview"style="max-width:100px; margin:10px;>
                        <?php
                        $photoArray = explode(',', $photos);
                        foreach ($photoArray as $photo) {
                            echo '<img src="../uploads/' . htmlspecialchars($photo) . '" alt="Existing Photo" width="100">';
                        }
                        ?>

                    </div>
                    <?php endif; ?>
                    <input type="file" id="photos" name="images[]" accept="image/*" multiple>

                    <label for="category">Category:</label>
                    <select id="category" name="category" required>
                        <?php
                        $categories = getCategories($con);
                        foreach ($categories as $category) {
                            $selected = ($category['category_id'] == $sub_category) ? 'selected' : '';
                            echo "<option value=\"" . $category['category_id'] . "\" $selected>" . $category['category_name'] . "</option>";
                        }
                        ?>
                    </select>

                    <label for="sub-category">Sub-Category:</label>
                    <select id="sub-category" name="sub-category" required>
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
                    <select id="brand" name="brand" required>
                        <?php
                        $brands = getBrands($con);
                        foreach ($brands as $brand) {
                            $selected = ($brand['brand_id'] == $brand) ? 'selected' : '';
                            echo "<option value=\"" . $brand['brand_id'] . "\" $selected>" . $brand['brand_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div id="rightDetails">
                    <label for="color">Color:</label>
                    <input type="text" id="color" name="color" value="<?php echo isset($color) ? htmlspecialchars($color) : ''; ?>" required>

                    <label for="yearsUsed">Number of Years Used:</label>
                    <input type="number" id="yearsUsed" name="yearsUsed"
                    value="<?php echo isset($years_used) ? htmlspecialchars($years_used) : ''; ?>" required>

                    <label for="condition">Condition:</label>
                    <select id="condition" name="condition" required>
                        <option value="new" <?php echo ($condition == 'new') ? 'selected' : ''; ?>>Barely Used i.e almost new</option>
                        <option value="fairly used" <?php echo ($condition == 'fairly used') ? 'selected' : ''; ?>>Fairly used</option>
                        <option value="used" <?php echo ($condition == 'used') ? 'selected' : ''; ?>>Used</option>
                    </select>

                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" value="<?php echo isset($price) ? htmlspecialchars($price) : ''; ?>" required>

                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4" style="width: 100%;" placeholder="Provide any more details necessary"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>

                    <div id="nextButtonContainer">
                        <button id="nextButton" type="button">Next</button>
                    </div>
                </div>
                <div class="details" id="contactDetails" style="display: none;">
                    <label for="city">Pickup City:</label>
                    <input type="text" id="city" name="city" value="<?php echo isset($city) ? htmlspecialchars($city) : ''; ?>" required placeholder="e.g Nairobi">
                    <label for="town">Location:</label>
                    <input type="text" id="town" name="town" value="<?php echo isset($town) ? htmlspecialchars($town) : ''; ?>" required placeholder="e.g Ruiru">
                    <label for="phone">Phone number:</label>
                    <input type="number" id="phone" name="phone" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>" required placeholder="provide the phone number you want to be contacted with">
                </div>
                <div class="details" id="submitButtonContainer" style="display: none;">
                    <button id="backButton" type="button" style="display: none;">Back</button><br>
                    <button class="btn btn-submit" name="submit" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
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
</script>
</body>
</html>
