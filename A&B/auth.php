<?php
require('dbconnect.php');

session_start();

$admin = isset($_SESSION["admin"]) ? $_SESSION["admin"] : false;
$member = isset($_SESSION["login"]);

// Disconnect
if (isset($_GET["disconnect"]) && $_GET["disconnect"] == 1) {
    session_unset();
    session_destroy();
}

// Check credentials
if (isset($_POST['login'], $_POST["password"])) {
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
        $_SESSION['admin'] = $member['admin'] == 1;
    } else {
        // Authentication failed
        header("Location: error.php");
        exit();
    }

    $connexion = null;
}
?>