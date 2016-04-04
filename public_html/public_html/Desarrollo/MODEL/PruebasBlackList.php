<?php 
	  
require_once('PHPMailer-master/PHPMailer-master/class.phpmailer.php');
	  $correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()
	  
 	
	//Usamos el SetFrom para decirle al script quien envia el correo
	$correo->SetFrom("fmartinez16@a2plcpnl0544.prod.iad2.secureserver.net", "telemetria@ghsmetric.com");	 
	//Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
	//$correo->AddReplyTo("jaimegomez10@live.com","Reportes de Recarga ");	 
	//Usamos el AddAddress para agregar un destinatario
	$correo->AddAddress( "jaimegomez1994@gmail.com", "Reporte Recarga");
	$correo->AddCC("jaimegomez10@live.com");	
	
	//$correo->AddAddress( "jaimegomez1994@gmail.com", "Reporte Recarga");	
	//$correo->AddAddress("frankymr11@gmail.com", "Reporte Carga ");	 
	//Ponemos el asunto del mensaje
	$correo->Subject = "Recarga";

	 $correo->IsHTML(true);
	 $correoBody = "wqeqw";

	 $correo->Body =  $correoBody;
	 //"  ".$fechaFormato ."  ".$HoraFormatoCorrecto."  ".$InfoUsuarioArray['nombre_cliente']."  ".$InfoUsuarioArray['nombre_plaza']."  "."Recarga detectada en almacen : "." ".$Reg[7]."Se reciben : "." ".$ProductoUM1." ".$InfoUsuarioArray['um1'];
	 




	 
	 
	//Enviamos el correo
		if(!$correo->Send()) {
		  echo "Hubo un error: " . $correo->ErrorInfo;
		} else {
		  echo "Mensaje enviado con exito.";
		}
		
		?>
	