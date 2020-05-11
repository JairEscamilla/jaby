<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    mis_albumes.php
 * @brief:  Este archivo se encarga de desplegar los albumes de cada uno de los albumes de un usuario en particular
 */
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/albumes'); // Cargamos los templates

    if(!isset($_SESSION['username'])){// En caso de no haberse loggeado, retornamos
        echo "Error";
        return;
    }
    // Desplegamos los links de la barra de navegacion
    $template->loadTemplatefile("mis_albumes.html", true, true);
    if($_SESSION['tipo_usuario'] == 1)
        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged_admin.html");
    else
        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged.html");
    $template->setCurrentBlock("NAVEGACION");
    $template->setVariable("FLAG", "");
    $template->parseCurrentBlock("NAVEGACION");

    $username = $_SESSION['username'];
    if($_SESSION['tipo_usuario'] == 1 AND isset($_GET['username'])){ // Si inicio sesion un usuario administrador, y existe la variable de username mediante GET, vamos a mostrar los albumes de un usuario pasado por parametro
        $queryPublicos = "SELECT id_album, titulo, descripcion, fecha_publicacion, tema, cover, username FROM Album WHERE username = '".$_GET['username']."' AND tipo = 0";
        $queryPrivados = "SELECT id_album, titulo, descripcion, fecha_publicacion, tema, cover, username FROM Album WHERE username = '".$_GET['username']."' AND tipo = 1";
    }else{
        $queryPublicos = "SELECT id_album, titulo, descripcion, fecha_publicacion, tema, cover, username FROM Album WHERE username = '$username' AND tipo = 0"; // En otro caso, vamos a desplegar los albumes propios
        $queryPrivados = "SELECT id_album, titulo, descripcion, fecha_publicacion, tema, cover, username FROM Album WHERE username = '$username' AND tipo = 1";
    }

    
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);

    $template->addBlockfile("PUBLICOS", "PUBLICOS", "album_publico.html");
    $template->setCurrentBlock("PUBLICOS");
    $result = mysqli_query($link, $queryPublicos);
    while($fields = mysqli_fetch_assoc($result)){
        $template->setCurrentBlock("ALBUM");
        $template->setVariable("TITULO", $fields['titulo']);
        $template->setVariable("DESCRIPCION", $fields['descripcion']);
        $template->setVariable("LINK", $fields['id_album']);
        $template->setVariable("FECHA", $fields['fecha_publicacion']);
        $template->setVariable("TEMA", $fields['tema']);
        $template->setVariable("IMAGEN", $fields['cover']);
        if ($_SESSION['username'] == $fields['username'])
            $template->setVariable("INVITACION", "<a href='#' id='invitacion' onclick='return invitar_usuario(" . $fields['id_album'] . ")' >Invita a un usuario</a>");
        else
            $template->setVariable("INVITACION", "");

        $template->parseCurrentBlock("ALBUM");
    }
    $template->parseCurrentBlock("PUBLICOS");

    $template->addBlockfile("PRIVADOS", "PRIVADOS", "album_privado.html");
    $template->setCurrentBlock("PRIVADOS");
    $result = mysqli_query($link, $queryPrivados);
    while($fields = mysqli_fetch_assoc($result)){
        $template->setCurrentBlock("ALBUMPRIVADO");
        $template->setVariable("IMAGEN", $fields['cover']);
        $template->setVariable("TITULO", $fields['titulo']);
        $template->setVariable("DESCRIPCION", $fields['descripcion']);
        $template->setVariable("LINK", $fields['id_album']);
        $template->setVariable("FECHA", $fields['fecha_publicacion']);
        $template->setVariable("TEMA", $fields['tema']);
        if($_SESSION['username'] == $fields['username'])
            $template->setVariable("INVITACION", "<a href='#' id='invitacion' onclick='return invitar_usuario(".$fields['id_album'].")' >Invita a un usuario</a>");
        else 
            $template->setVariable("INVITACION", "");

        $template->parseCurrentBlock("ALBUMPRIVADO");
    }
    $template->parseCurrentBlock("PRIVADOS");




    $template->show();
    mysqli_close($link);
?>