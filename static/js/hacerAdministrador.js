function hacerAdministrador(){
    console.log("Administrador");
    Swal.fire({
        title: 'Ingresa el username que quieres hacer administrador',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off',
        },
        showCancelButton: true,
        confirmButtonText: 'Hacer administrador',
        showLoaderOnConfirm: true,
        preConfirm: (username) => {
            $.ajax({ // Peticion AJAX para que invitemos a un usuario en cuanto se presione el boton de invitar
                url: '../users/hacer_admin.php',
                dataType: 'html',
                type: 'POST',
                async: true,
                data: { username: username },
                success: success,
                error: errorFunction
            });

        },
        allowOutsideClick: () => !Swal.isLoading()
    })
    return false;
}

function success(data, status){
    Swal.fire(data);
}

function errorFunction(error, status){
    console.log(error);
    
}