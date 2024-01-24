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