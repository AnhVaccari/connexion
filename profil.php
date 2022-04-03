<?php
session_start();

include('./config/autoload.php');
include('./includes/connexion_bdd.php');
$db = connectDBS();

include("./includes/header.php");
?>

<body>
  <?php
  include("./includes/nav.php");
  ?>
  <?php

  // Récupération de l'objet user en session
  $User = unserialize($_SESSION['user']);
  $errorForm = "";
  $errorMail = "";
  $errorMdp = "";
  $user = new User();

  // Si le formulaire est envoyé
  if (isset($_POST["mail"])) {
    // Si les champs mail et pseudo ne sont pas vide
    if ($_POST["mail"] != "" && $_POST["pseudo"] != "") {
      $userDao = new UserDao($db);

      // Si le champ mail est valide
      if (filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
        // on stock le pseudo dans $user
        $user->setPseudo($_POST["pseudo"]);
        // Si les mots de passe ne sont pas vides
        if ($_POST["password"] != "" && $_POST["passwordConfirm"] != "") {
          //Si les mots de passe correspondent
          if ($_POST["password"] == $_POST["passwordConfirm"]) {
            // on stock le mot de passe dans $user
            $user->setPassword(password_hash($_POST["password"], PASSWORD_DEFAULT));
            // Sinon
          } else {
            // on stock un message d'erreur
            $errorMdp = "Les mots de passe ne correspondent pas";
            //fin si
          }
          // Sinon
        } else {
          // on stock le mot de passe de session dans $user
          $user->setPassword($User->getPassword());
          //fin si
        }

        if ($_POST['mail'] == $User->getMail()) {
          $user->setMail($User->getMail());
        } else {
          $userExiste = $userDao->getBymail($_POST['mail']);
          if ($userExiste) {
            $errorMail = "Mail déjà existant";
          } else {
            $user->setMail($_POST['mail']);
          }
        }
        //sinon
      } else {
        $errorMail = "Mail invalide";
        //fin si
      }

      if ($errorMail == "") {
        $user->setId($User->getId());
        $userDao->update($user);
        $_SESSION['user'] = serialize($user);
        header("location: ./index.php");
        exit;
      }
      //sinon
    } else {
      //on stock un message d'erreur
      $errorForm = "Veuillez remplir tous les champs";
    }
  }
  // Gestion de la déconnexion
  if (isset($_GET['deco'])) {
    $_SESSION['auth'] = false;
  }
  if ($_SESSION['auth'] == false) {
    header("location: ./signin.php");
  }
  ?>
  <h1>Votre profil </h1>

  <form action="#" method="POST">
    <div class="form-group">
      <label for="mail">Adresse mail</label>
      <input type="email" class="form-control" id="mail" name="mail" value="<?= $User->getMail(); ?>">
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
      <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= $User->getPseudo(); ?>">
    </div>

    <div class="form-group">
      <label for="password">Mot de passe </label>
      <input type="password" class="form-control" id="password" name="password">
    </div>

    <div class="form-group">
      <label for="passwordConfirm">Mot de passe 2</label>
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
    <button type="submit" class="btn btn-dark">Enregister</button>
  </form>

  <?php
  include("./includes/footer.php");
  ?>

</body>

</html>