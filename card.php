<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Page</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="card.css">
  <script src="https://kit.fontawesome.com/661ba5765b.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <script src="script.js"></script>
  <style>
    .thumbnail {
      cursor: pointer;
    }

  </style>
</head>

<body>
        <section class="sticky-nav">
            <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
            <nav>
                <a href="index.php" class="logo"><b><span>Declutter</span> Ke</b></a>
                <a href="#home" class="active">Home</a>
                <a href="categories.php">Categories</a>
                <a href="about.php">About</a>
                <a href="#contact">Contact</a>
                <a href="listing.html" class="cta"><i class=" icon fa fa-plus"></i> Add a Listing</a>
                <a href="login.html" class="credentials"><i class="icon fa-solid fa-right-to-bracket "></i> Login</a>
                <a href="registration.html"><i class="icon fa-regular fa-user"></i> Sign Up</a>

            </nav>
        </section>
  <main>
    <section id="product-images">
      <?php
      include 'connection.php';
      //check if user is logged in
      // if(!isset($_SESSION['userId'])){
      //     //redirect to login page
      //     header("Location: login.html");
      //     exit();
      // }
      // Check if the listing_id is provided in the URL
      if (isset($_GET['listing_id'])) {
        $listing_id = $_GET['listing_id'];

        // Fetch product details based on the listing_id
        $query = "SELECT * FROM listings WHERE listing_id = $listing_id";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        // Display product images
        if ($row) {
          $photosArray = explode(',', $row['photos']); // Split photos field by comma
          // Display the first image as larger image
          echo '<img id="mainImage" src="uploads/' . $photosArray[0] . '" alt="Product Image" class="card-img-top" style="width: 50%;">';
          // Display the rest of the images underneath
          echo '<div class="image-group">';
          for ($i = 1; $i < count($photosArray); $i++) {
            echo '<img src="uploads/' . $photosArray[$i] . '" alt="Product Image" class="thumbnail" onclick="swapImage(this)">';
          }
          echo '</div>';
        } else {
          echo "Product not found.";
        }
      } else {
        echo "Listing ID not provided.";
      }
      ?>
    </section>

    <section id="product-details">
      <?php
      // Check if the listing_id is provided in the URL
      if (isset($_GET['listing_id'])) {
        // Fetch product details based on the listing_id
        $query = "SELECT * FROM listings WHERE listing_id = $listing_id";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        // Display product details
        if ($row) {
             // Retrieve phone number from the database
             $phone_number = $row['phone_number'];
      ?>
          <div class="card">
            <div class="card-body">
              <h2 class="card-title"><?php echo $row['name']; ?></h2>
              <p class="card-text"><?php echo $row['description']; ?></p>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Category: <span> <?php echo $row['category']; ?></li>
                <li class="list-group-item">Sub Category: <span> <?php echo $row['sub_category']; ?></li>
                <li class="list-group-item">Brand: <span> <?php echo $row['brand']; ?></li>
                <li class="list-group-item">Color: <span> <?php echo $row['color']; ?></li>
                <li class="list-group-item">Years Used: <span> <?php echo $row['years_used']; ?></li>
                <li class="list-group-item">Condition: <span> <?php echo $row['condition']; ?></li>
                <li class="list-group-item">Price: <span><?php echo 'ksh ' . $row['price']; ?></li>
             
              </ul>
              <div class="actions">
    <a href="#" class="wishlist">
        <span class="tooltip-text">Add to wishlist!</span>
        <a href="#" class="wishlist"><span class="material-symbols-outlined">
favorite
</span></a>
    </a><br>
    <?php
    echo '<a href="https://wa.me/' . $phone_number . '" class="btn btn-primary">Contact Seller</a>';
    ?>
</div>

            </div>
          </div>
      <?php
        } else {
          echo "Product not found.";
        }
      } else {
        echo "Listing ID not provided.";
      }
      ?>
    </section>

  </main>
  <section id="related-products">
  <h2>
    <?php
    if (isset($row) && $row) {
      echo 'Related Products';
    } else {
      echo 'Other Products';
    }
    ?>
  </h2>

  <!-- PHP code to fetch related products from the database -->
  <?php
  include 'connection.php'; // Include your database connection file

  // Check if the listing_id is provided in the URL
  if (isset($_GET['listing_id'])) {
    $listing_id = $_GET['listing_id'];

    // Fetch product details based on the listing_id
    $query = "SELECT * FROM listings WHERE listing_id = $listing_id";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    // Check if the product details are fetched successfully
    if ($row) {
      // Extract category and subcategory of the current product
      $category = $row['category'];
      $sub_category = $row['sub_category'];

      // Fetch related products with similar category or subcategory, limited to 3
      $related_query = "SELECT * FROM listings WHERE (category = '$category' OR sub_category = '$sub_category') AND listing_id != $listing_id LIMIT 4";
      $related_result = mysqli_query($con, $related_query);

      // Check if there are related products
      if (mysqli_num_rows($related_result) > 0) {
        echo '<div class="related-products-container">';
        // Loop through each related product and display it
        while ($related_row = mysqli_fetch_assoc($related_result)) {
          // Output HTML for each related product
          echo '<div class="related-product">';
          echo '<a href="card.php?listing_id=' . $related_row['listing_id'] . '">';
          echo '<div class="card">';
          // Fix image source path here
          echo '<img src="uploads/' . $related_row['photos'] . '" alt="Product Image" class="card-img-top">';
          echo '<div class="card-body">';
          echo '<h3>' . $related_row['name'] . '</h3>'; // Display product name
          // Display other product details here
          echo '</div>';
          echo '</div>';
          echo '</a>';
          echo '</div>';
        }
        echo '</div>'; // Close related-products-container
      } else {
        // If no related products found, fetch random products
        $random_query = "SELECT * FROM listings WHERE listing_id != $listing_id ORDER BY RAND() LIMIT 4"; // Exclude the current product
        $random_result = mysqli_query($con, $random_query);

        if (mysqli_num_rows($random_result) > 0) {
          echo '<div class="related-products-container">';
          while ($random_row = mysqli_fetch_assoc($random_result)) {
            echo '<div class="related-product">';
            echo '<a href="card.php?listing_id=' . $random_row['listing_id'] . '">';
            echo '<div class="card">';
            // Fix image source path here
            echo '<img src="uploads/' . $random_row['photos'] . '" alt="Product Image" class="card-img-top">';
            echo '<div class="card-body">';
            echo '<h3>' . $random_row['name'] . '</h3>';
            // Display other product details here
            echo '</div>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
          }
          echo '</div>';
        } else {
          echo '<p>No products found.</p>';
        }
      }
    } else {
      echo "Product not found.";
    }
  } else {
    echo "Listing ID not provided.";
  }
  ?>
</section>

  <footer>
    &copy; 2024 Your Company Name. All rights reserved.
  </footer>

  <script>
    function swapImage(thumbnail) {
      var mainImage = document.getElementById('mainImage');
      mainImage.style.opacity = 0; // Fade out main image
      setTimeout(function() {
        var tempSrc = mainImage.src;
        mainImage.src = thumbnail.src;
        thumbnail.src = tempSrc;
        mainImage.style.opacity = 1; // Fade in main image
      }, 300); // Wait for fade out transition to complete (300ms)
    }
  </script>
</body>

</html>