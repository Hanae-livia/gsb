<?php

namespace GSB\Controller;

use GSB\GSB\Controller;
use GSB\GSB\Flash;
use GSB\GSB\Validator;
use Slim\Http\Request;
use Slim\Http\Response;

class Authentication extends Controller
{
    /**
     * Rend la vue correspondant à la page de connexion à l'application
     *
     * @param Request $request
     * @param Response $response
     *
     * @return \Slim\Http\Response
     */
    public function index (Request $request, Response $response)
    {
        // Tableau qui contient toutes les données dont la vue a besoin
        $data = [
            'params' => Flash::has('params') ? Flash::get('params') : [],
            'errors' => Flash::has('errors') ? Flash::get('errors') : []
        ];

        return $this->render($response, 'Authentication/login.twig', $data);
    }

    /**
     * Page de traitement du formulaire de connexion
     *
     * @param Request $request
     * @param Response $response
     *
     * @return \Slim\Http\Response
     * @throws \Exception
     */
    public function login (Request $request, Response $response)
    {
        $router = $this->container->get('router');

        // Doc Slim ==> $_POST
        $params = $request->getParams();
        $result = [];

        $validator = new Validator($params);

        $validator->addRules([
            'inputUser'     => [
                'required' => 'L\'identifiant est obligatoire'
            ],
            'inputPassword' => [
                'required' => 'Le mot de passe est obligatoire'
            ]
        ]);

        // Vérification de la validité du formulaire
        if ($validator->check()) {

        }
        else {
            $errors = $validator->getErrors();

            Flash::set('params', $params);
            Flash::set('errors', $errors);


            return $response->withRedirect($router->pathFor('login_page'));
//            $sql = "SELECT `identifiant`,`mot_de_passe` FROM `utilisateur` WHERE `identifiant`, `mot_de_passe`";
        }

        // Vérification des champs vide / pas vide
        // Si c'est bon : requete DB pour le chercher avec le where
//        return $response->withJson($result);
    }
}
