function resetFilters() {
    document.getElementById('name').value = "";
    document.getElementById('brand').value = "";
    document.getElementById('color').value = "";
    document.getElementById('location').value = "";
    document.getElementById('category').value = "any";
    document.getElementById('years').value = "";
    document.getElementById('sub-category').value = "";
    document.getElementById('min-price').value = "";
    document.getElementById('max-price').value = "";
    var conditionInputs = document.querySelectorAll('.filter-condition input[type="checkbox"]');
    conditionInputs.forEach(function(input) {
        input.checked = false;
    });
    var conditionInputs = document.querySelectorAll('.filters input[type="select"]');
    conditionInputs.forEach(function(input) {
        input.selected = false;
    });

   window.location='store.php'
}