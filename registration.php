<?php
session_start();
include "connection.php";

$fname = isset($_POST['fname']) ? $_POST['fname'] : null;
$sname = isset($_POST['sname']) ? $_POST['sname'] : null;
$mail = isset($_POST['email']) ? $_POST['email'] : null;
$phone= isset($_POST['phone']) ? $_POST['phone'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$hash_pass = password_hash($password, PASSWORD_DEFAULT);
$confirm_password=isset($_POST['confirm_password'])?$_POST['confirm_password']:null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($fname) && !empty($sname) && !empty($phone) && !empty($mail) && !empty($hash_pass)) {
        // Check if email is already registered
        $check_sql = "SELECT * FROM users WHERE Email = ?";
        $check_stmt = mysqli_prepare($con, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $mail);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $error_message = "Email already registered. Please login.";
        } 
        $number_check="select * from users where phone=?";
        $number_stmt=mysqli_prepare($con,$number_check);
        mysqli_stmt_bind_param($number_stmt,"s",$phone);
        mysqli_stmt_execute($number_stmt);
        $number_result=mysqli_stmt_get_result($number_stmt);
        if(mysqli_num_rows($number_result)>0){
            $error_message="Phone number already registered. Please try again.";
        }
        if ($password !== $confirm_password) {
            $error_message= "Passwords do not match.";
            exit();
        }
        if (preg_match('/\d/', $fname) || preg_match('/\d/', $sname)) {
            $error_message="Names cannot contain numbers.";
            exit();
        }
    
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $error_message= "Invalid email.";
            exit();
        }
        //validate email
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $mail)) {
            $error_message= "Invalid email.";
            exit();
        }
        //validate password
        if (!preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*()]).{8,20}$/', $password)) {
            $error_message= "Password must contain at least one number, one uppercase letter, one lowercase letter, one special character and be 8-20 characters long.";
            exit();
        }
        else {
            $sql = "INSERT INTO users (FirstName, Surname, Email, phone,Password) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $fname, $sname, $mail,$phone, $hash_pass);
            $rs = mysqli_stmt_execute($stmt);

            if ($rs) {
                $success_message = "Successfully registered! Please login.";
                header("Location: login.html?message=" . urlencode($success_message));

                exit();
            } else {
                $error_message = "Failed to register";
            }
        }
    } else {
        $error_message = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <title>Decluttering Ke</title>
    <style>
        .error-message {
            color: red;
            display: <?php echo isset($error_message) ? 'block' : 'none'; ?>;
        }
    </style>
</head>

<body>
    <div id="logo">
        <a href="index.php" class="logo">
            <img src="./images/declutterLogo.png" class="icon">
            <b><span>Declutter</span> Ke</b>
        </a>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
        <h2 class="title">Sign Up</h2>
        <p>Create an account</p>
        <input type="text" id="fname" name="fname" placeholder="First Name" required>
        <input type="text" id="sname" name="sname" placeholder="Surname" required>
        <input type="email" id="email" name="email" placeholder="Email address" required>
        <input type="text" id="phone" name="phone" placeholder="Phone Number e.g 254711299300" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <span id="toggle-password">Show</span>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
        <span id="toggle-confirm_password" onclick="togglePassword('confirm_password')">Show</span>
        <div id="error-message" class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></div>
        <button type="submit">Sign Up</button>
        <p>Already have an account?<span><a href="login.html">Login</a></span></p>
    </form>
</body>
<script src="./js/script.js"></script>

</html>