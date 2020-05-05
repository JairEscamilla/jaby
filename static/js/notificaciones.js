$(document).ready(function(){
    $.ajax({ // Peticion AJAX para la validacion
        url: '../users/notificaciones.php',
        dataType: 'html',
        type: 'POST',
        async: true,
        data: {},
        success: successRespone,
        error: errorFunction
    });
});

function successRespone(response, status){
    $(".badge-light").html(response);
}

function errorFunction(error, status){
    console.log("Error");
    
}