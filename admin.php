<?php
session_start();
require_once 'connection.php';
if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 1)){
    header("Location: login.html");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/admin.css">

</head>

<body>
    <header>
        <a href="index.php" class="logo">
            <img src="./images/declutterLogo.png" class="icon">
        </a>
        <b><span>Declutter</span> Ke</b>
        <div class="profile">

            <span class="notification">4</span>
            <div class="user">
                <p><?php echo $_SESSION['name']; ?></p>
                <img src="./images/user.png" class="user-icon">
            <a href="logout.php"><i class="icon fa-solid fa-right-to-bracket "></i> Logout</a>
        </div>
        <div class="menu-toggle">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </header>
    <div class="container">
        <div class="side-bar">
            <nav>
                <ul>
                    <li><a class="nav-item active">Dashboard</a>
                    <li><a class="nav-item" href="users.php">Users</a>
                    <li><a class="nav-item">Listings</a>
                    <li><a class="nav-item">Stats</a>
                    <li><a class="nav-item" href="logout.php">Logout</a>
                </ul>
               
                <div class="tools">
                    <h4>Tools & Components</h4>
                    <ul>
                        <li><a href="#">Settings</a></li>

                    </ul>
                </div>
            </nav>
        </div>
        <div class="main-content">
            <section class="analytics">
                <h2>Analytics Dashboard</h2>
                <p>Sales: 2,382 (-3.65% Since last week)</p>
                <p>Earnings: $21.300 (6.65% Since last week)</p>
                <p>Visitors: 14,212 (5.25% Since last week)</p>
                <p>Orders: 64 (-2.25% Since last week)</p>
                <p>Recent Movement: Chart goes here</p>
            </section>
            <section class="calendar">
                <h2>Calendar</h2>
                <div id="miniCalendar"></div>
            </section>
            <div class="widget-container">
                <div class="widget-row">
                    <div class="widget">
                        <h2>Total Listings</h2>
                        <p>500</p>
                    </div>
                    <!-- Widget 2: Active Users -->
                    <div class="widget">
                        <h2>Active Users</h2>
                        <p>1000</p>
                    </div>
                    <!-- Widget 3: Reported Items -->
                    <div class="widget">
                        <h2>Reported Items</h2>
                        <p>20</p>
                    </div>
                </div>
                <div class="widget-row">
                    <!-- Widget 4: Pending Approvals -->
                    <div class="widget">
                        <h2>Pending Approvals</h2>
                        <p>5</p>
                    </div>
                    <!-- Widget 5: User Feedback -->
                    <div class="widget">
                        <h2>User Feedback</h2>
                        <p>4.2/5</p>
                    </div>
                    <!-- Widget 6: Messages -->
                    <div class="widget">
                        <h2>Messages</h2>
                        <p>10 unread</p>
                    </div>
                </div>
            </div>
            <div class="widget chart-container">
                <canvas id="monthlySalesChart"></canvas>
            </div>
            <div class="widget chart-container">
                <canvas id="websiteTrafficChart"></canvas>
            </div>
            <div class="widget chart-container">
                <canvas id="browserUsageChart"></canvas>
            </div>

            <section class="browser-usage">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Listing Date</th>
                            <th>Status</th>
                            <th>Seller</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Listing Alpha</td>
                            <td>01/01/2021</td>

                            <td class="on-sale">On Sale</td>
                            <td>John Doe</td>
                        </tr>
                        <tr>
                            <td>Listing Beta</td>
                            <td>01/01/2021</td>

                            <td class="in-progress">In Progress</td>
                            <td>Jane Doe</td>
                        </tr>
                        <tr>
                            <td>Listing Gamma</td>
                            <td>01/01/2021</td>

                            <td class="sold">Sold</td>
                            <td>John Smith</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </section>

        </div>
    </div>
    <script src="admin.js"></script>
    <script>
        // Data for the monthly sales chart
        const monthlySalesData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Monthly Sales',
                data: [50, 60, 70, 65, 80, 75, 70, 85, 90, 80, 75, 85],
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Bar fill color
                borderColor: 'rgba(54, 162, 235, 1)', // Bar border color
                borderWidth: 1
            }]
        };

        // Configuration options for the monthly sales chart
        const monthlySalesChartOptions = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };

        // Get the canvas element for the monthly sales chart
        const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');

        // Create the monthly sales chart
        const monthlySalesChart = new Chart(monthlySalesCtx, {
            type: 'bar',
            data: monthlySalesData,
            options: monthlySalesChartOptions
        });

        // Data for the website traffic chart
        const websiteTrafficData = {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Website Traffic',
                data: [120, 180, 200, 150, 220, 280, 230],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        };

        // Configuration options for the website traffic chart
        const websiteTrafficChartOptions = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };

        // Get the canvas element for the website traffic chart
        const websiteTrafficCtx = document.getElementById('websiteTrafficChart').getContext('2d');

        // Create the website traffic chart
        const websiteTrafficChart = new Chart(websiteTrafficCtx, {
            type: 'line',
            data: websiteTrafficData,
            options: websiteTrafficChartOptions
        });

        // Data for the browser usage chart
        const browserUsageData = {
            labels: ['Chrome', 'Firefox', 'Safari', 'Edge', 'IE'],
            datasets: [{
                label: 'Browser Usage',
                data: [60, 20, 10, 5, 5],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Configuration options for the browser usage chart
        const browserUsageChartOptions = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };

        // Get the canvas element for the browser usage chart
        const browserUsageCtx = document.getElementById('browserUsageChart').getContext('2d');

        // Create the browser usage chart
        const browserUsageChart = new Chart(browserUsageCtx, {
            type: 'pie',
            data: browserUsageData,
            options: browserUsageChartOptions
        });
    </script>

</body>

</html>