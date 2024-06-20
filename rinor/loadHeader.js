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
                    updateHeaderForLoginStatus();
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
    const mobileLogoutButton = document.getElementById("mobile-logout-button");
    const userIcon = document.getElementById("user-icon");
    const openModalButton = document.getElementById("open-modal");
    const galerieLink = document.getElementById("galerie-link");
    const mobileGalerieLink = document.querySelector(".mobile-header .nav-link[href='galerie.html']");

    if (token) {
        logoutButton.style.display = "block";
        mobileLogoutButton.style.display = "block";
        userIcon.style.display = "none";
        openModalButton.style.display = "none";
        if (mobileGalerieLink) mobileGalerieLink.style.display = "block";

        if (!galerieLink) {
            const navLinks = document.getElementById("nav-links");
            const galerieTab = document.createElement("li");
            galerieTab.id = "galerie-link";
            galerieTab.innerHTML = '<a href="galerie.html">Galerie des scans</a>';
            navLinks.appendChild(galerieTab);
        }
    } else {
        logoutButton.style.display = "none";
        mobileLogoutButton.style.display = "none";
        userIcon.style.display = "block";
        openModalButton.style.display = "block";
        if (mobileGalerieLink) mobileGalerieLink.style.display = "none";

        if (galerieLink) {
            galerieLink.remove();
        }
    }

    logoutButton.addEventListener("click", function() {
        localStorage.removeItem('authToken');
        window.location.href = 'acceuil.html';
    });

}