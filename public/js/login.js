$(document).ready(function () {
    // Vérification de la validité du formulaire
    $('#form_login').on('submit', function () {
        var username = $('#inputUser'),
            usernameGroup = username.parent(),
            password = $('#inputPassword'),
            passwordGroup = password.parent(),
            formGroup = $('.form-group');

        // Suppression des erreurs
        formGroup.removeClass('has-error');
        formGroup.prev('.alert').remove();

        if (username.val() === '') {
            usernameGroup.addClass('has-error');
            usernameGroup.before(
                $('<div />', {class: 'alert alert-danger', text: 'L\'identifiant est obligatoire'})
            );
        }
        if (password.val() === '') {
            passwordGroup.addClass('has-error');
            passwordGroup.before(
                $('<div />', {class: 'alert alert-danger', text: 'Le mot de passe est obligatoire'})
            );
        }

        return !!(username.val() !== '' && password.val() !== '');
    });

    // Gestion de la classe "has-error"
    $('.form-login').on('keypress', function () {
        var input = $(this),
            formGroup = input.parent();

        if (formGroup.hasClass('has-error')) {
            formGroup.removeClass('has-error');
            formGroup.prev().remove();

        }
    });
});