<?php
session_start();
include "connection.php";

if (isset($_POST['email']) && isset($_POST['password'])) {

    function validate($data)
    {
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
            if (password_verify($pass, $row['password'])) {
                $_SESSION['user_id'] = $row['UserId'];
                $_SESSION['user_role']= $row['role'];
                $_SESSION['name'] = $row['firstName'] ." ". $row['surname'];
                if($row['role'] == 1){
                    header("Location: admin.php");
                    exit();
                }
                else{
                header("Location: index.php");
                exit();
                }
            } else {
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
