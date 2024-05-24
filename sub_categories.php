<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subcategory Management</title>
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
        $sub_category_id = $_GET['id'];
        // Delete subcategory
        $sqlDeleteSubCategory = "DELETE FROM subcategories WHERE sub_category_id = $sub_category_id";
        $resultDeleteSubCategory = mysqli_query($con, $sqlDeleteSubCategory);

        if (!$resultDeleteSubCategory) {
            $message = 'Error deleting subcategory';
            $messageClass = 'alert-error';
        } else {
            $message = 'Subcategory deleted successfully';
            $messageClass = 'alert-success';
        }
    }

    // Pagination setup
    $subcategoriesPerPage = 10; // Number of subcategories per page
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
    $offset = ($currentPage - 1) * $subcategoriesPerPage;

    // Process search query
    $search_results = [];
    $isSearch = false;
    if (isset($_GET['sub_category']) && !empty($_GET['sub_category'])) {
        $isSearch = true;
        $search_sub_category = $_GET['sub_category'];
        // Search for subcategories containing the search term
        $sql_search = "SELECT * FROM subcategories WHERE sub_category_name LIKE '%$search_sub_category%' LIMIT $offset, $subcategoriesPerPage";
        $result_search = mysqli_query($con, $sql_search);
        if ($result_search) {
            $search_results = mysqli_fetch_all($result_search, MYSQLI_ASSOC);
        }
        // Total number of search results
        $sql_search_count = "SELECT COUNT(*) AS count FROM subcategories WHERE sub_category_name LIKE '%$search_sub_category%'";
        $result_search_count = mysqli_query($con, $sql_search_count);
        $totalSubcategories = mysqli_fetch_assoc($result_search_count)['count'];
    } else {
        // Get subcategories for the current page
        $sqlGetSubCategories = "SELECT * FROM subcategories LIMIT $offset, $subcategoriesPerPage";
        $resultGetSubCategories = mysqli_query($con, $sqlGetSubCategories);
    }
// Get total number of subcategories
$sql_count = "SELECT COUNT(*) AS count FROM subcategories";
$result_count = mysqli_query($con, $sql_count);
$totalSubcategories = mysqli_fetch_assoc($result_count)['count'];
    // Calculate total pages
    $totalPages = ceil($totalSubcategories / $subcategoriesPerPage);
    
    // Process search query
    $search_results = [];
    $isSearch = false;
    if (isset($_GET['sub_category']) && !empty($_GET['sub_category'])) {
        $isSearch = true;
        $search_sub_category = $_GET['sub_category'];
        // Search for subcategories containing the search term
        $sql_search = "SELECT * FROM subcategories WHERE sub_category_name LIKE '%$search_sub_category%' LIMIT $offset, $subcategoriesPerPage";
        $result_search = mysqli_query($con, $sql_search);
        if ($result_search) {
            $search_results = mysqli_fetch_all($result_search, MYSQLI_ASSOC);
        }
        // Total number of search results
        $sql_search_count = "SELECT COUNT(*) AS count FROM subcategories WHERE sub_category_name LIKE '%$search_sub_category%'";
        $result_search_count = mysqli_query($con, $sql_search_count);
        $totalSubcategories = mysqli_fetch_assoc($result_search_count)['count'];
    } else {
        // Get total number of subcategories
        $sql_count = "SELECT COUNT(*) AS count FROM subcategories";
        $result_count = mysqli_query($con, $sql_count);
        $totalSubcategories = mysqli_fetch_assoc($result_count)['count'];

        // Get subcategories for the current page
        $sqlGetSubCategories = "SELECT * FROM subcategories LIMIT $offset, $subcategoriesPerPage";
        $resultGetSubCategories = mysqli_query($con, $sqlGetSubCategories);
    }
