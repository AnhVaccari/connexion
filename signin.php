<?php
session_start();

include('./config/autoload.php');
include('./includes/connexion_bdd.php');
$db = connectDBS();

include("./includes/header.php");

// Déclarations des variables d'erreur
$errorForm = "";
$errorMail = "";
$errorMdp = "";

if (isset($_POST['mail'])) { // Si le formulaire est envoyé
  if ($_POST['mail'] != "" && $_POST['password'] != "") { // Si tous les champs sont remplis

    $errorMail = "";
    $userDao = new UserDao($db);
    $user = $userDao->getBymail($_POST['mail']);

    if ($user) {
      if (password_verify($_POST['password'], $user->getPassword())) {
        $_SESSION['auth'] = true; // On passe la variable de session auth à true

        $_SESSION['user'] = serialize($user);
        header("location: ./index.php"); // Redirection vers index.php
      } else {
        $errorMdp = "Mauvais mot de passe";
      }
    } else {
      $errorMail = "Aucun mail correspondant";
    }
  } else {
    $errorForm = "Veuillez remplir tous les champs";
  }
}
?>

<body>
  <?php
  if ($errorForm != "") {
  ?>
    <div class="alert alert-danger" role="alert">
      <?= $errorForm; ?>
    </div>
  <?php
  }
  ?>
  <h1>Connexion</h1>

  <form action="#" method="POST">
    <div class="form-group">
      <label for="mail">Adresse mail</label>
      <input type="email" class="form-control" id="mail" name="mail">
    </div>

    <?php
    if ($errorMail != "") {
    ?>
      <div class="alert alert-danger" role="alert">
        <?= $errorMail; ?>
      </div>
    <?php
    }
    ?>

    <div class="form-group">
      <label for="password">Mot de passe</label>
      <input type="password" class="form-control" id="password" name="password">
    </div>

    <?php
    if ($errorMdp != "") {
    ?>
      <div class="alert alert-danger" role="alert">
        <?= $errorMdp; ?>
      </div>
    <?php
    }
    ?>
    <button type="submit" class="btn-two">Connexion</button>
  </form>
  <br>
  <p>Pas de compte <a href="./signup.php">Inscrivez-vous</a></p>

  <?php
  include("./includes/footer.php");
  ?>

</body>

</html>