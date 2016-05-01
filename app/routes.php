<?php
/**
 * Ensemble des routes dont l'application a besoin
 */

// Page contenant le formulaire de connexion à l'application
$app->get('/', 'GSB\Controller\Authentication:index')->setName('login_page');

// Page de traitement du formulaire de connexion
$app->post('/login', 'GSB\Controller\Authentication:login')->setName('login');

/**
 * Création des routes préfixées par /dashboard
 * Ajouter le middleware Slim pour vérifier que la session utilisateur existe avant d'afficher la route
 * sinon rediriger vers login
 */
$app->group('/dashboard', function () {
    $this->get('', 'GSB\Controller\Pages:index')->setName('homepage');
})->add(function (\Slim\Http\Request $request, \Slim\Http\Response $response, $next) {
    if (empty($_SESSION['user'])) {
        return $response->withRedirect($this->get('router')->pathFor('login_page'));
    }

    // Si le user est connecté la route est appelée
    // $next = prochain middleware ou route si il n'y en a pas
    $response = $next($request, $response);

    return $response;
});
