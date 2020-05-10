$(document).ready(function () {
    $.ajax({ // Peticion AJAX para obtener las notificaciones de los usuarios
        url: 'users/notificaciones.php',
        dataType: 'html',
        type: 'POST',
        async: true,
        data: {},
        success: successRespone,
        error: errorFunction
    });
});

function successRespone(response, status) {
    $(".badge-light").html(response);
    if (response == "0") {
        $(".badge-light").html("");
    }
}

function errorFunction(error, status) {
    console.log("Error");

}