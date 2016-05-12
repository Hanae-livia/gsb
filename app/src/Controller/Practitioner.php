<?php
namespace GSB\Controller;

use GSB\GSB\Controller;
use GSB\Model\Practitioner as PractitionerModel;
use Slim\Http\Request;
use Slim\Http\Response;

class Practitioner extends Controller
{

    public function index (Request $request, Response $response, $args)
    {
        $practitionerModel = new PractitionerModel($this->container);

        // PAGINATION AUTOMATIQUE \\
        // On récupère le nombre de praticiens de la db
        $practitionerCount = $practitionerModel->count();

        // Déduction du nb de pages nécessaire
        $nbResultPerPage   = 10;
        $nbPage            = ceil($practitionerCount / $nbResultPerPage); // Nbr total de praticien divisé par le nb de résultats/page

        // Détermination du numéro de la page qui doit être affichée
        // Récupération du numéro de la page passé en Get
        $page              = $request->getQueryParam('page', 1);
        $page              = $page > $nbPage ? $nbPage : $page;

        // Récupération de la liste des praticiens dans la db
        // Avec une limite et un offset
        $limit  = $nbResultPerPage; // Plage de résultats
        $offset = ($page - 1) * $nbResultPerPage; // Première entrée à lire

        $practitioners = $practitionerModel->findAll($offset, $limit);

        return $this->render($response, 'Practitioner/practitioner_list.twig', [
            'practitioners' => $practitioners,
            'pagination'    => [
                'current'  => $page,
                'nbPage'   => $nbPage,
                'previous' => $page > 1,
                'next'     => $page < $nbPage
            ]
        ]);
    }
}
