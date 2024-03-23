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
    <link rel="stylesheet" href="categories.css">
    <script src="https://kit.fontawesome.com/661ba5765b.js" crossorigin="anonymous"></script>
    <title>Decluttering Ke</title>
</head>

<body>
        <!-- <section id="navigation"class="navbar"> -->

                <section id="navigation" class="listings">
        
                    <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
                    <nav>
                        <a href="index.php" class="logo"><b><span>Declutter</span> Ke</b></a>
                        <a href="index.php" >Home</a>
                        <a href="#categories">Categories</a>
                        <a href="about.php" class="active">About</a>
                        <a href="#contact">Contact</a>
                        <a href="listing.html" class="cta"><i class=" icon fa fa-plus"></i> Add a Listing</a>
                        <a href="login.html" class="credentials"><i class="icon fa-solid fa-right-to-bracket "></i> Login</a>
                        <a href="registration.html"><i class="icon fa-regular fa-user"></i> Sign Up</a>
        
                    </nav>
                </section>         
           
                <div class="side-nav">
                    <div class="filters">
                        <h2>Filters</h2>
                        <label for="location">Location:</label>
                        <input type="text" id="location" placeholder="Enter location">
            
                        <label for="price-range">Price Range:</label>
                        <input type="range" id="price-range" min="0" max="100" value="50">
            
                        <label for="category">Category:</label>
                        <select id="category">
                            <option value="electronics">Electronics</option>
                            <option value="clothing">Clothing</option>
                            <option value="furniture">Furniture</option>
                            <!-- Add more categories as needed -->
                        </select>
            
                        <label for="condition">Condition:</label><br>
                        <input type="checkbox" id="new">
                        <label for="new">New</label><br>
                        <input type="checkbox" id="used">
                        <label for="used">Used</label><br>
                        <!-- Add more condition options as needed -->
            
                        <label for="sort-by">Sort By:</label>
                        <select id="sort-by">
                            <option value="newest">Newest</option>
                            <option value="price-low-high">Price: Low to High</option>
                            <option value="price-high-low">Price: High to Low</option>
                            <!-- Add more sorting options as needed -->
                        </select>
                    </div>
                </div>

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
        <div class="listing-card">
            <div class="image-container">
                <img src="uploads/<?php echo $first_image; ?>" />
            </div>
            <div class="text-container">
            <h3 class="item-title"><?php echo $row['name']; ?></h3>
            <p class="price"><?php echo 'ksh ' . $row['price']; ?></p>
            <p class="brand"><?php echo $row['brand']; ?></p>
            <p>Location: New York</p>
            <p>Category: Electronics</p>
            <p class="condition"><?php echo $row['condition']; ?></p>
            <p class="item-description"><?php echo $row['description']; ?></p>
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
                        <li><a href="#"><i class="fa fa-phone"> </i> +254 000 000 000</i></a></li>
                        <li><a href="#"><i class="fa-regular fa-envelope"></i></i> declutterke@gmail.com</a></li>

                    </ul>
                </div>
            </div>
        </div>
    </section>
    </div>

          
               
            </body>
            </html>