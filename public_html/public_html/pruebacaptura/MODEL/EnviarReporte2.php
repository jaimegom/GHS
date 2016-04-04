<?php 



require_once ('CLS_DATABASE.php'); 
require_once('PHPMailer-master/PHPMailer-master/class.phpmailer.php');
require_once ('Classes/PHPExcel.php');
require_once "InsertarBitacora.php";
date_default_timezone_set('America/Monterrey'); 
 AbrirConexion();


function PasarDatosReporteRecarga($Reg ){	
if(!empty($Reg[0]) && !empty($Reg[1]) && !empty($Reg[2]) && !empty($Reg[3]) && !empty($Reg[4]) && !empty($Reg[5]) && !empty($Reg[6]) && !empty($Reg[7])) {
//echo "entro a if<br>";
try{
		
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
	AND UD.Reporte2=   1
	");
			
	$resultadoUsuariosHeader= mysql_query($sql );
				

	$Ultimas5TramasSQL = sprintf("
	SELECT 
	* 
	FROM(
		SELECT * 
		FROM detalle_reportes
		WHERE id_cliente =  '$Reg[1]'
		AND id_plaza =  '$Reg[2]'
		AND id_almacen =  '$Reg[5]'
		AND tipo_reporte =  '$Reg[3]'
		group by data
		ORDER BY id_detalle_reporte desc
		) as detalle
	
	ORDER BY id_detalle_reporte ASC
	");
	$Ultimas5Tramas= mysql_query($Ultimas5TramasSQL );
	
	//realizar la consulta para traernos todos los correos
	$sqlCorreos = sprintf("SELECT * 
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
	AND UD.Reporte2=   1
	");
			
	$resultadoCorreos= mysql_query($sqlCorreos );
				



//ponemos el while de los usuarios porque necesitamos la informacion de la plaza al generar el excel
  //while ($InfoUsuarioArray = mysql_fetch_assoc($resultadoUsuariosHeader)) 
	//  {
		  	//Primero hay que generar el excel con las tramas del arReglo $resultadoTrama 
		$objPHPExcel = new PHPExcel(); 
	
		$objPHPExcel->setActiveSheetIndex(0); 	

		//$objPHPExcel->setActiveSheetIndex(0)->getStyle('F:I')->getNumberFormat()->setFormatCode('#,##0.00'); 
	  //se genera el encabezado del excel

	  while ($InfoUsuarioArray = mysql_fetch_assoc($resultadoUsuariosHeader)) 
	 {
		 //asignaciond de variables
		 
		$NombreCliente= $InfoUsuarioArray['nombre_cliente'];
		$NombrePlaza= $InfoUsuarioArray['nombre_plaza'];
		$capacidad= $InfoUsuarioArray['capacidad'];
		$precision_ = $InfoUsuarioArray['precision_'];
		$factor= $InfoUsuarioArray['factor'];
		$capacidad= $InfoUsuarioArray['capacidad'];
		$um2= $InfoUsuarioArray['um2'];
		$factor2=  $InfoUsuarioArray['factor2'];
		
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', $NombreCliente);
	 $objPHPExcel->getActiveSheet()->SetCellValue('A2', $NombrePlaza);
	 $objPHPExcel->getActiveSheet()->SetCellValue('A3',"Reporte de tipo: Recarga");
	 
	 $objPHPExcel->getActiveSheet()->getStyle('A5:I5')->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('C0C0C0');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
	 $objPHPExcel->	getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
	 
	 $objPHPExcel->	getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
	 
	 $objPHPExcel->	getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
	 $objPHPExcel->	getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
	 
	 $objPHPExcel->	getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
	 
	 $objPHPExcel->getActiveSheet()->SetCellValue('A5',"Fecha");
	 $objPHPExcel->getActiveSheet()->SetCellValue('B5',"Hora");
	 $objPHPExcel->getActiveSheet()->SetCellValue('C5',"Cliente");
	 $objPHPExcel->getActiveSheet()->SetCellValue('D5',"Plaza");
	 $objPHPExcel->getActiveSheet()->SetCellValue('E5',"Tipo");
	 $objPHPExcel->getActiveSheet()->SetCellValue('F5',"%");	
	 $objPHPExcel->getActiveSheet()->SetCellValue('G5',"TQE".$Reg[5]);
	 $objPHPExcel->getActiveSheet()->SetCellValue('H5',"Rec. Lts.");
	 $objPHPExcel->getActiveSheet()->SetCellValue('I5',"Rec. Kg.");
	
	 break;
	 } //fin del while para el llenado de excel header
		 $rowCount = 6; //en esta fila empieza la info
		$RecLtsTotal=0;
		$RecKgTotal=0;	
		
	while($Ultimas5TramasArray = mysql_fetch_assoc($Ultimas5Tramas)){ 	

	 //se valida que las tramas esten dentro del mes
	 $mesAcomparar =(substr($Ultimas5TramasArray['fecha_envio'],0,2));
		 if(date("m") == $mesAcomparar ){
                     
                        $objPHPExcel->getActiveSheet()->getStyle("F".$rowCount)->getNumberFormat()->setFormatCode('###,###,###.00');
                        $objPHPExcel->getActiveSheet()->getStyle("G".$rowCount)->getNumberFormat()->setFormatCode('###,###,###.00');
			$objPHPExcel->getActiveSheet()->getStyle("H".$rowCount)->getNumberFormat()->setFormatCode('###,###,###.00');
			$objPHPExcel->getActiveSheet()->getStyle("I".$rowCount)->getNumberFormat()->setFormatCode('###,###,###.00');
			
		 	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $Ultimas5TramasArray['fecha_envio'] ); 
		 	//hora
		 	
		 	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,  $Ultimas5TramasArray['hora_envio'] );
		 	//Cliente
		 	 $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $NombreCliente);
	
		 	//Plaza
		 	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $NombrePlaza);
		 	//Tipo
		 	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,"Recarga");		 	
		 	//%
		 	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $Ultimas5TramasArray['porcentaje_final']);
				
			//TQE1
            $TQE1Volumen =  $Ultimas5TramasArray['TQE1Volumen'];
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $TQE1Volumen);
			

		 	//Rec. Lits
		 	$Producto1 =  $Ultimas5TramasArray['Producto1'];
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,$Producto1);
                        
		 	//Rec. Kg.
		 	$Producto2=  $Ultimas5TramasArray['Producto2'];
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $Producto2);
		    // Increment the Excel row counter
		  	$rowCount++;
			$RecLtsTotal = $RecLtsTotal + $Ultimas5TramasArray['Producto1'] ;
			$RecKgTotal = $RecKgTotal + $Ultimas5TramasArray['Producto2'] ;	
			
		 }
	     
	} //fin del while para las tramas
	
	    //crear la ultima trama
		/*
		 $TQE1Volumen =  number_format($Ultimas5TramasArray['TQE1Volumen'],2,'.',',');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $TQE1Volumen);
		*/
        
		//%
		$PorcentajeFinal = $Reg[8];
		
		 //TQE1
		//$TQE1Volumen = (($Reg[8] - $Reg[6])/100) * ($capacidad);
		$TQE1Volumen = (($Reg[8] )/100) * ($capacidad);
		
		 //Reclts
		 //$ProductoUM1 =  (($Reg[8] - $Reg[6])/100) * ($capacidad) * ($precision_) * ($factor);
		 $ProductoUM1 =  (($Reg[8] - $Reg[6])/100)  * ($precision_)* ($capacidad)* ($factor);
		 
		//RecKG
		if(!empty($um2)){
			$ProductoUM2 = $ProductoUM1 * $factor2;// (($Reg[8] - $Reg[6])/100) * ($InfoUsuarioArray['capacidad']) * ($InfoUsuarioArray['precision_']) * ($InfoUsuarioArray['factor']);									
		}	
		
		//HACER SUMATORIA
		$RecLtsTotal = $RecLtsTotal + $ProductoUM1 ;
		$RecKgTotal = $RecKgTotal+ $ProductoUM2 ;
		
		//TRUNCAR excel	
		//TQE1

                     
                        $objPHPExcel->getActiveSheet()->getStyle("F".$rowCount)->getNumberFormat()->setFormatCode('###,###,###.00');
                        $objPHPExcel->getActiveSheet()->getStyle("G".$rowCount)->getNumberFormat()->setFormatCode('###,###,###.00');
			$objPHPExcel->getActiveSheet()->getStyle("H".$rowCount)->getNumberFormat()->setFormatCode('###,###,###.00');
			$objPHPExcel->getActiveSheet()->getStyle("I".$rowCount)->getNumberFormat()->setFormatCode('###,###,###.00');
		
		
		 	//fecha
		 	
		 	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, date("m/d/Y") ); 
		 	//hora		 	
		 	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,  date("H:i"));
		 	//Cliente
		 	 $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $NombreCliente);
	
		 	//Plaza
		 	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $NombrePlaza);
		 	//Tipo
		 	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,"Recarga");		 	
		 	//%
		 	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $PorcentajeFinal);
		 	//TQE1
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $TQE1Volumen);
                        
			//Reclts
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $ProductoUM1);
			
			
			
			
                        
                        	
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $ProductoUM2 );
                        
                        
             $rowCount++;
						
			
            
			$objPHPExcel->getActiveSheet()->getStyle("H".$rowCount)->getNumberFormat()->setFormatCode('###,###,###.00');
			
			$objPHPExcel->getActiveSheet()->getStyle("I".$rowCount)->getNumberFormat()->setFormatCode('###,###,###.00');
			//SUMATORIAS
			//rec lts
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $RecLtsTotal);
			
			//rec kg                                  
            		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $RecKgTotal );	

 // echo "crear excel<br>";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
