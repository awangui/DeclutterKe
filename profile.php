<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./js/script.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="profile.css">

    <script src="https://kit.fontawesome.com/661ba5765b.js" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container">
        <h1>User Profile</h1>
        <div class="profile-section">
            <div class="profile-image">
                <img src="profile.jpg" alt="Profile Picture">
            </div>
            <div class="profile-details">
                <h2>Charles Hall</h2>
                <p>Email:</p>
            </div>
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

            <div class="listing-section">
                <h2>Items Listed</h2>
                <div class="listing-item">
                    <img src="item1.jpg" alt="Item 1">
                    <div class="details">
                        <h3>Item Name 1</h3>
                        <p>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <p>Price: $50</p>
                    </div>
                </div>
                <div class="listing-item">
                    <img src="item2.jpg" alt="Item 2">
                    <div class="details">
                        <h3>Item Name 2</h3>
                        <p>Description: Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        <p>Price: $70</p>
                    </div>
                </div>
                <!-- Add more listing items as needed -->
            </div>

            <div class="listing-section">
                <h2>Items Bought</h2>
                <div class="listing-item">
                    <img src="item3.jpg" alt="Item 3">
                    <div class="details">
                        <h3>Item Name 3</h3>
                        <p>Description: Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        <p>Price: $100</p>
                    </div>
                </div>
                <div class="listing-item">
                    <img src="item4.jpg" alt="Item 4">
                    <div class="details">
                        <h3>Item Name 4</h3>
                        <p>Description: Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        <p>Price: $120</p>
                    </div>
                </div>
                <!-- Add more listing items as needed -->
            </div>
        </div>
</body>

</html>