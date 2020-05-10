<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    fotos_por_album.php
 * @brief:  Este archivo se encarga desplegar en una tabla la cantidad de fotos por album de cada usuario
 */
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/administracion');
    $template->loadTemplatefile("fotos_por_album.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    if(!isset($_SESSION['username']) || $_SESSION['tipo_usuario'] == 0){
        echo "Acceso denegado";
        return;
    }

    // Obtenemos la cantidad de fotos por album según un usuario en particular y los deplegamos en un template
    $username = $_GET['username'];
    $template->setVariable("USERNAME", $username);
    $query = "SELECT id_album, titulo, COUNT(id_foto) cuenta FROM Album LEFT JOIN Fotos USING(id_album) WHERE username = '$username' GROUP BY id_album";
    $result = mysqli_query($link, $query);

    $template->addBlockfile("CUERPO_TABLA", "CUERPO_TABLA", "cuerpo_tabla.html");
    $template->setCurrentBlock("CUERPO_TABLA");
    while($fields = mysqli_fetch_assoc($result)){
        $template->setCurrentBlock("ALBUM");
        $template->setVariable("ID", $fields['id_album']);
        $template->setVariable("TITULO", $fields['titulo']);
        $template->setVariable("FOTOS", $fields['cuenta']);
        $template->parseCurrentBlock("ALBUM");
    }
    $template->parseCurrentBlock("CUERPO_TABLA");

    $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged_admin.html");
    $template->setCurrentBlock("NAVEGACION");
    $template->setVariable("FLAG", "");
    $template->parseCurrentBlock("NAVEGACION");

    mysqli_close($link);
    $template->show();
?>