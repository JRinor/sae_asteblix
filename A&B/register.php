<?php
require('header.php');
require('auth.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // TODO: Add your registration logic here
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>S'inscrire</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/login-register/register.css">
</head>

<body>
<div class="container-fluid">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-6">
            <h2>S'inscrire</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <input type="text" name="login" id="login" class="form-control" placeholder="Identifiant" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
                </div>
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </form>
            <p class="mt-3">Vous avez déjà un compte ? <a href="login.php">Se connecter</a></p>
        </div>
    </div>
</div>
</body>

</html>