// Write the Excel file to filename some_excel_file.xlsx in the current directory date("h:i")
$nombreArchivo = 'Reporte Recarga: '.$NombreCliente." ".date("d-m-Y")." ".date("H:i").'.xlsx';
$objWriter->save($nombreArchivo); 
//Aqui iniciamos el enviar correo 
sleep(3);
		 //El producto de la recarga del body 
		 
		 
		 //EMPIEZA EL WHILE DE LOS CORREOS
		 while ($CorreoUsuarioArray = mysql_fetch_assoc($resultadoCorreos)) {
		 $CortarFechayol = substr($Reg[0], 0,4);



	$fechaFormato =substr($CortarFechayol,0,2);
		 	$fechaFormato .="/";
		 	$fechaFormato .=substr($CortarFechayol,2,2);
		 	$fechaFormato .="/";
		 	$fechaFormato .=date("Y");

 //Cortar hora para obtener solo digitos de hora 
$CortarHorayol  = substr($Reg[0], 4,2);

 $HoraFormatoCorrecto = date("g:i a",strtotime($CortarHorayol));
		 
		
		 
		  
	  $correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()	 	
	//Usamos el SetFrom para decirle al script quien envia el correo
	$correo->SetFrom("telemetria@ghsmetric.com", "telemetria@ghsmetric.com");	 
	//Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
	$correo->AddReplyTo("telemetria@ghsmetric.com","Reportes de Recarga ");	 
	//Usamos el AddAddress para agregar un destinatario
	$correo->AddAddress( $CorreoUsuarioArray['correo'], "Reporte Recarga");	
	
	//$correo->AddAddress( "jaimegomez1994@gmail.com", "Reporte Recarga");	
	//$correo->AddAddress("frankymr11@gmail.com", "Reporte Carga ");	 
	//Ponemos el asunto del mensaje
	$correo->Subject = "Recarga"."  ".$CorreoUsuarioArray['nombre_plaza'];

	 $correo->IsHTML(true);	
	 $correoBody =date("m/d/Y")."  ";
	 $correoBody .=date("H:i")." hrs  ";
	 $correoBody .=$CorreoUsuarioArray['nombre_cliente'].", ";
	 $correoBody .=$CorreoUsuarioArray['nombre_plaza'].", ";
	 $correoBody .="Recarga detectada en Almacen "." ".$Reg[7];
	 $correoBody .=", se reciben : "." ".number_format($ProductoUM1,2,'.',',')." ";
	 $correoBody .=$CorreoUsuarioArray['um1'].".";
         if ($ProductoUM2>0) {
           $correoBody .=  "<br/>Aproximadamente ";
           $correoBody .= number_format($ProductoUM2,2,'.',',');
           $correoBody .=" ".$CorreoUsuarioArray['um2'];
         }
         
	 $correo->Body =  $correoBody;
	 //"  ".$fechaFormato ."  ".$HoraFormatoCorrecto."  ".$InfoUsuarioArray['nombre_cliente']."  ".$InfoUsuarioArray['nombre_plaza']."  "."Recarga detectada en almacen : "." ".$Reg[7]."Se reciben : "." ".$ProductoUM1." ".$InfoUsuarioArray['um1'];
	 
	//Si deseamos agregar un archivo adjunto utilizamos AddAttachment
	$correo->AddAttachment($nombreArchivo);	
	


	 $TipoReporte="2";
	$HoraActualBitacora = date("H:i");//HoraActualBitacora
	$FechaActualBitacora=date("m/d/Y");
	 
	 InsertarBitacoraReporteRecarga($CorreoUsuarioArray['correo'],$TipoReporte,$FechaActualBitacora,$HoraActualBitacora,$CorreoUsuarioArray['id_cliente'],$CorreoUsuarioArray['id_plaza'],$PorcentajeFinal,$ProductoUM1,$Reg[5], $ProductoUM2, $TQE1Volumen,$Reg[0]);	
	
	//Enviamos el correo
		if(!$correo->Send()) {
		  //echo "Hubo un error: " . $correo->ErrorInfo;
		} else {
		  //echo "Mensaje enviado con exito.";
		}
	
	} //fin del while para correos
//	} //fin del while para usuarios
	
	}catch(Exception $e){
		$e->getMessage();
	}
	}//fin del if
	
}//fin de la funcion

 
 
 
?>