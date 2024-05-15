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
    <script src="../js/script.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Homemade+Apple&family=Marck+Script&family=Noto+Serif:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/about.css">
    <script src="../js/font-awesome.js" crossorigin=" anonymous"></script>
    <title>Decluttering Ke</title>
</head>

<body>
    <!-- <section id="navigation"class="navbar"> -->
    <section id="header">
        <section id="navigation">

            <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
            <nav>
                <a href="index.php" class="logo">
                    <img src="../images/declutterLogo.png" class="icon">
                    <b><span>Declutter</span> Ke</b>
                </a>
                <a href="index.php">Home</a>
                <a href="store.php">Store</a>
                <a href="about.php" class="active">About</a>
                <a href="contact.php">Contact</a>
                <a href="listing.php" class="cta">Add a Listing</a>
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <div class="credentials">
                        <a href="profile.php"><i class="icon fa-regular fa-user"></i><?php echo $_SESSION['name']; ?></a>
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
            <div class="breadcrumbs">
                <a href="index.php">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="about.php">About</a>
            </div>
            <h1>About Us</h1>
            <div class="information">
                <h2>Exceptional Value, Unbeatable Quality</h2>
                <p>Discover top-notch quality products at prices that won't break the bank. Experience the perfect blend of affordability and excellence with our curated selection.</p>
                <a href="store.php"><button class="btn">Discover More</button></a>
            </div>
        </div>
    </section>

    <div class="mission-statement">
        <h2>Mission Statement</h2>
        <p>Our mission at Declutter Ke is to provide exceptional value and unbeatable quality to our customers. We aim to empower savings and enrich sustainability by offering top-notch pre-owned products at affordable prices. Through our platform, we strive to foster a community that embraces reuse and reduces waste, contributing to a healthier planet for future generations.</p>
    </div>

    <h2>Benefits of Reselling</h2>
    <div class="benefits">

        <ol class="benefit">
            <li>
                <i class="fa-solid fa-piggy-bank"></i><br>
                <h4 class="benefit-title">Saving Money</h4>
                <p>Buying of pre-owned items helps you save money as compared to purchasing new products.</p>
            </li>
            <li>
                <i class="fa-solid fa-leaf"></i><br>
                <h4 class="benefit-title">Promoting Sustainability</h4>
                <p>Extends the lifecycle of items, reducing the need for new production.</p>
            </li>
            <li>
                <i class="fa-solid fa-broom"></i><br>
                <h4 class="benefit-title">Clearing Clutter</h4 class="benefit-title">
                <p>Helps you declutter your living space by selling items that you no longer need or use.</p>
            </li>
            <li>
                <i class="fa-solid fa-chair"></i><br>
                <h4 class="benefit-title">Access to Unique Items</h4>
                <p>You often have access to unique or vintage items that may not be readily available in traditional retail stores.</p>

            <li>
                <i class="fa-solid fa-hand-holding-dollar"></i><br>
                <h4 class="benefit-title">Earning Money</h4>
                <p>One can easily earn extra income from selling items they no longer use or need.</p>
            </li>
            <li>
                <i class="fa-solid fa-trash"></i><br>
                <h4 class="benefit-title" class="benefit-title">Reducing waste</h4>
                <p>Helps reduce the amount of waste that ends up in landfills.</p>
            </li>
        </ol>
    </div>
    <section id="best-sellers">
        <div class="description">
            <h3>Empowering Savings, Enriching Sustainability</h3>
            <p>Our platform is dedicated to fostering a dual impact by enabling savvy savings while championing environmental responsibility. Explore a world where every purchase contributes to both your financial well-being and the health of our planet</p>
            <a href="store.php"><button class="btn">Shop Now</button></a>
        </div>
        <div class="details">
            <img src="../images/pexels-alina-vilchenko-1173651.jpg">
        </div>
    </section>
    <h2>Our buying process</h2>
    <div class="random clearfix">
        <div class="timeline">

            <div class="container right">
                <div class="content">
                    <h3>Registration </h3>
                    <p>Create an account on the resale platform.</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h3>Item Discovery</h3>
                    <p>Browse the platform to discover listed items.</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h3>Communicate with seller</h3>
                    <p>Inquire everything you would like to know about the item listed on whatsapp</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h3>Arrange viewing with seller</h3>
                    <p>View item in person.</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h3>Pay for item</h3>
                    <p>Return back to our app and pay using a secure Mpesa channel to ensure accountability and proof of payment.</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h3>Enjoy your new purchase!</h3>
                </div>
            </div>
        </div>
    </div>
    <section class="newsletter">
        <div class="form">
            <form class="sign" action="crisp.php" method="post" style="margin-top: 70px;">
                <div class="title">
                    <h4><b>Have a Query?</b></h4><br>
                    Do you want to enquire more about us and our services? Send us a message below and we will be in touch.
                </div>
                <div class="email">
                    <label for="mail"><b>Email address:</b></label>
                    <input type="email" name="mail" placeholder="e.g johndoe@gmail.com" required class="text"><br>
                    <div class="email">
                        <label for="message"><b>Message:</b></label> <br>
                        <textarea name="message" placeholder="Leave a message..." class="textarea" required></textarea>

                        <button type="submit" class="submit btn">Send</button>
            </form>
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