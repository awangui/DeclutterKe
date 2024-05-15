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

        .btn-confirm,
        .btn-cancel {
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

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }

        .alert-error {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
    </style>
</head>

<body>
    <?php

    require_once 'navbar.php';

    $message = '';
    $messageClass = '';

    // Check if the 'id' parameter is set in the URL
    if (isset($_GET['id'])) {
        $category_id = $_GET['id'];

        // Delete category from the database
        $sql = "DELETE FROM categories WHERE category_id = '$category_id'";
        if ($con->query($sql) === TRUE) {
            $message = "Category deleted successfully.";
            $messageClass = "alert-success";
        } else {
            $message = "Error deleting category: " . $con->error;
            $messageClass = "alert-error";
        }
    }

    // Get category with the most listings
    $sql = "SELECT category_name, COUNT(listing_id) as total_listings FROM categories JOIN listings ON categories.category_id = listings.category_id GROUP BY category_name ORDER BY total_listings DESC LIMIT 1";
    $result = $con->query($sql);
    $most_listings = $result->fetch_assoc();

    // Get the top 3 categories with the most listings
    $sql = "SELECT category_name, COUNT(listing_id) as total_listings FROM categories JOIN listings ON categories.category_id = listings.category_id GROUP BY category_name ORDER BY total_listings DESC LIMIT 3";
    $result = $con->query($sql);
    $top_categories = $result->fetch_all(MYSQLI_ASSOC);

    // Get category chart data
    $sql = "SELECT category_name, COUNT(listing_id) as total_listings FROM categories JOIN listings ON categories.category_id = listings.category_id GROUP BY category_name ORDER BY total_listings DESC";
    $result = $con->query($sql);
    $chart_labels = [];
    $chart_values = [];
    while ($row = $result->fetch_assoc()) {
        $chart_labels[] = $row['category_name'];
        $chart_values[] = $row['total_listings'];
    }

    // Process search query
    $search_results = [];
    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $search_category = $_GET['category'];
        // Search for categories containing the search term
        $sql_search = "SELECT * FROM categories WHERE category_name LIKE '%$search_category%'";
        $result_search = $con->query($sql_search);
        if ($result_search->num_rows > 0) {
            // Display search results
            $search_results = $result_search->fetch_all(MYSQLI_ASSOC);
        }
    }

    // Process add/edit category form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
            // Editing an existing category
            $category_id = $_POST['category_id'];
            $category_name = $_POST['category_name'];

            // Update category in the database
            $sql_update_category = "UPDATE categories SET category_name = '$category_name' WHERE category_id = '$category_id'";
            if ($con->query($sql_update_category) === TRUE) {
                $message = "Category updated successfully.";
                $messageClass = "alert-success";
            } else {
                $message = "Error updating category: " . $con->error;
                $messageClass = "alert-error";
            }
        } else {
            // Adding a new category
            $category_name = $_POST['category_name'];

            // Check if the category already exists
            $sql_check_duplicate = "SELECT * FROM categories WHERE category_name = '$category_name'";
            $result_check_duplicate = $con->query($sql_check_duplicate);
            if ($result_check_duplicate->num_rows > 0) {
                $message = "Category already exists.";
                $messageClass = "alert-error";
            } else {
                // Insert new category into the database
                $sql_insert_category = "INSERT INTO categories (category_name) VALUES ('$category_name')";
                if ($con->query($sql_insert_category) === TRUE) {
                    $message = "Category added successfully.";
                    $messageClass = "alert-success";
                } else {
                    $message = "Error adding category: " . $con->error;
                    $messageClass = "alert-error";
                }
            }
        }
    }
    ?>

    <div class="main-content" style="display: block;">
        <h1>Categories</h1>

        <?php if ($message): ?>
            <div class="alert <?php echo $messageClass; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="header">
            <div class="widget">
                <h3>Number of listings per category</h3>
                <canvas id="categoryChart"></canvas>
            </div>
            <div class="widget">
                <!-- most popular category -->
                <h2>Most popular Category</h2>
                <p><?php echo $most_listings['category_name']; ?></p>
            </div>
            <!-- top 3 categories -->
            <div class="widget">
                <h2>Top 3 Categories</h2>
                <ul>
                    <?php foreach ($top_categories as $category) { ?>
                        <li><?php echo $category['category_name']; ?> - <?php echo $category['total_listings']; ?> listings</li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!-- Add Category -->
        <h2>Add Category</h2>
        <form method="POST" action="">
            <input type="text" name="category_name" placeholder="Category Name" required>
            <button type="submit">Add</button>
        </form>
        <!-- Add a button to trigger the download -->
        <button id="downloadCSVButton"> <i class="fa-solid fa-download"></i> Download</button>

        <script>
            document.getElementById('downloadCSVButton').addEventListener('click', function () {
                // Define the CSV content
                var csvContent = "";

                // Add table headers, excluding the last column
                var headers = document.querySelectorAll(".table-display table th:not(:last-child)");
                var headerRow = Array.from(headers).map(header => header.textContent.trim());
                csvContent += headerRow.join(",") + "\n";

                // Add table rows, excluding the last column
                var rows = document.querySelectorAll(".table-display table tbody tr");
                rows.forEach(function (row) {
                    var rowData = Array.from(row.querySelectorAll("td:not(:last-child)")).map(cell => cell.textContent.trim());
                    csvContent += rowData.join(",") + "\n";
                });

                // Create a Blob containing the CSV data
                var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });

                // Create a temporary URL for the Blob
                var url = URL.createObjectURL(blob);

                // Create a temporary anchor element to trigger the download
                var a = document.createElement("a");
                a.href = url;
                a.download = "categories_data.csv";

                // Programmatically trigger a click event on the anchor element to initiate the download
                document.body.appendChild(a);
                a.click();

                // Cleanup
                document.body.removeChild(a);
            });
        </script>

        <!-- Search Category -->
        <h2>Search Category</h2>
        <form method="GET" action="">
            <input type="text" name="category" placeholder="Search Category" required>
            <button type="submit">Search</button>
            <button type="button" onclick="resetForm()">Reset</button>
        </form>
        <section class='table-display'>
            <!-- Edit Category Modal -->
            <div id="editCategoryModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit Category</h2>
                    <form id="editCategoryForm" method="POST" action="">
                        <input type="hidden" id="categoryId" name="category_id">
                        <input type="text" id="categoryName" name="category_name" placeholder="Category Name">
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display search results or all categories
                    if (isset($search_results) && !empty($search_results)) {
                        foreach ($search_results as $row) {
                            echo "<tr>";
                            echo "<td>" . $row["category_id"] . "</td><td>" . $row["category_name"] . "</td>";
                            echo "<td><a href='#' onclick='openEditModal(" . $row['category_id'] . ", \"" . $row['category_name'] . "\")' class='btn' >Edit</a> ";
                            echo " <a href='categories.php?id=" . $row['category_id'] . "' onclick='return confirm(\"Are you sure you want to delete this category?\")' class='btn delete btn-danger'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        // Display all categories
                        $sql = "SELECT c.category_id, c.category_name, COUNT(l.listing_id) as total_listings 
                        FROM categories c 
                        LEFT JOIN listings l ON c.category_id = l.category_id 
                        GROUP BY c.category_id, c.category_name 
                        ORDER BY total_listings DESC";
                        $result = $con->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["category_id"] . "</td><td>" . $row["category_name"] . "</td>";
                                echo "<td><a href='#' onclick='openEditModal(" . $row['category_id'] . ", \"" . $row['category_name'] . "\")' class='btn' >Edit</a> ";
                                echo " <a href='categories.php?id=" . $row['category_id'] . "' onclick='return confirm(\"Are you sure you want to delete this category?\")' class='btn delete btn-danger'>Delete</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No categories found.</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

    <script>
        // Function to reset the form fields
        function resetForm() {
            // Redirect back to the categories page to reset the search
            window.location.href = "categories.php";
        }

        // Function to open the edit category modal
        function openEditModal(categoryId, categoryName) {
            var modal = document.getElementById("editCategoryModal");
            var categoryIdField = document.getElementById("categoryId");
            var categoryNameField = document.getElementById("categoryName");

            // Populate form fields with category details
            categoryIdField.value = categoryId;
            categoryNameField.value = categoryName;

            // Open the modal
            modal.style.display = "block";
        }

        // Function to close the modal
        function closeModal() {
            var modal = document.getElementById("editCategoryModal");
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            var modal = document.getElementById("editCategoryModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    </script>

    <script>
        var ctx = document.getElementById('categoryChart').getContext('2d');
        var categoryChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($chart_labels); ?>,
                datasets: [{
                    label: 'Number of Listings',
                    data: <?php echo json_encode($chart_values); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>

</body>

</html>
