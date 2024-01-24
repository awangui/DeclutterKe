<?php

session_start();

include "connection.php";

if (isset($_POST['email']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data); // Removes any leading or trailing whitespace from the input data.
        $data = stripslashes($data); // Removes backslashes from the input data
        $data = htmlspecialchars($data); // Converts special characters to their corresponding HTML entities helps in preventing cross site scripting
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
        mysqli_stmt_close($stmt);

        if ($result && $row = mysqli_fetch_assoc($result)) {
            if (password_verify($pass, $row['password'])) {
                $_SESSION['id'] = $row['id'];
                header("Location: home.php");
                exit();
            } else {
                echo "Invalid password";
                exit();
            }
        } else {
            echo "Invalid email address";
            exit();
        }
    }
} else {
    echo "Invalid details";
    exit();
}
