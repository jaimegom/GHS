<?

require_once "CLS_DATABASE.php";
require_once('PHPMailer-master/PHPMailer-master/class.phpmailer.php');
require_once ('Classes/PHPExcel.php');
require_once "InsertarBitacora.php";
AbrirConexion();
date_default_timezone_set('America/Monterrey'); 
 			//Hora actual en que se ejecuta 
$var = date('H:i');
//Sentencia que encuentra todos los usuarios que coincidan con la hora actual 
$sql = sprintf("SELECT * FROM usuarios_detail UD
		LEFT JOIN almacen a ON UD.id_almacen = a.id_almacen
		AND UD.id_plaza = a.id_plaza
		LEFT JOIN plaza P ON a.id_plaza = P.id_plaza
		LEFT JOIN cliente C ON P.id_cliente = C.id_cliente
		WHERE UD.hora_rutina =  '$var' AND UD.Reporte1 = '1' AND UD.id_cliente = P.id_cliente
AND UD.id_cliente = a.id_cliente
AND UD.id_plaza = a.id_plaza
AND a.id_almacen = UD.id_almacen");
//Ejecutar la sentencia anterior 
$resultado = mysql_query($sql);
// Validacon de la correcta ejecucion de la sentencia anterior 
if (!$resultado) {
	$mensaje  = 'Consulta no valida:    ' . mysql_error() . "\n";    						 
    	$mensaje .= 'Consulta completa:      ' . $consulta;
   	die($mensaje);
}

while ($fila = mysql_fetch_assoc($resultado )) {
	
	//Traer la ultima trama corresondiente a los datos obtenidos en cada while 
  	$TraerUltimaTrama = ("SELECT * FROM  `trama` 
				WHERE id_cliente =  '$fila[id_cliente]'
				AND id_plaza =  '$fila[id_plaza]'
				AND tipo_dato =  '1'		
				ORDER BY id_trama DESC 
				LIMIT 1");
	//Ejecutar la sentencia anterior 
 	$Ejecutar = mysql_query($TraerUltimaTrama);
	//Pasar la informacion obtenida a un arreglo
	$ArregloDeTrama = mysql_fetch_assoc($Ejecutar);
	
	
	//Encontrar la informacion de la plaza de cada usuario
	$InformacionPlaza = ("SELECT * FROM  `plaza` WHERE id_plaza='$fila[id_plaza]' LIMIT 1");
	$ConsultarPlaza  = mysql_query($InformacionPlaza);
	$HacerArregloPlaza = mysql_fetch_assoc($ConsultarPlaza);

	 //Cortar fecha para obtener solo digitos de dias
	$CortarFecha = substr($ArregloDeTrama['data'], 0,4);
	
	
	$fechaFormato =substr($CortarFecha,0,2);
		 	$fechaFormato .="/";
		 	$fechaFormato .=substr($CortarFecha,2,2);
		 	$fechaFormato .="/";
		 	$fechaFormato .=date("Y");
	
	
	//Cortar hora para obtener solo digitos de hora 
	$CortarHora  = substr($ArregloDeTrama['data'], 4,7);
	$CortarHoraVal  = substr($ArregloDeTrama['data'], 4,2);
	
	

$horauno= date("Hisa");
$HoraFormatoCorrecto = substr($horauno, 0,2);
$HoraFormatoCorrecto .=":";
$HoraFormatoCorrecto .=substr($horauno,2,2);
$HoraFormatoCorrecto .= " ";
$HoraFormatoCorrecto .= "hrs";





	//Sacar el valor de la um1
$Producto  = ($fila[capacidad] * $fila[factor] * $ArregloDeTrama[p_tqe1]) / 100;
	
$Producto = number_format($Producto,2,'.',',');
	
		
	//Validar cuantos almacenes tiene 
	if ($ArregloDeTrama [tanque2] == 2) {
	
	$traerinfomraciondelsegundoalmacen= ("SELECT * FROM  `almacen` 
				WHERE id_cliente =  '$fila[id_cliente]'
				AND id_plaza =  '$fila[id_plaza]'
				AND id_almacen =  '2'");
	
	$ConsultarInformacion= mysql_query($traerinfomraciondelsegundoalmacen);
	$ResultadoSegundoAlmacen= mysql_fetch_assoc($ConsultarInformacion);
		
	//Formula para el segundo almacen
   	$SegundoAlmacen = ($ResultadoSegundoAlmacen[capacidad] * $ResultadoSegundoAlmacen[factor] * $ArregloDeTrama[p_tqe2]) / 100;
   	   		$SegundoAlmacen = number_format($SegundoAlmacen,2,'.',',');
   	//Cuando esta activada la opción del factor 2 en el almacen 2
	$Cantidaddelalmacen2 = 	$SegundoAlmacen  *  $ResultadoSegundoAlmacen[factor2];
		
//Sacar el valor de la um1

	
	//Cuando esta activada la opcion del factor 2 para el primer almacen
   	$Producto2 = $Producto * $fila[factor2];
   		$Producto2 = number_format($Producto2,2,'.',',');
   	
   	$correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()	 
	//Usamos el SetFrom para decirle al script quien envia el correo
	$correo->SetFrom("telemetria@ghsmetric.com", "telemetria@ghsmetric.com");	 
	//Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
	$correo->AddReplyTo("telemetria@ghsmetric.com","Reportes de Recarga ");	 
	//Usamos el AddAddress para agregar un destinatario
	$correo->AddAddress($fila['correo'], "Reporte Inventario");	
 
	//Ponemos el asunto del mensaje
	$correo->Subject = "Inventarios"."  ".$fila['nombre_plaza'];
$correo->IsHTML(false);

 if ($fila[act] == 1) {
	 
	 
	 if ($ResultadoSegundoAlmacen[act] == 1)
	 {
	 
	 
	  $correo->Body = " ".$fechaFormato ."  ".$HoraFormatoCorrecto."  ".$fila['nombre_cliente']."  ".$fila['nombre_plaza']."  "."Almacen  ".$fila['id_almacen']." Reporta : ".$Producto."  ".$fila[um1]." ".",". 	$ArregloDeTrama[p_tqe1]."%"."  "."Aproximadamente"."  	".$Producto2." ".$fila[um2]."\r\n"." Almacen 2 "."Reporta : ".$SegundoAlmacen." ".$ResultadoSegundoAlmacen[um1]." , ".$ArregloDeTrama[p_tqe2]."%"."Aproximadamente"."  	".$Cantidaddelalmacen2 ." ".$ResultadoSegundoAlmacen[um2];
	  
	  
	 }
	 
	 
	 
	 else {
	 
	 
	  $correo->Body = " ".$fechaFormato ."  ".$HoraFormatoCorrecto."  ".$fila['nombre_cliente']."  ".$fila['nombre_plaza']."  "."Almacen  ".$fila['id_almacen']." Reporta : ".$Producto."  ".$fila[um1]." ".",". 	$ArregloDeTrama[p_tqe1]."%"."  "."Aproximadamente"."  	".$Producto2." ".$fila[um2]."\r\n"." Almacen 2 "."Reporta :  ".$SegundoAlmacen." ".$ResultadoSegundoAlmacen[um1]." , ".$ArregloDeTrama[p_tqe2]."%";
	 
	 
	 } 
	 
	 }
	 
	 
	 
	 else {
	 
	 
	 if ($ResultadoSegundoAlmacen[act] == 1)
	  {
	 
	 $correo->Body = " ".$fechaFormato ."  ".$HoraFormatoCorrecto."  ".$fila['nombre_cliente']."  ".$fila['nombre_plaza']."  "."Almacen  ".$fila['id_almacen']." Reporta : ".$Producto."  ".$fila[um1]." ".",". 	$ArregloDeTrama[p_tqe1]."%"."  "." \r\n"."Almacen 2 "."Reporta : ".$SegundoAlmacen."  ".$ResultadoSegundoAlmacen[um1]." ,".$ArregloDeTrama[p_tqe2]."%"."Aproximadamente"."  	".$Cantidaddelalmacen2 ." ".$ResultadoSegundoAlmacen[um2];
	 
	 
	 }
	 
	 else {
	 
	  $correo->Body = " ".$fechaFormato ."  ".$HoraFormatoCorrecto."  ".$fila['nombre_cliente']."  ".$fila['nombre_plaza']."  "."Almacen  ".$fila['id_almacen']." Reporta : ".$Producto."  ".$fila[um1]." ".",". 	$ArregloDeTrama[p_tqe1]."%"."  "."\r"."Almacen  2 "."Reporta : ".$SegundoAlmacen."  ".$ResultadoSegundoAlmacen[um1]." ,".$ArregloDeTrama[p_tqe2]."%";
	 
	 }
	 }
	 

$TipoReporte="1";
	$HoraActualBitacora = date("Hisa");
	$FechaActualBitacora=date("d/m/Y");	 InsertarBitacoraReporte2($fila['correo'],$TipoReporte,$FechaActualBitacora,$HoraActualBitacora,$fila[id_cliente],$fila[id_plaza],$Producto,$ArregloDeTrama[tanque1],$Producto2);
//Enviamos el correo

$fechaActualServer = date("md"); 
	$HoraValidacion= date("Hisa");
	$HoraFormatoCorrectoValidacion = substr($HoraValidacion, 0,2);
        	
	/*if ($fechaActualServer > $CortarFecha ) {

	echo "CORREO AL ADMIN Fechas1";	
	
	
	}
	
	else {
	
//Si no es mayor ahora debemos validar la hora 




if ($HoraFormatoCorrectoValidacion > $CortarHoraVal) {
	 
	//Mandar mensaje al admin 
	echo "CORREO AL ADMIN hora 1";
	}
	
	else {
	//Mandar el correo 
	if(!$correo->Send()) {
		  //echo "Hubo un error: " . $correo->ErrorInfo;
		} else {
		  echo "Mensaje enviado con exito.";
		}

	}

	
	}
*/

if(!$correo->Send()) {
		  //echo "Hubo un error: " . $correo->ErrorInfo;
		} else {
		  echo "Mensaje enviado con exito.";
		}




		


} 

 
 
 else {
 
 
 $horauno= date("Hisa");
$HoraFormatoCorrecto = substr($horauno, 0,2);
$HoraFormatoCorrecto .=":";
$HoraFormatoCorrecto .=substr($horauno,2,2);
$HoraFormatoCorrecto .= " ";
$HoraFormatoCorrecto .= "hrs";
 
 $correo = new PHPMailer();	 

	//Usamos el SetFrom para decirle al script quien envia el correo
	$correo->SetFrom("telemetria@ghsmetric.com", "telemetria@ghsmetric.com");
	 
	//Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
	$correo->AddReplyTo("telemetria@ghsmetric.com","Reportes de Recarga ");	 
	//Usamos el AddAddress para agregar un destinatario

	$correo->AddAddress($fila['correo'], "Reporte Inventario");	
 
 //Ponemos el asunto del mensaje

	$correo->Subject = "Inventarios "."  ".$fila['nombre_plaza'];

	 $correo->IsHTML(false);
 
 
 if($fila[act] == 1) {
 
 
 

   	$Producto2 = $Producto * $fila[factor2];
   		$Producto2 = number_format($Producto2,2,'.',',');

$correo->Body = " ".$fechaFormato ."  ".$HoraFormatoCorrecto."  ".$fila['nombre_cliente']."  ".$fila['nombre_plaza']."  "."Almacen  ".$fila['id_almacen']." Reporta :".$Producto."  ".$fila[um1]." ".",". 	$ArregloDeTrama[p_tqe1]."%"." Aproximadamente :  ".$Producto2." ".$fila[um2];
}

else {

$correo->Body = " ".$fechaFormato ."  ".$HoraFormatoCorrecto."  ".$fila['nombre_cliente']."  ".$fila['nombre_plaza']."  "."Almacen  ".$fila['id_almacen']." Reporta : ".$Producto."  ".$fila[um1]." ".",". 	$ArregloDeTrama[p_tqe1]."%";

}	 
 
 
 
 $TipoReporte="1";
	$HoraActualBitacora = date("Hisa");
	$FechaActualBitacora=date("d/m/Y");
	 //InsertarBitacoraReporte1($fila['correo'],$TipoReporte,$CortarFecha,$CortarHora,$fila[id_cliente],$fila[id_plaza],$Producto,$ArregloDeTrama[tanque1]);
	
	 InsertarBitacoraReporte1($fila['correo'],$TipoReporte,$FechaActualBitacora,$HoraActualBitacora,$fila[id_cliente],$fila[id_plaza],$Producto,$ArregloDeTrama[tanque1]);
 //Enviamos el correo
 
 
 
 $fechaActualServer = date("md"); 
	$HoraValidacion= date("Hisa");
	$HoraFormatoCorrectoValidacion = substr($HoraValidacion, 0,2);
        $HoraFormatoCorrectoValidacion .=substr($HoraValidacion,2,2);	
	if(!$correo->Send()) {
		  //echo "Hubo un error: " . $correo->ErrorInfo;
		} else {
		  echo "Mensaje enviado con exito.";
		}
	
	
	
	
/*	
	if ($fechaActualServer > $CortarFecha ) {

	echo "CORREO AL ADMIN Fechas 2";	
	
	
	}
	
	else {
	
//Si no es mayor ahora debemos validar la hora 

if ($HoraFormatoCorrectoValidacion > $CortarHoraVal) {
	 
	//Mandar mensaje al admin 
	echo "CORREO AL ADMIN horas 2";
	}
	
	else {
	//Mandar el correo 
	
	if(!$correo->Send()) {
		  //echo "Hubo un error: " . $correo->ErrorInfo;
		} else {
		  echo "Mensaje enviado con exito.";
		}
	
	}

	
	
	
	}
 */
 
 
		 
 
 
 
 }
 










 }
 
 
 try {
} catch (Exception $e) {
    echo 'Excepci車n capturada: ',  $e->getMessage(), "\n";
}
 



?>