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


$("#analisis-meses").change(function(){
    peticion_mes_anio();
});

$("#anio").change(function(){
    peticion_mes_anio();
});

function peticion_mes_anio(){
    var mes = $("#analisis-meses").val();
    var anio = $("#anio").val();

    $.ajax({ // Peticion AJAX para la validacion
        url: '../analisis/analisis.php',
        dataType: 'html',
        type: 'POST',
        async: true,
        data: { opcion: 7, mes: mes, anio: anio },
        success: successResponse,
        error: errorFunction
    });
}