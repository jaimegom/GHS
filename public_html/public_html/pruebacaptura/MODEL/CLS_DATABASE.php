<?php   
function AbrirConexion() {
$enlace =  mysql_connect('localhost', 'ghsmetri_adiaz', 'AngelD1452015');
if (!$enlace) {
    die('No pudo conectarse: ' . mysql_error());
}
   
 $bd_seleccionada = mysql_select_db('ghsmetri_prueba', $enlace); 
 
if (!$bd_seleccionada)
{
    die ('No se puede usar base de datos: ' . mysql_error());
}

}

?>