$(document).ready(function () {
    // Graphe : données gloables (nbr visites, nbr echantillons & preoduits presente / mois)
    $.get('/dashboard/chart/global', function (data) {
        var globalChartOpts = {
                responsive: true,
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: data.datasets
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                stepSize: 1,
                                beginAtZero: true
                            }
                        }]
                    }
                }
            },
            ctx = $('#globalChart'),
            globalChart = new Chart(ctx, globalChartOpts);
    });

    // Graphe : evolution du taux d'impact
    $.get('/dashboard/chart/txImpact', function (data) {
        console.log(data);
        var txImpactChartOpts = {
                responsive: true,
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: data.datasets
                },
                options: {
                    'elements.point.radius' : 0,
                    scales: {
                        yAxes: [{
                            ticks: {
                                stepSize: 1,
                                max: 11,
                                beginAtZero: true
                            }
                        }]
                    }
                }
            },
            ctx = $('#txImpactChart'),
            txImpactChart = new Chart(ctx, txImpactChartOpts);
    });
});