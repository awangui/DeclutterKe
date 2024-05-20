<?php
use PHPUnit\Framework\TestCase;

class AddListingTest extends TestCase {
    private $con;

    protected function setUp(): void {
        // Establish a database connection
        $this->con = new mysqli('localhost', 'username', 'password', 'your_database');

        // Check connection
        if ($this->con->connect_error) {
            die("Connection failed: " . $this->con->connect_error);
        }
    }

    public function testAddListing(): void {
        // Prepare test data
        $listingData = array(
            'name' => 'Test Product',
            'category' => 1, // Replace with valid category ID from your database
            'sub-category' => 'Fridges',
            'brand' => 1, // Replace with valid brand ID from your database
            'color' => 'Blue',
            'yearsUsed' => 2,
            'condition' => 'used',
            'price' => 100,
            'description' => 'Test description',
            'phone' => 1234567890,
            'city' => 'Nairobi',
            'town' => 'Ruiru'
        );

        // Submit the form data to the server
        $response = $this->submitListingForm($listingData);

        // Check if the listing was added successfully
        $this->assertEquals('Listing uploaded successfully.', $response);
    }

    private function submitListingForm($listingData) {
        // Post request to the server
        $_POST = $listingData;

        // Buffer the output, capturing the response from the server
        ob_start();
        include 'path_to_your_listing_php_file'; // Replace 'path_to_your_listing_php_file' with the actual path to your PHP file
        $output = ob_get_clean();

        // Return the response from the server
        return trim($output);
    }

    protected function tearDown(): void {
        // Close the database connection
        $this->con->close();
    }
}
?>
