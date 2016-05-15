$(document).ready(function() {
    // Duplication du champs .product-id
    $('.product-id').on('change', function () {
        // Si le nbr d'élement ayant la classe product-id est inférieur à 2
        if ($('.product-id').length < 2) {
            var $select = $(this).parent(),
                $newSelect = $select.clone(true);

            $select.after($newSelect);
        }
    });

    // Duplication du champs .sample-id
    $('.sample-id').on('change', function () {
        // Si le nbr d'élement ayant la classe sample-id est inférieur à 10
        if ($('.sample-id').length < 10) {
            var $select = $(this).parent(),
                $newSelect = $select.clone(true);

            $select.after($newSelect);
        }
    });

    // Confirmation de réinitialisation
    $('#btn-reset').on('click', function() {
       var result = confirm('Etes-vous sûr de vouloir réinitilaiser le forumulaire ?');

        // Si l'utilisateur réinitialise le formulaire, suppression des champs de produits dupliqués
        if (result) {
            $('.sample-id').first().parent().nextAll().remove();
            $('.product-id').first().parent().nextAll().remove();
        }
    });
});
