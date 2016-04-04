<?php   
 


function AbrirConexion() {
$enlace =  mysql_connect('localhost', 'fmartinez', 'holamundo2016');
if (!$enlace) {
    die('No pudo conectarse: ' . mysql_error());
}
   
 $bd_seleccionada = mysql_select_db('DB_Desarrollo', $enlace); 
 
if (!$bd_seleccionada)
{
    die ('No se puede usar base de datos: ' . mysql_error());
}


}

?>