$("#exampleFormControlFile1").change(function(){ // Esta funcion se ejecuta cada vez que cambie su valor el input
    var files = this.files; // Obtenemos los archivos
    $(files).each(function(index, file){ // Para cada archivo, recorremos
        var url = URL.createObjectURL(file) // Generamos una URL para el archivo enviado
        $('.pic').css('background-image', 'url(' + url + ')'); // Cambiamos las propiedades css de la clase pic
    });
     $(".pic").addClass("picture-loaded"); // Agregamos una clase al elemento .pic
});