<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/administracion');
    $template->loadTemplatefile("fotos_comentadas.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    if (!isset($_SESSION['username']) || $_SESSION['tipo_usuario'] == 0) {
        echo "Acceso denegado";
        return;
    }
    $username = $_GET['username'];
    $template->setVariable("USERNAME", $username);
    $query = "SELECT direccion_foto FROM Comentarios LEFT JOIN Fotos USING(id_foto) WHERE username = '$username' GROUP BY id_foto";
    $result = mysqli_query($link, $query);

    $template->addBlockfile("IMAGENES", "IMAGENES", "contenedor_imagen_comentada.html");
    $template->setCurrentBlock("IMAGENES");
    while($fields = mysqli_fetch_assoc($result)){
        $template->setCurrentBlock("IMAGEN");
        $template->setVariable("FOTO", $fields['direccion_foto']);
        $template->parseCurrentBlock("IMAGEN");
    }
    $template->parseCurrentBlock("IMAGENES");

    $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged_admin.html");
    $template->setCurrentBlock("NAVEGACION");
    $template->setVariable("FLAG", "");
    $template->parseCurrentBlock("NAVEGACION");
    mysqli_close($link);
    $template->show();
?>