<?php

namespace GSB\Model;


use GSB\GSB\Model;

class User extends Model
{
    /**
     * Récupère dans la base de donnée un utilisateur
     * selon un identifiant et un mot de passe donné
     *
     * @param $username
     * @param $password
     *
     * @return mixed (false si pas trouvé sinon le user)
     */
    public function findUserByUsernameAndPassword ($username, $password)
    {
        // Requête avec des paramètres (:nom) ou marqueurs (?) pour lesquels les valeurs réelles seront substituées
        // lorsque la requête sera exécutée
        $sql = "SELECT * FROM utilisateur WHERE identifiant = :username AND mot_de_passe = :password;";

        // Préparation de la requête : récupère la requête  et sait qu'il doit remplacer ...
        $query = $this->db->prepare($sql);

        // Execution de la requête avec les valeurs protégées des paramètres
        $query->execute([':username' => $username, ':password' => sha1($password)]);

        return $query->fetch();
    }
} 