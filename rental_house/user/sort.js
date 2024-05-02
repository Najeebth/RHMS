// Function to attach event listener to "Add to Cart" buttons
function attachAddToCartListeners() {
    // Get all add to cart buttons
    var addToCartButtons = document.querySelectorAll(".add-to-cart-btn");

    // Attach click event listener to each button
    addToCartButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            // Get the plot_number from the data attribute
            var plotNumber = button.getAttribute("data-plot-number");

            // Send AJAX request to PHP endpoint
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "add_to_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Check if response text is not empty
                        if (xhr.responseText.trim() !== '') {
                            // Parse JSON response
                            var response = JSON.parse(xhr.responseText);
                            console.log(response); // Log the response to see if it's as expected

                            if (response.status === "success") {
                                // Handle success
                                alert(response.message); // or display it in the document
                                button.textContent = "Added"; // Change button text
                                button.disabled = true; // Disable the button
                            } 
                        } else {
                            alert("Already in cart");
                        }
                    } 
                }
            };

            xhr.send("plot_number=" + encodeURIComponent(plotNumber));
        });
    });
}

// Call the function to attach event listeners when the DOM content is loaded
document.addEventListener("DOMContentLoaded", function() {
    attachAddToCartListeners();
});

// Sort functions
function sortByRentIncreasing() {
    // Sort data
    data.sort(function(a, b) {
        return parseInt(a.rent) - parseInt(b.rent);
    });
    // Display sorted data
    displayPropertyDetails(data);
    // Update selected option
    document.getElementById('selected-option').innerText = 'Rent (Low to High)';
    // Reattach event listeners
    attachAddToCartListeners();
}

function sortByRentDecreasing() {
    // Sort data
    data.sort(function(a, b) {
        return parseInt(b.rent) - parseInt(a.rent);
    });
    // Display sorted data
    displayPropertyDetails(data);
    // Update selected option
    document.getElementById('selected-option').innerText = 'Rent (High to Low)';
    // Reattach event listeners
    attachAddToCartListeners();
}

function sortByLastUpdated() {
    // Sort data by last updated
    data.sort(function(a, b) {
        return new Date(b.updated_at) - new Date(a.updated_at);
    });
    // Display sorted data
    displayPropertyDetails(data);
    // Update selected option
    document.getElementById('selected-option').innerText = 'Last Updated';
    // Reattach event listeners
    attachAddToCartListeners();
}

function sortByLastCreated() {
    // Sort data by last created
    data.sort(function(a, b) {
        return new Date(b.created_at) - new Date(a.created_at);
    });
    // Display sorted data
    displayPropertyDetails(data);
    // Update selected option
    document.getElementById('selected-option').innerText = 'Last Created';
    // Reattach event listeners
    attachAddToCartListeners();
}

function sortByDefault() {
    // Display sorted data
    displayPropertyDetails(data);
    // Clear selected option
    document.getElementById('selected-option').innerText = '';
    // Reattach event listeners
    attachAddToCartListeners();
}
