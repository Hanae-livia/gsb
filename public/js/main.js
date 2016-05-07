$(document).ready(function () {
    // Gestion de l'affichage de mon compte
    $('#accountBlock').on('click', function (e) {
        e.preventDefault();

        var accountView = $('#accountView');

        // Si mon compte a la classe open je l'enlève...
        if (accountView.hasClass('open')) {
            accountView.removeClass('open');
        }
        // ... sinon je l'a rajoute
        else {
            accountView.addClass('open');
        }
    });

    $('.view-content').on('click', function () {
        var accountView = $('#accountView');

        accountView.removeClass('open');
    });
});