<?php
include 'connection.php';

$message = '';
$messageClass = 'alert-success'; // Default to success

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    // First, delete associated subscribers
    $sqlDeleteSubscribers = "DELETE FROM subscribers WHERE customer_id = $id";
    $resultDeleteSubscribers = mysqli_query($con, $sqlDeleteSubscribers);

    if (!$resultDeleteSubscribers) {
        // Handle the case where the query failed
        $message = 'Error deleting subscribers';
        $messageClass = 'alert-error';
    }

    // Then, delete associated listings
    $sqlDeleteListings = "DELETE FROM listings WHERE seller_id = $id";
    $resultDeleteListings = mysqli_query($con, $sqlDeleteListings);

    if (!$resultDeleteListings) {
        // Handle the case where the query failed
        $message = 'Error deleting listings';
        $messageClass = 'alert-error';
    }

    // Finally, delete the user
    $sqlDeleteUser = "DELETE FROM users WHERE UserId = $id";
    $resultDeleteUser = mysqli_query($con, $sqlDeleteUser);

    if (!$resultDeleteUser) {
        // Handle the case where the query failed
        $message = 'Error deleting user';
        $messageClass = 'alert-error';
    } else {
        $message = 'User deleted successfully';
    }

    // Redirect to a page after successful deletion
    header("Location: users.php?message=" . urlencode($message) . "&messageClass=" . urlencode($messageClass));
    exit();
}
?>
