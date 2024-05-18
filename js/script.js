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
// login and registration display error function
const urlParams = new URLSearchParams(window.location.search);
const myParam = urlParams.get('error');
if(typeof(myParam) !== 'undefined' && myParam !== null){
    document.querySelector('.login-error').style.display = 'block';
    document.querySelector('.login-error').textContent = myParam;
} else {
    document.querySelector('.login-error').style.display = 'none';
}
     // function to toggle password visibility
     function togglePassword(inputId) {
        var passwordInput = document.getElementById(inputId);
        var toggleButton = document.getElementById("toggle-" + inputId);
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleButton.textContent = "Hide";
        } else {
            passwordInput.type = "password";
            toggleButton.textContent = "Show";
        }
    }
 // function to validate form
 function validateForm() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;
    var errorMessage = document.getElementById("error-message");
    
    var fname = document.getElementById("fname").value;
    var sname = document.getElementById("sname").value;
    //check if the name contains numbers
    if (fname.match(/\d+/g) || sname.match(/\d+/g)) {
        errorMessage.innerText = "Name should not contain numbers";
        errorMessage.style.display = "block";
        return false;
    }
    //name length check
    if (fname.length < 3 || sname.length < 3) {
        errorMessage.innerText = "Name should be at least 3 characters long";
        errorMessage.style.display = "block";
        return false;
    }
    if (fname === "" || sname === "") {
        errorMessage.innerText = "Name cannot be empty";
        errorMessage.style.display = "block";
        return false;
    }
    fname = fname.trim();
    sname = sname.trim();
    
    // Password length check
    if (password.length < 8) {
        errorMessage.innerText = "Password must be at least 8 characters long.";
        errorMessage.style.display = "block";
        return false;
    }

    // Uppercase letter check
    if (!/[A-Z]/.test(password)) {
        errorMessage.innerText = "Password must contain at least one uppercase letter.";
        errorMessage.style.display = "block";
        return false;
    }
    if (phone.match(/\d+/g)) {
        errorMessage.innerText = "Phone number should not contain letters";
        errorMessage.style.display = "block";
        return false;
    }
    // Special character check
    if (!/[^a-zA-Z0-9]/.test(password)) {
        errorMessage.innerText = "Password must contain at least one special character.";
        errorMessage.style.display = "block";
        return false;
    }

    // Password match check
    if (password !== confirm_password) {
        errorMessage.innerText = "Passwords do not match.";
        errorMessage.style.display = "block";
        return false;
    }

    return true;
}

// event listener to toggle password button
document.getElementById("toggle-password").addEventListener("click", function() {
    togglePassword('password');
});