<?php
    include 'cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('templates');
    $template->loadTemplatefile("index.html");
    if (isset($_SESSION['username']) && $_SESSION['tipo_usuario'] == 1)
        $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "links_logged_admin_copy.html");
    else{
        if (isset($_SESSION['username']) && $_SESSION['tipo_usuario'] == 0)
            $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "links_logged_copy.html");
        else
            $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "links_unlogged_copy.html");
    }
    $template->setCurrentBlock("NAVEGACION");
    $template->setVariable("FLAG", "");
    $template->parseCurrentBlock("NAVEGACION");

    $template->show();
?>