<?php
namespace GSB\Controller;


use GSB\GSB\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

class Documentation extends Controller
{
    /**
     * Rend la vue correspondant à la page de documentation
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     *
     * @return \Slim\Http\Response
     */
    public function index (Request $request, Response $response, $args)
    {
        return $this->render($response, 'Documentation/documentation.twig');
    }
} 