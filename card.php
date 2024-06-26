<?php
session_start();
require_once 'connection.php';
// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Property Details</title>
  <script src="./js/font-awesome.js" crossorigin="anonymous"></script>
  <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
  <link rel="stylesheet" href="./css/styles.css">
  <link rel="stylesheet" href="./css/card.css">
</head>

<body>
  <section class="sticky-nav">
    <button class="menu" onclick="menuToggle()"><i class="fa fa-bars"></i></button>
    <nav>
      <a href="index.php" class="logo">
        <img src="./images/declutterLogo.png" class="icon">
        <b><span>Declutter</span> Ke</b>
      </a>
      <a href="index.php">Home</a>
      <a href="store.php" class="active">Store</a>
      <a href="about.php">About</a>
      <a href="conact.php">Contact</a>
      <a href="listing.php" class="cta">Add a Listing</a>
      <div class="credentials">
        <a href="profile.php"><i class="icon fa-regular fa-user"></i><?php echo $_SESSION['name']; ?></a>
        <a href="login.html"><i class="icon fa-solid fa-right-to-bracket "></i> Logout</a>
      </div>
    </nav>
  </section>

  <div class="container">
    <div class="property-images">
      <?php
      include 'connection.php';
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
          echo '<div class="image-gallery">';
          echo '<img src="uploads/' . $photosArray[0] . '" alt="Product Image" id="mainImage">';

          echo '<div class="gallery-row">';
          for ($i = 1; $i < count($photosArray); $i++) {
            echo ' <img src="uploads/' . $photosArray[$i] . '" alt="Product Image" onclick="swapImage(this)">';
          }
          echo '</div>';
          echo '</div>';
        } else {
          echo "Product not found.";
        }
      } else {
        echo "Listing ID not provided.";
      }
      ?> <div class="safety-tips">
        <h2>Safety tips</h2>
        <ul>
          <li><b>1.Bring a Friend:</b> It's always a good idea to bring a friend or family member along when viewing a listing.</li>
          <li><b>2.Inspect Items Thoroughly:</b> Before finalizing a purchase, inspect the item thoroughly for any damages or discrepancies. Ask for additional photos or information if needed.</li>
          <li><b>3.Do not pay before viewing: </b> inspect the item in person before making any payments to ensure it matches its description and meets your expectations.</li>
          <a href="listing.php" class="contact"><button class="post-like">Post Ad Like This</button></a>
        </ul>

      </div>
    </div>
    <div class="property-details">
      <?php
      // Check if the listing_id is provided in the URL
      if (isset($_GET['listing_id'])) {
        // Fetch product details based on the listing_id
        $query = "SELECT listings.*, users.firstName, users.surname, users.date, b.brand_name, c.category_name, s.sub_category_name
        FROM listings 
        INNER JOIN users ON listings.seller_id = users.userId 
        INNER JOIN brands b ON listings.brand_id = b.brand_id 
        INNER JOIN subcategories s ON listings.sub_category_id = s.sub_category_id
        INNER JOIN categories c ON listings.category_id = c.category_id 
        WHERE listings.listing_id = $listing_id";

        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        if ($row) {
          // Retrieve phone number from the database
          $phone_number = $row['phone_number'];

      ?>
          <h1 class="product-title"><?php echo $row['name'];  ?></h1>
          <div class="listing-details">
            <li class="list-group-item">Posted:<span><?php echo $row['date_posted']; ?></span></li>
            <li class="list-group-item">Pickup Town:<span><?php echo $row['city']; ?></span></li>
            <li class="list-group-item">Category: <span> <?php echo $row['category_name']; ?></span></li>
            <li class="list-group-item">Sub Category: <span> <?php echo $row['sub_category_name']; ?></span></li>
            <li class="list-group-item">Brand: <span> <?php echo $row['brand_name']; ?></span></li>
            <li class="list-group-item">Color: <span> <?php echo $row['color']; ?></span></li>
            <li class="list-group-item">Years Used: <span> <?php echo $row['years_used']; ?></span></li>
            <li class="list-group-item">Condition: <span> <?php echo $row['condition']; ?></span></li>
            <li class="list-group-item">Description:<span><?php echo $row['description']; ?></span></li>
          </div>
          <!-- Price and contact information -->
          <div class="price-contact">
            <li class="list-group-item">Price: <span><?php echo 'ksh ' . $row['price']; ?></span></li>
            <!-- Add contact options as needed -->
          </div>

          <!-- Seller information -->
          <div class="seller">
            <h2>Seller details</h2>
            <div class="seller-info">
              <p class="seller-name"> <?php echo $row['firstName'] . ' ' .  $row['surname']; ?></p>
              <p class="date-joined">Member since: <?php echo date('Y', strtotime($row['date'])); ?></p>
            </div>
            <!-- Add contact options as needed -->

            <button class="whatsapp">
              <i class="fa-brands fa-whatsapp"></i>
              <a href="https://wa.me/<?php echo $phone_number; ?>?text=Hello, I'm interested in your <?php echo $row['name']; ?> advertised on DeclutterKe" class="whatsapp">Chat on WhatsApp</a>
            </button>
            </a>

            <a class="contact">
              <button id="contactButton" class="btn" onclick="showPhoneNumber('<?php echo $phone_number; ?>')">
                <i class="fa-solid fa-phone"></i> Show Contact
              </button>
              <script>
                function showPhoneNumber(phoneNumber) {

                  // Change the text of the button
                  var contactButton = document.getElementById('contactButton');
                  contactButton.innerHTML = '<?php echo $phone_number; ?>';
                }
              </script>
            </a>
            <!-- Button to open the modal -->
            <div id="myModal" class="modal">

              <!-- Modal content -->
              <div class="modal-content">
                <span class="close">&times;</span>
                <div class="modal-body">
                  <h2>Pay using M-pesa</h2>
                  <form action="./safaricom/stk_initiate.php" method="POST">
                    <div class="form-group">
                      <label for="amount">Amount</label>
                      <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount">
                    </div>
                    <div class="form-group">
                      <label for="phone">Phone Number</label>
                      <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number">
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-success" name="submit" value="submit">Pay</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <button id="myBtn" class="btn buy-now-btn"> <i class="fa-solid fa-basket-shopping"> </i> Buy Now</button>

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
  </div>
  </div>

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
      $query = "SELECT listings.*, categories.category_name ,subcategories.sub_category_name
      FROM listings 
      INNER JOIN categories ON listings.category_id = categories.category_id 
      INNER JOIN subcategories ON listings.sub_category_id = subcategories.sub_category_id
      WHERE listings.listing_id = $listing_id";
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_assoc($result);

      // Check if the product details are fetched successfully
      if ($row) {
        // Extract category and subcategory of the current product
        $category = $row['category_name'];
        $sub_category = $row['sub_category_name'];
        // Fetch related products with similar category or subcategory, limited to 3
        $related_query = "SELECT * FROM listings WHERE listing_id != $listing_id AND category_id = " . $row['category_id'] . " LIMIT 3";
        $related_result = mysqli_query($con, $related_query);
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
            echo '<img src="uploads/' . explode(',', $related_row['photos'])[0] . '" alt="Product Image" class="card-img-top">';
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
          $random_query = "SELECT * FROM listings WHERE listing_id != $listing_id ORDER BY RAND() LIMIT 4";


          // Exclude the current product
          $random_result = mysqli_query($con, $random_query);

          if (mysqli_num_rows($random_result) > 0) {
            echo '<div class="related-products-container">';
            while ($random_row = mysqli_fetch_assoc($random_result)) {
              echo '<div class="related-product">';
              echo '<a href="card.php?listing_id=' . $random_row['listing_id'] . '">';
              echo '<div class="card">';
              // Fix image source path here
              echo '<img src="uploads/' . explode(',', $random_row['photos'])[0] . '" alt="Product Image" class="card-img-top">';
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
  <!-- Safety tips -->
  <div class="caution">

    <div class="disclaimer">
      <h3>Disclaimer</h3>
      <ul>
        <li>The platform serves as a marketplace for sellers to list their items, and while we strive to ensure the accuracy of the listings, we cannot guarantee the quality, safety, or legality of the items listed.</li>
        <li> Buyers are advised to exercise caution, conduct thorough inspections, and verify the authenticity of items before making any purchases.</li>
        <li> Additionally, transactions conducted through this platform are solely between the buyer and the seller, and we are not responsible for any disputes or issues that may arise.</li>
      </ul>
    </div>
  </div>

  <section id="footer">
    <div class="footer-main">
      <div class="contain">
        <div class="contained">
          <ul>
            <h4><span>About Us</span></h4>
            <li><a href="about.php">Mission Statement</a></li>
            <li><a href="#">Benefits of reselling</a></li>
            <li><a href="about.php">Our purpose</a></li>
            <li><a href="#">Our buying process</a></li>
          </ul>
        </div>
        <div class="contained">

          <h4><span>Get in touch</span></h4>
          <ul>
            <li><a href="#"><i class="fa fa-instagram"></i> Instagram</a></li>
            <li><a href="#"><i class="fa fa-phone"> </i> +254 000 000 000</i></a></li>
            <li><a href="#"><i class="fa-regular fa-envelope"></i></i> declutterke@gmail.com</a></li>

          </ul>
        </div>
        <div class="subscribe-content">
          <p>Join our mailing list</p>
          <form class="subscribe-form" action="#">
            <input type="email" name="email" placeholder="Your E-mail">
            <button type="submit">Subscribe</button>
          </form>
        </div>
      </div>
    </div>
  </section>
  <script src="./js/card.js"></script>
</body>

</html>