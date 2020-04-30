<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates'); // Cargamos los templates
    if(isset($_SESSION['username'])){ // Si hay una sesión, cargamos el profile del usuario
        $template->loadTemplatefile("profile.html", true, true);
        $template->setVariable("USERNAME", $_SESSION['username']);
    }else{
        $template->loadTemplatefile("error_acceso.html", true, true); // En caso de no tener a un usuario loggeado, mostramos un mensaje de error
        $template->setVariable("ERROR", "No estás autorizado para ver este contenido");
    }

    $template->show(); // Mostramos la plantilla
?>