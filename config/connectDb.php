<?php 

//Constantes pour la base de donnees
    const DBS_HOST = 'localhost';
    const DBS_BASE = 'user';
    const DBS_USER = 'root';
    const DBS_PASS = '';
 
    function connectDBS() {
        //Connexion à la base
        try {
            $bdd = new PDO('mysql:host='. DBS_HOST .';
                dbname='. DBS_BASE . 
                    ';charset=utf8',
                    DBS_USER, DBS_PASS,
                    array(PDO::ATTR_ERRMODE =>
                    PDO::ERRMODE_EXCEPTION));
                    return $bdd;
                } 
                catch (PDOException $err) {
            $msg = 'ERREUR PDO dans ' . $err->getFile() . 
                ' L.' . $err->getLine() . ' : ' . 
                $err->getMessage();
            die($msg);        
        }
    }
