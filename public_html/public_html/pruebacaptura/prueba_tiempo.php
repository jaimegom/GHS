<?php 

// Example 



date_default_timezone_set('America/Monterrey'); 
echo "La hora actual es :".date("H:i");


echo "</br></br>";
   $strStart = '2016-03-21 00:00'; 
   $strEnd   = '2016-03-20 23:47'; 





   $dteStart = new DateTime($strStart); 
   $dteEnd   = new DateTime($strEnd); 



   $dteDiff  = $dteStart->diff($dteEnd); 


$dteDiff =  $dteDiff->format("%H"); 
   print $dteDiff;
   
   if ($dteDiff >= 1 ) 
	{
	
	echo "Esta mal";
	
	}
	
	else {
	
	echo "Correcto";
	
	}
   
   
   

/* 
    Outputs 
    
    03:22:00 
*/ 

?> 