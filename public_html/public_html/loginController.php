<?php
//Traer clase de acceso a datos


require_once "LoginModelo.php";

if (isset($_COOKIE['username']) && isset($_COOKIE['password'])){
    if(!isset($_SESSIONS)){
        session_start();
        $_SESSION['username']  = $_COOKIE['username'];
    }
echo "pase usted ".$_COOKIE['username'];
}else{
    $loginModelo = new LoginModelo();
    $usuarioValido = $loginModelo->usuarioValido($_POST['form-username'], $_POST['form-password']);
    if($usuarioValido){
        if (isset($_POST['rememberme'])) {
            setcookie('username', $_POST['form-username'], time() + (86400 * 30), "/");
            setcookie('password', md5($_POST['form-password']), time() + (86400 * 30), "/");
        }
        session_start();
        $_SESSION['username']  = $_POST['form-username'];
        echo "pase usted sin cookies ".$_POST['form-username'];

    }
    else{
        echo "contraseña incorrecta";
        //header('Location: login.html');
    }
}




?>