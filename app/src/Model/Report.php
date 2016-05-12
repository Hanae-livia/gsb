<?php

namespace GSB\Model;


use GSB\GSB\Model;

class Report extends Model
{
    /**
     * Récupère dans la base de donnée le rapport
     *
     * @param $id
     *
     * @return mixed (false si pas trouvé sinon le rapport)
     */
    public function findOne ($id)
    {
        $userMatricule = $_SESSION['user']['matricule'];

        // Requête d'extraction des comptes rendus de visite
        $sql = 'SELECT
                  bilan.*,
                  praticien.nom,
                  praticien.prenom,
                  praticien.coef_notoriete,
                  praticien.adresse,
                  praticien.cp,
                  praticien.ville,
                  motif.libelle AS motif,
                  m1.reference AS pp_reference,
                  m1.nom_commercial AS pp_nom,
                  m2.reference AS eo_reference,
                  m2.nom_commercial AS eo_nom
                FROM bilan
                  INNER JOIN praticien ON bilan.praticien_numero = praticien.numero
                  INNER JOIN motif ON bilan.motif_id = motif.id
                  LEFT JOIN produit_presente ON bilan.numero = produit_presente.bilan_numero
                  LEFT JOIN medicament AS m1 ON produit_presente.medicament_reference = m1.reference
                  LEFT JOIN echantillon ON bilan.numero = echantillon.bilan_numero
                  LEFT JOIN medicament AS m2 ON echantillon.medicament_reference = m2.reference
                WHERE bilan.numero = ' . $id . '
                      AND bilan.utilisateur_matricule = ' . $userMatricule;

        $result = $this->db->query($sql);

        return $result ? $result->fetchAll() : [];
    }

    /**
     * Récupère dans la bdd les raports selon l'utilisateur connecté
     *
     * @param int $limit
     * @param int $offset
     *
     * @return mixed
     */
    public function findAll ($limit = 10, $offset = 0)
    {
        $userMatricule = $_SESSION['user']['matricule'];

        // Requête d'extraction des comptes rendus de visite
        $sql = 'SELECT bilan.numero, bilan.date_visite, praticien.nom, praticien.prenom, motif.libelle
                FROM bilan, utilisateur, praticien, motif
                WHERE utilisateur_matricule = utilisateur.matricule
                AND praticien_numero = praticien.numero
                AND bilan.motif_id = motif.id
                AND utilisateur.matricule = ' . $userMatricule . '
                ORDER BY date_saisie
                LIMIT ' . $offset . ', ' . $limit;

        $result = $this->db->query($sql);

        return $result ? $result->fetchAll() : [];
    }

    /**
     * Récupère dans la bdd les raports selon l'utilisateur connecté
     * Seulement les trois plus récents
     *
     * @internal param int $limit
     * @internal param int $offset
     *
     * @return mixed
     */
    public function findRecent ()
    {
        $userMatricule = $_SESSION['user']['matricule'];

        // Requête d'extraction des comptes rendus de visite
        $sql = 'SELECT bilan.numero, bilan.date_visite, bilan.date_saisie, praticien.nom, praticien.prenom, motif.libelle
                FROM bilan, utilisateur, praticien, motif
                WHERE utilisateur_matricule = utilisateur.matricule
                AND praticien_numero = praticien.numero
                AND bilan.motif_id = motif.id
                AND utilisateur.matricule = ' . $userMatricule . '
                ORDER BY date_saisie
                LIMIT 5';

        $result = $this->db->query($sql);

        return $result ? $result->fetchAll() : [];
    }

    /**
     * Retourne le nombre de rapport de l'utilisateur
     *
     * @return int
     */
    public function count ()
    {
        $userMatricule = $_SESSION['user']['matricule'];

        // Requête d'extraction des comptes rendus de visite
        $sql = 'SELECT COUNT(*) AS total
                FROM bilan
                WHERE utilisateur_matricule = ' . $userMatricule;

        $query  = $this->db->query($sql);
        $result = $query ? $query->fetch() : ['total' => 0];

        return (int)$result['total'];
    }

