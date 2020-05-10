<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    invitar_usuario.php
 * @brief:  Este archivo se encarga de hacer administradores a otros usuarios
 */
    include '../cfg_server.php';
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $username = $_POST['username'];
    if(strtolower($username) == strtolower($_SESSION['username'])){ // Validamos que no se úeda invitar a si mismo un usuario
        echo "Usted ya es administrador";
        return;
    }
    
    $query3 = "SELECT username FROM Usuario WHERE username = '$username'";
    $result = mysqli_query($link, $query3);
    if(mysqli_num_rows($result) == 0){ // Validamos que exista el usuario
        echo "Este usuario no existe):";
        return;
    }

    if(mysqli_query($link, "UPDATE Usuario SET tipo_usuario = 1 WHERE username = '$username'")){ // En caso de haber pasado todas la validaciones, invitamos a un nuevo usuario a ver un album privado
        mysqli_query($link, $query2);
        echo "Se ha hecho administrador el usuario ingresado";
        return;
    }
    mysqli_close($link);
