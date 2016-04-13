<?php
require_once "objetoPHP.php";

$objetoPHP = new objetoPHP();
/*
//Consultar los datos de ususario
$query="SELECT * FROM usuarios_header WHERE nombre_usuario='$Usuario' and password = '$Contrasena'";
$ValidaPrueba= mysql_query($query);
$fila = mysql_fetch_array($ValidaPrueba);
*/
$Contrasena = "coco";
$Usuario="francisco";
$bool = $objetoPHP->usuarioValido($Usuario, $Contrasena);
if($bool){

  echo "yes";
}

?>