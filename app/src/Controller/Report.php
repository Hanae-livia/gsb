<?php
namespace GSB\Controller;


use GSB\GSB\Controller;
use GSB\Model\Motif;
use GSB\Model\Product;
use GSB\Model\Report as ReportModel;
use GSB\Model\Practitioner;
use Slim\Http\Request;
use Slim\Http\Response;

class Report extends Controller{
    public function index (Request $request, Response $response, $args)
    {

        return $this->render($response, 'Report/report_list.twig');
    }

    public function formAdd (Request $request, Response $response, $args){
        $practitionerModel = new Practitioner($this->container);
        $practitioners = $practitionerModel->findAll();

        $motifModel = new Motif($this->container);
        $motifs = $motifModel->findAll();

        $productModel = new Product($this->container);
        $products = $productModel->findAll();

        return $this->render($response, 'Report/report_add.twig', [
            'practitioners' => $practitioners,
            'motifs' => $motifs,
            'products' => $products
        ]);
    }
} 