<?php
/**
 * Ensemble des routes dont l'application a besoin
 */

// Page contenant le formulaire de connexion à l'application
$app->get('/', 'GSB\Controller\Authentication:index')->setName('login_page');

// Page de traitement du formulaire de connexion
$app->post('/login', 'GSB\Controller\Authentication:login')->setName('login');

// Déconnexion
$app->get('/logout', 'GSB\Controller\Authentication:logout')->setName('logout');

/**
 * Création des routes préfixées par /dashboard
 * Ajouter le middleware Slim pour vérifier que la session utilisateur existe avant d'afficher la route
 * sinon rediriger vers login
 */
$app->group('/dashboard', function () {
    // Homepage
    $this->get('', 'GSB\Controller\Pages:index')->setName('homepage');

    // Graph
    $this->group('/chart', function () {
        $this->get('/global', 'GSB\Controller\Chart:globalStats');
        $this->get('/txImpact', 'GSB\Controller\Chart:txImpactStats');
    });

    // Bilan : saisie
    $this->get('/saisie-rapport', 'GSB\Controller\Report:formAdd')->setName('report_add');

    // Bilan : traitement
    $this->post('/ajout-rapport', 'GSB\Controller\Report:create')->setName('report_create');

    // Bilan : consultation
    $this->get('/consultation-rapports', 'GSB\Controller\Report:index')->setName('report_list');

    // Bilan : view
    $this->get('/rapport/{report_id}', 'GSB\Controller\Report:view')->setName('report_view');

    // Catalogue médicaments
    $this->get('/consultation-produits', 'GSB\Controller\Product:index')->setName('product_list');

    // Praticiens
    $this->get('/consultation-praticiens', 'GSB\Controller\Practitioner:index')->setName('practitioner_list');

    // Documentation
    $this->get('/documentation', 'GSB\Controller\Documentation:index')->setName('documentation');

})->add(function (\Slim\Http\Request $request, \Slim\Http\Response $response, $next) {
    if (empty($_SESSION['user'])) {
        return $response->withRedirect($this->get('router')->pathFor('login_page'));
    }

    // Si le user est connecté la route est appelée
    // $next = prochain middleware ou route si il n'y en a pas
    $response = $next($request, $response);

    return $response;
});
