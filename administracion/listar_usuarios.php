<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/administracion');
    $template->loadTemplatefile("listar_usuarios.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    if(!isset($_SESSION['username']) || $_SESSION['tipo_usuario'] == 0 ){
        echo "Acceso denegado";
        return;
    }

    $query = "SELECT username, password, tipo_usuario, foto, direccion, escolaridad, mail, nombre, ap_paterno, ap_materno, fecha_nacimiento, COUNT(id_album) cuenta FROM Usuario LEFT JOIN Album USING(username) GROUP BY Usuario.username;";
    $result = mysqli_query($link, $query);

    $template->addBlockfile("USUARIOS", "USUARIOS", "card_usuarios.html");
    $template->setCurrentBlock("USUARIOS");
    while($fields = mysqli_fetch_assoc($result)){
        $template->setCurrentBlock("USUARIO");
        $template->setVariable("NOMBRE", $fields['nombre']);
        $template->setVariable("AP_PATERNO", $fields['ap_paterno']);
        $template->setVariable("AP_MATERNO", $fields['ap_materno']);
        $template->setVariable("USERNAME", $fields['username']);
        $template->setVariable("EMAIL", $fields['mail']);
        $template->setVariable("DIRECCION", $fields['direccion']);
        $template->setVariable("ESCOLARIDAD", $fields['escolaridad']);
        if($fields['tipo_usuario'] == 1)
            $template->setVariable("TIPO_USUARIO", "Administrador");
        else
            $template->setVariable("TIPO_USUARIO", "Usuario normal");
        $template->setVariable("FECNAC", $fields['fecha_nacimiento']);
        $template->setVariable("NUMERO_ALBUMES", $fields['cuenta']);
        $template->setVariable("IMAGEN", $fields['foto']);
        
        $template->parseCurrentBlock("USUARIO");
    }
    $template->parseCurrentBlock("USUARIOS");

    $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged_admin.html");
    $template->setCurrentBlock("NAVEGACION");
    $template->setVariable("FLAG", "");
    $template->parseCurrentBlock("NAVEGACION");

    mysqli_close($link);
    $template->show();
?>