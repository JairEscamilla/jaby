<?php 
/*
 * @author:  Allan Jair Escamilla Hernández, María Gabriela Uribe 
 * @date:    9/mayo/2020
 * @file:    logout.php
 * @brief:  Este archivo se encarga de destruir las variables de sesion
 */
    // Destruimos todas las variables de sesion y redireccionamos al index
    session_start();
    $_SESSION = array();
    session_destroy();  
    header('location: ../index.php');
?>