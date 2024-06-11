<?php
session_start();
include "connection.php";

define('MAX_FAILED_ATTEMPTS', 3); // Maximum number of failed attempts
define('LOCKOUT_TIME', 5 * 60); // Lockout time in seconds (e.g., 5 minutes)
date_default_timezone_set('SYSTEM');

if (isset($_POST['email']) && isset($_POST['password'])) {

    function validate($data) {
        $data = trim($data); 
        $data = stripslashes($data); 
        $data = htmlspecialchars($data); 
        return $data;
    }

    $email = validate($_POST['email']);
    $pass = validate($_POST['password']);

    if (empty($email)) {
        header("Location: index.php?error=Email address is required");
        exit();
    } else if (empty($pass)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $current_time = time();
            $lockout_until = strtotime($row['lockout_until']);
            if ($lockout_until > $current_time) {
                header("Location: login.html?error=Account locked. Try again later.");
                exit();
            }

            if (password_verify($pass, $row['password'])) {
                $_SESSION['user_id'] = $row['UserId'];
                $_SESSION['user_role'] = $row['role'];
                $_SESSION['name'] = $row['firstName'];

                // Reset failed attempts on successful login
                $update_attempts_query = "UPDATE users SET failed_attempts = 0, lockout_until = NULL WHERE UserId = ?";
                $update_stmt = mysqli_prepare($con, $update_attempts_query);
                mysqli_stmt_bind_param($update_stmt, "i", $row['UserId']);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);

                if ($row['role'] == 1) {
                    header("Location: admin.php");
                    exit();
                } else {
                    header("Location: index.php");
                    exit();
                }
            } else {
                $failed_attempts = $row['failed_attempts'] + 1;

                if ($failed_attempts >= MAX_FAILED_ATTEMPTS) {
                    $lockout_until = date("Y-m-d H:i:s", $current_time + LOCKOUT_TIME);
                    $update_attempts_query = "UPDATE users SET failed_attempts = ?, lockout_until = ? WHERE UserId = ?";
                    $update_stmt = mysqli_prepare($con, $update_attempts_query);
                    mysqli_stmt_bind_param($update_stmt, "isi", $failed_attempts, $lockout_until, $row['UserId']);
                } else {
                    $update_attempts_query = "UPDATE users SET failed_attempts = ?, last_failed_attempt = NOW() WHERE UserId = ?";
                    $update_stmt = mysqli_prepare($con, $update_attempts_query);
                    mysqli_stmt_bind_param($update_stmt, "ii", $failed_attempts, $row['UserId']);
                }

                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);

                header("Location: login.html?error=Invalid details");
                exit();
            }
        } else {
            header("Location: login.html?error=Invalid details");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>
