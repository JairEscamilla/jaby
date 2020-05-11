function validate(){
    var form = document.nuevo;
    // Validamos los campos al momento de crear un album
    if (form.nombre.value.length == 0 || form.tema.value.length == 0 || form.descripcion.value.length == 0){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Todos los campos deben ser llenados'
        })
        return false;
    }

    return true;
}