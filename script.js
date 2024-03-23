window.addEventListener('scroll', function() {
    var navigation = document.getElementById('navigation');
    var navigationRect = navigation.getBoundingClientRect();
    var scrollPosition = window.scrollY;
    var navigationBottom = navigationRect.bottom;

    // Check if navigation is already sticky
    var isSticky = navigation.classList.contains('sticky-nav');

    // Add a class to make the navigation sticky when it's no longer in view
    if (!isSticky && navigationBottom < 0) {
        navigation.classList.add('sticky-nav');
    } else if (isSticky && scrollPosition <= navigationRect.top) {
        navigation.classList.remove('sticky-nav');
    }
});

function menuToggle() {
    var nav = document.querySelector('nav');
    if (nav.style.display === 'none' || nav.style.display === '') {
        nav.style.display = 'block';
    } else {
        nav.style.display = 'none';
    }
    nav.classList.toggle('show');
}


// function search() {
//     // Declare variables
//     var input, filter, card, title, txtValue;
//     input = document.getElementById('productName');
//     filter = input.value.toUpperCase();
//     card = document.getElementById("productCard");
  
//     // Get the title element within the card
//     title = card.querySelector('.item-title');
  
//     // Get the text content of the title
//     txtValue = title.textContent || title.innerText;
  
//     // Check if the search query is found in the product name
//     if (txtValue.toUpperCase().indexOf(filter) > -1) {
//       card.style.display = "";
//     } else {
//       card.style.display = "none";
//     }
//   }
  function search() {
    var input, filter, listings, card, title, i, txtValue;
    input = document.getElementById('productName');
    filter = input.value.toUpperCase();
    listings = document.getElementsByClassName('card'); // Assuming each listing has the class 'card'

    // Loop through all listings, and hide those that don't match the search input
    for (i = 0; i < listings.length; i++) {
        card = listings[i];
        title = card.querySelector('.item-title');
        if (title) {
            txtValue = title.textContent || title.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                card.style.display = ''; // Show the listing
            } else {
                card.style.display = 'none'; // Hide the listing
            }
        }
    }
}
  //accordion faq
  document.addEventListener("DOMContentLoaded", function() {
    var accordionTitles = document.querySelectorAll(".accordion-title");
    
    accordionTitles.forEach(function(title) {
        title.addEventListener("click", function() {
            var accordionItem = this.parentNode;
            accordionItem.classList.toggle("active");

            var accordionContent = accordionItem.querySelector(".accordion-content");
            if (accordionItem.classList.contains("active")) {
                accordionContent.style.display = "block";
            } else {
                accordionContent.style.display = "none";
            }
        });
    });
});

