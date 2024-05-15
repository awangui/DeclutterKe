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
  // Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
