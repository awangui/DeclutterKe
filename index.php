<?php
session_start();
require_once 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/script.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="./site.webmanifest">
    <link rel="stylesheet" href="./css/styles.css">

    <script src="./js/font-awesome.js" crossorigin="anonymous"></script>
    <title>Decluttering Ke</title>
</head>

<body>
    <section id="header">
        <section id="navigation">

            <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
            <nav>
                <a href="index.php" class="logo">
                    <img src="./images/declutterLogo.png" class="icon">
                    <b><span>Declutter</span> Ke</b>
                </a>
                <a href="index.php" class="active">Home</a>
                <a href="store.php">Store</a>
                <a href="about.php">About</a>
                <a href="#contact">Contact</a>
                <a href="listing.php" class="cta">Add a Listing</a>
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <div class="credentials">
                        <a href="profile.php"><i class="icon fa-regular fa-user"></i> Profile</a>
                        <a href="logout.php"><i class="icon fa-solid fa-right-to-bracket "></i> Logout</a>
                    </div>
                <?php } else {
                ?>
                    <div class="credentials">
                        <a href="login.html"><i class="icon fa-solid fa-right-to-bracket "></i> Login</a>
                        <a href="registration.php"><i class="icon fa-regular fa-user"></i> Sign Up</a>
                    </div>
                <?php } ?>
            </nav>
        </section>
        <div class="desc" id="index">
            <h1>Your Resale Haven</h1>
            <p>Helping your pre-loved items find a new home</p>
            <div class="search-container">
                <form id="searchForm" action="store.php" method="get">
                    <input type="text" name="name" class="text" id="searchInput" placeholder="What are you looking for?">
                    <button type="submit" class="searchbtn">Search</button>
                </form>


            </div>
        </div>
    </section>


    <?php if (!isset($_SESSION['user_id'])) { ?>
        <section id="best-sellers">
            <div class="details">
                <img src="./images/pexels-curtis-adams-6510974.jpg">
            </div>
            <div class="description">
                <h3>Discover Treasures in Every Corner</h3>
                <p>Explore a world of pre-loved wonders, where each item has a story to tell. Shop from our curated collection of household treasures and give them a new place to call home.</p>
                <a href="store.php"><button class="btn">Shop Now</button></a>
            </div>
        <?php } ?>
        </section>
        <section id="browse">
            <h2>Popular Categories</h2>
            <ul class="items">
                <li class="item"> <a href="store.php?sub-category=tables">
                        Tables
                    </a>
                </li>
                <li class="item">
                    <a href="store.php?cat=electronics">
                        Electronics</a>
                </li>
                <li class="item"><a href="store.php?cat=furniture">
                        Furniture</a>
                </li>
                <li class="item"> <a href="store.php?name=bed">
                        Beds</a>
                </li>
                <li class="item"> <a href="store.php?cat=appliances">
                        Appliances
                    </a>
                </li>

            </ul>
            <button class="btn"><a href="store.php?cat=any">View all categories</a></button>
        </section>




        <section id="most-popular">
            <h2>Newly Added</h2>
            <div class="row">
                <?php
                include 'connection.php';
                $query = "SELECT l.*, b.brand_name, c.category_name 
              FROM listings l 
              JOIN brands b ON l.brand_id = b.brand_id 
              JOIN categories c ON l.category_id = c.category_id";
                $res = mysqli_query($con, $query);
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
                                    <p class="location" id="location_<?php echo $row['listing_id']; ?>"><?php echo $row['city']; ?></p>
                                    <?php if ($row['brand_name'] !== 'Other') { ?>
                                        <p class="brand"><?php echo $row['brand_name']; ?></p>
                                    <?php } ?>
                                    <p class="color"><?php echo $row['color']; ?></p>
                                    <p class="condition"><?php echo $row['condition']; ?></p>
                                    <p class="price"><?php echo 'ksh ' . $row['price']; ?></p>

                                    <br>
                                    <span class="item-description"><?php echo $row['description']; ?></span>


                                </div>

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
                            <li><a href="about.php">Mission Statement</a></li>
                            <li><a href="#">Benefits of reselling</a></li>
                            <li><a href="about.php">Our purpose</a></li>
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
                        <div class="subscription"></div>
                        <form class="subscribe-form" action="subscribe.php" method="POST">
                            <input type="email" name="email" placeholder="Your E-mail">
                            <button type="submit">Subscribe</button>

                        </form>
                    </div>
                </div>
            </div>
        </section>
</body>
<script>
    function searchFunction() {
        var search = document.getElementById('productName').value;
        window.location.href = 'store.php?search=' + search;

    }

    function search() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById('productName');
        filter = input.value.toUpperCase();
        ul = document.getElementsByClassName('items')[0];
        li = ul.getElementsByClassName('item');
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }

    function menuToggle() {
        var nav = document.getElementsByTagName('nav')[0];
        nav.classList.toggle('active');
    }
    var acc = document.getElementsByClassName("accordion-title");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    };
</script>

</html>