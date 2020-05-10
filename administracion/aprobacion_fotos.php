<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    aprobacion_fotos.php
 * @brief:  Este archivo se encarga de mostrar y aprobar las fotos que cada uno de los usuario suba al sistema
 */
    include '../cfg_server.php'; // Archivo de conexion
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/administracion');
    
    if(isset($_SESSION['username']) && $_SESSION['tipo_usuario'] == 1){// Validamos que se haya iniciado sesión y que el tipo de usuario sea de tipo administrador
        $template->loadTemplatefile("fotos.html", true, true);
        $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
        $query = "SELECT * FROM Fotos WHERE status = 0";
        $result = mysqli_query($link, $query);

        $template->addBlockfile("FOTOS", "FOTOS", "card_fotos.html");
        $template->setCurrentBlock("FOTOS");

        // Para cada elemento del query, vamos a pintar en el template toda su información
        while($fields = mysqli_fetch_assoc($result)){
            $id_album = $fields['id_album'];
            $query2 = "SELECT titulo, username FROM Album WHERE id_album = '$id_album'";
            $result2 = mysqli_query($link, $query2);
            $fields2 = mysqli_fetch_assoc($result2);

            $template->setCurrentBlock("FOTO");
            $template->setVariable("ALBUM", $fields2['titulo']);
            $template->setVariable("PROPIETARIO", $fields2['username']);
            $template->setVariable("IMAGEN", $fields['direccion_foto']);
            $template->setVariable("ID_FOTO_AP", $fields['id_foto']);
            $template->setVariable("CARD", $fields['id_foto']);
            $template->parseCurrentBlock("FOTO");
        }
        $template->parseCurrentBlock("FOTOS");


        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged_admin.html");
        $template->setCurrentBlock("NAVEGACION");
        $template->setVariable("FLAG", "");
        $template->parseCurrentBlock("NAVEGACION");
        mysqli_close($link);// Cerramos la conexion y mostramos el template
        $template->show();
    }
?>