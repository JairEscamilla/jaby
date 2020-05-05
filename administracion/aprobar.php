<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/albumes');
    $template->loadTemplatefile("subir_foto.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $id_foto = $_POST['foto'];
    $query = "UPDATE Fotos SET status = 1 WHERE id_foto = '$id_foto'";
    mysqli_query($link, $query);
    echo $id_foto;
?>