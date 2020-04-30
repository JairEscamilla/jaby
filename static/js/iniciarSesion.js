function iniciarSesion(){
    // Obtenemos los valores del formulario
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
    if(result == "logged"){
        window.location.href = "profile.php"; // En caso de logearse con exito, redireccionamos al perfil del usuario
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Tus datos no coinciden' // En caso de que no haya coincidencias, mostramos error
        })
    }
}

function errorFunction(error, status){ // Desplegamos el error de conexion
    console.log("Ha ocurrido un error");   
}