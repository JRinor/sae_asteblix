// Get the modal
var modal = document.getElementById("login-modal");

// Get the button that opens the modal
var btn = document.getElementById("user-icon");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
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

// Handle the login form submission
document.getElementById("login-form").onsubmit = async function(event) {
    event.preventDefault();

    // Retrieve email and password
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    // Make the API call
    try {
        const response = await fetch('http://localhost:8080/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'email': email,
                'pass': password
            })
        });

        const data = await response.json();

        if (data.success) {
            // Store the token in localStorage
            localStorage.setItem('authToken', data.token);

            // Update the header to show the Galerie tab
            updateHeaderForLoginStatus();

            // Close the modal
            modal.style.display = "none";
        } else {
            alert('Login failed: ' + data.message);
        }
    } catch (error) {
        console.error('Error during login:', error);
        alert('An error occurred. Please try again.');
    }
}

// Handle logout
document.getElementById("logout-button").onclick = function() {
    localStorage.removeItem('authToken');
    updateHeaderForLoginStatus();
}

