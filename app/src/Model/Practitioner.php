<?php

namespace GSB\Model;


use GSB\GSB\Model;

class Practitioner extends Model
{
    protected $table = 'praticien';

    /**
     * Retourne le nombre de praticiens existants dans la bdd
     *
     * @return int
     */
    public function count ()
    {
        // Requête d'extraction des comptes rendus de visite
        $sql = 'SELECT COUNT(*) AS total
                FROM praticien';

        $query  = $this->db->query($sql);
        $result = $query ? $query->fetch() : ['total' => 0];

        return (int)$result['total'];
    }

    /**
     * Récupère dans la base de données tous les praticiens
     *
     * @param $limit
     * @param $offset
     *
     * @return mixed
     */
    public function findAll ($offset, $limit)
    {
        // Requête d'extraction de tous les praticiens
        $sql = 'SELECT praticien.*, type.libelle AS type_libelle, specialite.libelle AS specialite_libelle
                FROM praticien, specialite, type
                WHERE specialite_id = specialite.id AND type_id = type.id
                ORDER BY nom, prenom
                LIMIT ' . $offset . ', ' . $limit;

        // Execution de la requête
        $result = $this->db->query($sql);

        return $result->fetchAll();
    }

    /**
     * Récupère dans la bdd tous les praticiens
     * Ordonnés par coefficient de notoriété
     *
     * @return mixed
     */
    public function findOrderByNotoriete ()
    {
        $sql = 'SELECT praticien.*
                FROM praticien
                ORDER BY coef_notoriete DESC
                LIMIT 5';

        $result = $this->db->query($sql);

        return $result->fetchAll();
    }


} 