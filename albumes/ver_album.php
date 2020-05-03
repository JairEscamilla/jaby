<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/albumes');
    $template->loadTemplatefile("ver_album.html", true, true);
    $album = $_GET['album'];
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $query = "SELECT titulo, username, tema, fecha_publicacion, cover FROM Album WHERE id_album = '$album'";

    $result = mysqli_query($link, $query);
    $fields = mysqli_fetch_assoc($result);

    $template->setVariable("TITULO", $fields['titulo']);
    $template->setVariable("USERNAME", $fields['username']);
    $template->setVariable("TEMA", $fields['tema']);
    $template->setVariable("FECHA", $fields['fecha_publicacion']);
    $template->setVariable("IMAGEN", $fields['cover']);

    mysqli_close($link);
    $template->show();
    


?>