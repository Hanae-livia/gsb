<?php

namespace GSB\Model;


use GSB\GSB\Model;

class Practitioner extends Model
{
    protected $table = 'praticien';

    /**
     * Récupère dans la base de données tous les praticiens
     *
     * @return mixed
     */
    public function findAll ()
    {
        // Requête d'extraction de tous les praticiens
        $sql = 'SELECT praticien.*, type.libelle AS type_libelle, specialite.libelle AS specialite_libelle
                FROM praticien, specialite, type
                WHERE specialite_id = specialite.id AND type_id = type.id
                ORDER BY nom, prenom';

        // Execution de la requête
        $result = $this->db->query($sql);

        return $result->fetchAll();
    }
} 