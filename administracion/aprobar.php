<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    aprobacion_fotos.php
 * @brief:  Este archivo se encarga de realizar la aprobacion de las fotos, este archivo es llamado mediante AJAX
 */
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/albumes');
    $template->loadTemplatefile("subir_foto.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $id_foto = $_POST['foto'];
    // Query para actualizar el estado de la foto, a publicada
    $query = "UPDATE Fotos SET status = 1 WHERE id_foto = '$id_foto'";
    mysqli_query($link, $query);
    $query = "SELECT username FROM Album al, Fotos fo WHERE al.id_album = fo.id_album AND fo.id_foto = '$id_foto'";
    $result = mysqli_query($link, $query);
    $fields = mysqli_fetch_assoc($result);
    $username = $fields['username'];
    $query = "INSERT INTO Notificaciones(notificacion, status, username) VALUES('Una de las fotos que subiste, ha sido aprobada', 0, '$username')";
    mysqli_query($link, $query);


    $resultAlbumFoto = mysqli_query($link, "SELECT id_album FROM Fotos WHERE id_foto = '$id_foto'");
    $fields = mysqli_fetch_assoc($resultAlbumFoto);
    $album = $fields['id_album'];

    /* Codigo para mandar notificaciones a los usuarios que esten suscritos a un album privado */

 // Mandamos la notificacion
        $queryNotificacion = "SELECT username FROM Suscripciones WHERE id_album = '$album'";
        $resultNotificacion = mysqli_query($link, $queryNotificacion);
        while($fields = mysqli_fetch_assoc($resultNotificacion)){ // Mandamos una notificacion para cada usuario suscrito al album
            $usr = $fields['username'];
            $queryInsertaNotificacion = "INSERT INTO Notificaciones(notificacion, status, username) VALUES (\"Se ha subido una nueva foto a un album al que te han invitado <a class ='invitacion' href='../albumes/ver_album.php?album=" . $album . "'>Ver álbum</a>\", 0, '$usr')";
            mysqli_query($link, $queryInsertaNotificacion);
        }



    mysqli_close($link);
    echo $id_foto;

?>