<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    buscar_usuarios.php
 * @brief:  Este archivo se encarga realizar la busqueda de usuarios para el administrador, de acuerdo a lo que introduzca en un input, este archivo se llama mediante AJAX
 */
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/administracion');
    $template->loadTemplatefile("resultado_busqueda.html", true, true);
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    $busqueda = $_POST['busqueda'];
    $query = "SELECT username, password, tipo_usuario, foto, direccion, escolaridad, mail, nombre, ap_paterno, ap_materno, fecha_nacimiento, COUNT(id_album) cuenta FROM Usuario LEFT JOIN Album USING(username) WHERE username LIKE '%".$busqueda."%' OR nombre LIKE '%".$busqueda."%' OR tipo_usuario LIKE '%".$busqueda."%' GROUP BY Usuario.username;";
    $result = mysqli_query($link, $query);

    // Una vez que tenemos el resultado del query de busqueda, desplegamos un template con los datos de los usuarios que hayan coincidido con la busqueda

    $template->addBlockfile("RESULTADO", "USUARIOS", "card_usuarios.html");
    $template->setCurrentBlock("USUARIOS");
    while ($fields = mysqli_fetch_assoc($result)) {
        $template->setCurrentBlock("USUARIO");
        $template->setVariable("NOMBRE", $fields['nombre']);
        $template->setVariable("AP_PATERNO", $fields['ap_paterno']);
        $template->setVariable("AP_MATERNO", $fields['ap_materno']);
        $template->setVariable("USERNAME", $fields['username']);
        $template->setVariable("EMAIL", $fields['mail']);
        $template->setVariable("DIRECCION", $fields['direccion']);
        $template->setVariable("ESCOLARIDAD", $fields['escolaridad']);
        if ($fields['tipo_usuario'] == 1)
            $template->setVariable("TIPO_USUARIO", "Administrador");
        else
            $template->setVariable("TIPO_USUARIO", "Usuario normal");
        $template->setVariable("FECNAC", $fields['fecha_nacimiento']);
        $template->setVariable("NUMERO_ALBUMES", $fields['cuenta']);
        $template->setVariable("IMAGEN", $fields['foto']);

        $template->parseCurrentBlock("USUARIO");
    }
    $template->parseCurrentBlock("USUARIOS");

    mysqli_close($link);
    $template->show();
?>