<?php
require('auth.php');
?>

<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<html>


<head>
    <title>Astéblix</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/header.css">

    <script>
        function disconnect() {
            window.location.href = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" + '?disconnect=1';
        }
    </script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark d-none d-lg-flex align-items-center" style="background-color: #173753;">
    <a class="navbar-brand" href="#"><img src="img/logo.png" height="60"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="scan.php">Scan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="gdscans.php">Galerie des scans</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle fa-2x"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="login.php">Se connecter</a>
                    <a class="dropdown-item" href="register.php">S'inscrire</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<nav class="navbar navbar-dark d-block d-lg-none" style="background-color: #173753;">
    <div class="d-flex justify-content-between w-100 align-items-center">
        <a class="navbar-brand" href="#"><img src="img/logo.png" height="80"></a>
        <a class="nav-link" href="#" onclick="authenticate();"><i class="fas fa-user-circle fa-2x"></i></a>
    </div>
</nav>

<nav class="navbar fixed-bottom navbar-light bg-light d-block d-lg-none">
    <div class="d-flex justify-content-around w-100">
        <a class="nav-link" href="index.php"><i class="fas fa-home fa-2x"></i></a>
        <a class="nav-link" href="scan.php"><i class="fas fa-camera fa-2x"></i></a>
        <a class="nav-link" href="gdscans.php"><i class="fas fa-images fa-2x"></i></a>
    </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>