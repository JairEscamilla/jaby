<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    comentar.php
 * @brief:  Este archivo se encarga de hacer busquedas en el index de la pagina
 */
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates'); // Cargamos los templates
    $template->loadTemplatefile("invitados.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    // Ejecutamos un query diferente segun el filtro de busqueda
    if(isset($_GET['searcher']) && isset($_GET['options'])){
        $busqueda = $_GET['searcher'];
        $filtroBusqueda = $_GET['options'];
        if ($filtroBusqueda == "nombre")
            $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album WHERE username LIKE '%" . $busqueda . "%' AND tipo = 0";
        if ($filtroBusqueda == "tema")
            $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album WHERE tema LIKE '%" . $busqueda . "%' AND tipo = 0";
        if ($filtroBusqueda == "titulo")
            $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album WHERE titulo LIKE '%" . $busqueda . "%' AND tipo = 0";
        if ($filtroBusqueda == "fecha")
            $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album WHERE (MONTH(fecha_publicacion) = '$busqueda' OR YEAR(fecha_publicacion) = '$busqueda' OR DAY(fecha_publicacion) = '$busqueda' ) AND tipo = 0";
        if ($filtroBusqueda == "todos")
            $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album WHERE (username LIKE '%" . $busqueda . "%' OR tema LIKE '%" . $busqueda . "%' OR MONTH(fecha_publicacion) = '$busqueda' OR YEAR(fecha_publicacion) = '$busqueda' OR DAY(fecha_publicacion) = '$busqueda' OR titulo LIKE '%" . $busqueda . "%' ) AND tipo = 0";
            
    }else{
        $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album WHERE tipo = 0";
    }

    if(!isset($_SESSION['tipo_usuario']))
        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "links_unlogged.html");

    if ($_SESSION['tipo_usuario'] == 1)
        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "links_logged_admin.html");
    if($_SESSION['tipo_usuario' ] == 0)
        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "links_logged.html");
    $template->setCurrentBlock("NAVEGACION");
    $template->setVariable("FLAG", "");
    $template->parseCurrentBlock("NAVEGACION");

    $result = mysqli_query($link, $query);

    $template->addBlockfile("ALBUMES", "ALBUMES", "albumes_invitados.html");
    $template->setCurrentBlock("ALBUMES");
    while ($fields = mysqli_fetch_assoc($result)) {
        $template->setCurrentBlock("TODOS_ALBUMES");
        $template->setVariable("TITULO2", $fields['titulo']);
        $template->setVariable("DESCRIPCION2", $fields['descripcion']);
        $template->setVariable("PROPIETARIO", $fields['username']);
        $template->setVariable("VISITAS", $fields['visitas']);
        $template->setVariable("LINK2", $fields['id_album']);
        $template->setVariable("IMAGEN", $fields['cover']);
        $template->parseCurrentBlock("TODOS_ALBUMES");
    }
    $template->parseCurrentBlock("ALBUMES");

    mysqli_close($link);
    $template->show();
    
?>