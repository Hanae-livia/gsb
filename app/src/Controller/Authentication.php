<?php

namespace GSB\Controller;

class Authentication extends \GSB\GSB\Controller {

    public function index(\Slim\Http\Request $request, \Slim\Http\Response $response) {
        return $this->render($response, 'Authentication/login.twig');
    }

    public function login(\Slim\Http\Request $request, \Slim\Http\Response $response) {
        // Doc Slim ==> $_POST
        $params = $request->getParams();
        $result = [];

        $validator = new \GSB\GSB\Validator($request);

        $validator->addRules([
            'username' => 'notEmpty',
            'password' => 'notEmpty'
        ]);
        
        $validator->validate();
        
        
        
        // Vérification des champs vide / pas vide
        // Si c'est bon : requete DB pour le chercher avec le where
//        return $response->withJson($result);
    }

}
