<?php
require_once 'navbar.php';

$message = '';
$messageClass = '';

// Check if there's a message in the URL parameters
if (isset($_GET['message']) && isset($_GET['messageClass'])) {
    $message = urldecode($_GET['message']);// Decode the URL-encoded message
    $messageClass = urldecode($_GET['messageClass']);
}
// Function to get role label based on role number
function getRoleLabel($role)
{
    if ($role == 1) {
        return "Admin";
    } elseif ($role == 2) {
        return "Seller";
    } elseif ($role == 3) {
        return "Normal";
    } else {
        return "Unknown";
    }
}

// Fetch all distinct roles
$sqlFetchRoles = "SELECT DISTINCT role FROM users";
$resultFetchRoles = mysqli_query($con, $sqlFetchRoles);

if (!$resultFetchRoles) {
    // Handle the case where the query failed
    die("Error fetching roles: " . mysqli_error($con));
}

// Define the selected role (default to all roles)
$selectedRole = isset($_GET['role']) ? $_GET['role'] : 'All';

// Query to fetch users based on the selected role
$sqlFetchUsers = "SELECT u.*, IFNULL(listings.totalListings, 0) AS totalListings
                  FROM users u
                  LEFT JOIN (
                      SELECT seller_id, COUNT(*) AS totalListings
                      FROM listings
                      GROUP BY seller_id
                  ) AS listings ON u.UserId = listings.seller_id";

// If a role is selected, add a condition to filter users by role
if ($selectedRole !== 'All') {
    $sqlFetchUsers .= " WHERE role = '$selectedRole'";
}
$resultFetchUsers = mysqli_query($con, $sqlFetchUsers);
if (!$resultFetchUsers) {
    die("Error fetching users: " . mysqli_error($con));
}

if (!$resultFetchUsers) {
    die("Error fetching users: " . mysqli_error($con));
}
 // Modify the code to filter users by the selected month
 if (isset($_GET['month']) && $_GET['month'] !== 'All') {
    $month = $_GET['month'];
    $sqlFetchUsers .= " WHERE MONTH(date) = $month";
}

$resultFetchUsers = mysqli_query($con, $sqlFetchUsers);
if (!$resultFetchUsers) {
    die("Error fetching users: " . mysqli_error($con));
}
?>
<?php
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="./css/admin.css">
</head>

<body>
    <div class="main-content" >
    <?php if ($message): ?>
            <div class="alert <?= htmlspecialchars($messageClass) ?>"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="row">
        <h1 class="display" style="text-align: left;">
                            <?php
                            if ($selectedRole === 'All') {
                                echo "All Users";
                            } else if ($selectedRole === '2') {
                                echo "Sellers";
                            } else if ($selectedRole === '1') {
                                echo "Admins";
                            } else if ($selectedRole === '3') {
                                echo "Regular Users";
                            }
                            ?>
                        </h1>
            <div class="col">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <form method="GET">
                            <label for="role">Filter by Role:</label>
                            <select name="role" id="role">
                                <option value="All" <?php if ($selectedRole === 'All') echo 'selected'; ?>>All</option>
                                <?php
                                // Display role options
                                while ($row = mysqli_fetch_assoc($resultFetchRoles)) {
                                    $role = $row['role'];
                                    $roleLabel = getRoleLabel($role);
                                    echo "<option value='$role'";
                                    if ($selectedRole === $role) echo 'selected';
                                    echo ">$roleLabel</option>";
                                }
                                ?>
                            </select>
                            <button type="submit">Filter</button>
                        </form>
                    </div>
                    <div class="card-body">
                       
                        <!-- filter by month joined -->
                        <form method="GET">
                            <label for="month" >Filter by Month Joined:</label>
                            <select name="month" id="month">
                                <option value="All">All</option>
                                <?php
                                // Display month options
                                if (mysqli_num_rows($resultFetchUsers) == 0) {
                                    echo "<option value='All' selected>No users found</option>";
                                } else {
                                    for ($month = 1; $month <= 12; $month++) {
                                        $monthName = date('F', mktime(0, 0, 0, $month, 1));
                                        echo "<option value='$month'";
                                        if (isset($_GET['month']) && $_GET['month'] == $month) {
                                            echo 'selected';
                                        }
                                        echo ">$monthName</option>";
                                    }
                                }
                                ?>
                            </select>
                            <button type="submit">Filter</button>
                            
                        </form>

