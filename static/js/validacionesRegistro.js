$(document).ready(function(){
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    year = year - 15;
    if (day < 10) 
        day = '0' + day;
    if (month < 10) 
        month = '0' + month;
    date = year + '-' + month + '-' + day;
    document.registro.fecnac.value = date;
    document.registro.fecnac.max = date;
});

function validate(){
    var form = document.registro;
    var elementosLetras = [form.nombre, form.apPat, form.apMat];
    var labels = ["Nombre", "Apellido paterno", "Apellido materno"];
    var counter = 0;
    var retorno = true;
    if(form.username.value.length == 0 || form.password.value.length == 0 || form.email.value.length == 0 || form.nombre.value.length == 0 || form.apPat.value.length == 0  || form.apMat.value.length == 0 || form.escolaridad.value.length == 0 || form.direccion.value.length == 0){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Alguno de los campos está vacío):',
        })
        retorno = false;
    }


    elementosLetras.forEach(element => {
        var cadena = element.value;
        for(var i = 0; i < cadena.length; i++){
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