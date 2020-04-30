<?php
    include '../cfg_server.php';
    require_once 'HTML/Template/ITX.php';

    $template = new HTML_TEMPLATE_ITX("../templates");
    $template->loadTemplatefile("errorUsername.html", true, true);
    $username = $_POST['username'];

    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    if(!($link)){
        echo "Ha ocurrido un error";
        return;
    }

    $query = "SELECT username FROM Usuario WHERE username = '$username'";
    
    if(!($result = mysqli_query($link, $query))){
        echo "Ha ocurrido un error";
        return;
    }

    if(mysqli_num_rows($result) >= 1){
        $template->setVariable("MENSAJE_ERROR", "Username no disponible");
    }else{
        $template->setVariable("MENSAJE_ERROR", "Username");
    }

    $template->show();

?>