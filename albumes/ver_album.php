<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    ver_album.php
 * @brief:  Este archivo se encarga de mostrar las fotos y comentarios de cada album
 */
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/albumes');
    $template->loadTemplatefile("ver_album.html", true, true);
    $album = $_GET['album'];
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    
    // Validamos que el usuario tenga acceso al album
    $query = "SELECT username FROM Album WHERE id_album = '$album'";
    $res = mysqli_query($link, $query);
    $fields = mysqli_fetch_assoc($res);
    if($fields['username'] != $_SESSION['username']){
        mysqli_query($link, "CALL valida_entrada_album(@entrada, '".$_SESSION['username']."', '$album')");
        $resultado = mysqli_query($link, "SELECT @entrada AS entrada");
        $fields = mysqli_fetch_assoc($resultado);
        if($fields['entrada'] == 1){
            header('location: error_message.html');
            return;
        }
    }

   
    

    // Seleccionamos las fotos y comentarios de los albumes
    $query = "SELECT titulo, username, tema, fecha_publicacion, cover FROM Album WHERE id_album = '$album'";
    $queryVisitas = "SELECT visitas FROM Album WHERE id_album = '$album'";
    $resultVisitas = mysqli_query($link, $queryVisitas);
    $fieldsVisitas = mysqli_fetch_assoc($resultVisitas);
    $visitas = $fieldsVisitas['visitas'];
    $visitas = $visitas + 1;
    mysqli_query($link, "UPDATE Album SET visitas = '$visitas' WHERE id_album = '$album'");
    mysqli_query($link, "INSERT INTO Visitas(fecha_visita, id_album) VALUES(NOW(), '$album')");
    $result = mysqli_query($link, $query);
    $fields = mysqli_fetch_assoc($result);

    $template->setVariable("TITULO", $fields['titulo']);
    $template->setVariable("USERNAME", $fields['username']);
    $template->setVariable("TEMA", $fields['tema']);
    $template->setVariable("FECHA", $fields['fecha_publicacion']);
    $template->setVariable("IMAGEN", $fields['cover']);
    $template->setVariable("VISITAS", $visitas);

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
        $template->setVariable("ID_FOTO", $id_foto);

        $template->parseCurrentBlock("FOTO");
        
    }
    $template->parseCurrentBlock("FOTOS");

    mysqli_close($link);
    $template->show();
    
    //  Creamos una cadena con los comentarios hechos de cada foto
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
