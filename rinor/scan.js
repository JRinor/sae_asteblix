function triggerFileInput() {
    document.getElementById("fileInput").click();
}

function displayImage(event) {
    const imagePreview = document.getElementById("imagePreview");
    imagePreview.innerHTML = "";

    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function (e) {
        const img = document.createElement("img");
        img.src = e.target.result;
        img.classList.add("img-fluid", "mt-3", "row", "mx-auto");
        img.style.maxHeight = "400px";

        const button = document.createElement("button");
        button.textContent = "Lancer le scan";
        button.classList.add("btn", "btn-primary", "mt-3", "row");

        button.onclick = function () {
            localStorage.setItem("guessimage", img.src);
            scanImage(file);
        };

        imagePreview.appendChild(img);
        imagePreview.appendChild(button);
        imagePreview.scrollIntoView({ behavior: "smooth", block: "end" });
    };

    reader.readAsDataURL(file);
}

function openCamera() {
    const cameraModal = document.getElementById("cameraModal");
    cameraModal.style.display = "block";

    const video = document.getElementById("camera");
    navigator.mediaDevices
        .getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
        })
        .catch((err) => {
            console.error("Erreur d'accès à la caméra:", err);
        });

    const captureButton = document.getElementById("captureButton");
    captureButton.onclick = function () {
        const canvas = document.createElement("canvas");
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const context = canvas.getContext("2d");
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageURL = canvas.toDataURL("image/png");

        const imagePreview = document.getElementById("imagePreview");
        imagePreview.innerHTML = "";

        const img = document.createElement("img");
        img.src = imageURL;
        img.classList.add("img-fluid", "mt-3");
        img.style.maxHeight = "400px";

        const button = document.createElement("button");
        button.textContent = "Lancer le scan";
        button.classList.add("btn", "btn-primary", "mt-3");
        button.onclick = function () {
            fetch(imageURL)
                .then((res) => res.blob())
                .then((blob) => {
                    localStorage.setItem("guessimage", img.src);
                    scanImage(new File([blob], 'guessimage.png', { type: blob.type }));
                });
        };

        imagePreview.appendChild(img);
        imagePreview.appendChild(button);

        closeCamera();
    };
}

function closeCamera() {
    const cameraModal = document.getElementById("cameraModal");
    cameraModal.style.display = "none";

    const video = document.getElementById("camera");
    const stream = video.srcObject;
    const tracks = stream.getTracks();
    tracks.forEach((track) => track.stop());
    video.srcObject = null;
}

function scanImage(file) {
    const formData = new FormData();
    formData.append("guessimage", file);

    fetch("http://localhost:8080/api/guesses", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            const params = new URLSearchParams({
                imageUrl: URL.createObjectURL(file),
                guess: data.guess,
                guessId: data.id,
            });

            window.location.href = `resultat.html?${params.toString()}`;
        })
        .catch((error) => {
            console.error("Erreur lors du scan:", error);
        });
}
