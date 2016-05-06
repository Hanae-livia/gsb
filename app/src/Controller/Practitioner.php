<?php
namespace GSB\Controller;

use GSB\GSB\Controller;
use GSB\Model\Practitioner as PractitionerModel;
use Slim\Http\Request;
use Slim\Http\Response;

class Practitioner extends Controller {

    public function index (Request $request, Response $response, $args) {
        $practitioner_model = new PractitionerModel($this->container);
        $practitioners = $practitioner_model->findAll();

        return $this->render($response, 'Practitioner/practitioner_list.twig', [
            'practitioners' => $practitioners
        ]);
    }
}
