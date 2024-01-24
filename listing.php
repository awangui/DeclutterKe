<?php
session_start();

include "connection.php";


// Assuming you have a user authentication system, and the user ID is stored in the session
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];


    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data using prepared statements
        // ... (previous code)

        // Prepare and bind the SQL statement
        $sql = "INSERT INTO listings (ProductName, Description, CategoryID, SellerID, Price, ItemCondition) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters to the statement
        $stmt->bind_param("sssids", $name, $description, $category, $user_id, $price, $condition);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Listing added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
} else {
    echo "User not logged in"; // Handle the case where the user is not logged in
}
