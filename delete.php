<?php
include 'connection.php';

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    // First, delete associated subscribers
    $sqlDeleteSubscribers = "DELETE FROM subscribers WHERE customer_id = $id";
    $resultDeleteSubscribers = mysqli_query($con, $sqlDeleteSubscribers);

    if (!$resultDeleteSubscribers) {
        // Handle the case where the query failed
        die("Error deleting subscribers: " . mysqli_error($con));
    }

    // Then, delete associated listings
    $sqlDeleteListings = "DELETE FROM listings WHERE seller_id = $id";
    $resultDeleteListings = mysqli_query($con, $sqlDeleteListings);

    if (!$resultDeleteListings) {
        // Handle the case where the query failed
        die("Error deleting listings: " . mysqli_error($con));
    }

    // Finally, delete the user
    $sqlDeleteUser = "DELETE FROM users WHERE UserId = $id";
    $resultDeleteUser = mysqli_query($con, $sqlDeleteUser);

    if (!$resultDeleteUser) {
        // Handle the case where the query failed
        die("Error deleting user: " . mysqli_error($con));
    }

    // Redirect to a page after successful deletion
    header("Location: users.php");
    exit();
}
?>
