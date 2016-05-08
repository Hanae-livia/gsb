<?php

namespace GSB\Controller;

use GSB\GSB\Controller;
use GSB\GSB\Flash;
use GSB\GSB\Validator;
use GSB\Model\User;
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
        // Si l'utilisateur est déjà connecté redirection vers le dashboard
        if (!empty($_SESSION['user'])) {
            return $response->withRedirect($this->container->get('router')->pathFor('homepage'));
        }

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
        // On récupère le routeur pour pouvoir rediriger
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
            $user_model = new User($this->container);
            $user       = $user_model->findUserByUsernameAndPassword($params['inputUser'], $params['inputPassword']);

            if ($user) {
                // Destructin du mot de passe (sécurité)
                unset ($user['mot_de_passe']);

                // Récupération des informations relative à l'utilisateur connecté
                // dans la session
                $_SESSION['user'] = $user;

                // Redirection
                return $response->withRedirect($router->pathFor('homepage'));
            }
            else {
                $errors = [
                    'global' => 'Identifiants incorrects'
                ];
            }
        }
        else {
            $errors = $validator->getErrors();
        }

        Flash::set('params', $params);
        Flash::set('errors', $errors);

        return $response->withRedirect($router->pathFor('login_page'));

    }

    /**
     * Déconnecte l'utilisateur de l'application
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function logout (Request $request, Response $response) {
        $router = $this->container->get('router');

        session_destroy();

        return $response->withRedirect($router->pathFor('login_page'));
    }
}
