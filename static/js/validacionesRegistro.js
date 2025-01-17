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

// Vamos a validar que solamente haya un unico username

function validaUsername(){
    var username =  document.registro.username.value; // Obtenemos el valor del username
    $.ajax({ // Peticion AJAX para la validacion
        url: 'validaUsername.php',
        dataType: 'html',
        type: 'POST',
        async: true,
        data: { username: username },
        success: successRespone,
        error: errorFunction
    });
}

// Funcion en caso de que sea exitosa la peticion AJAX
function successRespone(result, status){
    document.getElementById("lblUsername").innerHTML = ""; // Limpiamos el HTML del label
    document.getElementById("lblUsername").innerHTML = result; // Le asignamos el resultado al html de del label
    if (result == "Username")
        document.getElementById("sendButton").disabled = false;
    else
        document.getElementById("sendButton").disabled = true;
}

// Funcion en caso de que falle la peticion AJAX
function errorFunction(status, error){
    console.log("Ha ocurrido un error):"); // Imprimimos en consola el error
}

