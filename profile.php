<?php
session_start(); // Start the session
$message = '';
$messageClass = '';
require_once 'connection.php'; // Include the connection file

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
// Get the user id from the session

$id = $_SESSION['user_id'];

// check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = isset($_POST['fname']) ? $_POST['fname'] : null;
    $sname = isset($_POST['sname']) ? $_POST['sname'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $city = isset($_POST['city']) ? $_POST['city'] : null;
    // Update user details in the database
    $query = "UPDATE users SET FirstName = ?, Surname = ?, Email = ?, Phone = ?, City = ? WHERE UserId = ?";
    $updateStmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($updateStmt, "sssssi", $fname, $sname, $email, $phone, $city, $_SESSION['user_id']);
    $result = mysqli_stmt_execute($updateStmt);

    if ($result) {
        $message = "Profile updated successfully";
        $messageClass = "alert-success";
    } else {
        $message = "Failed to update profile";
        $messageClass = "alert-error";
    }

    mysqli_stmt_close($updateStmt);
}


// Fetch user details from the database
$query = "SELECT * FROM users WHERE UserId = ?";
$selectStmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($selectStmt, "i", $id);
mysqli_stmt_execute($selectStmt);
$result = mysqli_stmt_get_result($selectStmt);

if ($row = mysqli_fetch_assoc($result)) {
    $fname = $row['firstName'];
    $sname = $row['surname'];
    $name = $fname . ' ' . $sname; // Combine first name and surname
    $email = $row['email'];
    $phone = $row['phone'] ?? 'Add phone number';
    $city = $row['city'] ?? 'Provide your city';
} else {
    $message = "User not found";
    $messageClass = "alert-error";
}

mysqli_stmt_close($selectStmt);
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
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">

    <script src="./js/font-awesome.js" crossorigin="anonymous"></script>
    <title>User Profile</title>
    <style>
        .error-message {
            color: red;
            display: <?php echo isset($error_message) ? 'block' : 'none'; ?>;
        }
    </style>
</head>

<body>

    <section class="navigation" id="navigation">

        <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
        <nav>
            <a href="index.php" class="logo">
                <img src="./images/declutterLogo.png" class="icon">
                <b><span>Declutter</span> Ke</b>
            </a>
            <a href="index.php">Home</a>
            <a href="store.php">Store</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>

            <?php if (isset($_SESSION['user_id'])) { ?>
                <?php if ($_SESSION['user_role'] == 2) { ?>

                    <a href="listing.php">Add a Listing</a>
                    <a href="manage_listings.php" class="cta">Manage Listings</a>
                <?php } else { ?>
                    <a href="listing.php" class="cta">Add a Listing</a>
                <?php } ?>
                <div class="credentials">
                    <a href="profile.php" class="active" id="myBtn"><i class="icon fa-regular fa-user"></i><?php echo $_SESSION['name']; ?></a>
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
    <div class="container">
        <div class="header">
            <h2>Personal Details</h2>
            <div class="profile">
                <div class="profile-image">
                    <img src="./images/undraw_up_to_date_re_nqid.svg" class="hero">
                </div>
                <div class="profile-details">
                    <?php if ($message) : ?>
                        <div class="alert <?php echo $messageClass; ?>">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                    <!-- <p>Welcome, <?php echo $name; ?></p> -->
                    <div class="name">
                        <span class="detail-title">Name:</span>
                        <span><?php echo $name; ?></span>
                    </div>
                    <div class="email">
                        <span class="detail-title">Email:</span>
                        <span><?php echo $email; ?></span>
                    </div>
                    <div class="phone">
                        <span class="detail-title">Phone:</span><?php echo $phone; ?>
                    </div>
                    <div class="city">
                        <span class="detail-title">City:</span>
                        <span><?php echo $city; ?></span>
                    </div>
                    <div class="update">
                        <button id="editBtn" class="btn cta">Edit</button>
                    </div>

                </div>

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
    <!-- Add the modal HTML structure -->
    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Edit Profile</h3>
            <form action="" method="POST" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($fname); ?>" required>
                </div>
                <div class="form-group">
                    <label for="sname">Surname:</label>
                    <input type="text" id="sname" name="sname" value="<?php echo htmlspecialchars($sname); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo $email; ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" placeholder="include country code e.g 254700111222" required>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn">Save Changes</button>
                </div>
                <div id="error-message" class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></div>
            </form>
        </div>
     
            <style>
                .form-group {
                    margin-bottom: 20px;
                }

                label {
                    display: block;
                    margin-bottom: 5px;
                    font-weight: bold;
                }

                input[type="text"],
                input[type="email"],
                input[type="tel"],
                input[type="password"] {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    box-sizing: border-box;
                }

                .btn {
                    margin-top: 20px;
                    padding: 10px 20px;
                    background-color: #ffb610;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }

                .btn:hover {
                    background-color: #3E3D3C;
                }

                .error-message {
                    color: red;
                    display: <?php echo isset($error_message) ? 'block' : 'none'; ?>;
                }
                    .modal-content {
                        top: 20px;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        margin: auto;
                        position: fixed;
                        width: 50%;
                        height: auto;
                        overflow: auto;
                        background-color: #fefefe;
                        border: 1px solid #888;
                        border-radius: 4px;
                        padding: 20px;
                    }
                    .modal-content h3{
                        text-align: center;
                        color: #3E3D3C;
                    }

            </style>
    </div>

    <script src="./js/profile.js"></script>
</body>

</html>