    /**
     * Insert dans la bdd un bilan
     *
     * @param $params
     */
    public function insert ($params)
    {
        // Requête avec des paramètres (:nom) ou marqueurs (?) pour lesquels les valeurs réelles seront substituées
        // lorsque la requête sera exécutée
        $sql = 'INSERT INTO `bilan` (`date_visite`, `date_saisie`, `impact`, `remarque`, `utilisateur_matricule`, `praticien_numero`, `motif_id`, `remplacant`)
                VALUES (:date_visite, :date_saisie, :impact, :remarque, :utilisateur_matricule, :praticien_numero, :motif_id, :remplacant)';

        // Préparation de la requête : récupère la requête  et sait qu'il doit remplacer ...
        $query = $this->db->prepare($sql);

        // Execution de la requête avec les valeurs protégées des paramètres
        $result = $query->execute([
            ':date_visite'           => $params['visit_date'],
            ':date_saisie'           => date('Y-m-d'),
            ':impact'                => $params['impact'],
            ':remarque'              => $params['comment'],
            ':utilisateur_matricule' => $_SESSION['user']['matricule'],
            ':praticien_numero'      => $params['practitioner_id'],
            ':motif_id'              => $params['motif_id'],
            ':remplacant'            => isset($params['remplacant']) ? $params['remplacant'] : 0
        ]);


        // Si le bilan est crée on lui attache les produits présentés
        if ($result) {
            $reportId    = $this->db->lastInsertId();
            $productsSql = [];
            $products    = [];

            // Construction de la requête
            foreach ($params['product_ids'] as $key => $product_id) {
                if (!empty($product_id) && !isset($productsSql[$product_id])) {
                    $productsSql[$product_id]                 = '(:bilan_numero' . $key . ', :medicament_reference' . $key . ')';
                    $products[':bilan_numero' . $key]         = $reportId;
                    $products[':medicament_reference' . $key] = $product_id;
                }
            }

            $sqlProducts = 'INSERT INTO produit_presente
                    VALUES ' . implode(', ', $productsSql);

            $queryProducts = $this->db->prepare($sqlProducts);

            $resultProducts = $queryProducts->execute($products);

            // Si les produits présentés son bien rattachés au bilan et que des échantillons ont été donnés
            if ($resultProducts && !empty($params['sample_ids'])) {
                $sampleSql = [];
                $samples   = [];

                // Construction de la requête
                foreach ($params['sample_ids'] as $key => $sample_id) {
                    if (!empty($sample_id) && !isset($sampleSql[$sample_id])) {
                        $sampleSql[$sample_id]                   = '(:bilan_numero' . $key . ', :medicament_reference' . $key . ')';
                        $samples[':bilan_numero' . $key]         = $reportId;
                        $samples[':medicament_reference' . $key] = $sample_id;
                    }
                }

                $sqlSamples = 'INSERT INTO echantillon
                    VALUES ' . implode(', ', $sampleSql);

                $querySamples = $this->db->prepare($sqlSamples);

                $resultSamples = $querySamples->execute($samples);
            }

            return $reportId;
        }

        return $result;
    }

    /**
     * Retourne le nombre de visite effectuées par mois
     *
     * @return array
     */
    public function countGroupByMonth ()
    {
        $userMatricule = $_SESSION['user']['matricule'];

        // Requête d'extraction du nombre de visite par mois
        $sql = 'SELECT MONTH(date_visite) AS month, COUNT(*) AS total
                FROM bilan
                WHERE utilisateur_matricule = ' . $userMatricule . '
                GROUP BY MONTH(date_visite)
                ORDER BY date_visite';

        $result = $this->db->query($sql);

        return $result ? $result->fetchAll() : [];
    }

    /**
     * Retourne le nombre de produits présentés par mois
     *
     * @return array
     */
    public function countProductGroupByMonth ()
    {
        $userMatricule = $_SESSION['user']['matricule'];

        // Requête d'extraction du nombre de produits présentés par mois
        $sql = 'SELECT MONTH(date_visite) AS month, COUNT(*) AS total
                FROM bilan
                LEFT JOIN produit_presente ON bilan.numero = produit_presente.bilan_numero
                WHERE utilisateur_matricule = ' . $userMatricule . '
                GROUP BY MONTH(date_visite)
                ORDER BY date_visite';

        $result = $this->db->query($sql);

        return $result ? $result->fetchAll() : [];
    }

    /**
     * Retourne le nombre d'échantillons offerts par mois
     *
     * @return array
     */
    public function countSampleGroupByMonth ()
    {
        $userMatricule = $_SESSION['user']['matricule'];

        // Requête d'extraction du nombre d'echantillons offerts par mois
        $sql = 'SELECT MONTH(date_visite) AS month, COUNT(*) AS total
                FROM bilan
                LEFT JOIN echantillon ON bilan.numero = echantillon.bilan_numero
                WHERE utilisateur_matricule = ' . $userMatricule . '
                GROUP BY MONTH(date_visite)
                ORDER BY date_visite';

        $result = $this->db->query($sql);

        return $result ? $result->fetchAll() : [];
    }

    /**
     * Retourne la moyenne de la valeur du tx d'impact par mois
     *
     * @return array
     */
    public function calcTxImpactGroupByMonth ()
    {
        $userMatricule = $_SESSION['user']['matricule'];

        $sql = 'SELECT MONTH(date_visite) AS month, ROUND(AVG(impact)) AS moyImpact
                FROM bilan
                WHERE utilisateur_matricule = ' . $userMatricule . '
                GROUP BY MONTH(date_visite)
                ORDER BY date_visite';

        $result = $this->db->query($sql);

        return $result ? $result->fetchAll() : [];
    }

    /**
     * Retourne la moyenne de la valeur du tx d'impact par mois
     * de tous les visiteurs
     *
     * @return array
     */
    public function calcMoyImpactAllGroupByMonth ()
    {
        $sql = 'SELECT MONTH(date_visite) AS month, ROUND(AVG(impact)) AS moyImpact
                FROM bilan
                GROUP BY MONTH(date_visite)
                ORDER BY date_visite';

        $result = $this->db->query($sql);

        return $result ? $result->fetchAll() : [];
    }
} 