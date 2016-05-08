<?php

namespace GSB\Model;


use GSB\GSB\Model;

class Motif extends Model{
    /**
     * Récupère dans la bdd tous les motifs
     *
     * @return mixed
     */
    public function findAll () {
        $sql = 'SELECT * FROM motif ORDER BY libelle';
        $result = $this->db->query($sql);

        return $result->fetchAll();
    }
} 