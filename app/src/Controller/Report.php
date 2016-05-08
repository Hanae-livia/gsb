<?php
namespace GSB\Controller;


use GSB\GSB\Controller;
use GSB\GSB\Flash;
use GSB\GSB\Validator;
use GSB\Model\Motif;
use GSB\Model\Practitioner;
use GSB\Model\Product;
use GSB\Model\Report as ReportModel;
use Slim\Http\Request;
use Slim\Http\Response;

class Report extends Controller
{
    /**
     * Retourne la vue qui permet de consulter les rapport saisis
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     *
     * @return Response
     */
    public function index (Request $request, Response $response, $args)
    {
        $reportModel = new ReportModel($this->container);
        $reports     = $reportModel->findAll();

        return $this->render($response, 'Report/report_list.twig', [
            'reports' => $reports
        ]);
    }

    /**
     * Récupère des données utiles à la vue du formulaire
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     *
     * @return Response
     * @throws \Exception
     */
    public function formAdd (Request $request, Response $response, $args)
    {
        $practitionerModel = new Practitioner($this->container);
        $practitioners     = $practitionerModel->findAllWithFields(['numero', 'nom', 'prenom'], ['nom', 'prenom']);

        $motifModel = new Motif($this->container);
        $motifs     = $motifModel->findAll();

        $productModel = new Product($this->container);
        $products     = $productModel->findAllWithFields(['reference', 'nom_commercial'], ['nom_commercial']);

        return $this->render($response, 'Report/report_add.twig', [
            'practitioners' => $practitioners,
            'motifs'        => $motifs,
            'products'      => $products
        ]);
    }

    /**
     * Insert un rapport de visite dans la bdd
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     *
     * @return Response
     * @throws \Exception
     */
    public function create (Request $request, Response $response, $args)
    {
        // Récupération du routeur pour la redirection
        $router = $this->container->get('router');
        $errors = [];
        $success = [];

        $params = $request->getParams(); // Données du formulaire

        // On vérifier la validité des champs
        $validator = new Validator($params);

        $validator->addRules([
            'practitioner_id' => [
                'required' => 'Le nom du praticien est obligatoire'
            ],
            'visit_date'      => [
                'required' => 'La date de la visite est obligatoire',
            ],
            'impact'          => [
                'required' => 'L\'impact de la visite est obligatoire'
            ],
            'motif_id'        => [
                'required' => 'Le motif de la visite est obligatoire'
            ],
            'product_ids'     => [
                'required' => 'Au moins un produit présenté est obligatoire'
            ]
        ]);

        // Si il n'y a pas d'erreurs on execute la requête d'insertion ...
        if ($validator->check()) {
            $reportModel = new ReportModel($this->container);
            $reports = $reportModel->insert($params);

            if ($reports) {
                $success = 'Le rapport de visite a bien été envoyé';
            }
            else {
                $errors = [
                    'global' => 'Une erreur est survenue lors de l\'exécution de la requête. Le rapport n\'a pas été envoyé'
                ];
            }
        }
        // .. sinon on récupère les erreurs
        else {
            $errors = $validator->getErrors();
        }

        Flash::set('success', $success);
        Flash::has('errors', $errors);

        // Redirection vers la page du formulaire
        return $response->withRedirect($router->pathFor('report_add'));
    }
}