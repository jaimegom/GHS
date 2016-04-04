<?php 
//echo date("m")==03;


 $Data= "02081250|11111|01|02|00000000|01|34.02|01|73.18";
$Reg = explode("|", $Data);
 	//$mmd=substr($Reg[0],0,2);
 //	echo $mmd;
 	
 	/*
 	
 			$fecha =substr($Reg[0],0,2);
		 	$fecha .="/";
		 	echo $fecha;
		 	
		 	$fecha2 =substr($Reg[0],2,2);
		 	
		 	echo $fecha2;
		 	$fecha.=$fecha2;
		 	$fecha .="/";
		 	$fecha .=date("Y");
		 	
		 	//echo $fecha;	
		 	
		 	$hora = substr($Reg0],4,2);
		 	$hora .= ":";
		 	$hora = substr($Reg[0],6,2);	
		 	
		 */	
		 	
		 	$hora = substr($Reg[0],4,2);
		 	$hora .= ":";
		 	
		 	$hora .= substr($Reg[0],6,2);
		 	echo $hora;	
		 	echo"jjj" ;	
?>