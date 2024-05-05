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
// Get the card section
const cardSection = document.getElementById('most-popular');

// Function to scroll to the card section
let debounceTimer;

function search() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(function() {
        var input, filter, cards, cardContainer, h3, i, txtValue;
        input = document.getElementById("productName");
        filter = input.value.toUpperCase();
        cardContainer = document.getElementById("most-popular");
        cards = cardContainer.getElementsByClassName("card");
        for (i = 0; i < cards.length; i++) {
            h3 = cards[i].querySelector(".item-title");
            txtValue = h3.textContent || h3.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }

        // Hide the best-sellers and browse sections
        document.getElementById("best-sellers").style.display = "none";
        document.getElementById("browse").style.display = "none";

        // Scroll to the card section with a slight delay
        scrollToCardSection();
    }, 400); // Adjust the debounce delay as needed (e.g., 300 milliseconds)
}

function searchFunction() {
    search();
}
function scrollToCardSection() {
    var cardSection = document.getElementById("most-popular");
    cardSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
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

