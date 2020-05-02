<?php
     include '../cfg_server.php';
    $con = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    if(!($con)){ // Si ocurrió un error en la conexion, imprimos que ha ocurrido un error
        echo "Ha ocurrido un error";
        return;
    }
    $flag = 0;
    $filename = "../static/uploads/"; // Direccion de donde vamos mover las imagenes
    $file = basename($_FILES['file']['name']);
    if(strlen($file) != 0){
        $filename = $filename.$file;
        if(!move_uploaded_file($_FILES['file']['tmp_name'], $filename)){ // Movemos las imagenes
            echo "Algo falló):";
        }
    }else{
        $file = "replace.png";// En caso de no mandar imagen, seleccionamos la por default
        $filename = $filename.$file;
        $flag = 1;
    }

    /* LEEMOS LOS DATOS QUE NOS LLEGAN VIA POST */
    $username = $_SESSION['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $apPat = $_POST['apPat'];
    $apMat = $_POST['apMat'];
    $escolaridad = $_POST['escolaridad'];
    $fecnac = $_POST['fecnac'];
    $direccion = $_POST['direccion'];

    if($flag == 0)
        $query = "UPDATE Usuario SET password ='$password', foto = '$filename', direccion = '$direccion', escolaridad = '$escolaridad', mail ='$email', nombre = '$nombre', ap_paterno = '$apPat', ap_materno = '$apMat', fecha_nacimiento = '$fecnac' WHERE username = '$username'";
    else
        $query = "UPDATE Usuario SET password ='$password', direccion = '$direccion', escolaridad = '$escolaridad', mail ='$email', nombre = '$nombre', ap_paterno = '$apPat', ap_materno = '$apMat', fecha_nacimiento = '$fecnac' WHERE username = '$username'";


    if(mysqli_query($con, $query)){ // INSERTAMOS EN LA BD Y REDIRECCIONAMOS A PANTALLA DE REGISTRO EXITOSO
        $_SESSION['username'] = $username;
       header('location: registro_exitoso.html');
    }else{
        echo "Ha ocurrido un error";
    }

    mysqli_close($con); // CERRAMOS LA CONEXION
?>