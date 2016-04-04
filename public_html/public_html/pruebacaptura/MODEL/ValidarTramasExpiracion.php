<?php

date_default_timezone_set('America/Monterrey'); 	
require_once "CLS_DATABASE.php";
require_once('PHPMailer-master/PHPMailer-master/class.phpmailer.php');
AbrirConexion();

$correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()	 
	//Usamos el SetFrom para decirle al script quien envia el correo
	$correo->SetFrom("telemetria@ghsmetric.com", "telemetria@ghsmetric.com");	 
	//Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
	$correo->AddReplyTo("telemetria@ghsmetric.com","Reportes de Recarga ");	 
	//Usamos el AddAddress para agregar un destinatario
	$correo->AddAddress("info@ghsmetric.com","Destinatario"); 
	//Ponemos el asunto del mensaje
	$correo->Subject = "Falla";
$correo->IsHTML(false);


//Traer la ultima trama 
$Ultima_Trama_Validar = ("SELECT * 
			FROM  `trama` ORDER BY id_trama DESC
			LIMIT 1");
	//Ejecutar la sentencia anterior 
 	$Ejecutar_validacion= mysql_query($Ultima_Trama_Validar);
	//Pasar la informacion obtenida a un arreglo
	$Arreglo_Validacion= mysql_fetch_assoc($Ejecutar_validacion);
//Termina el Query de traer la ultima trama 




//Traer el string comienzo de la ultima hora 
                $CortarFechaValidacion = date("Y");
                $CortarFechaValidacion =  $CortarFechaValidacion."-";
		$CortarFechaValidacion =$CortarFechaValidacion.substr($Arreglo_Validacion['data'], 0,2);
		$CortarFechaValidacion =  $CortarFechaValidacion."-";
		$CortarFechaValidacion =$CortarFechaValidacion.substr($Arreglo_Validacion['data'], 2,2);
		$CortarFechaValidacion=  $CortarFechaValidacion." ";
		$CortarFechaValidacion =$CortarFechaValidacion.substr($Arreglo_Validacion['data'], 4,2);
		$CortarFechaValidacion =  $CortarFechaValidacion.":";
		$CortarFechaValidacion =$CortarFechaValidacion.substr($Arreglo_Validacion['data'], 6,2);
//Traer el string terminado




//Aqui realizo el string de fecha mas hora del servidor 
                
                $Fecha_Inicial_Servidor =date("Y");
                $Fecha_Inicial_Servidor =  $Fecha_Inicial_Servidor."-";
                $Fecha_Inicial_Servidor = $Fecha_Inicial_Servidor.date("m");
                $Fecha_Inicial_Servidor =  $Fecha_Inicial_Servidor."-";
                $Fecha_Inicial_Servidor = $Fecha_Inicial_Servidor.date("d");
                $Fecha_Inicial_Servidor =  $Fecha_Inicial_Servidor." ";
                $Fecha_Inicial_Servidor = $Fecha_Inicial_Servidor.date("G");
                $Fecha_Inicial_Servidor =  $Fecha_Inicial_Servidor.":";
                $Fecha_Inicial_Servidor = $Fecha_Inicial_Servidor.date("i");
//Termina la creacion de la hora del servidor


//Convertir String en DateTimes
                $dteStart = new DateTime($Fecha_Inicial_Servidor); 
  		$dteEnd   = new DateTime($CortarFechaValidacion);  
	 //Realizar la operacion
	 	 $dteDiff  = $dteStart->diff($dteEnd); 



$Traer_cliente_validacion= ("SELECT * 
			FROM  `cliente` where id_cliente = $Arreglo_Validacion[id_cliente]
			LIMIT 1");	
	$Ejecutar_validacion_cliente= mysql_query($Traer_cliente_validacion);
	//Pasar la informacion obtenida a un arreglo
	$Arreglo_Validacion_cliente= mysql_fetch_assoc($Ejecutar_validacion_cliente);
	
	
	
	$Traer_plaza_validacion= ("SELECT * 
			FROM  `plaza` where id_plaza = $Arreglo_Validacion[id_plaza] and id_cliente = $Arreglo_Validacion[id_cliente]
			LIMIT 1");	
	$Ejecutar_validacion_plaza= mysql_query($Traer_plaza_validacion);
	//Pasar la informacion obtenida a un arreglo
	$Arreglo_Validacion_plaza= mysql_fetch_assoc($Ejecutar_validacion_plaza);
	
	
	$dteDiff =  $dteDiff->format("%H");
	
	
	if ($dteDiff >= 1 ) 
	{
	
	$correo->Body =$fechaFormato." ".$HoraFormatoCorrecto." ".$Arreglo_Validacion_cliente['nombre_cliente']." ".$Arreglo_Validacion_plaza['nombre_plaza'];
	
	if(!$correo->Send()) {
		  //echo "Hubo un error: " . $correo->ErrorInfo;
		} else {
		//  echo "Mensaje enviado con exito.";
		}
	}
	else {
	
	//echo "Correcto";
	
	}
	


?>