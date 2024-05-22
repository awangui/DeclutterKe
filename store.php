<?php
session_start();
require_once 'connection.php';
//query parameters for filtering
$name = isset($_GET['name']) ? $_GET['name'] : "";
$brand = isset($_GET['brand']) ? $_GET['brand'] : "";
$color = isset($_GET['color']) ? $_GET['color'] : "";
$location = isset($_GET['location']) ? $_GET['location'] : "";
$cat = isset($_GET['cat']) ? $_GET['cat'] : "";
$new = isset($_GET['new']) ? $_GET['new'] : "";
$fairly = isset($_GET['fairly']) ? $_GET['fairly'] : "";
$used = isset($_GET['used']) ? $_GET['used'] : "";
$years = isset($_GET['years']) ? $_GET['years'] : "";
$sub_category = isset($_GET['sub-category']) ? $_GET['sub-category'] : "";
$min_price = isset($_GET['min-price']) ? $_GET['min-price'] : "";
$max_price = isset($_GET['max-price']) ? $_GET['max-price'] : "";
$sort_by = isset($_GET['sort-by']) ? $_GET['sort-by'] : "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/store.css">
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <script src="./js/font-awesome.js" crossorigin=" anonymous"></script>
    <title>Decluttering Ke</title>
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
            <a href="store.php" class="active">Store</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>

            <?php if (isset($_SESSION['user_id'])) { ?>
                <?php if ($_SESSION['user_role'] == 2) { ?>
                    <a href="listing.php" class="cta">Add a Listing</a>
                    <a href="manage_listings.php">Manage Listings</a>
                <?php } else { ?>
                    <a href="listing.php" class="cta">Add a Listing</a>
                <?php } ?>
                <div class="credentials">
                    <a href="profile.php" id="myBtn"><i class="icon fa-regular fa-user"></i><?php echo $_SESSION['name']; ?></a>
                    <a href="logout.php"><i class="icon fa-solid fa-right-to-bracket"></i> Logout</a>
                </div>
            <?php } else { ?>
                <a href="listing.php" class="cta">Add a Listing</a>
                <div class="credentials">
                    <a href="login.html"><i class="icon fa-solid fa-right-to-bracket"></i> Login</a>
                    <a href="registration.php"><i class="icon fa-regular fa-user"></i> Sign Up</a>
                </div>
            <?php } ?>
        </nav>
    </section>

    <div class="side-nav">
        <div class="filters">
            <h2>Filters</h2>
            <form action="store.php" method="GET">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" placeholder="Enter item name" value="<?php echo $name; ?>" />
                <label for="brand">Brand:</label>
                <select id="brand" name="brand">
                    <option value="any">Any</option>
                    <?php
                    // Fetch the list of brands from the database
                    $num = mysqli_query($con, "SELECT DISTINCT LOWER(brand_name) AS brand FROM brands ORDER BY brand;");
                    while ($row = mysqli_fetch_assoc($num)) {
                        echo "<option " . ($brand == $row['brand'] ? 'selected' : '') . " value='" . $row['brand'] . "'>" . $row['brand'] . "</option> \n";
                    }
                    ?>
                </select>
                <label for="color">Color:</label>
                <input type="text" id="color" name="color" value="<?php echo $color; ?>" placeholder="Enter color">

                <label for="location">Location:</label>
                <input type="text" id="location" name="location" placeholder="Enter location" value="<?php echo $location; ?>" />

                <label for="category">Category:</label>
                <select id="category" name="cat">
                    <option value="any">Any</option>
                    <?php
                    $res = mysqli_query($con, "SELECT DISTINCT LOWER(category_name) AS category FROM categories ORDER BY category;");
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<option " . ($cat == $row['category'] ? 'selected' : '') . " value='" . $row['category'] . "'>" . $row['category'] . "</option> \n";
                    }
                    ?>
                </select>

                <div class="filter-condition">
                    <table>
                        <tr>
                            <td><label>Condition:</label></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" id="new" name="new"></td>
                            <td><label for="new">New</label></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" id="fairly" name="fairly"></td>
                            <td><label for="fairly">Fairly used</label></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" id="used" name="used"></td>
                            <td><label for="used">Used</label></td>
                        </tr>
                    </table>
                </div>

                <label for="years">Years Used:</label>
                <input type="number" id="years" name="years" placeholder="Enter years used" value="<?php echo $years; ?>">
                <label for="sub-category">Sub-Category:</label>
                <input type="text" id="sub-category" name="sub-category" placeholder="Enter sub-category" value="<?php echo $sub_category; ?>">
                <label for="min-price">Min Price:</label>
                <input type="number" id="min-price" name="min-price" placeholder="Enter price" value="<?php echo $min_price; ?>">
                <label for="max-price"> Max Price:</label>
                <input type="number" id="max-price" name="max-price" placeholder="Enter price" value="<?php echo $max_price; ?>">
                <label for="sort-by">Sort By:</label>
                <select id="sort-by" value="sort-by" name="sort-by">
                    <?php
                    echo "<option " . ($sort_by == 'newest' ? 'selected' : '') . " value='newest'>Newest</option> \n";
                    echo "<option " . ($sort_by == 'price-low-high' ? 'selected' : '') . " value='price-low-high'>Price: Low to High</option> \n";
                    echo "<option " . ($sort_by == 'price-high-low' ? 'selected' : '') . " value='price-high-low'>Price: High to Low</option> \n";
                    ?>
                </select>

                <button id="filter-btn" type="submit">Apply Filters</button>
                <button id="reset-btn" onclick="resetFilters()">Reset Filters</button>
            </form>
        </div>

    </div>

    <!-- Listings Showcase -->
    <div class="container" id="listings-container">
        <?php
        $category =  isset($_GET['cat']) ? $_GET['cat'] : "1";
        $queryFilter = "";
        if (isset($_GET['name']) && $_GET['name'] != "") {
            $queryFilter .= " AND name LIKE '%" . $_GET['name'] . "%'";
        }
        if (isset($_GET['brand']) && $_GET['brand'] != "any") {
            $queryFilter .= " AND b.brand_name = '" . $_GET['brand'] . "'";
        }
        if (isset($_GET['color']) && $_GET['color'] != "") {
            $queryFilter .= " AND color LIKE '%" . $_GET['color'] . "%'";
        }
        if (isset($_GET['location']) && $_GET['location'] != "") {
            $queryFilter .= " AND city LIKE '%" . $_GET['location'] . "%'";
        }
        if (isset($_GET['cat']) && $_GET['cat'] != "any") {
            $queryFilter .= " AND c.category_name = '" . $_GET['cat'] . "'";
        }
        if (isset($_GET['new'])) {
            $queryFilter .= " AND `condition` = 'New'";
        }
        if (isset($_GET['fairly'])) {
            $queryFilter .= " AND `condition` = 'Fairly Used'";
        }
        if (isset($_GET['used'])) {
            $queryFilter .= " AND `condition` = 'Used'";
        }
        if (isset($_GET['years']) && $_GET['years'] != "") {
            $queryFilter .= " AND years_used = " . $_GET['years'];
        }
        if (isset($_GET['sub-category']) && $_GET['sub-category'] != "") {
            $queryFilter .= " AND sub_category LIKE '%" . $_GET['sub-category'] . "%'";
        }
        if (isset($_GET['min-price']) && $_GET['min-price'] != "") {
            $queryFilter .= " AND price >= " . $_GET['min-price'];
        }
        if (isset($_GET['max-price']) && $_GET['max-price'] != "") {
            $queryFilter .= " AND price <= " . $_GET['max-price'];
        }
        if (isset($_GET['sort-by']) && $_GET['sort-by'] != "") {
            if ($_GET['sort-by'] == 'price-low-high') {
                $queryFilter .= " ORDER BY price ASC";
            } else if ($_GET['sort-by'] == 'price-high-low') {
                $queryFilter .= " ORDER BY price DESC";
            } else if ($_GET['sort-by'] == 'newest') {
                $queryFilter .= " ORDER BY listing_id DESC";
            }
        }
        $queryFilter = " WHERE 1 " . $queryFilter;
        $query = "SELECT listings.*, b.brand_name, c.category_name 
          FROM listings 
          INNER JOIN brands b ON listings.brand_id = b.brand_id 
          INNER JOIN categories c ON listings.category_id = c.category_id ";

        $query .= $queryFilter;
        $res = mysqli_query($con, $query);
        $rows = mysqli_num_rows($res);
        while ($row = mysqli_fetch_assoc($res)) {
            // Get the first image filename
            $photosArray = explode(',', $row['photos']); // Split photos field by comma
            $first_image = reset($photosArray); // Get the first item in the exploded array
        ?>
            <div class="card" id="productCard">
                <div class="card-content">
                    <div class="image_content">
                        <img src="./uploads/<?php echo $photosArray[0]; ?>" />
                    </div>
                    <div class="text_content">
                        <h3 class="item-title"><?php echo $row['name']; ?></h3>
                        <div class="item-details">
                            <!-- Update these elements with IDs -->
                            <p class="location" id="location_<?php echo $row['listing_id']; ?>"><?php echo $row['city']; ?></p>

                            <?php if ($row['brand_name'] !== 'Other') { ?>
                                <p class="brand"><?php echo $row['brand_name']; ?></p>
                            <?php } ?>

                            <p class="category" id="category_<?php echo $row['listing_id']; ?>"><?php echo $row['category_name']; ?></p>
                            <!-- 
                            <p class="years" id="years_<?php echo $row['listing_id']; ?>">Used for <?php echo $row['years_used']; ?> yr(s)</p> -->
                            <p class="sub-category" id="sub_category_<?php echo $row['listing_id']; ?>"><?php echo $row['sub_category']; ?></p>
                            <p class="condition" id="condition_<?php echo $row['listing_id']; ?>"><?php echo $row['condition']; ?></p>
                            <p class="price" id="price_<?php echo $row['listing_id']; ?>">Ksh <?php echo $row['price']; ?></p>
                            <br>
                            <span class="item-description"><?php echo $row['description']; ?></span>
                        </div>

                        <button class="btn btn-secondary"><a href="card.php?listing_id=<?php echo $row['listing_id']; ?>">View Item</a></button>
                    </div>
                </div>
            </div>
        <?php } ?>



    </div>
    <div id="message-card" style="<?php echo $rows == 0 ? '' : "display: none;" ?>">
        <img src="./images/error.svg" alt="No listing found error image">
        <p>No listings found. Please adjust your filters.</p>
        <button onclick="resetFilters()">Reset Filters</button>
    </div>
    <section id="footer">
        <div class="footer-main">
            <div class="contain">
                <div class="contained">
                    <ul>
                        <h4><span>About Us</span></h4>
                        <li><a href="about.php">Who we are</a></li>
                        <li><a href="#">Stories and News</a></li>
                        <li><a href="#">Customer Testimonials</a></li>
                    </ul>
                </div>
                <div class="contained">
                    <h4><span>Get in touch</span></h4>
                    <ul>
                        <li><a href="#"><i class="fa fa-instagram"></i> Instagram</a></li>
                        <li><a href="#"><i class="fa fa-phone"></i> +254 000 000 000</a></li>
                        <li><a href="#"><i class="fa-regular fa-envelope"></i> declutterke@gmail.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <script src="./js/store.js"></script>

</body>

</html>