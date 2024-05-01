<?php

session_start();
include "connection.php";

$fname = isset($_POST['fname']) ? $_POST['fname'] : null;
$sname = isset($_POST['sname']) ? $_POST['sname'] : null;
$mail = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$hash_pass = password_hash($password, PASSWORD_DEFAULT);

if (!empty($fname) && !empty($sname) && !empty($mail) && !empty($hash_pass)) {
    $sql = "INSERT INTO users (FirstName, Surname, Email, Password) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $fname, $sname, $mail, $hash_pass);
    $rs = mysqli_stmt_execute($stmt);
    
    if ($rs) {
        $_SESSION['id'] = mysqli_insert_id($con); // Get the ID of the inserted user
        $_SESSION['email'] = $mail; // Store additional user information in session if needed
        header("Location: home.php");
        exit();
    } else {
        header("Location: registration.php?error=Failed to register");
        exit();
    }
} else {
    header("Location: registration.php?error=All fields are required.");
    exit();
}
?>
