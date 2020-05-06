<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/albumes');
    $template->loadTemplatefile("ver_album.html", true, true);
    $album = $_GET['album'];
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $query = "SELECT titulo, username, tema, fecha_publicacion, cover FROM Album WHERE id_album = '$album'";

    $result = mysqli_query($link, $query);
    $fields = mysqli_fetch_assoc($result);

    $template->setVariable("TITULO", $fields['titulo']);
    $template->setVariable("USERNAME", $fields['username']);
    $template->setVariable("TEMA", $fields['tema']);
    $template->setVariable("FECHA", $fields['fecha_publicacion']);
    $template->setVariable("IMAGEN", $fields['cover']);

    if(isset($_SESSION['username'])){
        if ($_SESSION['tipo_usuario'] == 1)
            $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged_admin.html");
        else
            $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged.html");
        $template->setCurrentBlock("NAVEGACION");
        $template->setVariable("FLAG", "");
        $template->parseCurrentBlock("NAVEGACION");
    }

    $query = "SELECT id_foto, direccion_foto FROM Fotos WHERE id_album = '$album' AND status = 1";
    $result = mysqli_query($link, $query);

    $template->addBlockfile("FOTOS", "FOTOS", "card_foto.html");
    $template->setCurrentBlock("FOTOS");

    while($fields = mysqli_fetch_assoc($result)){
        $template->setCurrentBlock("FOTO");
        $template->setVariable("URL_IMAGEN", $fields['direccion_foto']);

        $id_foto = $fields['id_foto'];
        $query2 = "SELECT comentario, usu.username, usu.foto FROM Comentarios com INNER JOIN Usuario usu USING(username) WHERE id_foto = '$id_foto'";
        $result2 = mysqli_query($link, $query2);
        $comentarios = "";
        while($fields2 = mysqli_fetch_assoc($result2)){
            $comentarios = $comentarios.crearCadena($fields2['foto'], $fields2['username'], $fields2['comentario']);
        }
        $template->setVariable("COMENTARIOS", $comentarios);


        $template->parseCurrentBlock("FOTO");
        
    }
    $template->parseCurrentBlock("FOTOS");

    mysqli_close($link);
    $template->show();
    

    function crearCadena($imagen, $usuario, $comentario){
        $base = "
            <div class='card comment tarjeta'>
                <div class='encabezado'>
                    <div class='imagen-perfil' style='background-image: url(\"".$imagen."\");'></div>
                    <div class='user-container'>
                        <p class='user'>".$usuario."</p>
                    </div>
                </div>
                <div class='cuerpo-comentario'>
                    <p>".$comentario."</p>
                </div>
            </div>
        ";

        return $base;
    }
?>
