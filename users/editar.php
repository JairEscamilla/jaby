<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates');
    if(isset($_SESSION['username'])){
        $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
        $username = $_SESSION['username'];
        if($_SESSION['tipo_usuario'] == 1 AND isset($_GET['username'])){
            $query = "SELECT * FROM Usuario WHERE username = '".$_GET['username']."'";
            $archivo = "actualizar2.php?username=".$_GET['username'];
        }else{
            $archivo = "actualizar.php";
            $query = "SELECT * FROM Usuario WHERE username = '$username'";
        }

        $result = mysqli_query($link, $query);
        $fields = mysqli_fetch_assoc($result);

        $template->loadTemplatefile("editar_perfil.html", true, true);
        $template->setVariable("IMAGEN", $fields['foto']);
        $template->setVariable("DIR_IMAGE", $fields['foto']);
        $template->setVariable("TITULO", "Editar información");
        $template->setVariable("USERNAME", $fields['username']);
        $template->setVariable("PASSWORD", $fields['password']);
        $template->setVariable("EMAIL", $fields['mail']);
        $template->setVariable("NOMBRE", $fields['nombre']);
        $template->setVariable("AP_PAT", $fields['ap_paterno']);
        $template->setVariable("AP_MAT", $fields['ap_materno']);
        $template->setVariable("ESCOLARIDAD", $fields['escolaridad']);
        $template->setVariable("DIRECCION", $fields['direccion']);
        $template->setVariable("ACCION", $archivo);
        if ($_SESSION['tipo_usuario'] == 1)
            $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "links_logged_admin.html");
        else
            $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "links_logged.html");
        $template->setCurrentBlock("NAVEGACION");
        $template->setVariable("FLAG", "");
        $template->parseCurrentBlock("NAVEGACION");
        $template->Show();
    }else{
        echo "Error";
    }
?>