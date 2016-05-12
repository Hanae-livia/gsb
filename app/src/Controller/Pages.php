<?php

namespace GSB\Controller;

use GSB\GSB\Controller;
use GSB\Model\Practitioner;
use GSB\Model\Report;
use Slim\Http\Request;
use Slim\Http\Response;

class Pages extends Controller
{
    // Homepage
    public function index (Request $request, Response $response, $args)
    {
        $reportModel = new Report($this->container);
        $reportData  = $reportModel->findRecent();

        $practitionerModel = new Practitioner($this->container);
        $practitionerData  = $practitionerModel->findOrderByNotoriete();

        return $this->render($response, 'Pages/homepage.twig', [
            'reports'       => $reportData,
            'practitioners' => $practitionerData
        ]);
    }

    // Bilan : saisie
    public function add (Request $request, Response $response, $args)
    {

        return $this->render($response, 'Report/report_add.twig');
    }

    // Bilan : historique
    public function result_hist (Request $request, Response $response, $args)
    {

        return $this->render($response, 'Report/report_list.twig');
    }

    // Produits
    public function catalog (Request $request, Response $response, $args)
    {

        return $this->render($response, 'Product/product_list.twig');
    }
}

