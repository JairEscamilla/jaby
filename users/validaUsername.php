<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    validaUsername.php
 * @brief:  Este archivo se encarga de validar la disponibilidad de un username
 */
    include '../cfg_server.php';
    require_once 'HTML/Template/ITX.php';

    $template = new HTML_TEMPLATE_ITX("../templates");
    $template->loadTemplatefile("errorUsername.html", true, true);
    $username = $_POST['username']; // Recibimos los parametros

    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    if(!($link)){ // En caso de error retornamos
        echo "Ha ocurrido un error";
        return;
    }

    $query = "SELECT username FROM Usuario WHERE username = '$username'";
    
    if(!($result = mysqli_query($link, $query))){ // Obtenemos el resultado del query
        echo "Ha ocurrido un error";
        return;
    }

    if(mysqli_num_rows($result) >= 1){ // En caso de tener mas de un resultado, el username no esta disponible
        $template->setVariable("MENSAJE_ERROR", "Username no disponible");
    }else{
        $template->setVariable("MENSAJE_ERROR", "Username");
    }
    mysqli_close($link);// Cerramos la conexion
    $template->show();

?>