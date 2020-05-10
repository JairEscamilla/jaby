<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    index.php
 * @brief:  Este archivo se encarga de mostrar el archivo principal del sistema
 */
    include 'cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('templates');
    $template->loadTemplatefile("index.html");
    // MOstramos la navegacion
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