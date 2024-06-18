// Function to initialize the page after header is loaded
function initializePage() {
    const params = new URLSearchParams(window.location.search);
    document.getElementById("guess").innerText = params.get("guess");
    document.getElementById("resultImage").src = localStorage.getItem("guessimage");

    // Afficher l'ID de l'image
    const guessId = params.get("guessId");
    const idElement = document.createElement('p');
    idElement.innerText = `ID de l'image : ${guessId}`;
    document.getElementById('imageIdContainer').appendChild(idElement);
}

// Function to send feedback
function sendFeedback(isWin) {
    const params = new URLSearchParams(window.location.search);
    const guessId = params.get("guessId");
    const winValue = isWin ? 1 : -1;

    const body = JSON.stringify({ win: winValue });

    console.log("Sending feedback...");
    console.log("Guess ID:", guessId);
    console.log("Win Value:", winValue);

    fetch(`http://localhost:8080/api/guesses/${guessId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json"
        },
        body: body,
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error("Network response was not ok " + response.statusText);
        }
        return response.json();
    })
    .then((data) => {
        console.log("Response data:", data);
        document.getElementById("feedbackMessage").innerHTML = `
            <div class="alert alert-success" role="alert">
                La mise à jour a été effectuée avec succès !
            </div>
        `;
        $("#feedbackModal").modal("show");
        $("#feedbackModal").on("hidden.bs.modal", function (e) {
            // Nettoie le backdrop modal après sa fermeture
            $("body").removeClass("modal-open");
            $(".modal-backdrop").remove();
        });
    })
    .catch((error) => {
        console.error("Error:", error);
        document.getElementById("feedbackMessage").innerHTML = `
            <div class="alert alert-danger" role="alert">
                Une erreur s'est produite : ${error.message}
            </div>
        `;
        $("#feedbackModal").modal("show");
    });
}

// Load header content
document.addEventListener("DOMContentLoaded", function () {
    const headerContainer = document.getElementById('header-container');
    fetch('header.html')
        .then(response => response.text())
        .then(data => {
            headerContainer.innerHTML = data;
            initializePage(); // Call function to initialize the page after header is loaded
        })
        .catch(error => {
            console.error('Erreur lors du chargement du header:', error);
        });
});
