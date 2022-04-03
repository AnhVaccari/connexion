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
  <h1>Liste des utilisateurs</h1>
  <br><br>

  <?php
  $userDao = new UserDao($db);
  if (isset($_POST["action_supprimer"])) {
    $userDao->delete($_POST['sup']);
  }
  $listUser = $userDao->getAll();

  ?>
  <table class="table">
    <thead class="thead">
      <tr>
        <th scope="col">Mail</th>
        <th scope="col">Pseudo</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>

      <?php
      // Boucle sur le tableau
      foreach ($listUser as $key => $value) {
      ?>
        <tr>
          <td><?= $value->getMail(); ?></td>
          <td><?= $value->getPseudo(); ?></td>
          <td class="d-flex">

            <form action="#" method="post">
              <input type="hidden" name="sup" value="<?= $value->getId(); ?>">
              <input type="hidden" name="action_supprimer" value="1">
              <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')" class="btn btn-danger">Suprimer</button>
            </form>

          </td>
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
  <?php
  // Gestion de la déconnexion
  if (isset($_GET['deco'])) {
    $_SESSION['auth'] = false;
  }
  if ($_SESSION['auth'] == false) {
    header("location: ./signin.php");
  }
  ?>

  <?php
  include("./includes/footer.php");
  ?>

</body>

</html>