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
    <link rel="icon" type="image" href="/images/reading-book.png">
    <script src="https://kit.fontawesome.com/661ba5765b.js" crossorigin="anonymous"></script>
    <title>Decluttering Ke</title>
</head>

<body>
    <section id="header">
        <section id="navigation">
            <div class="navbar">
            <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
                <nav>
                    <a href="index.php" class="logo"><b><span>Declutter</span> Ke</b></a>
                    <a href="#home" class="active">Home</a>
                    <a href="#categories">Categories</a>
                    <a href="#about">About</a>
                    <a href="#contact">Contact</a>
                    <a href="listing.html" class="cta"><i class=" icon fa fa-plus"></i> Add a Listing</a>
                    <a href="login.html" class="credentials"><i class="icon fa-solid fa-right-to-bracket "></i> Login</a>
                    <a href="registration.html"><i class="icon fa-regular fa-user"></i> Sign Up</a>

                </nav>
            </div>
        </section>
        <div class="desc">
            <h1>Your Resale Haven</h1>
            <p>Helping your pre loved items find a new home</p>
            <div class="search-container">
                <input type="text" placeholder="What are you looking for?" id="productName" name="search" onkeyup="search()">
                <input type="text" placeholder="All Categories" name="search">
                <button type="button" class="searchbtn" onclick="searchFunction()">Search</button>
                </form>
            </div>
        </div>
    </section>

    <section id="browse">
        <h2>Popular Categories</h2>
        <p>Most viewed items</p>
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
    <section id="best-sellers">
        <div class="details">
            <img src="./images/pexels-curtis-adams-6510974.jpg">
        </div>
        <div class="description">
            <h3>Discover Treasures in Every Corner</h3>
            <p>Explore a world of pre-loved wonders, where each item has a story to tell. Shop from our curated collection of household treasures and give them a new place to call home.</p>
            <button class="btn">Shop Now</button>
        </div>
    </section>

    <section id="most-popular">
        <h2>Most Popular</h2>
        <div class="row">
            <div class="card" id="productCard">
                <div class="card-content">
                    <div class="image_content">
                        <img src="images/download.jfif">
                    </div>
                    <div class="text_content">
                        <div class="item-details">
                            <p class="brand">LG</p>
                            <p class="color">Silver</p>
                            <p class="condition">Fairly Used</p>
                        </div>
                        <h5 class="item-title">Refrigerator</h5>
                        <button class="btn btn-secondary">View Item</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="image_content">
                        <img src="images/download.jfif">

                    </div>
                    <div class="text_content">
                        <h5>LG Fridge</h5>
                        <button class="btn btn-secondary">View Item</button>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="image_content">
                        <img src="images/download.jfif">

                    </div>
                    <div class="text_content">
                        <h5>LG Fridge</h5>
                        <button class="btn btn-secondary">View Item</button>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="image_content">
                        <img src="images/download.jfif">

                    </div>
                    <div class="text_content">
                        <h5>LG Fridge</h5>
                        <button class="btn btn-secondary">View Item</button>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="image_content">
                        <img src="images/download.jfif">

                    </div>
                    <div class="text_content">
                        <h5>LG Fridge</h5>
                        <button class="btn btn-secondary">View Item</button>
                    </div>

                </div>
            </div>


            <div class="card">
                <div class="card-content">
                    <div class="image_content">
                        <img src="images/download.jfif">

                    </div>
                    <div class="text_content">
                        <h5>LG Fridge</h5>
                        <button class="btn btn-secondary">View Item</button>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <div class="image_content">
                        <img src="images/download.jfif">

                    </div>
                    <div class="text_content">
                        <h5>LG Fridge</h5>
                        <button class="btn btn-secondary">View Item</button>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="image_content">
                        <img src="images/download.jfif">

                    </div>
                    <div class="text_content">
                        <h5>LG Fridge</h5>
                        <button class="btn btn-secondary">View Item</button>
                    </div>

                </div>
            </div>

        </div>

    </section>


    <section class="newsletter">
        <div class="form">
            <form class="sign" action="crisp.php" method="post" style="margin-top: 70px;">
                <div class="title">
                    <h4><b>Have a Query?</b></h4><br>
                    Do you want to enquire more about us and our services? Send us a message below and we will be in touch.
                </div>
                <div class="email">
                    <label for="mail"><b>Email address:</b></label>
                    <input type="email" name="mail" placeholder="e.g johndoe@gmail.com" required><br>
                    <div class="email">
                        <label for="message"><b>Message:</b></label> <br>
                        <textarea name="message" placeholder="Leave a message..."></textarea>

                        <button type="submit" class="submit btn">Send</button>
            </form>
        </div>
    </section>
    </section>
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
                    <ul>
                        <h4><span>Get in touch</span></h4>
                        <li><a href="#" class="fa fa-instagram"> Instagram</a></li>
                        <li><a href="#" class="fa fa-phone"> +254 000 000 000</a></li>
                        <li><a href="#" class="fa fa-email">declutterKe@gmail.com</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </section>
</body>

</html>