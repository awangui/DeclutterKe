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

        // Use prepared statement to update user details
        $updateQuery = "UPDATE users SET firstName=?, surname=?, email=? WHERE UserId=?";
        $updateStmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "sssi", $fname, $sname, $email, $id);
        $result = mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);

        if ($result) {
            header('location:users.php');
            echo "Profile updated successfully";
        } else {
            echo "Failed to update profile";
            die(mysqli_error($con));
        }
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
    <link rel="stylesheet" href="login.css">
    <title>Update Profile</title>
</head>

<body>
    <form action="update.php?editId=<?php echo $id; ?>" method="post"> <!-- Include editId in the form action -->
        <h2 class="title">Update Profile</h2>

        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($fname); ?>" required>

        <label for="sname">Surname:</label>
        <input type="text" id="sname" name="sname" value="<?php echo htmlspecialchars($sname); ?>" required>

        <label for="email">Email address:</label>
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($mail); ?>" required>

        <button type="submit" name="submit">Update Profile</button>
    </form>
</body>

</html>
