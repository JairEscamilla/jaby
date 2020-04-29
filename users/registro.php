<?php 
    include '../cfg_server.php';
    $con = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    if(!($con)){
        echo "Ha ocurrido un error";
        return;
    }
    $filename = "../static/uploads/";
    $file = basename($_FILES['file']['name']);
    if(strlen($file) != 0){
        $filename = $filename.$file;
        if(!move_uploaded_file($_FILES['file']['tmp_name'], $filename)){
            echo "Algo falló):";
        }
    }else{
        $file = "replace.png";
        $filename = $filename.$file;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $apPat = $_POST['apPat'];
    $apMat = $_POST['apMat'];
    $escolaridad = $_POST['escolaridad'];
    $fecnac = $_POST['fecnac'];
    $direccion = $_POST['direccion'];

    $query = "INSERT INTO Usuario VALUES('$username', '$password', false, '$filename', '$direccion', '$escolaridad', '$email', '$nombre', '$apPat', '$apMat', '$fecnac')";

    if(mysqli_query($con, $query)){
        header('location: ../index.html');
    }else{
        echo "Ha ocurrido un error";
    }

    mysqli_close($con);
?>