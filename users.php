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
                        <div class="card-header">
                          
                        </div>
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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>First Name</th>
                                        <th>Email</th>
                                        <th>Date Joined</th>
                                        <th>Role</th>
<?php
                                    if ($selectedRole === '2') {
                                        echo"<th>Total Listings</th>";
                                        echo"<th>Actions</th>";
                                    }
                                    ?>

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
                                        <?php
                                        if ($row['role'] == 2) {
                                            echo "<td>" . $row['totalListings'] . "</td>";
                                            echo "<td><a href='seller.php?userId={$row['UserId']}'>View</a></td>";
                                        }
                                        if ($row['role'] == 1) {
                                            echo "<td><a href='admin.php?userId={$row['UserId']}'>View</a></td>";
                                        }
                                        if ($row['role'] == 3) {
                                            echo "<td><a href='normal.php?userId={$row['UserId']}'>View</a></td>";
                                        }
                                        
                                        $id = $row['UserId'];
                                        if ($row['role'] != 1) { 
                                            echo "<td><a href='delete.php?deleteid=$id' class='btn btn-danger'>Delete</a></td>";
                                        }
                                        ?>

                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                            <style>
                                .display {
                                    text-align: center;
                                    margin-bottom: 20px;
                                }
                                .table {
                                    width: 100%;
                                    border-collapse: collapse;
                                }
                                .table th, .table td {
                                    border: 1px solid #ddd;
                                    padding: 8px;
                                    text-align: left;
                                }

                                .table tr:nth-child(even) {
                                    background-color: #f2f2f2;
                                }
                                .table tr:hover {
                                    background-color: #f1f1f1;
                                }
                                .table th {
                                    padding-top: 12px;
                                    padding-bottom: 12px;
                                    text-align: left;
                                    color: white;
                                }
                                .table td {
                                    padding-top: 12px;
                                    padding-bottom: 12px;
                                    text-align: left;
                                }
                                .btn {
                                    background-color: #f44336;
                                    color: white;
                                    padding: 10px 15px;
                                    border: none;
                                    cursor: pointer;
                                    border-radius: 5px;
                                    text-align: center;
                                    display: inline-block;
                                    text-decoration: none;
                                }
                                .btn:hover {
                                    background-color: #f44336;
                                }
                            </style>
                        </div>
                    </div>
                </div>
            </div>

    <script>
        //function to display bar chart of users joined by month
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
    </script>
</body>

</html>
