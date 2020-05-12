<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    profile.php
 * @brief:  Este archivo se encarga de mostrar el inicio de cada usuario
 */
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates'); // Cargamos los templates
    $template->loadTemplatefile("base.html", true, true);
    $template->setVariable("TITULO", "Jaby");
    
    
    if(isset($_SESSION['username'])){ // Si hay una sesión, cargamos el profile del usuario
        // Establecemos conexion a la base de datos
        $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
        $username = $_SESSION['username'];
       
        $query = "SELECT foto, nombre, ap_paterno, ap_materno FROM Usuario WHERE username = '$username'";

        $result = mysqli_query($link, $query);
        $query_result = mysqli_fetch_assoc($result);




        $template->addBlockfile("CONTENIDO", "CONTENT", "contenedorBienvenida.html");
        $template->setCurrentBlock("CONTENT");
        $template->setVariable("FLAG", "");
        $template->setVariable("IMAGEN_PERFIL", $query_result['foto']);
        $template->setVariable("NOMBRE", $query_result['nombre']);
        $template->setVariable("AP_PAT", $query_result['ap_paterno']);
        $template->setVariable("AP_MAT", $query_result['ap_materno']);
        $result = mysqli_query($link, "SELECT COUNT(id_album) cuenta FROM Album WHERE username = '$username'");
        $fields = mysqli_fetch_assoc($result);
        $template->setVariable("NUMERO_ALBUMES", $fields['cuenta']);

            // SELECT titulo, descripcion, id_album, COUNT(id_foto) FROM Album LEFT JOIN Fotos USING(id_album) WHERE username = 'jair1' GROUP BY id_album;
            $template->addBlockfile("ALBUMES", "ALBUMES", "card_album_fotos.html");
            $template->setCurrentBlock("ALBUMES");
            $query = "SELECT titulo, descripcion, id_album, COUNT(id_foto) cuenta, AVG(calificacion) calif FROM Album a LEFT JOIN Fotos USING(id_album) LEFT JOIN Calificaciones USING(id_foto) WHERE a.username = '$username' AND status = 1  GROUP BY id_album ORDER BY calif DESC";
            $result = mysqli_query($link, $query);

            while($line = mysqli_fetch_assoc($result)){
                $template->setCurrentBlock("ALBUM");
                $template->setVariable("TITULO", $line['titulo']);
                $template->setVariable("DESCRIPCION", $line['descripcion']);
                $template->setVariable("LINK", $line['id_album']);
                $template->setVariable("FOTOS", $line['cuenta']);
                if($line['calif'] != NULL)
                    $template->setVariable("CALIFICACION", $line['calif']);
                else 
                    $template->setVariable("CALIFICACION", "0");
                $template->parseCurrentBlock("ALBUM");
            }
            $template->parseCurrentBlock("ALBUMES");

            
            $template->addBlockfile("ALBUMES_USUARIOS", "ALBUMES_USUARIOS", "card_album2.html");
            $template->setCurrentBlock("ALBUMES_USUARIOS");
            $query2 = "SELECT titulo, cover, visitas, tema, fecha_publicacion, descripcion, a.id_album, COUNT(id_foto) cuenta, a.username, AVG(calificacion) calif FROM Album a LEFT JOIN Fotos USING(id_album) LEFT JOIN Calificaciones USING(id_foto) LEFT JOIN Suscripciones sus ON sus.id_album = a.id_album WHERE tipo = 0 OR a.username = '$username' OR (a.id_album IN (SELECT id_album FROM Suscripciones WHERE username = '$username')) GROUP BY id_album";
            $result2 = mysqli_query($link, $query2);
            
            while($fields = mysqli_fetch_assoc($result2)){
                $template->setCurrentBlock("TODOS_ALBUMES");
                $template->setVariable("TITULO2", $fields['titulo']);
                $template->setVariable("DESCRIPCION2", $fields['tema']);
                $template->setVariable("PROPIETARIO", $fields['username']);
                $template->setVariable("VISITAS", $fields['visitas']);
                $template->setVariable("LINK2", $fields['id_album']);
                $template->setVariable("IMAGEN", $fields['cover']);
                $template->setVariable("PUBLICACION", $fields['fecha_publicacion']);
                if ($fields['calif'] != NULL)
                    $template->setVariable("CALIFICACION", $fields['calif']);
                else
                    $template->setVariable("CALIFICACION", "0");
                $template->parseCurrentBlock("TODOS_ALBUMES");
            }

            $template->parseCurrentBlock("ALBUMES_USUARIOS");

            $template->parseCurrentBlock("CONTENT");

            if($_SESSION['tipo_usuario'] == 1)
                $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "links_logged_admin.html");
            else
                $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "links_logged.html");
            $template->setCurrentBlock("NAVEGACION");
            $template->setVariable("FLAG", "");
            $template->parseCurrentBlock("NAVEGACION");

            
        mysqli_close($link);
    }else{
        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "links_unlogged.html");
        $template->setCurrentBlock("NAVEGACION");
        $template->setVariable("FLAG", "");
        $template->parseCurrentBlock("NAVEGACION");
    }

    $template->show(); // Mostramos la plantilla
?>
