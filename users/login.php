<?php
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates');
    $template->loadTemplatefile("respuestaLogin.html", true, true);
    $username = $_POST['username']; // Recogemos los valores que nos mandaron
    $password = $_POST['password'];
    $error = 0;
    // Validamos en contra de SQL injection
    if(count(explode("'", $username)) > 1 || count(explode("'", $password)) > 1){
        $error = 1;
    }
    if($error == 0){
        $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
        if(!($link)){ // En caso de error retornamos
            echo "Ha ocurrido un error";
            return;
        }
        $query = "SELECT username, password, tipo_usuario FROM Usuario WHERE username = '$username' AND password = '$password'";
        
        if (!($result = mysqli_query($link, $query))) { // Obtenemos el resultado del query
            echo mysqli_error($link);
            return;
        }
        $fields = mysqli_fetch_assoc($result);
        if(mysqli_num_rows($result) == 1){ // En caso de que solo haya un resultado, logeamos al user
            $template->setVariable("RESPUESTA", "logged");
            $_SESSION['username'] = $username;
            $_SESSION['tipo_usuario'] = $fields['tipo_usuario'];
        }else 
            $template->setVariable("RESPUESTA", "error");
        mysqli_close($link); // Cerramos la variable
    }else
        $template->setVariable("RESPUESTA", "error asd");

    $template->show(); // Mostramos el template
?>