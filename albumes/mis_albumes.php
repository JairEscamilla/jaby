<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/albumes'); // Cargamos los templates

    if(!isset($_SESSION['username'])){
        echo "Error";
        return;
    }
    $template->loadTemplatefile("mis_albumes.html", true, true);
    if($_SESSION['tipo_usuario'] == 1)
        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged_admin.html");
    else
        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged.html");
    $template->setCurrentBlock("NAVEGACION");
    $template->setVariable("FLAG", "");
    $template->parseCurrentBlock("NAVEGACION");

    $username = $_SESSION['username'];
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);

    $queryPublicos = "SELECT id_album, titulo, descripcion, fecha_publicacion, tema, cover FROM Album WHERE username = '$username' AND tipo = 0";
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
        $template->parseCurrentBlock("ALBUM");
    }
    $template->parseCurrentBlock("PUBLICOS");

    $template->addBlockfile("PRIVADOS", "PRIVADOS", "album_privado.html");
    $template->setCurrentBlock("PRIVADOS");
    $queryPrivados = "SELECT id_album, titulo, descripcion, fecha_publicacion, tema, cover FROM Album WHERE username = '$username' AND tipo = 1";
    $result = mysqli_query($link, $queryPrivados);
    while($fields = mysqli_fetch_assoc($result)){
        $template->setCurrentBlock("ALBUMPRIVADO");
        $template->setVariable("IMAGEN", $fields['cover']);
        $template->setVariable("TITULO", $fields['titulo']);
        $template->setVariable("DESCRIPCION", $fields['descripcion']);
        $template->setVariable("LINK", $fields['id_album']);
        $template->setVariable("FECHA", $fields['fecha_publicacion']);
        $template->setVariable("TEMA", $fields['tema']);
        $template->parseCurrentBlock("ALBUMPRIVADO");
    }
    $template->parseCurrentBlock("PRIVADOS");




    $template->show();
    mysqli_close($link);
?>