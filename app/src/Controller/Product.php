<?php
namespace GSB\Controller;


use GSB\GSB\Controller;
use GSB\Model\Product as ProductModel;
use Slim\Http\Request;
use Slim\Http\Response;

class Product extends Controller
{
    public function index (Request $request, Response $response, $args)
    {
        $product_model   = new ProductModel($this->container);
        $products_result = $product_model->findAll();
        $products        = [];

        foreach ($products_result as $product) {
            // Récupération du composant du produit en cours
            $composant = [
                'libelle'  => $product['composant_libelle'],
                'quantite' => $product['quantite']
            ];
            // Suppression du composant du produit en cours
            unset($product['composant_libelle']);
            unset($product['quantite']);

            // Si le produit existe déjà dans le tableau produits et qu'il a déjà des composants
            // on les récupère
            // sinon on laisse un tableau vide
            $product['composants'] = isset($products[$product['reference']]) && !empty($products[$product['reference']]['composants']) ? $products[$product['reference']]['composants'] : [];

            // Remplissage du tableau des composants
            $product['composants'][] = $composant;

            // Remplissage du tableau des produits
            $products[$product['reference']] = $product;
        }

        return $this->render($response, 'Product/product_list.twig', [
            'products' => $products
        ]);
    }
} 