<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates');
    $template->loadTemplatefile("perfil.html", true, true);
    if(isset($_SESSION['username'])){
        $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
        $username = $_SESSION['username'];
        $query = "SELECT * FROM Usuario WHERE username = '$username'";
        $result = mysqli_query($link, $query);
        $fields = mysqli_fetch_assoc($result);
        
        $template->setVariable("NOMBRE", $fields['nombre']);
        $template->setVariable("AP_PATERNO", $fields['ap_paterno']);
        $template->setVariable("AP_MATERNO", $fields['ap_materno']);
        $template->setVariable("USERNAME", $fields['username']);
        $template->setVariable("EMAIL", $fields['mail']);
        $template->setVariable("DIRECCION", $fields['direccion']);
        $template->setVariable("ESCOLARIDAD", $fields['escolaridad']);
        if($fields['tipo_usuario'] == 0)
            $template->setVariable("TIPO_USUARIO", "Normal");
        else
            $template->setVariable("TIPO_USUARIO", "Administrador");
        $template->setVariable("FECNAC", $fields['fecha_nacimiento']);
        $template->setVariable("IMAGEN", $fields['foto']);

        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "links_logged.html");
        $template->setCurrentBlock("NAVEGACION");
        $template->setVariable("FLAG", "");
        $template->parseCurrentBlock("NAVEGACION");

        $template->show();
        mysqli_close($link);
    }else{  
        echo "Ha ocurrido un error";
    }
?>