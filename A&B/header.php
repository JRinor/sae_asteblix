<!-- header -->
<?php
require('dbconnect.php');


session_start();



//check disconnect
if (isset($_GET["disconnect"])) {
    if ($_GET["disconnect"] == 1) {
        $_SESSION["admin"] = false;
        unset($_SESSION["login"]);
        unset($_SESSION["admin"]);
    }
}

//check credentiels
if (isset($_POST['login'])) {
    if (isset($_POST["password"])) {
        $connexion = dbconnect();

        // Query Prepare
        $sql = "SELECT * FROM members WHERE login = :login";
        $query = $connexion->prepare($sql);
        $query->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
        $query->execute();
        $member = $query->fetch();

        if ($member && password_verify($_POST['password'], $member['password'])) {
            // Authentication successful
            $_SESSION['login'] = $member['login'];
            $_SESSION['admin'] = $member['admin'] == 1 ? true : false;
        } else {
            // Authentication failed
            echo "Identifiants incorrects";
        }

        $connexion = null;
    }
}

$admin = false;
$member = false;

if (isset($_SESSION["login"])) {
    $member = true;
    if (isset($_SESSION["admin"])) {
        $admin = $_SESSION["admin"];
    }
}

?>

<html>

<head>
    <title>Astéblix</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Rounded+Mplus+1c:wght@400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/headerCSS.css">

    <script>
        /**
         * Fonction qui gère l'authentification : 
         */
        function authenticate() {
            // Affiche le formulaire qui a pour id : loginModal.

            let modal = document.getElementById('loginModal');
            modal.style.display = 'block';
        }

        function disconnect() {
            window.location.href = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" + '?disconnect=1';
        }
    </script>


</head>

<body>
    <div class="navbar">
        <ul>
            <li class="brandlogo cursor-pointer"><img height="80" src="img/logo.png"></li>
            <?php
                ?>
                <li style="float:right; margin-right: 30;"><a href="#" onclick="authenticate();"><img height="50"
                            src="img/login.png"></a></li>
                <?php
            ?>
            <div class="textheader">
                <li><a href="index.php" class="link cursor-pointer">Accueil</a></li>
                <?php if (!$member): ?>
                <?php endif; ?>
                <li><a href="scan.php" class="link cursor-pointer">Scan</a></li>
                <li><a href="gdscans.php" class="link cursor-pointer">Galerie des scans</a></li>
            </div>
        </ul>
    </div>


    <div id="loginModal" class="modal">

        <form id="loginForm" class="modal-content animate"
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="dlgheadcontainer">
            <img src="img/logonoir.png" alt="Logo" class="logoco">
                <span onclick="document.getElementById('loginModal').style.display='none'" class="close"
                    title="Close Modal">&times;</span> 

            </div>

            <div class="dlgcontainer">
                
                <input type="text" placeholder="IDENTIFIANT" name="login" id="login" required>
                <input type="password" placeholder="MOT DE PASSE" name="password" id="password" required>

                <button type="submit" class="okbtn">Se connecter</button>

            </div>

        </form>
    </div>
</body>