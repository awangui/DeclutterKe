<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="script.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Homemade+Apple&family=Marck+Script&family=Noto+Serif:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="store.css">
    <script src="https://kit.fontawesome.com/661ba5765b.js" crossorigin="anonymous"></script>
    <title>Decluttering Ke</title>
    <script>
function applyFilters() {
  var locationInput = document.getElementById('location');
  var categoryInput = document.getElementById('category');
  var conditionInputs = document.querySelectorAll('.filter-condition input[type="checkbox"]');
  var nameInput = document.getElementById('name');
  var sortByInput = document.getElementById('sort-by');

  // Get selected values
  var locationValue = locationInput.value.toUpperCase();
  var categoryValue = categoryInput.value;
  var conditions = [];
  conditionInputs.forEach(function(input) {
    if (input.checked) {
      conditions.push(input.id); // Push the id of the checked checkbox
    }
  });
  var nameValue = nameInput.value.toUpperCase();
  var sortByValue = sortByInput.value;

  // Apply filters
  var listings = document.getElementsByClassName('listing-card');
  for (var i = 0; i < listings.length; i++) {
    var card = listings[i];
    var location = card.querySelector('.location').textContent.toUpperCase();
    var category = card.querySelector('.category').textContent;
    var condition = card.querySelector('.condition').textContent.toUpperCase();
    var name = card.querySelector('.item-title').textContent.toUpperCase();

    // Check if listing matches the filters
    var locationMatch = location.includes(locationValue);
    var categoryMatch = (category === categoryValue || categoryValue === 'all');
    var conditionMatch = conditions.length === 0 || conditions.includes(condition);
    var nameMatch = name.includes(nameValue);

    if (locationMatch && categoryMatch && conditionMatch && nameMatch) {
      card.style.display = ''; // Show the listing
    } else {
      card.style.display = 'none'; // Hide the listing
    }
  }
}


// Add event listener to the apply filters button
document.getElementById('filter-btn').addEventListener('click', applyFilters);

</script>

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
    <a href="store.php" class="active">Store</a>
    <a href="about.html">About</a>
    <a href="#contact">Contact</a>
    <a href="listing.php" class="cta">Add a Listing</a>
    <div class="credentials">
    <a href="login.html"><i class="icon fa-solid fa-right-to-bracket "></i> Login</a>
    <a href="registration.html"><i class="icon fa-regular fa-user"></i> Sign Up</a>
    </div>

</nav>
</section>

    <div class="side-nav">
        <div class="filters">
            <h2>Filters</h2>
            <label for="name">Name:</label>
            <input type="text" id="name" placeholder="Enter item name">

            <label for="location">Location:</label>
            <input type="text" id="location" placeholder="Enter location">

            <label for="category">Category:</label>
            <select id="category">
                <option value="electronics">Electronics</option>
                <option value="clothing">Clothing</option>
                <option value="furniture">Furniture</option>
                <!-- Add more categories as needed -->
            </select>

            <div class="filter-condition">
                <label for="condition">Condition:</label>
                <input type="checkbox" id="new">
                <label for="new">New</label>
                <input type="checkbox" id="fairly">
                <label for="fairly">Fairly used</label>
                <input type="checkbox" id="used">
                <label for="used">Used</label>
                <!-- Add more condition options as needed -->
            </div>

            <label for="sort-by">Sort By:</label>
            <select id="sort-by">
                <option value="newest">Newest</option>
                <option value="price-low-high">Price: Low to High</option>
                <option value="price-high-low">Price: High to Low</option>
                <!-- Add more sorting options as needed -->
            </select>

            <button onclick="applyFilters()" id="filter-btn">Apply Filters</button>
        </div>
    </div>

    <!-- Listings Showcase -->
    <!-- Listings Showcase -->
    <div class="container">
    <?php
    include 'connection.php';
    $res = mysqli_query($con, "SELECT * FROM listings");
    while ($row = mysqli_fetch_assoc($res)) {
        // Get the first image filename
        $photosArray = explode(',', $row['photos']); // Split photos field by comma
        $first_image = reset($photosArray); // Get the first item in the exploded array
    ?>
         <div class="card" id="productCard">
        <div class="card-content">
            <div class="image_content">
                <img src="uploads/<?php echo $photosArray[0]; ?>" />
            </div>
            <div class="text_content">
                <h3 class="item-title"><?php echo $row['name']; ?></h3>
                <div class="item-details">
                    <p class="brand"><?php echo $row['brand']; ?></p>
                    <p class="color"><?php echo $row['color']; ?></p>
                    <p class="location"><?php echo $row['city']; ?></p>
                    <p class="category"><?php echo $row['category']; ?></p> 
                    <p class="years"><?php echo  $row['years_used']; ?></p>
                <p class="sub-category"><?php echo  $row['sub_category'];?></p>
                  
                    <p class="condition"><?php echo $row['condition']; ?></p>
                    <p class="price"><?php echo 'ksh ' . $row['price']; ?></p>
                    <br>
                </div>
                <p class="item-description"><?php echo $row['description']; ?></p>

                <button class="btn btn-secondary"><a href="card.php?listing_id=<?php echo $row['listing_id']; ?>">View Item</a></button>
            </div>
        </div>
    </div>
    <?php } ?>
   
</div>
<section id="footer">
        <div class="footer-main">
            <div class="contain">
                <div class="contained">
                    <ul>
                        <h4><span>About Us</span></h4>
                        <li><a href="about.html">Who we are</a></li>
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

   
</body>
</html>
