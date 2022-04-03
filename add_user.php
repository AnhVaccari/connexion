<?php

include('./config/autoload.php');
include('./includes/connexion_bdd.php');

$db = connectDBS();

$UserDao = new UserDao($db);

$user = [
    'mail' => "titi@gmail.com",
    'pseudo' => htmlspecialchars("lili"),
    'password' => password_hash("klm", PASSWORD_DEFAULT)
];

$userNew = new User($user);

$UserDao->add($userNew);
