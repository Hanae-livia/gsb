<?php

namespace GSB\Controller;

use GSB\GSB\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

class Pages extends Controller {
    // Homepage
    public function index(Request $request, Response $response, $args) {

        return $this->render($response, 'Pages/homepage.twig');
    }
}

