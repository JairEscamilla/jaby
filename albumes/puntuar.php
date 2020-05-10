<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    comentar.php
 * @brief:  Este archivo se encarga de hacer las calificaciones de las fotos por un usuario en particular
 */
    include '../cfg_server.php';
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $puntuacion = $_POST['puntuacion'];
    $id_foto = $_POST['id_foto'];
    if(!isset($_SESSION['username'])){
        echo "error";
        return;
    }
    
    $username = $_SESSION['username'];
    // En caso de tener una calificacion la foto por parte de un mismo usuario, solo se actualiza la calificacion, en caso contrario, insertamos una nueva calificacion
    $queryValidator = "SELECT username FROM Calificaciones WHERE id_foto = '$id_foto' AND username = '$username'";
    $result = mysqli_query($link, $queryValidator);
    if(mysqli_num_rows($result) > 0)
        $query = "UPDATE Calificaciones SET calificacion = '$puntuacion' WHERE id_foto = '$id_foto' AND username = '$username'";
    else
        $query = "INSERT INTO Calificaciones(calificacion, id_foto, username) VALUES('$puntuacion', '$id_foto', '$username')";
    mysqli_query($link, $query);
    echo "Calificación hecha";
    mysqli_close($link);
?>