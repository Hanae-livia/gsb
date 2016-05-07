<?php

namespace GSB\Model;


use GSB\GSB\Model;

class Report extends Model
{
    /**
     * Récupère dans la base de donnée tous les comptes rendus saisis
     *
     * @return mixed (false si pas trouvé sinon les comptes rendus)
     */
    public function findAll ()
    {
        // Requête d'extraction des comptes rendus de visite
        $sql = "SELECT bilan.*, utilisateur.*, praticien.*, produit_presente.*, echantillon.*
                FROM bilan, utilisateur, praticien, produit_presente, echantillon
                WHERE utilisateur_matricule = utilisateur.matricule
                AND praticien_numero = praticien.numero
                AND bilan.numero = produit_presente.bilan_numero
                AND bilan.numero = echantillon.bilan_numero
                ORDER BY date_saisie";

        $result = $this->db->query($sql);

        return $result->fetchAll();
    }
} 