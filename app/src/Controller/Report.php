<?php
namespace GSB\Controller;


use GSB\GSB\Controller;
use GSB\Model\Report as ReportModel;
use Slim\Http\Request;
use Slim\Http\Response;

class Report extends Controller{
    public function index (Request $request, Response $response, $args)
    {

        return $this->render($response, 'Report/report_add.twig');
    }
} 