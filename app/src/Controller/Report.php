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
        $reportModel     = new ReportModel($this->container);
        $reportCount     = $reportModel->count();
        $page            = $request->getQueryParam('page', 1);
        $nbResultPerPage = 2;
        $nbPage          = ceil($reportCount / $nbResultPerPage);
        $page            = $page > $nbPage ? $nbPage : $page;

        $limit  = $nbResultPerPage;
        $offset = ($page - 1) * $nbResultPerPage;

        $reports = $reportModel->findAll($limit, $offset);

        return $this->render($response, 'Report/report_list.twig', [
            'reports'    => $reports,
            'pagination' => [
                'current'  => $page,
                'nbPage'   => $nbPage,
                'previous' => $page > 1,
                'next'     => $page < $nbPage
            ]
        ]);
    }

    /**
     * Retourne une vue correspond au bilan donnée en paramètre
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     *
     * @return Response
     */
    public function view (Request $request, Response $response, $args)
    {
        $reportModel    = new ReportModel($this->container);
        $reports_result = $reportModel->findOne($args['report_id']);
        $report         = [];

        // Reconstruction du tableau résultat
        foreach ($reports_result as $current_report) {
            // Creation du produit presente
            $product = [
                'reference'      => $current_report['pp_reference'],
                'nom_commercial' => $current_report['pp_nom']
            ];
            // Creation de l'echantillon
            $sample = [
                'reference'      => $current_report['eo_reference'],
                'nom_commercial' => $current_report['eo_nom']
            ];

            // Suppression des champs inutiles correspondant aux medicament precedemment cree
            unset($current_report['pp_reference']);
            unset($current_report['pp_nom']);
            unset($current_report['eo_reference']);
            unset($current_report['eo_nom']);

            // Initialisation des 2 tableaux de medicaments
            $current_report['products'] = !empty($report['products']) ? $report['products'] : [];
            $current_report['samples']  = !empty($report['samples']) ? $report['samples'] : [];

            // Ajout des 2 medicaments precedents dans le rapport
            // indexe avec la reference du medicament pour eviter les doublons
            $current_report['products'][$product['reference']] = $product;
            $current_report['samples'][$sample['reference']]  = $sample;

            // Ajout du rapport reconstruit dans le rapport a retourner a la vue
            $report = $current_report;
        }

        return $this->render($response, 'Report/report_view.twig', [
            'report' => $report
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
        $router  = $this->container->get('router');
        $errors  = [];
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
            $reports     = $reportModel->insert($params);

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