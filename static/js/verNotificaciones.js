function verNotificacion(id_notificacion){
    
    $.ajax({ // Peticion AJAX para ver las notificaciones
        url: 'ver_notificacion.php',
        dataType: 'html',
        type: 'POST',
        async: true,
        data: { id_notificacion: id_notificacion },
        success: successRespone1,
        error: errorFunction
    });
    return false;
}

function successRespone1(response, status){
    $("#"+response).slideUp();
    
}

function errorFunction(error, status){
    console.log(error);
}