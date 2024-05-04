<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="script.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">

    <script src="https://kit.fontawesome.com/661ba5765b.js" crossorigin="anonymous"></script>
    <title>Decluttering Ke</title>
</head>

<body>
    <section id="header">
        <section id="navigation">

            <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
            <nav>
                <a href="index.php" class="logo">
                    <img src="./images/Logo maker project (1).png" class="icon">
                    <b><span>Declutter</span> Ke</b>
                </a>
                <a href="#home" class="active">Home</a>
                <a href="store.php">Store</a>
                <a href="about.html">About</a>
                <a href="#contact">Contact</a>
                <a href="listing.php" class="cta">Add a Listing</a>
                <div class="credentials">
                <a href="login.html"><i class="icon fa-solid fa-right-to-bracket "></i> Login</a>
                <a href="registration.html"><i class="icon fa-regular fa-user"></i> Sign Up</a>
                </div>

            </nav>
        </section>
        <div class="desc" id="index">
            <h1>Your Resale Haven</h1>
            <p>Helping your pre-loved items find a new home</p>
            <div class="search-container">
                <input type="text" placeholder="What are you looking for?" id="productName" name="search" onkeyup="search()" class="text">
                <!-- <input type="text" placeholder="All Categories" name="search" class="text"> -->
                <button type="button" class="searchbtn" onclick="searchFunction()">Search</button>
                </form>
            </div>
        </div>
    </section>
    <section id="best-sellers">
        <div class="details">
            <img src="./images/pexels-curtis-adams-6510974.jpg">
        </div>
        <div class="description">
            <h3>Discover Treasures in Every Corner</h3>
            <p>Explore a world of pre-loved wonders, where each item has a story to tell. Shop from our curated collection of household treasures and give them a new place to call home.</p>
            <a href="store.php"><button class="btn">Shop Now</button></a>
        </div>
    </section>
    <section id="browse">
        <h2>Popular Categories</h2>
        <ul class="items">
            <li class="item"><a href="#">
                    Tables
                </a>
            </li>
            <li class="item">
                <a href="#">
                    TVs</a>
            </li>
            <li class="item"><a href="#">
                    Sofas</a>
            </li>
            <li class="item"><a href="#">
                    Beds</a>
            </li>
            <li class="item"><a href="#">
                    Fridges
                </a>
            </li>

        </ul>
        <button class="btn">View all categories</button>
    </section>


    <section id="most-popular">
        <h2>Newly Added</h2>
        <div class="row">
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
                    <p class="condition"><?php echo $row['condition']; ?></p>
                    <p class="price"><?php echo 'ksh ' . $row['price']; ?></p>
                    <br>
                </div>
                <p class="item-description"><?php echo $row['description']; ?></p>

                <button class="btn btn-secondary"><a href="card.php?listing_id=<?php echo $row['listing_id']; ?>">View Item</a></button>
            </div>
        </div>
    </div>
    <?php
}
?>
        </div>

    </section>
    <section id="faq">
        <h2>Frequently Asked Questions</h2>
        <div class="accordion">
            <div class="accordion-item">
                <h3 class="accordion-title">How do I list an item for sale?<i class="fa-solid fa-angle-down"></i></h3>
                <div class="accordion-content">
                    <p>Make sure you are logged into your account.Click on add listing and fill in the necessary details then click on submit.</p>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-title"> How do you facilitate communication between buyers and sellers?<i class="fa-solid fa-angle-down"></i></h3>
                <div class="accordion-content">
                    <p>We offer communication between parties through WhatsApp but we aim to implement an inbuilt chat feature soon. Which will facilitate communication between involvied parties directly on the web app.</p>
                </div>
                <div class="accordion-item">
                    <h3 class="accordion-title"> Do you offer shipping?<i class="fa-solid fa-angle-down"></i></h3>
                    <div class="accordion-content">
                        <p>No, at the moment we currently do not offer any shipping.</p>
                    </div>
                </div>
                <div class="accordion-item">
                    <h3 class="accordion-title">What payment methods do you accept?<i class="fa-solid fa-angle-down"></i></h3>
                    <div class="accordion-content">
                        <p>We currently only accept payments via Mpesa.</p>
                    </div>
                </div>
            </div>
    </section>

    <section id="footer">
        <div class="footer-main">
            <div class="contain">
                <div class="contained">
                    <ul>
                        <h4><span>About Us</span></h4>
                        <li><a href="about.html">Mission Statement</a></li>
                        <li><a href="#">Benefits of reselling</a></li>
                        <li><a href="about.html">Our purpose</a></li>
                        <li><a href="#">Our buying process</a></li>
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
                <div class="subscribe-content">
        <p>Join our mailing list</p>
        <form class="subscribe-form" action="#">
            <input type="email" name="email" placeholder="Your E-mail">
            <button type="submit">Subscribe</button>
        </form>
    </div>
            </div>
        </div>
    </section>
</body>

</html>