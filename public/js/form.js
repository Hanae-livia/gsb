$(document).ready(function() {
    $('.product-id').on('change', function () {
        if ($('.product-id').length < 2) {
            var $select = $(this).parent(),
                $newSelect = $select.clone(true);

            $select.after($newSelect);
        }
    });

    $('.sample-id').on('change', function () {
        if ($('.sample-id').length < 10) {
            var $select = $(this).parent(),
                $newSelect = $select.clone(true);

            $select.after($newSelect);
        }
    });
});
