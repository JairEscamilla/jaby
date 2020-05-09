<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates'); // Cargamos los templates
    $template->loadTemplatefile("resultado_busqueda.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $busqueda = $_POST['busqueda'];
    $filtroBusqueda = $_POST['filtroBusqueda'];
    $username = $_SESSION['username'];
    if($filtroBusqueda == "nombre")
        $query = "SELECT titulo, cover, tema, visitas, fecha_publicacion, descripcion, id_album, COUNT(id_foto) cuenta, a.username, AVG(calificacion) calif FROM Album a LEFT JOIN Fotos USING(id_album) LEFT JOIN Calificaciones USING(id_foto) WHERE a.username LIKE '%" . $busqueda . "%'  AND tipo = 0 GROUP BY id_album";
    if($filtroBusqueda == "tema")
        $query = "SELECT titulo, cover, tema, visitas, fecha_publicacion, descripcion, id_album, COUNT(id_foto) cuenta, a.username, AVG(calificacion) calif FROM Album a LEFT JOIN Fotos USING(id_album) LEFT JOIN Calificaciones USING(id_foto) WHERE tema LIKE '%" . $busqueda . "%'  AND tipo = 0 GROUP BY id_album";
    if($filtroBusqueda == "titulo")
        $query = "SELECT titulo, cover, tema, visitas, fecha_publicacion, descripcion, id_album, COUNT(id_foto) cuenta, a.username, AVG(calificacion) calif FROM Album a LEFT JOIN Fotos USING(id_album) LEFT JOIN Calificaciones USING(id_foto) WHERE titulo LIKE '%" . $busqueda . "%'  AND tipo = 0 GROUP BY id_album";
    if($filtroBusqueda == "fecha"){
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];
        $query = "SELECT titulo, cover, tema, visitas, fecha_publicacion, descripcion, id_album, COUNT(id_foto) cuenta, a.username, AVG(calificacion) calif FROM Album a LEFT JOIN Fotos USING(id_album) LEFT JOIN Calificaciones USING(id_foto) WHERE fecha_publicacion >= '$date1' AND fecha_publicacion <= '$date2'  AND tipo = 0 GROUP BY id_album";
    }
    if($filtroBusqueda == "todos"){
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];
        $query = "SELECT titulo, cover, tema, visitas, fecha_publicacion, descripcion, id_album, COUNT(id_foto) cuenta, a.username, AVG(calificacion) calif FROM Album a LEFT JOIN Fotos USING(id_album) LEFT JOIN Calificaciones USING(id_foto) WHERE (a.username LIKE '%" . $busqueda . "%' OR tema LIKE '%" . $busqueda . "%' OR titulo LIKE '%".$busqueda."%') AND tipo = 0 GROUP BY id_album";
    }
    
   
    $result = mysqli_query($link, $query);
    if(mysqli_num_rows($result) > 0 && strlen($busqueda) != 0)
        mysqli_query($link, "INSERT INTO HistorialBusquedas(busqueda, timestamp, username) VALUES('$busqueda', NOW(), '$username')");

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
    $template->parseCurrentBlock("ALBUMES");
    mysqli_close($link);
    $template->show();

?>