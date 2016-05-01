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

} 