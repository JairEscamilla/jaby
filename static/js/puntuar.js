$(document).ready(function(){
    $.ajax({ // Peticion AJAX para la validacion
        url: 'mostrar_estrellas.php',
        dataType: 'html',
        type: 'POST',
        async: true,
        data: {},
        success: mostrarEstrellas,
        error: errorFunction
    });
});

$(':radio').change(function () {
    var separar = this.value.split("/");
    var puntuacion = separar[0];
    var id_foto = separar[1];
    
    $.ajax({ // Peticion AJAX para la validacion
        url: 'puntuar.php',
        dataType: 'html',
        type: 'POST',
        async: true,
        data: { puntuacion: puntuacion, id_foto: id_foto },
        success: successResponse,
        error: errorFunction
    });
    
});

function successResponse(data, status){
    console.log(data);   
}

function errorFunction(error, status){
    console.log(error);
}

function mostrarEstrellas(data, status){
    var calificaciones = JSON.parse(data);
    for(var i = 0; i < calificaciones.length; i++){
        var calificacion = calificaciones[i];
        var identificador = "radio"+ calificacion['calificacion'] + "-" + calificacion['id_foto'];
        console.log(identificador);
        document.getElementById(identificador).checked = true;
    }
    
    
}
