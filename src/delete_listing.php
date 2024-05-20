<?php
include 'connection.php';

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $sqlDeleteListing = "DELETE FROM listings WHERE listing_id = $id";
    $resultDeleteListing = mysqli_query($con, $sqlDeleteListing);
    
    if (!$resultDeleteListing) {
        // Handle the case where the query failed
        $message = 'Error deleting listing';
        $messageClass = 'alert-error';
    } else {
        $message = 'Listing deleted successfully';
        $messageClass = 'alert-success';
    }
    
    // Redirect to manage_listings.php with the message and message class as URL parameters
    header("Location: manage_listings.php?message=" . urlencode($message) . "&messageClass=" . urlencode($messageClass));
    exit();
}
?>
