// Select the element with the class 'add-cart'
var addCart = document.querySelector('.add-cart');

// Add a click event listener to the 'add-cart' element
addCart.addEventListener('click', function() {
    var xhr = new XMLHttpRequest();
    
    // Construct a GET request to 'insert-cart.php' with the ID from 'addCart'
    xhr.open('GET', './DB/insert-cart.php?id=' + addCart.id, true);
    
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            // The server's response (output from PHP) is in xhr.responseText
            console.log(xhr.responseText);
        }
    };
    
    // Send the GET request
    xhr.send();
});
