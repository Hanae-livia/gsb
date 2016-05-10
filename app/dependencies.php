<?php

$container = $app->getContainer();

// Ajout d'un obj view dans le container (ici obj Twig)
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig($c->get('settings')['view']['template_path'], [
        'cache' => $c->get('settings')['view']['twig']['cache']
    ]);
    
    // Ajout extension Twig à l'obj view
    $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $c['request']->getUri()));
    $view->addExtension(new Twig_Extension_Debug());
    
    return $view;
};

 $container['db'] = function ($c) {
     // Récupération dans une variable du tableau DB de l'objet settings
     $settings = $c->get('settings')['db'];
     
     // Connexion à la base de données
     $dsn = $settings['driver'] . ':dbname=' . $settings['dbname'] . ';host=' . $settings['host'] . ';charset=' . $settings['charset'];
     $pdo = new PDO($dsn, $settings['username'], $settings['password']);
     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
     return $pdo;
 };