<?php
session_start();
include "connection.php";

$message = '';
$messageClass = '';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$id = $_SESSION['user_id'];

// Fetch user details for pre-filling the form
$selectQuery = "SELECT * FROM users WHERE UserId = ?";
$selectStmt = mysqli_prepare($con, $selectQuery);
mysqli_stmt_bind_param($selectStmt, "i", $id);
mysqli_stmt_execute($selectStmt);
$result = mysqli_stmt_get_result($selectStmt);

if ($row = mysqli_fetch_assoc($result)) {
    $fname = $row['firstName'];
    $sname = $row['surname'];
    $email = $row['email'];
    // Additional fields
    $phone = $row['phone'];
    $city = $row['city'];
} else {
    $message = "User not found";
    $messageClass = "alert-error";
    exit();
}
mysqli_stmt_close($selectStmt);

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $sname = $_POST['sname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];

    if (strlen($phone) != 12) {
        $message = "Phone number must be 12 characters";
        $messageClass = "alert-error";
    } else {
        // Use prepared statement to update user details
        $updateQuery = "UPDATE users SET firstName=?, surname=?, email=?, phone=?, city=? WHERE UserId=?";
        $updateStmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "sssssi", $fname, $sname, $email, $phone, $city, $id);

        // Execute the statement
        if (mysqli_stmt_execute($updateStmt)) {
            header('location:profile.php');
            $message = "Profile updated successfully";
            $messageClass = "alert-success";
        } else {
            $message = "Failed to update profile: " . mysqli_error($con);
            $messageClass = "alert-error";
        }

        mysqli_stmt_close($updateStmt);
    }
} else {
    $message = "Edit ID not provided";
    $messageClass = "alert-error";
    exit();
}
?>
