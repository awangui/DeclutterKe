<?php
include "connection.php";

// Check if 'editId' is set in the URL
if (isset($_GET['editId'])) {
    $id = $_GET['editId'];

    // Fetch user details for pre-filling the form
    $selectQuery = "SELECT * FROM users WHERE UserId = ?";
    $selectStmt = mysqli_prepare($con, $selectQuery);
    mysqli_stmt_bind_param($selectStmt, "i", $id);
    mysqli_stmt_execute($selectStmt);
    $result = mysqli_stmt_get_result($selectStmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $fname = $row['firstName'];
        $sname = $row['surname'];
        $mail = $row['email'];
        // Additional fields
        $phone = $row['phone'];
        $city = $row['city'];
    } else {
        echo "User not found";
        exit();
    }
    mysqli_stmt_close($selectStmt);

    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $sname = $_POST['sname'];
        $email = $_POST['email'];
        // Additional fields
        $phone = $_POST['phone'];
        $city = $_POST['city'];

        // Use prepared statement to update user details
        $updateQuery = "UPDATE users SET firstName=?, surname=?, email=?, phone=?, city=? WHERE UserId=?";
        $updateStmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "sssssi", $fname, $sname, $email, $phone, $city, $id);

        // Execute the statement
        if (mysqli_stmt_execute($updateStmt)) {
            header('location:profile.php');
            exit(); // Always exit after redirecting
        } else {
            echo "Failed to update profile: " . mysqli_error($con);
        }

        mysqli_stmt_close($updateStmt);
    }
} else {
    echo "Edit ID not provided";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Update Profile</title>
</head>

<body>

    <a href="index.php" class="logo">
        <img src="../images/declutterLogo.png" class="icon">
        <b><span>Declutter</span> Ke</b>
    </a>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?editId=<?php echo $id; ?>" method="post">
        <h2 class="title">Update Profile</h2>

        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($fname); ?>" required>

        <label for="sname">Surname:</label>
        <input type="text" id="sname" name="sname" value="<?php echo htmlspecialchars($sname); ?>" required>

        <label for="email">Email address:</label>
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($mail); ?>" required>

        <!-- Additional fields -->
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>" required>

        <button type="submit" name="submit">Update Profile</button>
    </form>
</body>

</html>