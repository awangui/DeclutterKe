<?php
session_start();
include "connection.php";

$fname = isset($_POST['fname']) ? $_POST['fname'] : null;
$sname = isset($_POST['sname']) ? $_POST['sname'] : null;
$mail = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$hash_pass = password_hash($password, PASSWORD_DEFAULT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($fname) && !empty($sname) && !empty($mail) && !empty($hash_pass)) {
        // Check if email is already registered
        $check_sql = "SELECT * FROM users WHERE Email = ?";
        $check_stmt = mysqli_prepare($con, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $mail);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $error_message = "Email already registered. Please login.";
        } else {
            $sql = "INSERT INTO users (FirstName, Surname, Email, Password) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $fname, $sname, $mail, $hash_pass);
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
    <link rel="stylesheet" href="../css/login.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
    <link rel="manifest" href="./site.webmanifest">
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
            <img src="../images/declutterLogo.png" class="icon">
            <b><span>Declutter</span> Ke</b>
        </a>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
        <h2 class="title">Sign Up</h2>
        <p>Create an account</p>
        <input type="text" id="fname" name="fname" placeholder="First Name" required>
        <input type="text" id="sname" name="sname" placeholder="Surname" required>
        <input type="email" id="email" name="email" placeholder="Email address" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <span id="toggle-password">Show</span>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
        <span id="toggle-confirm_password" onclick="togglePassword('confirm_password')">Show</span>
        <div id="error-message" class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></div>
        <button type="submit">Sign Up</button>
        <p>Already have an account?<span><a href="login.html">Login</a></span></p>
    </form>
    <script>
        // function to toggle password visibility
        function togglePassword(inputId) {
            var passwordInput = document.getElementById(inputId);
            var toggleButton = document.getElementById("toggle-" + inputId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleButton.textContent = "Hide";
            } else {
                passwordInput.type = "password";
                toggleButton.textContent = "Show";
            }
        }


        // function to validate form
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;
            var errorMessage = document.getElementById("error-message");

            // Password length check
            if (password.length < 8) {
                errorMessage.innerText = "Password must be at least 8 characters long.";
                errorMessage.style.display = "block";
                return false;
            }

            // Uppercase letter check
            if (!/[A-Z]/.test(password)) {
                errorMessage.innerText = "Password must contain at least one uppercase letter.";
                errorMessage.style.display = "block";
                return false;
            }

            // Special character check
            if (!/[^a-zA-Z0-9]/.test(password)) {
                errorMessage.innerText = "Password must contain at least one special character.";
                errorMessage.style.display = "block";
                return false;
            }

            // Password match check
            if (password !== confirm_password) {
                errorMessage.innerText = "Passwords do not match.";
                errorMessage.style.display = "block";
                return false;
            }

            return true;
        }

        // event listener to toggle password button
        document.getElementById("toggle-password").addEventListener("click", function() {
            togglePassword('password');
        });
    </script>
</body>

</html>