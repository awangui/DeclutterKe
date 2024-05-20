<div class="profile">
                 <a href="#" id="openModalBtn"><i class='bx bx-cog'></i></a>
                </div>
<div class="modal" id="profileModal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <!-- Tab links -->
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'UserProfile')">User Profile</button>
            <button class="tablinks" onclick="openTab(event, 'FarmDetails')">Farm Details</button>
            <button class="tablinks" onclick="openTab(event, 'SoilDetails')">Soil Details</button>
            <button class="tablinks" onclick="openTab(event, 'CropDetails')">Crop Details</button>
            <button class="tablinks" onclick="openTab(event, 'Activity')">Activity Log</button>
            <button class="tablinks" onclick="openTab(event, 'Reports')">Reports</button>
        </div>

        <!-- Tab content -->
        <div id="UserProfile" class="tabcontent">
    <h3>User Profile</h3>
    <form method="post" action="edit_profile.php">
        <label for="fullname">Fullname:</label>
        <input type="text" id="fullname" name="fullname" value="<?php echo isset($userData['FullName']) ? $userData['FullName'] : 'user not found'; ?>" ><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo isset($userData['Username']) ? htmlspecialchars($userData['Username']) : ''; ?>"><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($userData['Email']) ? htmlspecialchars($userData['Email']) : ''; ?>"><br>

        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" ><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" ><br>

        <button class="edit-button" type="submit" name="edit">Edit</button>
        <button class="delete-button" type="submit" name="delete">Delete</button>
    </form>
</div>


        <div id="FarmDetails" class="tabcontent">
            <h3>Farm Details</h3>
            <form method="post" action="">
            <div class="form-group">
                <label for="farm_name">Farm Name:</label>
                <input type="text" id="farm_name" name="farm_name" value="<?php echo isset($farmData['FarmName']) ? $farmData['FarmName'] : ''; ?>" >
            </div>

            <div class="form-group">
    <label for="location">Location:</label>
    <select id="location" name="location">
        <option value="">Select Location</option>
        <option value="Nairobi" <?php echo isset($farmData['Location']) && $farmData['Location'] == 'Nairobi' ? 'selected' : ''; ?>>Nairobi</option>
        <option value="Mombasa" <?php echo isset($farmData['Location']) && $farmData['Location'] == 'Mombasa' ? 'selected' : ''; ?>>Mombasa</option>
        <option value="Kisumu" <?php echo isset($farmData['Location']) && $farmData['Location'] == 'Kisumu' ? 'selected' : ''; ?>>Kisumu</option>
        <option value="Kiambu" <?php echo isset($farmData['Location']) && $farmData['Location'] == 'Kiambu' ? 'selected' : ''; ?>>Kiambu</option>
        <option value="Trans Nzoia" <?php echo isset($farmData['Location']) && $farmData['Location'] == 'Trans Nzoia' ? 'selected' : ''; ?>>Trans Nzoia</option>
    </select>
</div>


            <div class="form-group">
                <label for="farm_name">Farm Size(in Acres):</label>
                <input type="text" id="farm_size" name="farm_size" value="<?php echo isset($farmData['FarmSize']) ? $farmData['FarmSize'] : ''; ?>">
            </div>

            <div class="form-group">
    <label for="irrigation_system">Irrigation System:</label>
    <select id="irrigation_system" name="irrigation_system" required>
        <option value="">Select Irrigation System</option>
        <option value="Drip" <?php echo isset($farmData['IrrigationSystem']) && $farmData['IrrigationSystem'] == 'Drip' ? 'selected' : ''; ?>>Drip</option>
        <option value="Sprinkler" <?php echo isset($farmData['IrrigationSystem']) && $farmData['IrrigationSystem'] == 'Sprinkler' ? 'selected' : ''; ?>>Sprinkler</option>
        <option value="Flood" <?php echo isset($farmData['IrrigationSystem']) && $farmData['IrrigationSystem'] == 'Flood' ? 'selected' : ''; ?>>Flood</option>
    </select>
</div>

<div class="form-group">
    <label for="soil_type">Soil Type:</label>
    <select id="soil_type" name="soil_type" required>
        <option value="">Select Soil Type</option>
        <option value="Loam" <?php echo isset($farmData['SoilType']) && $farmData['SoilType'] == 'Loam' ? 'selected' : ''; ?>>Loam</option>
        <option value="Clay" <?php echo isset($farmData['SoilType']) && $farmData['SoilType'] == 'Clay' ? 'selected' : ''; ?>>Clay</option>
        <option value="Sand" <?php echo isset($farmData['SoilType']) && $farmData['SoilType'] == 'Sand' ? 'selected' : ''; ?>>Sand</option>
    </select>
