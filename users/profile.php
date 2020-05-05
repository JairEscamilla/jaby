<?php
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

            $template->addBlockfile("ALBUMES", "ALBUMES", "card_album.html");
            $template->setCurrentBlock("ALBUMES");
            $query = "SELECT titulo, descripcion FROM Album WHERE username = '$username'";
            $result = mysqli_query($link, $query);

            while($line = mysqli_fetch_assoc($result)){
                $template->setCurrentBlock("ALBUM");
                $template->setVariable("TITULO", $line['titulo']);
                $template->setVariable("DESCRIPCION", $line['descripcion']);
                $template->parseCurrentBlock("ALBUM");
            }
            $template->parseCurrentBlock("ALBUMES");


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