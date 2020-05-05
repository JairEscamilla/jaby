<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/');
    if(!isset($_SESSION['username'])){
        echo "Usuario no loggeado";
        return;
    }
    $template->loadTemplatefile("ver_notificaciones.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $username = $_SESSION['username'];
    $query = "SELECT id_notificacion, notificacion FROM Notificaciones WHERE username = '$username' AND status = 0";
    $result = mysqli_query($link, $query);

    $template->addBlockfile("NOTIFICACIONES", "NOTIFICACIONES", "card_notificaciones.html");
    $template->setCurrentBlock("NOTIFICACIONES");

    while($fields = mysqli_fetch_assoc($result)){
        $template->setCurrentBlock("NOTIFICACION");
        $template->setVariable("TEXTO_NOTIFICACION", $fields['notificacion']);
        $template->setVariable("ID_NOTIFICACION", $fields['id_notificacion']);
        $template->setVariable("ID_NOTIF", $fields['id_notificacion']);
        $template->parseCurrentBlock("NOTIFICACION");
    }

    $template->parseCurrentBlock("NOTIFICACIONES");

    if($_SESSION['tipo_usuario'] == 1)
        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "links_logged_admin.html");
    else
        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "links_logged.html");
    $template->setCurrentBlock("NAVEGACION");
    $template->setVariable("FLAG", "");
    $template->parseCurrentBlock("NAVEGACION");

    mysqli_close($link);
    $template->show();
?>