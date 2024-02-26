<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Page</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="card.css">
  <style>
    .thumbnail {
      cursor: pointer;
    }
  </style>
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
                <a href="listing.html"><i class=" icon fa fa-plus"></i> Add a Listing</a>
                <a href="login.html" class="credentials"><i class="icon fa-solid fa-right-to-bracket "></i> Login</a>
                <a href="registration.html"><i class="icon fa-regular fa-user"></i> Sign Up</a>

            </nav>
        </div>
    </section>
    <main>
      <section id="product-images">
        <?php
        include 'connection.php';

        // Check if the listing_id is provided in the URL
        if(isset($_GET['listing_id'])) {
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
        if(isset($_GET['listing_id'])) {
            // Fetch product details based on the listing_id
            $query = "SELECT * FROM listings WHERE listing_id = $listing_id";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            // Display product details
            if ($row) {
        ?>
            <div class="card">
              <div class="card-body">
                <h2 class="card-title"><?php echo $row['name']; ?></h2>
                <p class="card-text"><?php echo $row['description']; ?></p>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Category: <?php echo $row['category']; ?></li>
                  <li class="list-group-item">Sub Category: <?php echo $row['sub_category']; ?></li>
                  <li class="list-group-item">Brand: <?php echo $row['brand']; ?></li>
                  <li class="list-group-item">Color: <?php echo $row['color']; ?></li>
                  <li class="list-group-item">Years Used: <?php echo $row['years_used']; ?></li>
                  <li class="list-group-item">Condition: <?php echo $row['condition']; ?></li>
                  <li class="list-group-item">Price: <?php echo 'ksh ' . $row['price']; ?></li>
                </ul>
                <a href="#" class="btn btn-primary">Add to Cart</a>
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
