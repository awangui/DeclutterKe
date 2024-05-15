<?php
require_once 'navbar.php';

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

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    // Handle the case where the query failed
    die("Error fetching users: " . mysqli_error($con));
}
// Fetch data for bar chart
$sqlFetchUsersByMonth = "SELECT MONTH(date) AS month, YEAR(date) AS year, COUNT(*) AS totalUsers
                         FROM users
                         GROUP BY YEAR(date), MONTH(date)
                         ORDER BY year DESC, month DESC";
$resultFetchUsersByMonth = mysqli_query($con, $sqlFetchUsersByMonth);

// Check for query errors
if (!$resultFetchUsersByMonth) {
    // Handle error
    die("Error fetching data: " . mysqli_error($con));
}

// Initialize arrays to store labels and data for chart
$labels = [];
$data = [];

// Fetch data and populate arrays
while ($row = mysqli_fetch_assoc($resultFetchUsersByMonth)) {
    // Generate label in "Month Year" format
    $label = date('M Y', mktime(0, 0, 0, $row['month'], 1, $row['year']));
    $labels[] = $label;
    // Store total users for the month
    $data[] = $row['totalUsers'];
}

// Close connection
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Modal styles */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0, 0, 0); 
            background-color: rgba(0, 0, 0, 0.4); 
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-confirm, .btn-cancel {
            margin: 10px;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        .btn-confirm {
            background-color: #d9534f;
            color: white;
        }

        .btn-cancel {
            background-color: #5bc0de;
            color: white;
        }
    </style>
</head>

<body>
    <div class="main-content" style="display: block;">
        <div class="row">
            <div class="col">
                <div class="widget">
                    <canvas id="usersByMonthChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
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
                        <h2 class="display">
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
                        </h2>
                        <button id="downloadCSVButton"> <i class="fa-solid fa-download"></i> Download</button>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>First Name</th>
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
                                        <td><?= $row['email'] ?></td>
                                        <td><?= $row['date'] ?></td>
                                        <td><?= getRoleLabel($row['role']) ?></td>
                                        <td><?= $row['totalListings'] ?></td> 
                                        <?php
                                             $id = $row['UserId'];
                                          if ($row['role'] != 1) { 
                                           
                                            if ($row['role'] == 2) {                                            echo "<td><a href='#' data-id='{$row['UserId']}' data-name='{$row['firstName']}' data-email='{$row['email']}' data-date='{$row['date']}' data-role='" . getRoleLabel($row['role']) . "' data-listings='{$row['totalListings']}' class='btn viewBtn'>View</a> ";
                                        }
                                             if ($row['role'] == 3) {
                                            echo " <td><a href='#' data-id='{$row['UserId']}' data-name='{$row['firstName']}' data-email='{$row['email']}' data-date='{$row['date']}' data-role='" . getRoleLabel($row['role']) . "' data-listings='{$row['totalListings']}' class='btn viewBtn'>View</a> ";
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

        <!-- User Modal -->
        <div id="userModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>User Details</h2>
                <p><strong>User ID:</strong> <span id="modalUserId"></span></p>
                <p><strong>First Name:</strong> <span id="modalFirstName"></span></p>
                <p><strong>Email:</strong> <span id="modalEmail"></span></p>
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
                var headers = document.querySelectorAll(".table-display table th:not(:last-child)");
                var headerRow = Array.from(headers).map(header => header.textContent.trim());
                csvContent += headerRow.join(",") + "\n";
                var rows = document.querySelectorAll(".table-display table tbody tr");
                rows.forEach(function(row) {
                    var rowData = Array.from(row.querySelectorAll("td:not(:last-child)")).map(cell => cell.textContent.trim());
                    csvContent += rowData.join(",") + "\n";
                });
                var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                var url = URL.createObjectURL(blob);
                var a = document.createElement("a");
                a.href = url;
                a.download = "users_data.csv";
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            });

            // Function to display bar chart of users joined by month
            const labels = <?php echo json_encode($labels); ?>;
            const data = <?php echo json_encode($data); ?>;

            const ctx = document.getElementById('usersByMonthChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Users Joined',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            // JavaScript to handle view button clicks
            document.querySelectorAll('.viewBtn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var userId = this.getAttribute('data-id');
                    var firstName = this.getAttribute('data-name');
                    var email = this.getAttribute('data-email');
                    var date = this.getAttribute('data-date');
                    var role = this.getAttribute('data-role');
                    var listings = this.getAttribute('data-listings');

                    document.getElementById('modalUserId').textContent = userId;
                    document.getElementById('modalFirstName').textContent = firstName;
                    document.getElementById('modalEmail').textContent = email;
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


