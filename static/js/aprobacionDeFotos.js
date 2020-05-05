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