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
    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
    <link rel="manifest" href="./site.webmanifest">
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
                <a href="about.php">About</a>
                <a href="contact.php" class="active">Contact</a>
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
        <section class="newsletter">
            <div class="form">
                <form class="sign" action="" method="post" style="margin-top: 70px;">
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