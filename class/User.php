<?php

/**
 * \class User User.php"class/User.php"
 * \file   User.php
 * \author
 * \version 1.0
 * \date 28/06/2021
 * \brief Classe des utilisateurs
 * \todo Reste pleine de chose à faire
 * 
 * \ détails Classe des utilisateurs  Elle définit les attributs et les méthodes utilisés des utilisateurs
 */
class User
{
        /**
         * Identifiant de l'utilisateur
         *
         * @var number
         */
        private $id;/*!< id de l'utilisateur*/
        private $mail;/*!< mail de l'utilisateur*/
        private $pseudo;/*!< pseudo de l'utilisateur*/
        private $password;/*!< password de l'utilisateur*/

        /**
         * Constructeur de la classe
         *
         * @param array $valeurs
         * Tableau associatif issu d'une reqête SQL
         */
        public function __construct($valeurs = array())
        {
                foreach ($valeurs as $key => $value) {
                        // On récupère dynamiquement le nom du setter correspondant à l'attribut.
                        $method = 'set' . ucfirst($key);
                        // Si le setter correspondant existe.
                        if (method_exists($this, $method)) { // On appelle le setter dynamiquement.
                                $this->$method($value);
                        }
                }
        }

        /**
         * Get the value of id
         */
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @param string $id
         * @return  self
         */
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of mail
         */
        public function getMail()
        {
                return $this->mail;
        }

        /**
         * Set the value of mail
         *
         * @param string $mail
         * @return  self
         */
        public function setMail($mail)
        {
                $this->mail = $mail;

                return $this;
        }

        /**
         * Get the value of pseudo
         */
        public function getPseudo()
        {
                return $this->pseudo;
        }

        /**
         * Set the value of pseudo
         *
         * @param string $pseudo
         * @return  self
         */
        public function setPseudo($pseudo)
        {
                $this->pseudo = $pseudo;

                return $this;
        }

        /**
         * Get the value of password
         */
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @param string $password
         * @return  self
         */
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }
}
