$(document).ready(function () {
    // Gestion de l'affichage de mon compte
    $('#userspace').on('click', function () {
        event.preventDefault();

        var userspaceContent = $('#userspace-content');

        // Si mon compte est visible je le cache ...
        if (userspaceContent.is(':visible')) {
            userspaceContent.hide();
        }
        // ... sinon je l'affiche
        else {
            userspaceContent.show();
        }
    });
});