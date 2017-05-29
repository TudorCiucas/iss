$(function () {
    $("#btn_login").click(function () {
        login();
        return false;
    });
    $("#btn_register").click(function () {
        register();
        return false;
    });
});

/**
 * executa procedura de login
 */
function login() {
    $.ajax({
        url: 'auth.ajax.php',
        type: 'post',
        dataType: 'json',
        data: {
            op: 'login',
            email: $('#email').val(),
            password: $('#password').val()
        },
        success: function (r) {
            if (r.status === 'ok') {
                document.location = '/home.php';
            } else {
                alert(r.message);
            }
        }
    });
}

function register() {
    $.ajax({
        url: 'auth.ajax.php',
        type: 'post',
        dataType: 'json',
        data: {
            op: 'register',
            formData: $('#register').serialize()
        },
        success: function (r) {
            if (r.status === 'ok') {
                alert(r.message);
                document.location = '/';
            } else {
                alert(r.message);
            }
        }
    });
}