function invitar_usuario(id_album){
    Swal.fire({
        title: 'Ingresa el username que quieres invitar',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off',
        },
        showCancelButton: true,
        confirmButtonText: 'Invitar',
        showLoaderOnConfirm: true,
        preConfirm: (username) => {
            $.ajax({ // Peticion AJAX para la validacion
                url: 'invitar_usuario.php',
                dataType: 'html',
                type: 'POST',
                async: true,
                data: { username: username, id_album: id_album },
                success: successResponse,
                error: errorFunction
            });
            
        },
        allowOutsideClick: () => !Swal.isLoading()
    })
    return false;
}   

function successResponse(data, status){
    Swal.fire(data);
}

function errorFunction(error, status) {
    console.log(error);
}