<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/administracion');
    
    if(isset($_SESSION['username']) && $_SESSION['tipo_usuario'] == 1){
        $template->loadTemplatefile("fotos.html", true, true);
        $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
        $query = "SELECT * FROM Fotos WHERE status = 0";
        $result = mysqli_query($link, $query);

        $template->addBlockfile("FOTOS", "FOTOS", "card_fotos.html");
        $template->setCurrentBlock("FOTOS");

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
        mysqli_close($link);
        $template->show();
    }
?>