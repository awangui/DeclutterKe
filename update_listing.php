<?php
session_start();
require_once 'connection.php';

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
        mysqli_stmt_close($selectStmt);
    } else {
        echo "Listing not found";
        exit();
    }
}

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
    $query = "SELECT * FROM brands" ;
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
    <script src="./js/listing.js"></script>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/listing.css">
    <script src="./js/font-awesome.js" crossorigin="anonymous"></script>
    <title>Update Listing</title>
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
            <a href="#contact">Contact</a>
            <a href="listing.php" class="cta active">Add a Listing</a>
            <div class="credentials">
                <a href="profile.php"><i class="icon fa-regular fa-user"></i><?php echo $_SESSION['name']; ?></a>
                <a href="logout.php"><i class="icon fa-solid fa-right-to-bracket "></i> Logout</a>
            </div>

        </nav>
    </section>

    <form id="listingForm" method="post" enctype="multipart/form-data">

        <div class="listing-container">
            <h2>Update a listing</h2>
            <div class="details-container">
                <div class="details" id="productDetails">
                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
                    <label for="photos">Photos:</label>
                    <input type="file" id="photos" name="photos[]" multiple required>
                    <label for="category">Category:</label>
                    <select id="category" name="category" required>
                        <?php
                        // Fetch categories from the database and populate the dropdown
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
                        // Fetch brands from the database and populate the dropdown
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
                    <input type="number" id="yearsUsed" name="yearsUsed" value="<?php echo isset($years_used) ? $years_used : ''; ?>" required>

                    <label for="condition">Condition:</label>
                    <select id="condition" name="condition" required>
                        <option value="new" <?php echo ($condition == 'new') ? 'selected' : ''; ?>>Barely Used (almost new)</option>
                        <option value="fairly used" <?php echo ($condition == 'fairly used') ? 'selected' : ''; ?>>Fairly Used</option>
                        <option value="used" <?php echo ($condition == 'used') ? 'selected' : ''; ?>>Used</option>
                    </select>

                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" value="<?php echo isset($price) ? $price : ''; ?>" required>

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
                    <input type="number" id="phone" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>" required placeholder="Provide the phone number you want to be contacted with">
                </div>
                <div class="details" id="submitButtonContainer" style="display: none;">
                    <button id="backButton" type="button" style="display: none;">Back</button><br>
                    <button class="btn btn-submit" name="submit" type="submit">Update Listing</button>
                </div>
            </div>
        </div>
<?php
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

    // Insert category if it doesn't exist and get its ID
    $categoryId = $_POST['category'];

    // Insert brand if it doesn't exist and get its ID
    $brandId = $_POST['brand'];

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
    $photos = implode(',', $file_names);
    $updateQuery = "UPDATE listings SET name=?, sub_category=?, brand_id=?, color=?, years_used=?, `condition`=?, price=?, description=?, city=?, town=?, phone_number=?, photos=? WHERE listing_id=?";
    $updateStmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "ssssisdssssi", $name, $sub_category, $brand, $color, $years_used, $condition, $price, $description, $city, $town, $phone, $photos, $id);
    $result = mysqli_stmt_execute($updateStmt);
    mysqli_stmt_close($updateStmt);
}
?>
    </form>
    <!-- Page dots -->
    <div class="page-dots">
        <span class="dot" id="dot1"></span>
        <span class="dot" id="dot2"></span>
    </div>
</body>

</html>
