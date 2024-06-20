document.addEventListener("DOMContentLoaded", function() {
    const token = localStorage.getItem('authToken');

    if (!token) {
        alert('Vous devez vous connecter pour voir cette page.');
        return;
    }

    function loadImages() {
        const token = localStorage.getItem('authToken');
        console.log('Token used:', token);

        fetch(`http://localhost:8080/api/guesses?token`, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data && Array.isArray(data)) {
                const gallery = document.getElementById('scan-gallery');
                gallery.innerHTML = '';

                data.forEach(item => {
                    const scanItem = document.createElement('div');
                    scanItem.className = 'scan-item';

                    const img = document.createElement('img');
                    img.src = `http://localhost:8080${item.imagepath}`;
                    img.alt = `Scan ${item.id}`;

                    const scanInfo = document.createElement('div');
                    scanInfo.className = 'scan-info';
                    scanInfo.innerHTML = `
                        <p>Guess: ${item.guess}</p>
                        <p>Win: ${item.win}</p>
                        <p>Date: ${item.date}</p>
                    `;

                    scanItem.appendChild(img);
                    scanItem.appendChild(scanInfo);
                    gallery.appendChild(scanItem);
                });
            }
        })
        .catch(error => {
            console.error('Erreur lors du chargement des images:', error);
        });
    }

    loadImages();
});