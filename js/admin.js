document.querySelectorAll('.delete').forEach(function(button) {
    button.addEventListener('click', function() {
        var id = this.getAttribute('data-id');
        document.getElementById('confirmDeleteButton').setAttribute('data-id', id);
        document.getElementById('deleteModal').style.display = "block";
    });
});

// Close the delete modal when the user clicks on the close button
document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('deleteModal').style.display = "none";
});

// Close the delete modal when the user clicks outside of it
window.onclick = function(event) {
    var modal = document.getElementById('deleteModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

// JavaScript to handle delete button clicks
document.querySelectorAll('.deleteBtn').forEach(function(button) {
    button.addEventListener('click', function() {
        var listing_id = this.getAttribute('data-id');
        document.getElementById('confirmDeleteButton').setAttribute('data-id', listing_id);
        document.getElementById('deleteModal').style.display = "block";
    });
});

// JavaScript to handle confirm delete button click
document.getElementById('confirmDeleteButton').addEventListener('click', function() {
    var listing_id = this.getAttribute('data-id');
    window.location.href = `delete_listing.php?deleteid=${listing_id}`;
});
//
// Close the delete modal when the user clicks on the close button
function closeModal() {
    document.getElementById('deleteModal').style.display = "none";
}
document.querySelectorAll('.close').forEach(function(button) {
    button.addEventListener('click', closeModal);
});
// JavaScript to handle close button click
document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('deleteModal').style.display = "none";
});