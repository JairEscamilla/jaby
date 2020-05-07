function buscador(){
    var busqueda = document.formulario.searcher.value;
    var filtroBusqueda = document.formulario.options.value;
    $.ajax({ // Peticion AJAX para la validacion
        url: 'buscador.php',
        dataType: 'html',
        type: 'POST',
        async: true,
        data: { busqueda: busqueda, filtroBusqueda: filtroBusqueda },
        success: successResponse,
        error: errorFunction
    });

}

function successResponse(response, status){
    $(".busquedas").html("");

    if(response.length == 0)
        $("#albumesTitle").html("No hemos encontrado un resultado para tú búsqueda):");
    else
        $("#albumesTitle").html("Álbum(es)");
    $(".busquedas").html(response);
}

function errorFunction(error, status){
    console.log(error);
}