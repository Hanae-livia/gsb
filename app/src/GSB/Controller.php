<?php

namespace GSB\GSB;


class Controller {
    // Conteneur d'injection de dépendance
    protected $container;
    
    // Contient des infos globales (user...)
    protected $global_data = [];


    /**
     * Stocke le container Slim dans le controller
     * 
     * @param type $container
     */
    public function __construct ($container) {
        // Je stocke le conteneur d'injection de dépendance de Slim dans mon controller
        $this->container = $container;
        
//        $this->global_data['user'] = 'Toto';
    }
    
    /**
     * Rend une vue avec des infos globales
     * 
     * @return type
     */
    public function render (\Slim\Http\Response $response, $filename, $data = []) {
        $data = array_replace_recursive($this->global_data, $data);
        return $this->container->view->render($response, $filename, $data);
    }
}
