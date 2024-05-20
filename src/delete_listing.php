<?php
include 'connection.php';
$message = '';
$messageClass = '';
if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $sqlDeleteListing= "DELETE FROM listings WHERE listing_id = $id";
    $resultDeleteListing = mysqli_query($con, $sqlDeleteListing);
    if (!$resultDeleteUser) {
        // Handle the case where the query failed
        $message = 'Error deleting listing';
        $messageClass = 'alert-error';
    }
    else{
        $message = 'Listing deleted successfully';
        $messageClass = 'alert-success';
    }
    // Redirect to a page after successful deletion
    header("Location: manage_listings.php?message=$message&messageClass=$messageClass");
    exit();
}
