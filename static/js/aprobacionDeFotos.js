function aprobar(id_foto){
    $.ajax({ // Peticion AJAX para la validacion
        url: 'aprobar.php',
        dataType: 'html',
        type: 'POST',
        async: true,
        data: { foto: id_foto },
        success: aprobacionExitosa,
        error: errorFunction
    });
    return false;
}


function aprobacionExitosa(result, status){
    console.log(result);
    // Mostramos mensaje de exito y desaparecemos con un slideup el elemento que coincida con el id
    Swal.fire(
        'Se ha aprobado una nueva foto',
        '',
        'success'
    )
    $("#"+result).slideUp();
}

function errorFunction(status, error){
    console.log("Ha ocurrido un error");
}