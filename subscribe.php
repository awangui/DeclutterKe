<?php
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Validate the email address if needed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit;
    }

    // Insert the email into the database
    $query = "INSERT INTO subscribers (email, customer_id, subscriber_name) SELECT '$email', users.UserId, CONCAT(users.firstname, ' ', users.surname) FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "Thank you for subscribing!";
        header("Location: index.php"); exit;

    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
