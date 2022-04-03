<?php
session_start();

include('./config/autoload.php');
include('./includes/connexion_bdd.php');
$db = connectDBS();

include("./includes/header.php");
?>

<body>
  <h1>Enregistrement</h1>

  <?php
  include("./includes/nav.php");

  $errorForm = "";
  $errorMail = "";
  $errorMdp = "";

  if (isset($_POST['mail'])) { // Si le formulaire est envoyé
    if ($_POST['mail'] != "" && $_POST['password'] != "" && $_POST['passwordConfirm'] != "" && $_POST['pseudo'] != "") { // Si tous les champs sont remplis
      $mailValid = true;

      // Si l'adrresse mail n'est pas valide
      if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        // on passe la variable"$mailValid" à "false"
        $mailValid = false;
        // on stock "Mailinvalid" dans la variable qui gère les erreurs de mail
        $errorMail = "Mail invalide";
      }

      if ($mailValid) {
        if ($_POST['password'] == $_POST['passwordConfirm']) { // Si les mots de passe correspondent aux nouveaux mots de passe
          // Enregistrement de l'utilisateur
          $user = [
            "mail" => $_POST['mail'],
            "password" => password_hash($_POST['password'], PASSWORD_DEFAULT),
            "pseudo" => htmlspecialchars($_POST['pseudo'])
          ];

          $userNew = new User($user);
          $userDao = new UserDao($db);
          $userDao->add($userNew);

          header("location: ./index.php"); // Redirection vers index.php

        } else {
          $errorMdp = "Les mots de passe ne correspondent pas";
        }
      }
    } else {
      $errorForm = "Veuillez remplir tous les champs";
    }
  }
  ?>

  <?php
  if ($errorForm != "") {
  ?>
    <div class="alert alert-danger" role="alert">
      <?= $errorForm; ?>
    </div>
  <?php
  }
  ?>

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
      <label for="pseudo">Pseudo</label>
      <input type="text" class="form-control" id="pseudo" name="pseudo">
    </div>

    <div class="form-group">
      <label for="password">Mot de passe </label>
      <input type="password" class="form-control" id="password" name="password">
    </div>

    <div class="form-group">
      <label for="passwordConfirm">Confirmation<br>mot de passe</label>
      <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm">
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
    <button type="submit" class="btn btn-dark">Enregistrer</button>
  </form>

  <?php
  include("./includes/footer.php");
  ?>

</body>

</html>