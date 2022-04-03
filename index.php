<?php
session_start();

include('./config/autoload.php');
include('./includes/connexion_bdd.php');


// Si aucune variable de session auth, on l'a crée à la valeur false
if (!isset($_SESSION['auth'])) {
  $_SESSION['auth'] = false;
}
// Gestion de la déconnexion
if (isset($_GET['deco'])) {
  $_SESSION['auth'] = false;
}

if ($_SESSION['auth'] == false) {
  header("location: ./signin.php");
}
include("./includes/header.php");
?>

<body>
  <?php
  include("./includes/nav.php");

  // récupération l'objet user en session pour le réutilisé
  $user = unserialize($_SESSION['user']);

  ?>
  <div class='container projects'>
    <h2>Bienvenue <?= $user->getPseudo(); ?></h2>
    <div class="overlay"></div>
  </div>

  <?php
  include("./includes/footer.php");
  ?>

</body>

</html>