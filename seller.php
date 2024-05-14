<?php
require_once 'connection.php';


// check if user id is in the url and set to seller id
if (isset($_GET['userId'])) {
    $sellerId = $_GET['userId'];
    // Replace with the actual seller ID
    $query = "SELECT * FROM listings WHERE seller_id = $sellerId";
    $result = mysqli_query($con, $query);
} else {
    echo "No seller ID provided";
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: "Lato", sans-serif;
            background-color: #f2f2f2;
        }

        .listing {
            background-color: #fff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .listing h3 {
            margin: 0;
            font-size: 18px;
        }

        .listing p {
            margin: 5px 0;
        }

        .listing .price {
            font-weight: bold;
            color: #ff0000;
        }
    </style>
</head>
<body>
    <?php
    // Display the listings
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="listing">';
        echo '<h3>Listing ID: ' . $row['listing_id'] . '</h3>';
        echo '<p>Title: ' . $row['name'] . '</p>';
        echo '<p>Description: ' . $row['description'] . '</p>';
        echo '<p class="price">Price: $' . $row['price'] . '</p>';
        echo '<p class="price">Phone: ' . $row['phone_number'] . '</p>';
        echo '<p>Name: ' . $row['name'] . '</p>';
        echo '<p>Sub Category: ' . $row['sub_category'] . '</p>';
        echo '<p>Brand: ' . $row['brand'] . '</p>';
        echo '<p>Color: ' . $row['color'] . '</p>';
        echo '<p>Years Used: ' . $row['years_used'] . '</p>';
        echo '<p>Condition: ' . $row['condition'] . '</p>';
        echo '<p>Price: ' . $row['price'] . '</p>';
        echo '<p>Description: ' . $row['description'] . '</p>';
        echo '<p>City: ' . $row['city'] . '</p>';
        echo '<p>Town: ' . $row['town'] . '</p>';
        echo '<p>Phone Number: ' . $row['phone'] . '</p>';
        echo '</div>';
    }

    // Close the database connection
    mysqli_close($con);
    ?>
</body>
</html>