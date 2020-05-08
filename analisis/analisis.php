<?php 
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates'); // Cargamos los templates
    $template->loadTemplatefile("resultado_busqueda.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $opcion = $_POST['opcion'];


    if($opcion == 1)
        $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album WHERE tipo = 0 ORDER BY visitas DESC LIMIT 10";
    if($opcion == 2)
        $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album LEFT JOIN Visitas USING(id_album)  WHERE MONTH(fecha_visita) = MONTH(NOW()) AND tipo = 0 GROUP BY id_album ORDER BY visitas DESC";
    if($opcion == 3)
        $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album a LEFT JOIN Fotos USING(id_album) WHERE tipo = 0 GROUP BY a.id_album ORDER BY COUNT(id_foto) DESC LIMIT 10";
    if($opcion == 4)
        $query = "SELECT id_album, direccion_foto, COUNT(id_comentario) comentarios FROM Fotos LEFT JOIN Comentarios USING(id_foto) LEFT JOIN Album USING(id_album) WHERE tipo = 0 GROUP BY id_foto ORDER BY COUNT(id_comentario) DESC LIMIT 10";
    if($opcion == 5)
        $query = "SELECT titulo, descripcion, al.username, visitas, id_album, cover, AVG(calificacion) prom_cal FROM Album al LEFT JOIN Fotos USING(id_album) LEFT JOIN Calificaciones USING(id_foto) WHERE tipo = 0 GROUP BY id_album ORDER BY prom_cal DESC LIMIT 10";
    if($opcion == 6)
        $query = "SELECT titulo, descripcion, username, visitas, id_album, cover FROM Album WHERE tipo = 0";
    $result = mysqli_query($link, $query);

    if($opcion == 5){
        $template->addBlockfile("ALBUMES", "ALBUMES", "card_album4.html");
        $template->setCurrentBlock("ALBUMES");
        while ($fields = mysqli_fetch_assoc($result)) {
            $template->setCurrentBlock("TODOS_ALBUMES");
            $template->setVariable("TITULO2", $fields['titulo']);
            $template->setVariable("DESCRIPCION2", $fields['descripcion']);
            $template->setVariable("PROPIETARIO", $fields['username']);
            $template->setVariable("CALIFICACION", $fields['prom_cal']);
            $template->setVariable("LINK2", $fields['id_album']);
            $template->setVariable("IMAGEN", $fields['cover']);
            $template->parseCurrentBlock("TODOS_ALBUMES");
        }
    }

    if($opcion != 4 && $opcion != 5){
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