// Handle button clicks
document.addEventListener('DOMContentLoaded', function() {
    const productDetailsSection = document.getElementById('productDetails');
    const contactDetailsSection = document.getElementById('contactDetails');
    const rightDetailsSection = document.getElementById('rightDetails'); // Added this line
    const nextButton = document.getElementById('nextButton');
    const backButton = document.getElementById('backButton');
    const dot1 = document.getElementById('dot1');
    const dot2 = document.getElementById('dot2');

    // Add event listener for "Next" and "Back" buttons
    nextButton.addEventListener('click', handleButtonClick);
    backButton.addEventListener('click', handleButtonClick);

    // Handle browser back button
    window.onpopstate = function(event) {
        if (event.state) {
            if (event.state.page === 'contact') {
                showContactDetails();
            } else {
                showProductDetails();
            }
        }
    };

    function handleButtonClick(event) {
        if (event.target.id === 'nextButton') {
            showContactDetails();
            history.pushState({ page: 'contact' }, null, '');
        } else if (event.target.id === 'backButton') {
            showProductDetails();
            history.pushState({ page: 'product' }, null, '');
        }
    }

    function showProductDetails() {
        productDetailsSection.style.display = 'block';
        contactDetailsSection.style.display = 'none';
        rightDetailsSection.style.display = 'block'; // Show right details
        backButton.style.display = 'none';
        nextButton.style.display = 'block';
        dot1.classList.add('active-dot');
        dot2.classList.remove('active-dot');
        document.getElementById('submitButtonContainer').style.display = 'none';
    }

    function showContactDetails() {
        productDetailsSection.style.display = 'none';
        contactDetailsSection.style.display = 'block';
        rightDetailsSection.style.display = 'none'; // Hide right details
        backButton.style.display = 'block';
        nextButton.style.display = 'none';
        dot1.classList.remove('active-dot');
        dot2.classList.add('active-dot');
        document.getElementById('submitButtonContainer').style.display = 'block';
    }
});

 // Handle browser back button
 window.onpopstate = function(event) {
     if (event.state) {
         if (event.state.page === 'contact') {
             // Show contact details section and hide product details section
             contactDetailsSection.style.display = 'block';
             productDetailsSection.style.display = 'none';
             // Show back button and hide next button
             backButton.style.display = 'block';
             nextButton.style.display = 'none';
             // Show submit button
             document.getElementById('submitButtonContainer').style.display = 'block';
             // Activate dot2 and deactivate dot1
             dot1.classList.remove('active-dot');
             dot2.classList.add('active-dot');
         } else {
             // Show product details section and hide contact details section
             productDetailsSection.style.display = 'block';
             contactDetailsSection.style.display = 'none';
             // Show next button and hide back button
             nextButton.style.display = 'block';
             backButton.style.display = 'none';
             // Hide submit button
             document.getElementById('submitButtonContainer').style.display = 'none';
             // Activate dot1 and deactivate dot2
             dot1.classList.add('active-dot');
             dot2.classList.remove('active-dot');
         }
     }
 };

 // Save state on button clicks
 nextButton.addEventListener('click', function() {
     history.pushState({ page: 'contact' }, null, '');
 });

 backButton.addEventListener('click', function() {
     history.pushState({ page: 'product' }, null, '');
 });

function submitForm() {
    // You can add validation logic here if needed

    // Get form values
    var name = document.getElementById('name').value;
    var brand = document.getElementById('brand').value;
    var yearsUsed = document.getElementById('yearsUsed').value;
    var condition = document.getElementById('condition').value;

    // Create an object to store the form data
    var formData = {
        name: name,
        brand: brand,
        yearsUsed: yearsUsed,
        condition: condition
    };

    // You can send the formData object to the server using AJAX or any other method
    // Example AJAX call using fetch API
    fetch('/your-server-endpoint', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        // You can redirect or perform any other action upon successful submission
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