</div>


           

            <div class="form-group">
            <button class="edit-button" type="submit" name="edit">Edit</button>
            <button class="delete-button" type="submit" name="delete">Delete</button>
        </div>
        </form>
        </div>

        <div id="SoilDetails" class="tabcontent">
    <h3>Soil Details</h3>
    <form id="soil-form" method="POST" action="add_soil.php">
        <label for="soil-temperature">Soil Temperature:</label>
        <input type="text" id="soil-temperature" name="soil-temperature" required><br>

        <label for="ph-level">pH Level:</label>
        <input type="number" id="ph-level" name="ph-level" required><br>

        <label for="soil-moisture">Soil Moisture:</label>
        <input type="text" id="soil-moisture" name="soil-moisture" required><br>

        <div class="form-group">
            <button class="edit-button" type="submit" name="add">Add Data</button>
        </div>
    </form>
</div>


        <div id="CropDetails" class="tabcontent">
            <h3>Crop Details</h3>
            <form id="crop-form" method="POST" action="edit_crops.php">


        <label for="crop-name">Crop Name:</label>
        <?php

            
// Check if query is successful and if there are any rows returned
if ($result && $result->num_rows > 0) {
    echo "<select id='crop-type' name='crop-type'>";
    echo "<option value=''>Select Crop</option>"; // Option for default selection
    // Fetch and display each crop name as an option in the dropdown
    while ($row = $result->fetch_assoc()) {
        $crop_name = $row["CropName"];
        echo "<option value='$crop_name'>$crop_name</option>";
    }
    echo "</select>";
} else {
    // If no crops found, display a message
    echo "<select id='crop-type' name='crop-type'>";
    echo "<option value=''>No crops found</option>";
    echo "</select>";
}


            ?>

        <input type="hidden" id="crop-id" name="crop-id"><br>


        <label for="cultivated_area">Cultivated Area:</label>
        <input type="number" id="cultivated_area" name="cultivated_area"><br>
        
        <label for="growth-stage">Growth Stage:</label>
        <input type="text" id="growth-stage" name="growth-stage"><br>
              
        <label for="watering-needs">Watering Needs:</label>
        <input type="text" id="watering-needs" name="watering-needs"><br>
        
        <label for="health-status">Health Status:</label>
        <input type="text" id="health-status" name="health-status"><br>

        <div class="form-group">
            <button class="edit-button" type="submit" name="edit">Edit</button>
            <button class="delete-button" type="submit" name="delete">Delete</button>
        </div>
        
        
      </form>
        </div>

        <div id="Activity" class="tabcontent">
            <h3>Activity Log</h3>
        <?php
        // Retrieve activity log records from the database for the current user

$sql = "SELECT user_id, activity_message, timestamp FROM activity_log WHERE user_id = ? ORDER BY timestamp DESC LIMIT 10";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Check if the prepare() method failed
if ($stmt === false) {
    echo "Error preparing SQL statement: " . $conn->error;
    $conn->close();
    exit; // Stop execution in case of an error
}

// Bind the user ID parameter
$stmt->bind_param("i", $userID);

// Execute the SQL statement

$result = $stmt->execute();

// Get the result set

$result = $stmt->get_result();

// Display activity log content
if ($result->num_rows > 0) {

    echo '<ul>';
    while ($row = $result->fetch_assoc()) {
        $user_id = $row["user_id"];
        $activity_message = $row["activity_message"];
        $timestamp = $row["timestamp"];
        echo "<li>  $activity_message at $timestamp</li>";
    }
    echo '</ul>';
} else {
    echo "No activity log records found.";
}
// Check if the query was successful
if (!$result) {
    echo "Error executing query: " . $conn->error;
    $conn->close();
    exit; // Stop execution in case of an error
}

?>
        </div>
        <script>
                        // Open the modal when the profile picture is clicked
document.getElementById("openModalBtn").addEventListener("click", function() {
    document.getElementById("profileModal").style.display = "block";
});

// Close the modal when the close button is clicked
document.getElementsByClassName("close")[0].addEventListener("click", function() {
    document.getElementById("profileModal").style.display = "none";
});

// Open the default tab
document.getElementById("UserProfile").style.display = "block";

function openTab(evt, tabName) {
    // Get all elements with class="tabcontent" and hide them
    var tabcontent = document.getElementsByClassName("tabcontent");
    for (var i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    var tablinks = document.getElementsByClassName("tablinks");
    for (var i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

        </script>
        <footer class="footer">
        <div class="footer__container container">
            <h1 class="footer__title">Declutter</h1>
            <p class="footer__description">Sell and buy second-hand items with ease.</p>
            <div class="footer__social">
                <a href="#" class="footer__link"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="footer__link"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" class="footer__link"><i class="fa-brands fa-instagram"></i></a>
            </div>
            <span class="footer__copy">&#169; 2023 Declutter. All rights reserved.</span>
        </div>
    </footer>