<!-- filter reset button -->
<button onclick="window.location.href='users.php'" >Reset</button>

                         <!-- Search Category -->
              <button id="downloadCSVButton"> <i class="fa-solid fa-download"></i> Download</button>                
                        <section class='table-display'>
                        <table>
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>Email</th>
                                    <th>Date Joined</th>
                                    <th>Role</th>
                                    <th>Total Listings</th> 
                                    <th>Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                while ($row = mysqli_fetch_assoc($resultFetchUsers)) {
                                    ?>
                                    <tr>
                                        <td><?= $row['UserId'] ?></td>
                                        <td><?= $row['firstName'] ?></td>
                                        <td><?= $row['surname'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td><?= date('Y-m-d', strtotime($row['date'])) ?></td>
                                        <td><?= getRoleLabel($row['role']) ?></td>
                                        <td><?= $row['totalListings'] ?></td> 
                                        <?php
                                             $id = $row['UserId'];
                                          if ($row['role'] != 1) { 
                                           
                                            if ($row['role'] == 2) {                                            echo "<td><a href='#' data-id='{$row['UserId']}' data-name='{$row['firstName']}'data-surname='{$row['surname']}'data-phone='{$row['phone']}'
                                             data-email='{$row['email']}' data-date='{$row['date']}' data-role='" . getRoleLabel($row['role']) . "' data-listings='{$row['totalListings']}' class='btn viewBtn'>View</a> ";
                                        }
                                             if ($row['role'] == 3) {
                                            echo " <td><a href='#' data-id='{$row['UserId']}' data-name='{$row['firstName']}' data-surname='{$row['surname']}'data-phone='{$row['phone']}'data-email='{$row['email']}' data-date='{$row['date']}' data-role='" . getRoleLabel($row['role']) . "' data-listings='{$row['totalListings']}' class='btn viewBtn'>View</a> ";
                                        }
                                        
                                        echo " <a href='#' data-id='$id' class='btn deleteBtn btn-danger'>Delete</a></td>";
                                        
                                    }
                                    
                                    else{
                                         
                                        echo "<td><a href='#' data-id='{$row['UserId']}' data-name='{$row['firstName']}' data-email='{$row['email']}' data-date='{$row['date']}' data-role='" . getRoleLabel($row['role']) . "' data-listings='{$row['totalListings']}' class='btn viewBtn'>View</a></td>";
                                        }
                                    }
                                    ?>
                                    </tr>
                                
                            </tbody>
                        </table>
                                </div>
                    </div>
                </div>
            </div>
        </div>

           <!-- User Modal -->
        <div id="userModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>User Details</h2>
                <p><strong>User ID:</strong> <span id="modalUserId"></span></p>
                <p><strong>First Name:</strong> <span id="modalFirstName"></span></p>
                <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                <p><strong>Phone Number:</strong> <span id="modalPhone"></span></p>
                <p><strong>Date Joined:</strong> <span id="modalDate"></span></p>
                <p><strong>Role:</strong> <span id="modalRole"></span></p>
                <p><strong>Total Listings:</strong> <span id="modalListings"></span></p>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Confirm Deletion</h2>
                <p>Are you sure you want to delete this user?</p>
                <button id="confirmDeleteButton" class="btn-confirm">Confirm</button>
                <button class="btn-cancel close">Cancel</button>
            </div>
        </div>

        <script>
            // CSV download functionality
            document.getElementById('downloadCSVButton').addEventListener('click', function() {
                var csvContent = "";
                var headers = document.querySelectorAll(".table-display th:not(:last-child)");
                var headerRow = Array.from(headers).map(header => header.textContent.trim());//create a new header array from the headers and map through eachh header to get the text content
                csvContent += headerRow.join(",") + "\n";//join the header row with a comma and a new line
                var rows = document.querySelectorAll(".table-display tbody tr");//get all the rows in the table
                rows.forEach(function(row) {
                    var rowData = Array.from(row.querySelectorAll("td:not(:last-child)")).map(cell => cell.textContent.trim());
                    csvContent += rowData.join(",") + "\n";//join the row data with a comma and a new line
                });
                var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });//create a new blob object which holds the csv content
                var url = URL.createObjectURL(blob);//create a url for the blob object
                var a = document.createElement("a");//create a new anchor element
                a.href = url;//set the href attribute of the anchor element to the url
                a.download = "users_data.csv";//set the download attribute of the anchor element to the file name
                document.body.appendChild(a);//append the anchor element to the body
                a.click();//click the anchor element
                document.body.removeChild(a);//remove the anchor element from the body
            });
            // JavaScript to handle view button clicks
            document.querySelectorAll('.viewBtn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var userId = this.getAttribute('data-id');
                    var firstName = this.getAttribute('data-name');
                    var email = this.getAttribute('data-email');
                    var date = this.getAttribute('data-date').split(' ')[0];
                    var role = this.getAttribute('data-role');
                    var phone = this.getAttribute('data-phone');
                    var listings = this.getAttribute('data-listings');

                    document.getElementById('modalUserId').textContent = userId;
                    document.getElementById('modalFirstName').textContent = firstName;
                    document.getElementById('modalEmail').textContent = email;
                    document.getElementById('modalPhone').textContent = phone;
                    document.getElementById('modalDate').textContent = date;
                    document.getElementById('modalRole').textContent = role;
                    document.getElementById('modalListings').textContent = listings;

                    document.getElementById('userModal').style.display = "block";
                });
            });

            // JavaScript to handle modal close buttons
            document.querySelectorAll('.close').forEach(function(button) {
                button.addEventListener('click', function() {
                    document.getElementById('userModal').style.display = "none";
                    document.getElementById('deleteModal').style.display = "none";
                });
            });

            // Close the modal if the user clicks outside of it
            window.addEventListener('click', function(event) {
                var userModal = document.getElementById('userModal');
                var deleteModal = document.getElementById('deleteModal');
                if (event.target == userModal) {
                    userModal.style.display = "none";
                }
                if (event.target == deleteModal) {
                    deleteModal.style.display = "none";
                }
            });

            // JavaScript to handle delete button clicks
            document.querySelectorAll('.deleteBtn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var userId = this.getAttribute('data-id');
                    document.getElementById('confirmDeleteButton').setAttribute('data-id', userId);
                    document.getElementById('deleteModal').style.display = "block";
                });
            });

            // JavaScript to handle confirm delete button click
            document.getElementById('confirmDeleteButton').addEventListener('click', function() {
                var userId = this.getAttribute('data-id');
                window.location.href = `delete.php?deleteid=${userId}`;
            });
        </script>
    </div>
</body>

</html>