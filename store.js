function applyFilters() {
    console.log("Applying filters...");

    // Get the filter input values
    var nameInput = document.getElementById('name');
    var brandInput = document.getElementById('brand');
    var colorInput = document.getElementById('color');
    var locationInput = document.getElementById('location');
    var categoryInput = document.getElementById('category');
    var yearsInput = document.getElementById('years');
    var subCategoryInput = document.getElementById('sub-category');
    var priceInput = document.getElementById('price');
    var conditionInputs = document.querySelectorAll('.filter-condition input[type="checkbox"]');
    var sortByInput = document.getElementById('sort-by');

    var nameValue = nameInput.value.toUpperCase();
    var brandValue = brandInput.value.toUpperCase();
    var colorValue = colorInput.value.toUpperCase();
    var locationValue = locationInput.value.toUpperCase();
    var categoryValue = categoryInput.value;
    var yearsValue = yearsInput.value;
    var subCategoryValue = subCategoryInput.value.toUpperCase();
    var priceValue = priceInput.value;
    var sortByValue = sortByInput.value;
    var conditions = [];
    conditionInputs.forEach(function(input) {
        if (input.checked) {
            conditions.push(input.id);
        }
    });

    // Log filter input values
    console.log("Name:", nameValue);
    console.log("Brand:", brandValue);
    console.log("Color:", colorValue);
    console.log("Location:", locationValue);
    console.log("Category:", categoryValue);
    console.log("Years Used:", yearsValue);
    console.log("Sub-Category:", subCategoryValue);
    console.log("Price:", priceValue);
    console.log("Sort By:", sortByValue);
    console.log("Conditions:", conditions);

    // Apply filters
    var listings = document.getElementsByClassName('card');
    var listingsFound = false;
    for (var i = 0; i < listings.length; i++) {
        var card = listings[i];
        var nameElement = card.querySelector('.item-title');
        if (!nameElement) {
            console.error("Item title not found in card:", card);
            continue; // Skip to the next iteration
        }
        var name = nameElement.textContent.toUpperCase();
        var brand = card.querySelector('.brand').textContent.toUpperCase();
        var color = card.querySelector('.color').textContent.toUpperCase();
        var location = card.querySelector('.location').textContent.toUpperCase();
        var category = card.querySelector('.category').textContent;
        var years = card.querySelector('.years').textContent;
        var subCategory = card.querySelector('.sub-category').textContent.toUpperCase();
        var price = card.querySelector('.price').textContent;
        var condition = card.querySelector('.condition').textContent.toUpperCase();

        // Check if any filter input has a value
        var filterApplied = nameValue || brandValue || colorValue || locationValue || categoryValue !== "any" || yearsValue || subCategoryValue || priceValue || conditions.length > 0 || sortByValue;

        if (filterApplied) {
            // Check if each field matches the criteria
            var nameMatch = !nameValue || name.includes(nameValue);
            var brandMatch = !brandValue || brand.includes(brandValue);
            var colorMatch = !colorValue || color.includes(colorValue);
            var locationMatch = !locationValue || location.includes(locationValue);
            var categoryMatch = categoryValue === "any" || category === categoryValue || categoryValue === 'all';
            var yearsMatch = !yearsValue || years.includes(yearsValue);
            var subCategoryMatch = !subCategoryValue || subCategory.includes(subCategoryValue);
            var priceMatch = !priceValue || parseFloat(price.substring(4)) <= parseFloat(priceValue);
            var conditionMatch = conditions.length === 0 || conditions.includes(condition);

            // Log matches
            console.log("Name Match:", nameMatch);
            console.log("Brand Match:", brandMatch);
            console.log("Color Match:", colorMatch);
            console.log("Location Match:", locationMatch);
            console.log("Category Match:", categoryMatch);
            console.log("Years Used Match:", yearsMatch);
            console.log("Sub-Category Match:", subCategoryMatch);
            console.log("Price Match:", priceMatch);
            console.log("Condition Match:", conditionMatch);

            // Show or hide the listing based on the matches
            if (nameMatch && brandMatch && colorMatch && locationMatch && categoryMatch && yearsMatch && subCategoryMatch && priceMatch && conditionMatch) {
                card.style.display = ""; // Show the listing
                listingsFound = true;
            } else {
                card.style.display = "none"; // Hide the listing
            }
        } else {
            // If no filters are applied, show all listings
            card.style.display = ""; // Show the listing
            listingsFound = true;
        }
    }

    // Show or hide the message card based on listings found
    var messageCard = document.getElementById('message-card');
    if (listingsFound) {
        messageCard.style.display = "none";
    } else {
        messageCard.style.display = "";
    }
}

function resetFilters() {
    document.getElementById('name').value = "";
    document.getElementById('brand').value = "";
    document.getElementById('color').value = "";
    document.getElementById('location').value = "";
    document.getElementById('category').value = "any";
    document.getElementById('years').value = "";
    document.getElementById('sub-category').value = "";
    document.getElementById('price').value = "";
    var conditionInputs = document.querySelectorAll('.filter-condition input[type="checkbox"]');
    conditionInputs.forEach(function(input) {
        input.checked = false;
    });
    document.getElementById('sort-by').value = "";

    // Reset all listings to be displayed
    var listings = document.getElementsByClassName('card');
    for (var i = 0; i < listings.length; i++) {
        var card = listings[i];
        card.style.display = ""; // Show the listing
    }

    // Hide the message card
    document.getElementById('message-card').style.display = "none";
}