// Process add/edit subcategory form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sub_category_name = trim($_POST['sub_category_name']); // Trim whitespace from the beginning and end of the subcategory name

    if (empty($sub_category_name)) {
        $message = 'Subcategory name cannot be empty';
        $messageClass = 'alert-error';
    } else {
        if (isset($_POST['sub_category_id']) && !empty($_POST['sub_category_id'])) {
            // Edit subcategory
            $sub_category_id = $_POST['sub_category_id'];

            $sqlEditSubCategory = "UPDATE subcategories SET sub_category_name = '$sub_category_name' WHERE sub_category_id = $sub_category_id";
            $resultEditSubCategory = mysqli_query($con, $sqlEditSubCategory);

            if (!$resultEditSubCategory) {
                $message = 'Error editing subcategory';
                $messageClass = 'alert-error';
            } else {
                $message = 'Subcategory edited successfully';
                $messageClass = 'alert-success';
            }
        } else {
            // Add subcategory
            // Check if subcategory already exists
            $sqlCheckSubCategory = "SELECT * FROM subcategories WHERE sub_category_name = '$sub_category_name'";
            $resultCheckSubCategory = mysqli_query($con, $sqlCheckSubCategory);

            if (mysqli_num_rows($resultCheckSubCategory) > 0) {
                $message = 'Subcategory already exists';
                $messageClass = 'alert-error';
            } else {
                $sqlAddSubCategory = "INSERT INTO subcategories (sub_category_name) VALUES ('$sub_category_name')";
                $resultAddSubCategory = mysqli_query($con, $sqlAddSubCategory);

                if (!$resultAddSubCategory) {
                    $message = 'Error adding subcategory';
                    $messageClass = 'alert-error';
                } else {
                    $message = 'Subcategory added successfully';
                    $messageClass = 'alert-success';
                }
            }
        }
    }
}

    ?>

    <div class="main-content" style="display: block;">
        <h1>Subcategories</h1>

        <?php if ($message) : ?>
            <div class="alert <?php echo $messageClass; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Add Subcategory -->
        <h2>Add Subcategory</h2>
        <form method="POST" action="">
            <label for="sub_category_name">Subcategory Name</label>
            <input type="text" name="sub_category_name" id="sub_category_name" required>
            <button type="submit">Add</button>
        </form>

        <!-- Add a button to trigger the download -->
        <button id="downloadCSVButton"> <i class="fa-solid fa-download"></i> Download</button>

          <!-- Search Subcategory -->
          <h2>Search Subcategory</h2>
        <form method="GET" action="">
            <input type="text" name="sub_category" placeholder="Search Subcategory" required>
            <button type="submit">Search</button>
            <button type="button" onclick="resetForm()">Reset</button>
        </form>

        <section class="table-display">
            <!-- Edit Subcategory Modal -->
            <div id="editSubCategoryModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit Subcategory</h2>
                    <form id="editSubCategoryForm" method="POST" action="">
                        <input type="hidden" id="subCategoryId" name="sub_category_id">
                        <input type="text" id="subCategoryName" name="sub_category_name" placeholder="Subcategory Name">
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
                    // Display search results or all subcategories
                    if ($isSearch) {
                        $subcategories = $search_results;
                    } else {
                        $subcategories = [];
                        while ($row = mysqli_fetch_assoc($resultGetSubCategories)) {
                            $subcategories[] = $row;
                        }
                    }

                    if (!empty($subcategories)) {
                        foreach ($subcategories as $row) {
                            echo "<tr>";
                            echo "<td>" . $row["sub_category_id"] . "</td><td>" . $row["sub_category_name"] . "</td>";
                            echo "<td><a href='#' onclick='openEditModal(" . $row['sub_category_id'] . ", \"" . $row['sub_category_name'] . "\")' class='btn' >Edit</a> ";
                            echo " <a data-id='".$row['sub_category_id']."' class='cta delete deleteBtn'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No subcategories found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <!-- Pagination Controls -->
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="?page=<?php echo $currentPage - 1; ?>&sub_category=<?php echo isset($_GET['sub_category']) ? $_GET['sub_category'] : ''; ?>">&laquo; Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&sub_category=<?php echo isset($_GET['sub_category']) ? $_GET['sub_category'] : ''; ?>" class="<?php if ($i == $currentPage) echo 'active'; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="?page=<?php echo $currentPage + 1; ?>&sub_category=<?php echo isset($_GET['sub_category']) ? $_GET['sub_category'] : ''; ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this Subcategory?</p>
            <button id="confirmDeleteButton" class="btn-confirm">Confirm</button>
            <button class="btn-cancel close">Cancel</button>
        </div>
    </div>

    <script>
        // Function to reset the form fields
        function resetForm() {
            // Redirect back to the subcategories page to reset the search
            window.location.href = "sub_categories.php";
        }

        // Function to open the edit subcategory modal
        function openEditModal(subCategoryId, subCategoryName) {
            var modal = document.getElementById("editSubCategoryModal");
            var subCategoryIdField = document.getElementById("subCategoryId");
            var subCategoryNameField = document.getElementById("subCategoryName");

            // Populate form fields with subcategory details
            subCategoryIdField.value = subCategoryId;
            subCategoryNameField.value = subCategoryName;

            // Open the modal
            modal.style.display = "block";
        }

        // Function to close the modal
        function closeModal() {
            var modal = document.getElementById("editSubCategoryModal");
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            var modal = document.getElementById("editSubCategoryModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        // JavaScript to handle delete modal
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', function() {
                var subCategoryId = this.getAttribute('data-id');
                var deleteModal = document.getElementById("deleteModal");
                deleteModal.style.display = "block";

                document.getElementById('confirmDeleteButton').onclick = function() {
                    window.location.href = "sub_categories.php?id=" + subCategoryId;
                };
            });
        });

        document.querySelectorAll('.close').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById("deleteModal").style.display = "none";
            });
        });

        // CSV download functionality
        document.getElementById("downloadCSVButton").addEventListener("click", function() {
            window.location.href = "download_sub_categories.php";
        });
    </script>
</body>

</html>
