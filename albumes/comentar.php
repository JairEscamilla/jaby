<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    comentar.php
 * @brief:  Este archivo se encarga de insertar comentarios en las fotos de cada album
 */
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $id_foto = $_POST['id_foto'];
    $comentario = $_POST['comentario'];
    if(!isset($_SESSION['username'])){ // No se puede insertar un comentario si es que no se ha iniciado sesióm
        echo "Tiene que loggearse un usuario";
        return;
    }
    $username = $_SESSION['username'];
    
    $query = "INSERT INTO Comentarios(username, comentario, id_foto, fecha) VALUES('$username', '$comentario', '$id_foto', NOW())";

    // Insertamos y desplegamos el comentario en la base de datos
    if(!mysqli_query($link, $query)){
        echo "Ha ocurrido un error a la hora de ejecutar el query";
        return;
    }
    $template = new HTML_TEMPLATE_ITX('../templates/albumes');
    $template->loadTemplatefile("card_comentario.html", true, true);
    $query2 = "SELECT foto FROM Usuario WHERE username = '$username'";
    $result2 = mysqli_query($link, $query2);
    $fields = mysqli_fetch_assoc($result2);
    $template->setVariable("USUARIO", $username);
    $template->setVariable("COMMENT", $comentario);
    $template->setVariable("PERFIL_COMENTARIO", $fields['foto']);
    
    $result = mysqli_query($link, "SELECT CURDATE() AS fecha");
    $fields = mysqli_fetch_assoc($result);
    $template->setVariable("FECHA", $fields['fecha']);

    mysqli_close($link);

    $template->show();

    

?>
