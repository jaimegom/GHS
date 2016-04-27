<?php
//Traer clase de acceso a datos

session_start();

if ((isset($_COOKIE['username']) && isset($_COOKIE['password'])) ||  isset($_SESSION['username']) ){
    if(!isset($_SESSION['username'])){
        session_start();
        $_SESSION['username']  = $_COOKIE['username'];
    }
    //no redirigimos a ningun sitio, solo dejamos que deje pasar al sitio soliticado
    //header('Location: Clientes.php');
    //header('Location: confirmarSession.php');

}else{
    session_start();
    header('Location: ../../../home.php?error=2');
}


?>