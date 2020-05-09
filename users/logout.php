<?php 
    // Destruimos todas las variables de sesion y redireccionamos al index
    session_start();
    $_SESSION = array();
    session_destroy();  
    header('location: ../index.php');
?>