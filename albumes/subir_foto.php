<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    comentar.php
 * @brief:  Este archivo se encarga mostrar la plantilla que mostrara el formulario para subir una foto
 */
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/albumes');
    $template->loadTemplatefile("subir_foto.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    
    if(!isset($_SESSION['username'])){
        echo "Error";
        return;
    }

    $username = $_SESSION['username'];
    $query = "SELECT titulo, id_album FROM Album WHERE username = '$username'";
    $result = mysqli_query($link, $query);
    $template->addBlockfile("OPCIONES", "OPCIONES", "albumes_opciones.html");
    $template->setCurrentBlock("OPCIONES");
    while($fields = mysqli_fetch_assoc($result)){
        $template->setCurrentBlock("OPCION");
        $template->setVariable("ALBUM", $fields['titulo']);
        $template->setVariable("ID", $fields['id_album']);
        $template->parseCurrentBlock("OPCION");
    }
    $template->parseCurrentBlock("OPCIONES");

    if ($_SESSION['tipo_usuario'] == 1)
        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged_admin.html");
    else
        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged.html");
    $template->setCurrentBlock("NAVEGACION");
    $template->setVariable("FLAG", "");
    $template->parseCurrentBlock("NAVEGACION");
    mysqli_close($link);
    $template->show();
?>