<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/albumes');
    $template->loadTemplatefile("subir_foto.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $id_foto = $_POST['foto'];
    $query = "UPDATE Fotos SET status = 1 WHERE id_foto = '$id_foto'";
    mysqli_query($link, $query);
    $query = "SELECT username FROM Album al, Fotos fo WHERE al.id_album = fo.id_album AND fo.id_foto = '$id_foto'";
    $result = mysqli_query($link, $query);
    $fields = mysqli_fetch_assoc($result);
    $username = $fields['username'];
    $query = "INSERT INTO Notificaciones(notificacion, status, username) VALUES('Una de las fotos que subiste, ha sido aprobada', 0, '$username')";
    mysqli_query($link, $query);
    mysqli_close($link);
    echo $id_foto;

?>