<?php 

function chargerClasse($classe)
{
    require_once('./class/' .$classe. '.php');
}

spl_autoload_register('chargerClasse');


?>
