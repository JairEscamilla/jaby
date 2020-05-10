<?php 
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    anallisis.php
 * @brief:  Este archivo se encarga del modulo de analisis 
 */
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates'); // Cargamos los templates
    $template->loadTemplatefile("resultado_busqueda.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $opcion = $_POST['opcion'];
    $username = $_SESSION['username'];


    // Según cada una de las opciones del modulo de analisis, vamos a ejecutar un nuevo query
    if($opcion == 1)
        $query = "SELECT titulo, cover, tema, visitas, fecha_publicacion, descripcion, id_album, COUNT(id_foto) cuenta, a.username, AVG(calificacion) calif FROM Album a LEFT JOIN Fotos USING(id_album) LEFT JOIN Calificaciones USING(id_foto) WHERE tipo = 0 GROUP BY id_album ORDER BY visitas DESC";
    if($opcion == 3)
        $query = "SELECT titulo, cover, tema, visitas, fecha_publicacion, descripcion, id_album, COUNT(id_foto) cuenta, a.username, AVG(calificacion) calif FROM Album a LEFT JOIN Fotos USING(id_album) LEFT JOIN Calificaciones USING(id_foto) WHERE tipo = 0 GROUP BY id_album ORDER BY cuenta DESC";
    if($opcion == 4)
        $query = "SELECT id_album, direccion_foto, COUNT(id_comentario) comentarios FROM Fotos LEFT JOIN Comentarios USING(id_foto) LEFT JOIN Album USING(id_album) WHERE tipo = 0 GROUP BY id_foto ORDER BY COUNT(id_comentario) DESC LIMIT 10";
    if($opcion == 5)
        $query = "SELECT titulo, cover, tema, visitas, fecha_publicacion, descripcion, id_album, COUNT(id_foto) cuenta, a.username, AVG(calificacion) calif FROM Album a LEFT JOIN Fotos USING(id_album) LEFT JOIN Calificaciones USING(id_foto) WHERE tipo = 0 GROUP BY id_album ORDER BY calif DESC";
    if($opcion == 6)
        $query = "SELECT titulo, cover, visitas, tema, fecha_publicacion, descripcion, a.id_album, COUNT(id_foto) cuenta, a.username, AVG(calificacion) calif FROM Album a LEFT JOIN Fotos USING(id_album) LEFT JOIN Calificaciones USING(id_foto) LEFT JOIN Suscripciones sus ON sus.id_album = a.id_album WHERE tipo = 0 OR a.username = '$username' OR (a.id_album IN (SELECT id_album FROM Suscripciones WHERE username = '$username')) GROUP BY id_album";
    if($opcion == 7){
        $mes = $_POST['mes'];
        $anio = $_POST['anio'];
        $query = "SELECT titulo, cover, tema, visitas, fecha_publicacion, descripcion, id_album, COUNT(id_foto) cuenta, a.username, AVG(calificacion) calif FROM Album a LEFT JOIN Fotos USING(id_album) LEFT JOIN Calificaciones USING(id_foto) LEFT JOIN Visitas USING(id_album) WHERE MONTH(fecha_visita) = '$mes' AND YEAR(fecha_visita) = '$anio' AND tipo = 0 GROUP BY id_album ORDER BY COUNT(Visitas.id) DESC";
    }

    $result = mysqli_query($link, $query);
    
    if($opcion != 4){ // Si la opcion de analisis es cuatro, desplegamos un card distinto al de las demas opciones
        $template->addBlockfile("ALBUMES", "ALBUMES", "card_album2.html");
        $template->setCurrentBlock("ALBUMES");
        while ($fields = mysqli_fetch_assoc($result)) {
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
    }else{
        $template->addBlockfile("ALBUMES", "ALBUMES", "card_album3.html");
        $template->setCurrentBlock("ALBUMES");
        while ($fields = mysqli_fetch_assoc($result)) {
            $template->setCurrentBlock("TODOS_ALBUMES");
            $template->setVariable("COMENTARIO", $fields['comentarios']);
            $template->setVariable("IMAGEN", $fields['direccion_foto']);
            $template->setVariable("LINK2", $fields['id_album']);
            $template->parseCurrentBlock("TODOS_ALBUMES");
        }
    }
    $template->parseCurrentBlock("ALBUMES");
    mysqli_close($link);
    $template->show();
?>