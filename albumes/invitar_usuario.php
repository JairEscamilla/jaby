<?php
    include '../cfg_server.php';
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $username = $_POST['username'];
    $album = $_POST['id_album'];

    if(strtolower($username) == strtolower($_SESSION['username'])){
        echo "No puede invitarse usted mismo):";
        return;
    }
    $query = "INSERT INTO Suscripciones(username, id_album) VALUES('$username', '$album')";
    $query2 = "INSERT INTO Notificaciones(notificacion, status, username) VALUES(\"Se te ha invitado a un nuevo album <a class ='invitacion' href='../albumes/ver_album.php?album=".$album."'>Ver álbum</a>\", 0, '$username')";
    $query3 = "SELECT username FROM Suscripciones WHERE username = '$username' AND id_album = '$album'";
    $result = mysqli_query($link, $query3);
    if(mysqli_num_rows($result) > 0){
        echo "Ya haz invitado a este usuario";
        return;
    }

    if(mysqli_query($link, $query)){
        mysqli_query($link, $query2);
        echo "Se ha invitado correctamente a este usuario";
        return;
    }
    echo "No se ha encontrado el usuario ingresado):";
    mysqli_close($link);
?>