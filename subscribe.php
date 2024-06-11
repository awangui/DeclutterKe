<?php
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Validate the email address if needed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit;
    }

    // Check if the email exists in the users table
    $checkUserQuery = "SELECT UserId FROM users WHERE email = '$email'";
    $checkUserResult = mysqli_query($con, $checkUserQuery);

    if (mysqli_num_rows($checkUserResult) == 0) {
        // Email not found in users table (i.e., user is not registered)
        echo "You are not registered. Please create an account to subscribe.";
        exit;
    }

    // Check if the email already exists in the subscribers table
    $checkSubscriptionQuery = "SELECT * FROM subscribers WHERE email = '$email'";
    $checkSubscriptionResult = mysqli_query($con, $checkSubscriptionQuery);

    if (mysqli_num_rows($checkSubscriptionResult) > 0) {
        // Email already subscribed
        echo "<script>alert (' Email already subscribed')</script>";
        echo "<script>window.location.href = 'index.php';</script>";
        exit;
    }

    // Insert the email into the subscribers table
    $insertQuery = "INSERT INTO subscribers (email, customer_id, subscriber_name) SELECT '$email', UserId, CONCAT(firstname, ' ', surname) FROM users WHERE email = '$email'";
    $insertResult = mysqli_query($con, $insertQuery);

    if ($insertResult) {
        // Successfully subscribed
        echo "You have successfully subscribed!";
    } else {
        // Error inserting record
        echo "An error occurred while subscribing!";
    }
}
?>
