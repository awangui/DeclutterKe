<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listings Management</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php
    require_once 'navbar.php';

    $message = '';
    $messageClass = '';

    // Check if the 'id' parameter is set in the URL
    if (isset($_GET['id'])) {
        $listing_id = $_GET['id'];

        // Delete listing from the database
        $sql = "DELETE FROM listings WHERE listing_id = '$listing_id'";
        if ($con->query($sql) === TRUE) {
            $message = "Listing deleted successfully.";
            $messageClass = "alert-success";
        } else {
            $message = "Error deleting listing: " . $con->error;
            $messageClass = "alert-error";
        }
    }

    // Get listing categories
    $sql_categories = "SELECT category_id, category_name FROM categories";
    $result_categories = $con->query($sql_categories);
    $categories = [];
    if ($result_categories->num_rows > 0) {
        while ($row = $result_categories->fetch_assoc()) {
            $categories[$row['category_id']] = $row['category_name'];
        }
    }

    // Get listings count by category
    $sql_listings_count = "SELECT category_id, COUNT(listing_id) AS total_listings FROM listings GROUP BY category_id";
    $result_listings_count = $con->query($sql_listings_count);
    $listings_count = [];
    if ($result_listings_count->num_rows > 0) {
        while ($row = $result_listings_count->fetch_assoc()) {
            $listings_count[$row['category_id']] = $row['total_listings'];
        }
    }
    ?>

    <div class="main-content" style="display: block;">
        <h1>Listings Management</h1>

        <?php if ($message): ?>
            <div class="alert <?php echo $messageClass; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Add a button to trigger the download -->
        <button id="downloadCSVButton"><i class="fa-solid fa-download"></i> Download</button>
        <style>
            .table-display th {
                background-color: #ffa500;
            }
        </style>
        <!-- Listings Table -->
        <section class='table-display'>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Color</th>
                        <th>Years Used</th>
                        <th>Condition</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Photos</th>
                        <th>Phone Number</th>
                        <th>City</th>
                        <th>Town</th>
                        <th>Date Posted</th>
                        <th>Seller ID</th>
                        <th>Brand ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_listings = "SELECT * FROM listings";
                    $result_listings = $con->query($sql_listings);
                    if ($result_listings->num_rows > 0) {
                        while ($row = $result_listings->fetch_assoc()) {
                            $id = $row['listing_id'];
                            echo "<tr>";
                            echo "<td>" . $row["listing_id"] . "</td><td>" . $row["name"] . "</td><td>" . $categories[$row["category_id"]] . "</td>";
                            echo "<td>" . $row["color"] . "</td>";
                            echo "<td>" . $row["years_used"] . "</td>";
                            echo "<td>" . $row["condition"] . "</td>";
                            echo "<td>" . $row["price"] . "</td>";
                            echo "<td>" . $row["description"] . "</td>";
                            // Concatenate photos into one cell
                            $photos = explode(",", $row["photos"]);
                            echo "<td>" . implode(", ", $photos) . "</td>";
                            echo "<td>" . $row["phone_number"] . "</td>";
                            echo "<td>" . $row["city"] . "</td>";
                            echo "<td>" . $row["town"] . "</td>";
                            echo "<td>" . $row["date_posted"] . "</td>";
                            echo "<td>" . $row["seller_id"] . "</td>";
                            echo "<td>" . $row["brand_id"] . "</td>";
                            echo "<td><a href='#' onclick='openEditModal(" . $row['listing_id'] . ", \"" . $row['name'] . "\", \"" . $row['category_id'] . "\")' class='btn'>Edit</a> ";
                            echo "<a href='#' data-id='$id' class='btn deleteBtn btn-danger'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='16'>No listings found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <!-- Edit Listing Modal -->
        <div id="editListingModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="closeModal('editListingModal')">&times;</span>
                <h2>Edit Listing</h2>
                <form action="edit_listing.php" method="post">
                    <input type="hidden" id="listingId" name="listing_id">
                    <label for="listingName">Name:</label>
                    <input type="text" id="listingName" name="name" required>
                    <label for="listingCategory">Category:</label>
                    <select id="listingCategory" name="category_id">
                        <?php
                        foreach ($categories as $id => $name) {
                            echo "<option value='$id'>$name</option>";
                        }
                        ?>
                    </select>
                    <button type="submit">Save</button>
                </form>
            </div>
        </div>
        <!-- Delete Confirmation Modal -->
        <div id="deleteConfirmationModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="closeModal('deleteConfirmationModal')">&times;</span>
                <h2>Delete Listing</h2>
                <p>Are you sure you want to delete this listing?</p>
                <button id="confirmDeleteButton">Delete</button>
            </div>
        </div>
        <script>
            // CSV download functionality
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
                    var rowData = [];
                    // Iterate through each cell in the row, excluding the last cell
                    Array.from(row.querySelectorAll("td:not(:last-child)")).forEach(function (cell, index) {
                        // If it's the Photos column, concatenate the photo names
                        if (index === 8) {
                            var photos = cell.textContent.trim().split(", "); // Split photos into array
                            rowData.push('"' + photos.join(", ") + '"'); // Join photos and wrap in quotes
                        } else {
                            rowData.push(cell.textContent.trim());
                        }
                    });
                    csvContent += rowData.join(",") + "\n";
                });

                // Create a Blob containing the CSV data
                var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });

                // Create a temporary URL for the Blob
                var url = URL.createObjectURL(blob);

                // Create a temporary anchor element to trigger the download
                var a = document.createElement("a");
                a.href = url;
                a.download = "listings_data.csv";

                // Programmatically trigger a click event on the anchor element to initiate the download
                document.body.appendChild(a);
                a.click();

                // Cleanup
                document.body.removeChild(a);
            });

            // Function to reset the form fields
            function resetForm() {
                // Redirect back to the listings page to reset the search
                window.location.href = "listings.php";
            }

            // Function to open the edit listing modal
            function openEditModal(listingId, listingName, categoryId) {
                var modal = document.getElementById("editListingModal");
                var listingIdField = document.getElementById("listingId");
                var listingNameField = document.getElementById("listingName");
                var listingCategoryField = document.getElementById("listingCategory");

                // Populate form fields with listing details
                listingIdField.value = listingId;
                listingNameField.value = listingName;
                listingCategoryField.value = categoryId;

// Open the modal
modal.style.display = "block";
}

// Function to close the modal
function closeModal(modalId) {
var modal = document.getElementById(modalId);
modal.style.display = "none";
}

// JavaScript to handle delete button clicks
document.querySelectorAll('.deleteBtn').forEach(function (button) {
button.addEventListener('click', function () {
    var listingId = this.getAttribute('data-id');
    document.getElementById('confirmDeleteButton').setAttribute('data-id', listingId);
    document.getElementById('deleteConfirmationModal').style.display = "block";
});
});

// JavaScript to handle confirm delete button click
document.getElementById('confirmDeleteButton').addEventListener('click', function () {
var listingId = this.getAttribute('data-id');
window.location.href = `listings.php?id=${listingId}`;
});

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
var editModal = document.getElementById("editListingModal");
var deleteModal = document.getElementById("deleteConfirmationModal");
if (event.target == editModal) {
    editModal.style.display = "none";
}
if (event.target == deleteModal) {
    deleteModal.style.display = "none";
}
};
</script>
</div>
</body>

</html>
