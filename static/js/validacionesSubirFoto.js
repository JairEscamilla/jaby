function validate(){
    if (document.formulario.file.value.length == 0 || document.formulario.albumes.value.length == 0){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes llenar todos los campos'
        })
        return false;
    }
    return true;
}