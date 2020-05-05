<?php
    include '../cfg_server.php';
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $username = $_SESSION['username'];
    $query = "SELECT COUNT(id_notificacion) cuenta FROM Notificaciones WHERE username = '$username' AND status = 0";
    $result = mysqli_query($link, $query);
    $fields = mysqli_fetch_assoc($result);
    echo $fields['cuenta'];
?>