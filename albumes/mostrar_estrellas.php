<?php
    include '../cfg_server.php';
    $link = mysqli_connect($cfg['host'], $cfg['user'], $cfg['password'], $cfg['db']);
    if(!isset($_SESSION['username'])){
        echo "No has iniciado sesión";
        return;
    }
    $album = $_POST['album'];
    $username = $_SESSION['username'];
    $query = "SELECT calificacion, id_foto FROM Calificaciones WHERE id_foto IN (SELECT id_foto FROM Fotos WHERE id_album = '$album') AND username = '$username'";
    
    $result = mysqli_query($link, $query);

    $response = array();
    while($fields = mysqli_fetch_assoc($result)){
        array_push($response, $fields);
    }

    echo json_encode($response);
    mysqli_close($link);
?>