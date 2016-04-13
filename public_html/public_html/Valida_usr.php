<?
//Traer clase de acceso a datos


require_once "CLS_DATABASE.php";

$con= new ConfigDB();

AbrirConexion();



//Inicio de Variable Sesions

if(!isset($_SESSIONS)){
session_start();

}


//Recibir los datos del formulario


$Usuario  = $_POST['form-username'];
$Contrasena = $_POST['form-password'];


//Consultar los datos de ususario

$query="SELECT * FROM usuarios_header WHERE nombre_usuario='$Usuario' and password = '$Contrasena'";
$ValidaPrueba= mysql_query($query);
$fila = mysql_fetch_array($ValidaPrueba);

 if($fila[id_usuario] == 0 )
 {

 header("Location: home.html");

 }


 else

 {

 //Definimos Variable de sesion y mandamos a la pagina de usuario

 $_SESSION['id_usuario'] = $fila['id_usuario'];
 $_SESSION['nombre_usuario'] = $fila['nombre_usuario'];

 header("Location: pagina_usuario.php");

 }


?>