<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="./css/admin.css">
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

        <?php if ($message) : ?>
            <div class="alert <?php echo $messageClass; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Add Category -->
        <h2>Add Category</h2>
        <form method="POST" action="">
            <input type="text" name="category_name" placeholder="Category Name" required>
            <button type="submit">Add</button>
        </form>
        <!-- Add a button to trigger the download -->
        <button id="downloadCSVButton"> <i class="fa-solid fa-download"></i> Download</button>

        <script>
            document.getElementById('downloadCSVButton').addEventListener('click', function() {
                // Define the CSV content
                var csvContent = "";

                // Add table headers, excluding the last column
                var headers = document.querySelectorAll(".table-display table th:not(:last-child)");
                var headerRow = Array.from(headers).map(header => header.textContent.trim());
                csvContent += headerRow.join(",") + "\n";

                // Add table rows, excluding the last column
                var rows = document.querySelectorAll(".table-display table tbody tr");
                rows.forEach(function(row) {
                    var rowData = Array.from(row.querySelectorAll("td:not(:last-child)")).map(cell => cell.textContent.trim());
                    csvContent += rowData.join(",") + "\n";
                });

                // Create a Blob containing the CSV data
                var blob = new Blob([csvContent], {
                    type: 'text/csv;charset=utf-8;'
                });

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
                            echo " <a data-id='".$row['category_id']."' class='cta delete deleteBtn'>Delete</a></td></td>";
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
                                echo " <a data-id='".$row['category_id']."' class='cta delete deleteBtn'>Delete</a></td>";
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
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this Category?</p>
            <button id="confirmDeleteButton" class="btn-confirm">Confirm</button>
            <button class="btn-cancel close">Cancel</button>
        </div>
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
        window.onclick = function(event) {
            var modal = document.getElementById("editCategoryModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
        // JavaScript to handle delete button clicks
document.querySelectorAll('.deleteBtn').forEach(function(button) {
    button.addEventListener('click', function() {
        var listing_id = this.getAttribute('data-id');
        document.getElementById('confirmDeleteButton').setAttribute('data-id', listing_id);
        document.getElementById('deleteModal').style.display = "block";
    });
});

// JavaScript to handle confirm delete button click
document.getElementById('confirmDeleteButton').addEventListener('click', function() {
    var category_id = this.getAttribute('data-id');
    window.location.href = `categories.php?id=${category_id}`;
});
//
// Close the delete modal when the user clicks on the close button
function closeModal() {
    document.getElementById('deleteModal').style.display = "none";
}
document.querySelectorAll('.close').forEach(function(button) {
    button.addEventListener('click', closeModal);
});
// JavaScript to handle close button click
document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('deleteModal').style.display = "none";
});
    </script>
</body>

</html>