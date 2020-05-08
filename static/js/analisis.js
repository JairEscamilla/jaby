function analisis(opcion){
    $.ajax({ // Peticion AJAX para la validacion
        url: '../analisis/analisis.php',
        dataType: 'html',
        type: 'POST',
        async: true,
        data: { opcion: opcion },
        success: successResponse,
        error: errorFunction
    });
    return false;
}


function successResponse(data, status){
    console.log(data);
    $(".busquedas").html(data);
}

function errorFunction(error, status){
    console.log(error);   
}
