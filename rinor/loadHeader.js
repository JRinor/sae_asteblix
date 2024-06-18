document.addEventListener("DOMContentLoaded", function() {
    const headerContainer = document.getElementById('header-container');

    if (headerContainer) {
        fetch('header.html')
            .then(response => response.text())
            .then(data => {
                headerContainer.innerHTML = data;

                const script = document.createElement("script");
                script.src = "modal.js";
                script.onload = function() {
                    updateHeaderForLoginStatus(); // Met à jour l'affichage en fonction de l'état de connexion
                };
                document.body.appendChild(script);
            })
            .catch(error => console.error('Erreur lors du chargement du header:', error));
    } else {
        console.error('Element with id "header-container" not found.');
    }
});

function updateHeaderForLoginStatus() {
    const token = localStorage.getItem('authToken');
    const logoutButton = document.getElementById("logout-button");
    const mobileLogoutButton = document.getElementById("mobile-logout-button"); // Get the mobile logout button
    const userIcon = document.getElementById("user-icon");
    const openModalButton = document.getElementById("open-modal"); // Get the mobile login button
    const galerieLink = document.getElementById("galerie-link");
    const mobileGalerieLink = document.querySelector(".mobile-header .nav-link[href='galerie.html']"); // Get the mobile galerie link

    if (token) {
        logoutButton.style.display = "block";
        mobileLogoutButton.style.display = "block"; // Show the mobile logout button
        userIcon.style.display = "none";
        openModalButton.style.display = "none"; // Hide the mobile login button
        if (mobileGalerieLink) mobileGalerieLink.style.display = "block"; // Show the mobile galerie link

        // Si l'utilisateur est connecté et le lien vers la galerie n'existe pas encore, on l'ajoute
        if (!galerieLink) {
            const navLinks = document.getElementById("nav-links");
            const galerieTab = document.createElement("li");
            galerieTab.id = "galerie-link";
            galerieTab.innerHTML = '<a href="galerie.html">Galerie des scans</a>';
            navLinks.appendChild(galerieTab);
        }
    } else {
        logoutButton.style.display = "none";
        mobileLogoutButton.style.display = "none"; // Hide the mobile logout button
        userIcon.style.display = "block";
        openModalButton.style.display = "block"; // Show the mobile login button
        if (mobileGalerieLink) mobileGalerieLink.style.display = "none"; // Hide the mobile galerie link

        // Si l'utilisateur n'est pas connecté et le lien vers la galerie existe, on le supprime
        if (galerieLink) {
            galerieLink.remove();
        }
    }

    logoutButton.addEventListener("click", function() {
        localStorage.removeItem('authToken');
        window.location.href = 'acceuil.html';
    });

    // Add event listener for the mobile logout button
    mobileLogoutButton.addEventListener("click", function() {
        localStorage.removeItem('authToken');
        window.location.href = 'acceuil.html';
    });
}