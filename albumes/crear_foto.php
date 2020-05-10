<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    crear_foto.php
 * @brief:  Este archivo se encarga de subir una foto a un album
 */
    include '../cfg_server.php';
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $album = $_POST['albumes'];


    $filename = "../static/fotos_albumes/"; // Direccion de donde vamos mover las imagenes
    $file = basename($_FILES['file']['name']);
    $filename = $filename . $file;
    if (!move_uploaded_file($_FILES['file']['tmp_name'], $filename)) { // Movemos las imagenes
        echo "Algo falló):";
    }
    // Insertamos la foto
    $query = "INSERT INTO Fotos(direccion_foto, status, id_album) VALUES ('$filename', 0, '$album')";
    if(mysqli_query($link, $query)){
        header('location: mensaje_exito_subir_foto.html');
    }

    mysqli_close($link);
?>