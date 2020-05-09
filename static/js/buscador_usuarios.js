function buscar(){
    var busqueda = $("#busqueda").val();
    $.ajax({ // Peticion AJAX para la validacion
        url: 'buscar_usuarios.php',
        dataType: 'html',
        type: 'POST',
        async: true,
        data: { busqueda: busqueda },
        success: successResponse,
        error: errorFunction
    });
    return false;
}

function successResponse(data, status){
    $(".usuarios-container").html("");
    $(".usuarios-container").html(data);
}

function errorFunction(error, status){
    console.log(error);
}