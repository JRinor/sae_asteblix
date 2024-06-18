var modal = document.getElementById("login-modal");

var btn = document.getElementById("user-icon");

var btnMobile = document.getElementById("open-modal");

var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    modal.style.display = "block";
}

btnMobile.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

document.getElementById("login-form").onsubmit = async function(event) {
    event.preventDefault();

    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

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
            localStorage.setItem('authToken', data.token);

            updateHeaderForLoginStatus();

            modal.style.display = "none";
        } else {
            alert('Login failed: ' + data.message);
        }
    } catch (error) {
        console.error('Error during login:', error);
        alert('An error occurred. Please try again.');
    }
}


document.getElementById("logout-button").onclick = function() {
    localStorage.removeItem('authToken');
    updateHeaderForLoginStatus();
}