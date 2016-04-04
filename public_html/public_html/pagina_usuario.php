<? 

require_once "CLS_DATABASE.php"; 
AbrirConexion();



//Iniciar Sesion 
session_start();

if(!$_SESSION){
echo '<script language = javascript>
alert ("usuario no identificado")
self.location = "formulario.html"
</script>';

}


$id_usuario = $_SESSION[id_usuario];
?>


<html>

<head>
<title> Pagina del usuario    </title>
</head>
<form method='POST'>


<select name='usuario' onchange='submit()'>

<?php
 //Consultar los usuarios 

$TraerUsuarios = "Select * from usuarios_detail";
$rec = mysql_query($TraerUsuarios);


 
while ($row= mysql_fetch_array($rec))
{

echo "<option   value = '".$row['id_usuario_detalle']."'";
if($_POST['usuario']==$row['id_usuario_detalle'])
echo "Selected";

echo ">";
echo $row['correo'];

echo "</option>";

 
}

?>


</select>
<br>
<br>

ID Usuario : <input type="text" name="fname" value="holis"><br><br>
ID PLAZA: <input type="text" name="lname" disabled><br><br>
ID Almacen: <input type="text" name="lname" disabled><br><br>
Hora de envio : <input type="text" name="lname" disabled><br><br>
ID Cliente : <input type="text" name="lname" disabled><br><br>
</form>

<body>

</body>