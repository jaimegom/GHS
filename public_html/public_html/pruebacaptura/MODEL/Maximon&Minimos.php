<?php 
require_once "CLS_DATABASE.php"; 
require_once ('Classes/PHPExcel.php');
require_once "InsertarBitacora.php";
AbrirConexion();
date_default_timezone_set('America/Monterrey'); 
function PasarDatosReporteMaximo($Reg){
if(!empty($Reg[0]) && !empty($Reg[1]) && !empty($Reg[2]) && !empty($Reg[3]) && !empty($Reg[4]) && !empty($Reg[5]) && !empty($Reg[6]) && !empty($Reg[7]) && !empty($Reg[8])) 
			{
			
			//realizar la consulta , donde tambien nos traemos los usuarios a los cuales mandaremos el correo
			$sql = sprintf("SELECT * 
FROM usuarios_detail UD
LEFT JOIN almacen a ON UD.id_almacen = a.id_almacen
AND UD.id_plaza = a.id_plaza
LEFT JOIN plaza P ON a.id_plaza = P.id_plaza
LEFT JOIN cliente C ON P.id_cliente = C.id_cliente
WHERE C.id_cliente =  '$Reg[1]'
AND P.id_plaza =      '$Reg[2]'
AND P.id_cliente =    '$Reg[1]'
AND a.id_almacen =    '$Reg[5]'
AND a.id_cliente =    '$Reg[1]'
AND a.id_plaza =      '$Reg[2]'
AND UD.id_cliente =   '$Reg[1]'
AND UD.Reporte3 = '1'");
				 
				
				$resultado = mysql_query($sql);
while ($fila = mysql_fetch_assoc($resultado )) 
  {

  				 		//Encontrar la informacion de la plaza de cada usuario
						$InformacionPlaza = ("SELECT * FROM  `plaza` WHERE id_plaza='$fila[id_plaza]' LIMIT 1");
						$ConsultarPlaza  = mysql_query($InformacionPlaza);
						$HacerArregloPlaza = mysql_fetch_assoc($ConsultarPlaza);


 //Cortar fecha para obtener solo digitos de dias
			$CortarFecha = substr($Reg[0], 0,4);	
			$fechaFormato =substr($CortarFecha,0,2);
		 	$fechaFormato .="/";
		 	$fechaFormato .=substr($CortarFecha,2,2);
		 	$fechaFormato .="/";
		 	$fechaFormato .=date("Y");	
//Cortar hora para obtener solo digitos de hora 
			$CortarHora  = substr($ArregloDeTrama['data'], 4,7);
			$horauno= date("Hisa");
			$HoraFormatoCorrecto = substr($horauno, 0,2);
			$HoraFormatoCorrecto .=":";
			$HoraFormatoCorrecto .=substr($horauno,2,2);
			$HoraFormatoCorrecto .= " ";
			$HoraFormatoCorrecto .= "hrs";


//Sacar el valor de la um1
			$Producto  = ($Reg[6]* $fila[capacidad] * $fila[factor])/100;
			$Producto = number_format($Producto,2,'.',',');
//Revisar si esta activado el campo del segundo factor 
//Si el campo de act es igual a 1 entonces quiere decir que reporta en el segundo tipo de factor tambien.


if ($fila[act] == 1) {


   $Producto2 = ($Reg[6] / 100) * $fila[capacidad] * $fila[factor2];
   $Producto2 = number_format($Producto2,2,'.',',');
   
		        $correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()	 
//Usamos el SetFrom para decirle al script quien envia el correo
			$correo->SetFrom("telemetria@ghsmetric.com", "telemetria@ghsmetric.com");	 
//Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
			$correo->AddReplyTo("telemetria@ghsmetric.com","Reportes de Recarga ");	 
//Usamos el AddAddress para agregar un destinatario
			$correo->AddAddress($fila['correo'], "Reporte Nivel Maximo alcanzado");	

//Ponemos el asunto del mensaje
			$correo->Subject = "Nivel Maximo "."  ".$fila['nombre_plaza'];
			$correo->IsHTML(false);
	 		
	 		//Generamos el cuerpo del correo.
	 		
	 		$correo->Body =$fechaFormato ."  ".$HoraFormatoCorrecto."  "."  ".$fila['nombre_cliente']."  ".$fila['nombre_plaza']." Almacen ".$Reg[5].", "."Nivel Maximo alcanzado se ha llegado al : "." ".$Reg[6]."%,"." ".$Producto." ".$fila[um1]."  "."Aproximadamente : "."  ".$Producto2." ".$fila[um2];


//Seteamos valores para bitacora
			$TipoReporte="3";
			$HoraActualBitacora = date("Hisa");
			$FechaActualBitacora=date("d/m/Y"); 
	 InsertarBitacoraReporte2($fila['correo'],$TipoReporte,$FechaActualBitacora,$HoraActualBitacora,$fila[id_cliente],$fila[id_plaza],$Producto,$ArregloDeTrama[tanque1],$Producto2);
	 
	//Enviamos el correo
		if(!$correo->Send()) {
		 // echo "Hubo un error: " . $correo->ErrorInfo;
		} else {
		 // echo "Mensaje enviado con exito.";
		}

   
   
   
   
   
   
   
}

 else {




$correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()	 
	//Usamos el SetFrom para decirle al script quien envia el correo
	$correo->SetFrom("telemetria@ghsmetric.com", "telemetria@ghsmetric.com");	 
	//Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
	$correo->AddReplyTo("telemetria@ghsmetric.com","Reportes de Recarga ");	 
	//Usamos el AddAddress para agregar un destinatario
	$correo->AddAddress($fila['correo'], "Reporte Nivel Maximo alcanzado");	

	//Ponemos el asunto del mensaje
	$correo->Subject = "Nivel Maximo "."  ".$fila['nombre_plaza'];

	 $correo->IsHTML(false);
	 $correo->Body =$fechaFormato ."  ".$HoraFormatoCorrecto."  "."  ".$fila['nombre_cliente']."  ".$fila['nombre_plaza']." Almacen  ".$Reg[5].", "."Nivel Maximo alcanzado se ha llegado al : "." ".$Reg[6]."%,"." ".$Producto." ".$fila[um1];
	 
	 $TipoReporte="3";
	$HoraActualBitacora = date("Hisa");
	$FechaActualBitacora=date("d/m/Y");
	 InsertarBitacoraReporte1($fila['correo'],$TipoReporte,$FechaActualBitacora,$HoraActualBitacora,$fila[id_cliente],$fila[id_plaza],$Producto,$ArregloDeTrama[tanque1]);
	 
	//Enviamos el correo
		if(!$correo->Send()) {
		  //echo "Hubo un error: " . $correo->ErrorInfo;
		} else {
		 // echo "Mensaje enviado con exito.";
		}







 }

 

} 
try {
} catch (Exception $e) {
    echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
}
 
	}
	}
 
 
 
?>