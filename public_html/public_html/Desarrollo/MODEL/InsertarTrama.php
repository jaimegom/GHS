<?php
require_once "CLS_DATABASE.php"; 
require_once "Maximon&Minimos.php";
require_once "Minimo.php";


require_once "EnviarReporte2.php";
//echo "</br> correcto paso la clase de Reporte2";
AbrirConexion();

function InsertarArreglo($Reg){
  
			if(!empty($Reg[0]) && is_numeric($Reg[0]) &&
                           !empty($Reg[1]) && is_numeric($Reg[1]) && 
                            !empty($Reg[2]) && is_numeric($Reg[2])&& 
                            !empty($Reg[3]) && is_numeric($Reg[3])&&
                            !empty($Reg[4])&& is_numeric($Reg[4]) && 
                            !empty($Reg[5])&& is_numeric($Reg[5]) &&
                            !empty($Reg[6])&& is_numeric($Reg[6]) &&
                            !empty($Reg[7])&& is_numeric($Reg[7]) &&
                            !empty($Reg[8])&& is_numeric($Reg[8])    
                                ) 
			{
		
						
 $queryInsertAF  = "INSERT INTO `trama`(`data`, `id_cliente`, `id_plaza`, `tipo_dato`, `id_1`, `tanque1`, `p_tqe1`, `tanque2`, `p_tqe2`, `trama_completa`) 
VALUES ('$Reg[0]', '$Reg[1]' ,'$Reg[2]', '$Reg[3]', '$Reg[4]', '$Reg[5]', '$Reg[6]', '$Reg[7]', '$Reg[8]', '$Reg[9]')";
				
				
switch ($Reg[3]) {
    case 1:
    $resultado = mysql_query($queryInsertAF  );   

        break;
    case 2:

          $resultado = mysql_query($queryInsertAF  ); 
          PasarDatosReporteRecarga($Reg); 
            
         break;
    case 3:       
        $resultado = mysql_query($queryInsertAF  );
        PasarDatosReporteMaximo($Reg);
        
        break;  
    case 4:
        $resultado = mysql_query($queryInsertAF  );
        PasarDatosReporteMinimo($Reg);
         
        break;
}
return true;
	}else{
	echo "TC";
	return false;
	
	}
	}
	
function tramaExiste($trama){

	$sql = sprintf("SELECT * 
	FROM trama where trama_completa='$trama[9]'
	");
			
	$resultadoUsuariosHeader= mysql_query($sql );
	$contador = 0;
	 while ($InfoUsuarioArray = mysql_fetch_assoc($resultadoUsuariosHeader)) 
	 {
			$contador++; 
	 }        
	
	if($contador == 0) {
	   return false;
	   // Nothing found!
	}else{
	
		return true;
	}
	
}
 

?>