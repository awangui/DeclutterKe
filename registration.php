<?php

session_start();
if (isset($_SESSION['error_message'])) {
    echo '<script>alert("' . $_SESSION['error_message'] . '");</script>';
    unset($_SESSION['error_message']); // Clear the session variable
}
include "connection.php";

$fname = isset($_POST['fname']) ? $_POST['fname'] : null;
$sname = isset($_POST['sname']) ? $_POST['sname'] : null;
$mail = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$hash_pass = password_hash($password, PASSWORD_DEFAULT);
//validation
if (!empty($fname) && !empty($sname) && !empty($mail) && !empty($hash_pass)) {
    $sql = "INSERT INTO users (FirstName, Surname, Email, Password) VALUES (?, ?, ?, ?)"; //? are parameterized queries to prevent sql injection attacks
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $fname, $sname, $mail, $hash_pass);
    $rs = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($rs) {
        header("Location: home.php");
       echo"Successfully registered";
        exit();
    } else {
        header("Location: registation.php");
        echo"Failed to register";
        exit();
    }
} else {
    echo "All fields are required.";
    exit();
}
?>