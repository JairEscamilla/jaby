$(document).ready(function(){ // Esta funcion se ejecutará cada vez que cargue el archivo
    // Obtenemos la fecha actual
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    year = year - 15;
    // En caso de estar en dias o meses entre 1 y 9, se le agrega un 0 al dia o al mes
    if (day < 10) 
        day = '0' + day;
    if (month < 10) 
        month = '0' + month;
    date = year + '-' + month + '-' + day;
    document.registro.fecnac.value = date; // Le asignamos el valor de la fecha al input
    document.registro.fecnac.max = date; // Asignamos un valor maximo a la fecha
});

function validate(){ // Función de validacion de datos
    var form = document.registro;
    var elementosLetras = [form.nombre, form.apPat, form.apMat]; // Arreglo de los elementos que solamente pueden contener letras
    var labels = ["Nombre", "Apellido paterno", "Apellido materno"];
    var counter = 0; 
    var retorno = true; // Valor de retorno de la función

    /*
        Validamos que los campos no estén vacíos
    */
    if(form.username.value.length == 0 || form.password.value.length == 0 || form.email.value.length == 0 || form.nombre.value.length == 0 || form.apPat.value.length == 0  || form.apMat.value.length == 0 || form.escolaridad.value.length == 0 || form.direccion.value.length == 0){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Alguno de los campos está vacío):',
        })
        retorno = false;
    }

    // Para cada elemento del arreglo de elementos, recorremos
    elementosLetras.forEach(element => {
        var cadena = element.value;
        for(var i = 0; i < cadena.length; i++){ // En caso de que el valor de algunos de los elementos contenga números, disparamos un mensaje de error
            if(cadena.charAt(i) >= '0' && cadena.charAt(i) <= '9'){
                Swal.fire({
                    icon: 'error',
                    title: labels[counter],
                    text: 'Este campo solo puede contener caracteres alfabéticos):',
                })
                retorno = false;
            }
        }
        counter++;
    });
    return retorno;
}

