<?php

namespace GSB\Controller;

class Pages extends \GSB\GSB\Controller {
    // Homepage
    public function index(\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        return $this->render($response, 'Pages/homepage.twig');
    }
    
    
}

