   // JavaScript for modal display
   var modal = document.getElementById("edit-modal");
   var editBtn = document.getElementById("editBtn");
   var closeBtn = document.querySelector(".modal-content .close");

   editBtn.onclick = function() {
       modal.style.display = "block";
   }

   closeBtn.onclick = function() {
       modal.style.display = "none";
   }

   window.onclick = function(event) {
       if (event.target == modal) {
           modal.style.display = "none";
       }
   }
 
 
 // function to validate form
 function validateForm() {
    var errorMessage = document.getElementById("error-message");
    var phone = document.getElementById("phone").value;
    var fname = document.getElementById("fname").value;
    var sname = document.getElementById("sname").value;
    //check if the name contains numbers
    if (fname.match(/\d+/g) || sname.match(/\d+/g)) {
        errorMessage.innerText = "Name should not contain numbers";
        errorMessage.style.display = "block";
        return false;
    }
    if (fname === "" || sname === "") {
        errorMessage.innerText = "Name cannot be empty";
        errorMessage.style.display = "block";
        return false;
    }
    if (!phone.match(/^\d{12}$/)) {
        errorMessage.innerText = "Phone number should be 12 digits long and not any contain letters.";
        errorMessage.style.display = "block";
        return false;
    }
    return true;
}