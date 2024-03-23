<?php
// Include the connection.php file
include 'connection.php';
//check if user is logged in
// if(!isset($_SESSION['userId'])){
//     //redirect to login page
//     header("Location: login.html");
//     exit();
// }
// Check if the form is submitted
if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $category = htmlspecialchars($_POST['category']);
    $sub_category = htmlspecialchars($_POST['sub-category']);
    $brand = htmlspecialchars($_POST['brand']);
    $color = htmlspecialchars($_POST['color']);
    $years_used = intval($_POST['yearsUsed']);
    $condition = htmlspecialchars($_POST['condition']);
    $price = floatval($_POST['price']);
    $description = htmlspecialchars($_POST['description']);
    $phone = floatval($_POST['phone']);
    //file upload
    $file_names = array();
    $file_count = count($_FILES['images']['name']);
    for ($i = 0; $i < $file_count; $i++) {
        $file_name = $_FILES['images']['name'][$i];
        $temp_name = $_FILES['images']['tmp_name'][$i];
        $folder = 'uploads/' . $file_name;
        if (move_uploaded_file($temp_name, $folder)) {
            $file_names[] = $file_name;
        }
    }
    // Insert listing with all photos
    $photos = implode(',', $file_names); // Convert array of file names to a comma-separated string
    $query = "INSERT INTO listings (name, category, sub_category, brand, color, years_used, `condition`, price, description, photos, phone_number) 
              VALUES ('$name', '$category', '$sub_category', '$brand', '$color', $years_used, '$condition', $price, '$description', '$photos', '$phone')";
    if (mysqli_query($con, $query)) {
        echo "<h2>Listing uploaded successfully</h2>";
    } else {
        echo "<h2>Listing failed to upload</h2>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="script.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="listing.css">
    <script src="https://kit.fontawesome.com/661ba5765b.js" crossorigin="anonymous"></script>
    <title>Add Listing</title>
</head>

<body>
    <section id="navigation">
        <div class="navbar">
            <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
            <nav>
                <a href="index.php" class="logo"><b><span>Declutter</span> Ke</b></a>
                <a href="#home">Home</a>
                <a href="#categories">Categories</a>
                <a href="#about">About</a>
                <a href="#contact">Contact</a>
                <a href="listing.html" class="active"><i class=" icon fa fa-plus"></i> Add a Listing</a>
                <a href="login.html" class="credentials"><i class="icon fa-solid fa-right-to-bracket "></i> Login</a>
                <a href="registration.html"><i class="icon fa-regular fa-user"></i> Sign Up</a>

            </nav>
        </div>
    </section>

    <form id="listingForm" method="post" enctype="multipart/form-data">
        <h2>Add a listing</h2>
        <div class="listing-container">
            <div class="details">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="photos">Photos:</label>
                <input type="file" id="photos" name="images[]" multiple accept="image/*" required>


                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="furniture">Furniture</option>
                    <option value="electronics">Electronics</option>
                    <option value="Appliances">Appliances</option>
                    <option value="Kitchenware">Kitchenware</option>
                    <option value="other">Other</option>
                </select>


                <label for="sub-category">Sub-Category:</label>
                <select id="sub-category" name="sub-category" required>
                    <option value="fridges">Fridges</option>
                    <option value="phones">Phones</option>
                    <option value="tables">Tables</option>
                    <option value="phones">Phones</option>
                    <option value="Speakers">Speakers</option>
                    <option value="TVs">TVs</option>
                    <option value="Microwaves">Microwaves</option>
                    <option value="other">Other</option>
                </select>


                <label for="brand">Brand:</label>
                <select id="brand" name="brand" required>
                    <option value="">Select a brand</option>
                    <option value="Samsung">Samsung</option>
                    <option value="LG">LG</option>
                    <option value="Mika">Mika</option>
                    <option value="Hisense">Hisense</option>
                    <option value="Ramtons">Ramtons</option>
                    <option value="Hotpoint">Hotpoint</option>
                    <option value="otherbrand">Other</option>
                </select>

            </div>
            <div class="details">
                <label for="color">Color:</label>
                <select id="color" name="color" required>
                    <option value="Black">Black</option>
                    <option value="Silver">Silver</option>
                    <option value="Bronze">Bronze</option>
                    <option value="Brown">Brown</option>
                    <option value="White">White</option>
                    <option value="Red">Red</option>
                    <option value="other">Other</option>
                </select>

                <label for="yearsUsed">Number of Years Used:</label>
                <select id="yearsUsed" name="yearsUsed" required>
                    <option value="">Select the number of years used</option>
                    <option value="0">Less than 1 year</option>
                    <option value="1">1 year</option>
                    <option value="2">2 years</option>
                    <option value="3">2-3 years</option>
                    <option value="4">3 years and above</option>

                </select>

                <label for="condition">Condition:</label>
                <select id="condition" name="condition" required>
                    <option value="">Select the condition</option>
                    <option value="new">Barely Used i.e almost new</option>
                    <option value="fairly used">Fairly used</option>
                    <option value="used">Used</option>

                </select>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" style="width: 100%;" placeholder="provide any more details necessary"></textarea>
                <label for="number">Phone number:</label>
                <input type="number" id="phone" name="phone" required placeholder="provide the phone number you want to be contacted with">
                <button class="btn btn-submit" name="submit" type="submit">Submit</button>
                <br>
            </div>
        </div>

    </form>


</body>

</html>