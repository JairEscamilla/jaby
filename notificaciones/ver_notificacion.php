<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    comentar.php
 * @brief:  Este archivo se encarga de marcar como leidas las notificaciones
 */
    include '../cfg_server.php';
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $id_notificacion = $_POST['id_notificacion'];
    $query = "UPDATE Notificaciones SET status = 1 WHERE id_notificacion = '$id_notificacion'";
    if(mysqli_query($link, $query))
        echo $id_notificacion;

    mysqli_close($link);
?>