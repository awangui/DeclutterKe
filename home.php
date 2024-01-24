<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
    <script src="script.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image" href="/images/reading-book.png">
    <script src="https://use.fontawesome.com/9d7bb590aa.js"></script>
    <title>Decluttering Ke</title>
</head>

<body>
    <section id="navigation">
        <div class="navbar">
            <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>

            <nav>
                <a href="home.php" class="logo"><b>Decluttering Ke</b></a>
                <a href="#home">Home</a>
                <a href="#categories">Categories</a>
                <a href="listing.html">listings</a>
                <div class="search-container">
                    <form action="/search" class="search">
                        <input type="text" placeholder="Search..." name="search">
                        <button type="button" onclick="searchFunction()"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <a href="logout.php">Logout</a>

            </nav>
        </div>
    </section>

    <section id="browse">
        <h2>Popular Categories</h2>
        <ul class="items">
            <li class="item"><a href="#">
                    Fridges
                </a>
            </li>
            <li class="item"><a href="#">
                    TVs</a>
            </li>
            <li class="item"><a href="#">
                    Sofas</a>
            </li>
            <li class="item"><a href="#">
                    Beds</a>
            </li>
            <li class="item"><a href="#">
                    Tables
                </a>
            </li>
        </ul>

    </section>



    <section class="newsletter">
        <div class="form">
            <form class="sign" action="crisp.php" method="post" style="margin-top: 70px;">
                <div class="title">
                    <h4><b>Have a Query?</b></h4><br>
                    Do you want to enquire more about us and our services. Feel free to send us a message below and we will be in touch.
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
                    <ol>
                        <h4><span>Get in touch</span></h4>
                        <address>
                            <li><a href="#" class="fa fa-instagram"> Instagram</a></li>
                            <li><a href="#" class="fa fa-phone"> +254 000 000 000</a></li>
                            <li><a href="#" class="fa fa-email">declutterKe@gmail.com</a></li>
                        </address>
                    </ol>
                </div>
            </div>
        </div>
    </section>
</body>

</html>