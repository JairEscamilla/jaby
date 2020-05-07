<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates'); // Cargamos los templates
    $template->loadTemplatefile("resultado_busqueda.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $busqueda = $_POST['busqueda'];
    $filtroBusqueda = $_POST['filtroBusqueda'];
    if($filtroBusqueda == "nombre")
        $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album WHERE username LIKE '%".$busqueda."%' AND tipo = 0";
    if($filtroBusqueda == "tema")
        $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album WHERE tema LIKE '%".$busqueda."%' AND tipo = 0";
    if($filtroBusqueda == "titulo")
        $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album WHERE titulo LIKE '%".$busqueda."%' AND tipo = 0";
    if($filtroBusqueda == "fecha")
        $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album WHERE (MONTH(fecha_publicacion) = '$busqueda' OR YEAR(fecha_publicacion) = '$busqueda' OR DAY(fecha_publicacion) = '$busqueda' ) AND tipo = 0";
    if($filtroBusqueda == "todos")
        $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album WHERE (username LIKE '%" . $busqueda . "%' OR tema LIKE '%".$busqueda."%' OR MONTH(fecha_publicacion) = '$busqueda' OR YEAR(fecha_publicacion) = '$busqueda' OR DAY(fecha_publicacion) = '$busqueda' OR titulo LIKE '%".$busqueda."%' ) AND tipo = 0";
    
   
    $result = mysqli_query($link, $query);

    $template->addBlockfile("ALBUMES", "ALBUMES", "card_album2.html");
    $template->setCurrentBlock("ALBUMES");
    while($fields = mysqli_fetch_assoc($result)){
        $template->setCurrentBlock("TODOS_ALBUMES");
        $template->setVariable("TITULO2", $fields['titulo']);
        $template->setVariable("DESCRIPCION2", $fields['descripcion']);
        $template->setVariable("PROPIETARIO", $fields['username']);
        $template->setVariable("VISITAS", $fields['visitas']);
        $template->setVariable("LINK2", $fields['id_album']);
        $template->setVariable("IMAGEN", $fields['cover']);
        $template->parseCurrentBlock("TODOS_ALBUMES");
    }
    $template->parseCurrentBlock("ALBUMES");
    mysqli_close($link);
    $template->show();

?>