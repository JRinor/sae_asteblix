<!-- Connexion à la base de données -->
<?php
define('USER', "app_user");
define('PASSWD', "t3rceS");
define('SERVER', "localhost");
define('BASE', "toutatix");

function dbconnect()
{
  $dsn = "mysql:dbname=" . BASE . ";host=" . SERVER;
  try {
    $connexion = new PDO($dsn, USER, PASSWD);
    $connexion->exec("set names utf8");
  } catch (PDOException $e) {
    printf("Échec de la connexion: %s\n", $e->getMessage());
    exit();
  }
  return $connexion;
}
?>