function buscador(){
    var busqueda = document.formulario.searcher.value;
    var filtroBusqueda = document.formulario.options.value;
    // Dependiendo del fiktro de busqueda, nos vamos a dirigir a diferentes archivos 
    if (filtroBusqueda == "fecha" || filtroBusqueda == "todos"){
        var separarFechas = busqueda.split("/");
        var date1 = separarFechas[0];
        var date2 = separarFechas[1];
        $.ajax({ // Peticion AJAX para la validacion
            url: 'buscador.php',
            dataType: 'html',
            type: 'POST',
            async: true,
            data: { busqueda: busqueda, filtroBusqueda: filtroBusqueda, date1: date1, date2: date2 },
            success: successResponse,
            error: errorFunction
        });
        return;
    }
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
    console.log(response);
    // Cambiamos los titulos de los elementos
    if(response.length == 0)
        $("#albumesTitle").html("No hemos encontrado un resultado para tú búsqueda):");
    else
        $("#albumesTitle").html("Álbum(es)");
    $(".busquedas").html(response);
}

function errorFunction(error, status){
    console.log(error);
}