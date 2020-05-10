<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    notificaciones.php
 * @brief:  Este archivo se encarga de contar la cantidad de notificaciones que tiene cada usuario
 */
    include '../cfg_server.php';
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $username = $_SESSION['username'];
    $query = "SELECT COUNT(id_notificacion) cuenta FROM Notificaciones WHERE username = '$username' AND status = 0";
    $result = mysqli_query($link, $query);
    $fields = mysqli_fetch_assoc($result);
    echo $fields['cuenta'];
?>