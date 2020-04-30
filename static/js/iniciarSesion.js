function iniciarSesion(){
    var username = document.login.username.value;
    var password = document.login.password.value;
    $.ajax({ // Peticion AJAX para la validacion
        url: 'login.php',
        dataType: 'html',
        type: 'POST',
        async: true,
        data: { username: username, password: password },
        success: successRespone,
        error: errorFunction
    });
}

function successRespone(result, status){
    console.log(result);
}

function errorFunction(error, status){
    console.log("Ha ocurrido un error");   
}