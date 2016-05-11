<?php

namespace GSB\Controller;


use GSB\GSB\Controller;
use GSB\Model\Report;
use Slim\Http\Request;
use Slim\Http\Response;

class Chart extends Controller
{
    /**
     * Récupère les données à transmettre au graphe
     * qui affiche les données globales
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function globalStats (Request $request, Response $response)
    {
        $report_model = new Report($this->container);

        $report_count = $report_model->countGroupByMonth();
        $pp_count     = $report_model->countProductGroupByMonth();
        $eo_count     = $report_model->countSampleGroupByMonth();

        $months = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jui', 'Jui', 'Aou', 'Sep', 'Oct', 'Déc'];

        $data_count    = [];
        $data_pp_count = [];
        $date_eo_count = [];

        foreach ($months as $key => $month) {
            $data_count[$key]    = 0;
            $data_pp_count[$key] = 0;
            $data_eo_count[$key] = 0;

            //
            foreach ($report_count as $count) {
                if ($count['month'] - 1 === $key) {
                    $data_count[$key] = (int)$count['total'];
                }
            }

            foreach ($pp_count as $count) {
                if ($count['month'] - 1 === $key) {
                    $data_pp_count[$key] = (int)$count['total'];
                }
            }

            foreach ($eo_count as $count) {
                if ($count['month'] - 1 === $key) {
                    $data_eo_count[$key] = (int)$count['total'];
                }
            }
        }

        $datasets = [
            ['label' => 'Nb visites', 'backgroundColor' => '#1ABB9C', 'data' => $data_count],
            ['label' => 'Nb produits présentés', 'backgroundColor' => '#3498DB', 'data' => $data_pp_count],
            ['label' => 'Nb échantillons offerts', 'backgroundColor' => '#9b59b6', 'data' => $data_eo_count]
        ];

        return $response->withJson([
            'labels'   => $months,
            'datasets' => $datasets
        ]);
    }

    /**
     * Récupère les données à transmettre au graphe
     * qui affiche l'évolution du taux d'impact
     *
     * @param Request $request
     * @param Response $response
     *
     * @return \Slim\Http\Response
     */
    public function txImpactStats (Request $request, Response $response)
    {
        $reportModel   = new Report($this->container);
        $moyImpactUser = $reportModel->calcTxImpactGroupByMonth();
        $moyImpactAll  = $reportModel->calcMoyImpactAllGroupByMonth();

        $months = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jui', 'Jui', 'Aou', 'Sep', 'Oct', 'Déc'];

        // Création d'un tableau des données utiles aux graphes
        $data_ImpactUser = [];
        $data_ImpactAll = [];

        // Association de la valeur de la moyenne du tx impact à chaque mois correspondant
        foreach ($months as $key => $month) {
            // Initialisation de la moyenne à 0 pour chaque mois
            $data_ImpactUser[$key] = 0;
            $data_ImpactAll[$key] = 0;

            // Parcours du résultat de la requête pour un utilisateur
            foreach ($moyImpactUser as $moyenne) {
                // Si le mois correspond au mois du tableau months on affecte la valeur
                if ($moyenne['month'] - 1 === $key) {
                    $data_ImpactUser[$key] = (int)$moyenne['moyImpact'];
                }
            }

            // Parcours du résultat de la requête pour tous les utilisateurs
            foreach ($moyImpactAll as $moyenne) {
                // Si le mois correspond au mois du tableau months on affecte la valeur
                if ($moyenne['month'] - 1 === $key) {
                    $data_ImpactAll[$key] = (int)$moyenne['moyImpact'];
                }
            }
        }

        $datasets = [
            [
                'label'           => 'Votre moyenne taux d\'impact',
                'fill'            => false,
                'lineTension'     => 0,
                'borderJoinStyle' => 'miter',
                'borderColor'     => '#2A3F54',
                'backgroundColor' => '#2A3F54',
                'data'            => $data_ImpactUser
            ],
            [
                'label'           => 'Moyenne taux d\'impact de tous les visiteurs',
                'fill'            => false,
                'lineTension'     => 0,
                'borderJoinStyle' => 'miter',
                'borderColor'     => '#3498DB',
                'backgroundColor' => '#3498DB',
                'data'            => $data_ImpactAll
            ],
        ];

        return $response->withJson([
            'labels'   => $months,
            'datasets' => $datasets
        ]);

    }
}