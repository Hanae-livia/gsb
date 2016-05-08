<?php

namespace GSB\GSB;


class Model
{
    // Conteneur d'injection de dépendance
    protected $container;
    protected $db;


    /**
     * Stocke le container Slim dans le model
     *
     * @param $container
     */
    public function __construct ($container)
    {
        // Je stocke le conteneur d'injection de dépendance de Slim dans mon model
        $this->container = $container;
        $this->db        = $this->container->get('db');
    }

    /**
     * Récupère dans la bdd les occurences d'une table donnée
     * avec les champs donnés en paramètre
     *
     * @param array $fields Tableau contenant les champs que l'on souhaite séléctionner
     * @param array $orderBy
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function findAllWithFields ($fields = [], $orderBy = [])
    {
        // On vérifie que le model est bien relié à une table
        if (empty($this->table)) {
            throw new \Exception('Table not define in model');
        }

        // Si aucun champs n'est défini on selectionne tous les champs
        if (empty($fields)) {
            $fields = '*';
        }
        // ... sinon on rassemble les éléments du tableau $fields en une chaine de caractère
        else {
            $fields = implode(', ', $fields);
        }

        $orderBySql = '';
        if (!empty($orderBy)) {
            $orderBySql = 'ORDER BY ' . implode(', ', $orderBy);
        }

        // Requête d'extraction de tous les praticiens
        $sql = 'SELECT ' . $fields . '
                FROM ' . $this->table . '
                ' . $orderBySql;

        // Execution de la requête
        $result = $this->db->query($sql);

        return $result->fetchAll();
    }
} 