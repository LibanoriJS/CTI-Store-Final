// Select all elements with the class 'rem-cart'
var remCart = document.querySelectorAll('.rem-cart');

// Add a click event listener to each element with the class 'rem-cart'
for (var i = 0; i < remCart.length; i++) {
    remCart[i].addEventListener('click', function() {
        var id = this.id; // Get the ID of the clicked element
        var xhr = new XMLHttpRequest();
        xhr.open('GET', './DB/remove-cart.php?id=' + id, true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                // The server's response (output from PHP) is in xhr.responseText
                console.log(xhr.responseText);
            }
        };
        xhr.send();
        
        // Reload the page after a 200ms delay
        setTimeout(() => {
            window.location.reload(true);
        }, 200);
    });
}

// Disable the click event for the 'disabled-link' button to prevent it from performing its default action
document.querySelector('.disabled-link').addEventListener('click', function (event) {
    event.preventDefault();
});
