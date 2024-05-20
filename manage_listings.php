<?php
session_start();
require_once 'connection.php';
$message = '';
$messageClass = '';

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Fetch listings posted by the user
if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    $query_listings = "SELECT * FROM listings WHERE seller_id = ?";
    $stmt = mysqli_prepare($con, $query_listings);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $listings_result = mysqli_stmt_get_result($stmt);
    $listings = mysqli_fetch_all($listings_result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
}

// Check if there's a message in the URL parameters
if (isset($_GET['message']) && isset($_GET['messageClass'])) {
    $message = urldecode($_GET['message']);
    $messageClass = urldecode($_GET['messageClass']);
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
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <script src="./js/font-awesome.js" crossorigin="anonymous"></script>
    <title>User Profile</title>
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
            <a href="listing.php" class="cta">Add a Listing</a>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <?php if ($_SESSION['user_role'] == 2) { ?>
                    <a href="manage_listings.php" class="active">Manage Listings</a>
                <?php } ?>
                <div class="credentials">
                    <a href="profile.php" id="myBtn"><i class="icon fa-regular fa-user"></i><?php echo $_SESSION['name']; ?></a>
                    <a href="logout.php"><i class="icon fa-solid fa-right-to-bracket"></i> Logout</a>
                </div>
            <?php } else { ?>
                <div class="credentials">
                    <a href="login.html"><i class="icon fa-solid fa-right-to-bracket"></i> Login</a>
                    <a href="registration.php"><i class="icon fa-regular fa-user"></i> Sign Up</a>
                </div>
            <?php } ?>
        </nav>
    </section>
    <div class="container">
        <h2>Listings Posted</h2>
        <p style="text-align: center;">View and manage your listings</p>
        <?php if ($message) : ?>
            <div class="alert <?php echo $messageClass; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <button class="btn add" onclick="window.location.href='listing.php'">Post a new ad</button>
        <div class="listings">
            <?php if ($listings && count($listings) > 0) : ?>
                <table>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($listings as $count => $listing) : ?>
                        <tr>
                            <td><?php echo $count + 1 ?></td>
                            <td><?php echo $listing['name']; ?></td>
                            <td><?php echo $listing['description']; ?></td>
                            <td><?php echo $listing['price']; ?></td>
                            <td>
                                <a href="card.php?listing_id=<?php echo $listing['listing_id']; ?>" class="cta view">View</a>
                                <a href="update_listing.php?editId=<?php echo $listing['listing_id']; ?>" class="cta edit">Edit</a>
                                <button data-id='<?php echo $listing['listing_id']; ?>' class='cta delete deleteBtn'>Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <div class="empty-listings">
                    <img src="./images/error.svg" alt="No listings found" class="empty">
                    <p>No listings found.</p>
                    <a href="listing.php"><button class="cta">Post an ad today</button></a>
                </div>
            <?php endif; ?>
        </div>
        <div id="viewModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Listing Details</h2>
                <div class="listing-details">
                    <p><strong>Name:</strong> <span id="listingName"></span></p>
                    <p><strong>Description:</strong> <span id="listingDescription"></span></p>
                    <p><strong>Price:</strong> <span id="listingPrice"></span></p>
                    <p><strong>Category:</strong> <span id="listingCategory"></span></p>
                </div>
            </div>
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Confirm Deletion</h2>
                    <p>Are you sure you want to delete this listing?</p>
                    <button id="confirmDeleteButton" class="btn-confirm">Confirm</button>
                    <button class="btn-cancel close">Cancel</button>
                </div>
            </div>
        </div>
        <script>
            document.querySelectorAll('.delete').forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    document.getElementById('confirmDeleteButton').setAttribute('data-id', id);
                    document.getElementById('deleteModal').style.display = "block";
                });
            });

            // Close the delete modal when the user clicks on the close button
            document.querySelector('.close').addEventListener('click', function() {
                document.getElementById('deleteModal').style.display = "none";
            });

            // Close the delete modal when the user clicks outside of it
            window.onclick = function(event) {
                var modal = document.getElementById('deleteModal');
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };

            // JavaScript to handle delete button clicks
            document.querySelectorAll('.deleteBtn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var listing_id = this.getAttribute('data-id');
                    document.getElementById('confirmDeleteButton').setAttribute('data-id', listing_id);
                    document.getElementById('deleteModal').style.display = "block";
                });
            });

            // JavaScript to handle confirm delete button click
            document.getElementById('confirmDeleteButton').addEventListener('click', function() {
                var listing_id = this.getAttribute('data-id');
                window.location.href = `delete_listing.php?deleteid=${listing_id}`;
            });
            //
            // Close the delete modal when the user clicks on the close button
            function closeModal() {
                document.getElementById('deleteModal').style.display = "none";
            }
            document.querySelectorAll('.close').forEach(function(button) {
                button.addEventListener('click', closeModal);
            });
            // JavaScript to handle close button click
            document.querySelector('.close').addEventListener('click', function() {
                document.getElementById('deleteModal').style.display = "none";
            });
        </script>
</body>

</html>