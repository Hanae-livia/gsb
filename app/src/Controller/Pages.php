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

    // Bilan : saisie
    public function add(Request $request, Response $response, $args) {

        return $this->render($response, 'Report/report_add.twig');
    }

    // Bilan : historique
    public function result_hist(Request $request, Response $response, $args) {

        return $this->render($response, 'Report/report_list.twig');
    }

    // Produits
    public function catalog(Request $request, Response $response, $args) {

        return $this->render($response, 'Product/product_list.twig');
    }


}

