<?php
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    crear_album.php
 * @brief:  Este archivo se encarga de insertar un album en la base de datos
 */
    include '../cfg_server.php';
    require_once "HTML/Template/ITX.php";
    $template = new HTML_TEMPLATE_ITX('../templates/albumes');
    
    if(!isset($_SESSION['username'])){
        echo "Error"; // No se puede insertar un album si es no has iniciado sesion
        return;
    }
    
    if(isset($_POST['nombre'])){
        $filename = "../static/uploads/"; // Direccion de donde vamos mover las imagenes
        $file = basename($_FILES['file']['name']);
        if (strlen($file) != 0) {
            $filename = $filename . $file;
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $filename)) { // Movemos las imagenes
                echo "Algo falló):";
            }
        } else {
            $file = "album.jpg"; // En caso de no mandar imagen, seleccionamos la por default
            $filename = $filename . $file;
        }

        $con = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
        // Recogemos todos los parametros
        $nombre = $_POST['nombre'];
        $tema = $_POST['tema'];
        $descripcion = $_POST['descripcion'];
        $tipo = $_POST['options'];
        $username = $_SESSION['username'];


        $query = "INSERT INTO Album(titulo, tema, descripcion, visitas, tipo, fecha_publicacion, cover, username) VALUES ('$nombre', '$tema', '$descripcion', 0, '$tipo', NOW(), '$filename', '$username')";

        if(mysqli_query($con, $query)){
            header('location: mensaje_exito.html'); // Redireccionamos a la pagina de exito
        }else{
            echo mysqli_error($con);
        }

        mysqli_close($con);

    }else{
        // Desplegamos los links de la barra de navegacion
        $template->loadTemplatefile("nuevo_album.html", true, true);
        if($_SESSION['tipo_usuario'] == 1)
            $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged_admin.html");
        else
            $template->addBlockfile("LINKS_NAVEGACION", "NAVEGACION", "../links_logged.html");
        $template->setCurrentBlock("NAVEGACION");
        $template->setVariable("FLAG", "");
        $template->parseCurrentBlock("NAVEGACION");
    
        $template->show();
    }


?>