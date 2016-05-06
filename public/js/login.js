$(document).ready(function() {
    $('#form_login').on('submit', function() {
        var username = $('#inputUser'),
            password = $('#inputPassword');

        if (username.val() === '') {
            username.parent().addClass('has-error');
        }
        if (password.val() === '') {
            password.parent().addClass('has-error');
        }

        if (username.val() !== '' && password.val() !== '') {
            return true;
        }

        return false;
    })

});