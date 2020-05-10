<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    fotos_comentadas.php
 * @brief:  Este archivo se encarga de desplegar las fotos que haya comentado un usuario en particular
 */
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/administracion');
    $template->loadTemplatefile("fotos_comentadas.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    if (!isset($_SESSION['username']) || $_SESSION['tipo_usuario'] == 0) { // En caso de no ser un administrador loggeado, no se puede acceder a esta parte del sistema
        echo "Acceso denegado";
        return;
    }
    $username = $_GET['username']; // Obtenemos el username de quien queremos mostrar las fotos comentadas

    $template->setVariable("USERNAME", $username);
    $query = "SELECT direccion_foto FROM Comentarios LEFT JOIN Fotos USING(id_foto) WHERE username = '$username' GROUP BY id_foto";
    $result = mysqli_query($link, $query);

    /* Para cada foto comentada, la desplegamos en el template */
    $template->addBlockfile("IMAGENES", "IMAGENES", "contenedor_imagen_comentada.html");
    $template->setCurrentBlock("IMAGENES");
    while($fields = mysqli_fetch_assoc($result)){
        $template->setCurrentBlock("IMAGEN");
        $template->setVariable("FOTO", $fields['direccion_foto']);
        $template->parseCurrentBlock("IMAGEN");
    }
    $template->parseCurrentBlock("IMAGENES");

    $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged_admin.html");
    $template->setCurrentBlock("NAVEGACION");
    $template->setVariable("FLAG", "");
    $template->parseCurrentBlock("NAVEGACION");
    mysqli_close($link);
    $template->show();
?>