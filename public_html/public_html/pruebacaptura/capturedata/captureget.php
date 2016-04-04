<?php 

 include '../CONTROLER/claseprueba.php';
 date_default_timezone_set('America/Monterrey'); 

 $var = date('H:i');

$Data = $_GET['Dat'];
	
	new captureget($Data);	
	class captureget{
		
		public function __construct($Data){			
			
			new claseprueba($Data);	
			
		}
	}
	#http://ghsmetric.com/pruebacaptura/capturedata/captureget.php?Dat=01081250|0001|04|01|00000000|01|34.02|02|73.18
?>