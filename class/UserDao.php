<?php

/**
 * \class UserDao UserDao.php"class/UserDao.php"
 * \file  UsserDao.php
 * \author
 * \version 1.0
 * \date 28/06/2021
 * \brief Class de requête des utilisateurs
 * 
 * details Classe des requête des utilisateurs. Elle définit les accès à la base de données
 */
class UserDao
{
    private $_db; // Instance de PDO

    /**
     * Constructeur de la classe
     *
     * @param PDO $db
     */
    public function __construct($db)
    {
        $this->setDb($db);
    }

    /**
     * Set the value of _db
     *
     * @return  self
     */
    public function setDb(PDO $db)
    {
        $this->_db = $db;

        return $this;
    }

    public function add(User $user)
    {
        $q = $this->_db->prepare('INSERT INTO user (mail, pseudo, password)
            VALUES (:mail, :pseudo, :password)');
        $q->bindValue(':mail', $user->getMail(), PDO::PARAM_STR);
        $q->bindValue(':pseudo', $user->getPseudo(), PDO::PARAM_STR);
        $q->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);

        $q->execute();
    }

    public function update(User $user)
    {
        $q = $this->_db->prepare('UPDATE user 
            SET mail = :mail, pseudo = :pseudo, password = :password
            WHERE id = :id');
        $q->bindValue(':mail', $user->getMail(), PDO::PARAM_STR);
        $q->bindValue(':pseudo', $user->getPseudo(), PDO::PARAM_STR);
        $q->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
        $q->bindValue(':id', $user->getId(), PDO::PARAM_INT);

        $q->execute();
    }

    public function delete(INT $id)
    {
        $this->_db->exec('DELETE FROM user WHERE id = ' . $id);
    }

    public function get($id)
    {
        $id = (int) $id;
        $q = $this->_db->query('SELECT * FROM user WHERE id = ' . $id);

        return $q->fetchObject(User::class);
    }

    public function getAll()
    {
        $q = $this->_db->query('SELECT * FROM user');

        return $q->fetchAll(PDO::FETCH_CLASS, User::class);
    }

    public function getBymail($mail)
    {

        $q = $this->_db->query("SELECT * FROM user WHERE mail = '" . $mail . "'");

        return $q->fetchObject(User::class);
    }
}
