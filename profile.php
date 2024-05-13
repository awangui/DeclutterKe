<?php
session_start(); // Start the session

require_once 'connection.php';

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];

    // Get user details from the database
    $query = "SELECT * FROM users WHERE UserId = $id";

    // Execute the query
    $result = mysqli_query($con, $query);

    // Check if the query was successful
    if ($result) {
        // Fetch the data from the result set
        $user = mysqli_fetch_assoc($result);

        // Extract user details
        $name = $user['firstName'] . ' ' . $user['surname'];
        $email = $user['email'];
        $phone = $user['phone'] ?? 'Add phone number';
        $city = $user['city'] ?? 'Provide your city';
    } else {
        // Handle the error if the query fails
        echo "Error: " . mysqli_error($con);
    }

    // Get listings posted by the user
    $query_listings = "SELECT * FROM listings WHERE seller_id = $id";
    $listings_result = mysqli_query($con, $query_listings);

    // Check if the query was successful
    if ($listings_result) {
        // Fetch the listings from the result set
        $listings = mysqli_fetch_all($listings_result, MYSQLI_ASSOC);
    } else {
        // Handle the error if the query fails
        echo "Error: " . mysqli_error($con);
    }
} else {
    // Redirect to login page if user is not logged in
    header("Location: login.html");
    exit();
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/profile.css">
    <script src="./js/font-awesome.js" crossorigin="anonymous"></script>
    <title>User Profile</title>
</head>

<body>
    <section id="navigation">

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
            <a href="listing.php" class="cta">Add a Listing</a>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <div class="credentials">
                    <a href="profile.php" class="active"><i class="icon fa-regular fa-user"></i> Profile</a>
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
    <div class="container">
        <div class="header">
            <h1>Welcome, <?php echo $name; ?></h1>
            <h2>Personal Details</h2>
            <div class="profile">
                <div class="profile-image">
                    <img src="./images/undraw_up_to_date_re_nqid.svg" class="hero">
                </div>
                <div class="profile-details">
                    <form action="update_profile.php" method="POST">
                        <p>
                            <label for="avatar">Avatar:</label>
                            <input type="file" id="avatar" name="avatar">
                        </p>
                        <p>
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" value="<?php echo $name; ?>">
                        </p>
                        <p>
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                        </p>
                        <p>
                            <label for="phone">Phone:</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>">
                        </p>
                        <p>
                            <label for="city">City:</label>
                            <input type="text" id="city" name="city" value="<?php echo $city; ?>">
                        </p>
                        <p>
                            <input type="submit" value="Update">
                        </p>
                    </form>
                </div>
            </div>

            <h2>Listings Posted</h2>
            <div class="listings">
                <?php if ($listings && count($listings) > 0) : ?>
                    <table>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>

                        <?php
                        $count = 0;
                        foreach ($listings as $listing) :
                            $count += 1 ?>
                            <tr>
                                <td><?php echo $count ?></td>
                                <td><?php echo $listing['name']; ?></td>
                                <td><?php echo $listing['description']; ?></td>
                                <td><?php echo $listing['price']; ?></td>
                                <td><a href="update.php?editId=<?= $id ?>" class="btn btn-primary">Edit</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else : ?>
                    <div class="empty-listings">
                        <img src="./images/error.svg" alt="No listings found" class="empty">
                        <p>No listings found.</p>
                        <a href="listing.php"><button>Post an ad today</button></a>
                    </div>
                <?php endif; ?>
                </table>
            </div>
        </div>
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


</body>

</html>