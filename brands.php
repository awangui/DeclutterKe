<?php
require_once 'navbar.php';

// Check if the 'id' parameter is set in the URL
if(isset($_GET['id'])) {
    $brand_id = $_GET['id'];

    // Delete brand from the database
    $sql = "DELETE FROM brands WHERE brand_id = '$brand_id'";
    if ($con->query($sql) === TRUE) {
        // Redirect back to brands.php after successful deletion
        header("Location: brands.php");
        exit();
    } else {
        // Handle deletion error
        echo "Error deleting brand: " . $con->error;
    }
}



// Process search query
$search_results = [];
if(isset($_GET['brand']) && !empty($_GET['brand'])) {
    $search_brand = $_GET['brand'];
    // Search for brands containing the search term
    $sql_search="SELECT brands.*, COUNT(listings.brand_id) as total_listings FROM brands LEFT JOIN listings ON brands.brand_id = listings.brand_id WHERE brand_name LIKE '%$search_brand%' GROUP BY brands.brand_id";
    $result_search = $con->query($sql_search);
    if ($result_search->num_rows > 0) {
        // Display search results
        $search_results = $result_search->fetch_all(MYSQLI_ASSOC);
    }
}

// Process add/edit brand form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['brand_id']) && !empty($_POST['brand_id'])) {
        // Editing an existing brand
        $brand_id = $_POST['brand_id'];
        $brand_name = $_POST['brand_name'];

        // Update brand in the database
        $sql_update_brand = "UPDATE brands SET brand_name = '$brand_name' WHERE brand_id = '$brand_id'";
        if ($con->query($sql_update_brand) === TRUE) {
            echo "Brand updated successfully.";
        } else {
            echo "Error updating brand: " . $con->error;
        }
    } else {
        // Adding a new brand
        $brand_name = $_POST['brand_name'];
        
        // Check if the brand already exists
        $sql_check_duplicate = "SELECT * FROM brands WHERE brand_name = '$brand_name'";
        $result_check_duplicate = $con->query($sql_check_duplicate);
        if ($result_check_duplicate->num_rows > 0) {
            echo "Brand already exists.";
        } else {
            // Insert new brand into the database
            $sql_insert_brand = "INSERT INTO brands (brand_name) VALUES ('$brand_name')";
            if ($con->query($sql_insert_brand) === TRUE) {
                echo "Brand added successfully.";
            } else {
                echo "Error adding brand: " . $con->error;
            }
        }
    }
}

?>

<div class="main-content" style="display: block;">
    <h1>Brands</h1>

    <!-- Add Brand -->
    <h2>Add Brand</h2>
    <form method="POST" action="">
        <input type="text" name="brand_name" placeholder="Brand Name" required>
        <button type="submit">Add</button>
    </form>

    <!-- Add a button to trigger the download -->
    <button id="downloadCSVButton"> <i class="fa-solid fa-download"></i> Download</button>
        <!-- Search Brand -->
        <h2>Search Brand</h2>
    <form method="GET" action="">
        <input type="text" name="brand" placeholder="Search Brand" required>
        <button type="submit">Search</button>
        <button type="button" onclick="resetForm()">Reset</button>
    </form>
    <section class='table-display'>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Total Listings</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display search results or all brands
                if(isset($search_results) && !empty($search_results)) {
                    foreach ($search_results as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["brand_id"] . "</td><td>" . $row["brand_name"] . "</td><td>" . $row["total_listings"] . "</td>";
                        echo "<td><a onclick='openEditModal(".$row['brand_id'].", \"".$row['brand_name']."\")' class='btn'>Edit</a>  <a href='brands.php?id=".$row['brand_id']."' onclick='return confirm(\"Are you sure you want to delete this brand?\")'class='btn delete btn-danger'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    // Display all brands
                    $sql = "SELECT brands.*, COUNT(listings.brand_id) as total_listings FROM brands LEFT JOIN listings ON brands.brand_id = listings.brand_id GROUP BY brands.brand_id";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["brand_id"] . "</td><td>" . $row["brand_name"] . "</td><td>" . $row["total_listings"] . "</td>";
                            echo "<td><a onclick='openEditModal(".$row['brand_id'].", \"".$row['brand_name']."\")' class='btn '>Edit</a>  <a href='brands.php?id=".$row['brand_id']."' onclick='return confirm(\"Are you sure you want to delete this brand?\")' class='btn delete btn-danger'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No brands found.</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </section>
</div>

<!-- Edit Brand Modal -->
<div id="editBrandModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Edit Brand</h2>
        <form id="editBrandForm" method="POST" action="">
            <input type="hidden" id="brandId" name="brand_id">
            <input type="text" id="brandName" name="brand_name" placeholder="Brand Name">
            <button type="submit">Submit</button>
        </form>
    </div>
</div>

<script>
    // Function to reset the form fields
    function resetForm() {
        // Redirect back to the brands page to reset the search
        window.location.href = "brands.php";
    }

    // Function to open the edit brand modal
    function openEditModal(brandId, brandName) {
        var modal = document.getElementById("editBrandModal");
        var brandIdField = document.getElementById("brandId");
        var brandNameField = document.getElementById("brandName");

        // Populate form fields with brand details
        brandIdField.value = brandId;
        brandNameField.value = brandName;

        // Open the modal
        modal.style.display = "block";
    }

    // Function to close the modal
    function closeModal() {
        var modal = document.getElementById("editBrandModal");
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        var modal = document.getElementById("editBrandModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    // CSV download functionality
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
        var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });

        // Create a temporary URL for the Blob
        var url = URL.createObjectURL(blob);

        // Create a temporary anchor element to trigger the download
        var a = document.createElement("a");
        a.href = url;
        a.download = "brands_data.csv";
        
        // Programmatically trigger a click event on the anchor element to initiate the download
        document.body.appendChild(a);
        a.click();

        // Cleanup
        document.body.removeChild(a);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
</script>
