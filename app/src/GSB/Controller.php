<?php

namespace GSB\GSB;


use Slim\Http\Response;

class Controller
{
    // Conteneur d'injection de dépendance
    protected $container;

    // Contient des infos globales (user...)
    protected $global_data = [];


    /**
     * Stocke le container Slim dans le controller
     *
     * @param $container
     */
    public function __construct ($container)
    {
        // Je stocke le conteneur d'injection de dépendance de Slim dans mon controller
        $this->container = $container;
    }

    /**
     * Rend une vue avec des infos globales
     *
     * @param Response $response
     * @param $filename
     * @param array $data
     *
     * @return Response
     */
    public function render (Response $response, $filename, $data = [])
    {
        // Si l'utilisateur est connecté on passe user à la vue
        if (isset ($_SESSION['user'])) {
            $this->global_data['user'] = $_SESSION['user'];
        }

        // Fusionne les global_data avec les data du controller fils
        $data = array_replace_recursive($this->global_data, $data);

        return $this->container->view->render($response, $filename, $data);
    }
}
