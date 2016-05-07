<?php

namespace GSB\Model;


use GSB\GSB\Model;

class Product extends Model
{
    /**
     * Récupère dans la base de donnée la liste de tous les praticiens
     *
     * @return mixed (false si pas trouvé sinon les praticiens)
     */
    public function findAll ()
    {
        // Requête d'extraction de tous les praticiens
        $sql = "SELECT medicament.*, famille.libelle AS famille_libelle, composant.libelle AS composant_libelle, composition.quantite
                FROM medicament, famille, composant, composition
                WHERE famille_code = famille.code
                AND medicament.reference = composition.medicament_reference
                AND composant.id = composition.composant_id
                ORDER BY nom_commercial";

        $result = $this->db->query($sql);

        return $result->fetchAll();
    }
} 