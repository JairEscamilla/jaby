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
    if(result == "logged"){
        Swal.fire(
            'Jaby',
            'Haz iniciado sesión con éxito',
            'success'
        )
        window.location.href = "profile.php";
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Tus datos no coinciden'
        })
    }
}

function errorFunction(error, status){
    console.log("Ha ocurrido un error");   
}