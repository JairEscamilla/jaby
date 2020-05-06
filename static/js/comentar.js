function comentar(id_foto){
    var comentario = document.getElementById(id_foto).value;
    if(comentario.length == 0)
        return;
    $.ajax({ // Peticion AJAX para la validacion
        url: 'comentar.php',
        foto: id_foto,
        dataType: 'html',
        type: 'POST',
        async: true,
        data: { id_foto: id_foto, comentario: comentario },
        success: function(data, status){
            successResponse(data, status, this.foto);
        },
        error: errorFunction
    });
    $(".input-comment").val("");
    return false;
}

function successResponse(response, status, foto){
    $("#"+foto+"-container").append(response);
}

function errorFunction(error, status) {
    console.log(error);
}