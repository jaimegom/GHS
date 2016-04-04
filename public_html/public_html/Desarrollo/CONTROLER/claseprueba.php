<?php


include '../MODEL/InsertarTrama.php';

		
class claseprueba{
	 
		public $data;
		public function __construct($Data){
		
			$Reg = explode("|", $Data);
			
			
			
			
		 for ($index = 0; $index < 9; $index++) {
                        $trama_completa.=$Reg[$index];

                        
        }

        $trama_completa .= date("Y");

			
			$Reg[9]= $trama_completa;
			
			
		
		if(tramaExiste($Reg)){
		
			echo "DR";
		}else{
			
			//El siguiente metodo es el que se va a la carpeta model , para luego insertarse con sql
			if(InsertarArreglo($Reg)){
				
			echo "OE".date("Hisa");
			}
			
		}

		
		}
	
	}
?>