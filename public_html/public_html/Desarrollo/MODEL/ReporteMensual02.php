<?php

require_once('PHPMailer-master/PHPMailer-master/class.phpmailer.php');
require_once ('Classes/PHPExcel.php');
require_once ('CLS_DATABASE.php'); 
date_default_timezone_set('America/Monterrey'); 
AbrirConexion();

$month = date('m');
$year = date('Y');
$day = date("d", mktime(0,0,0, $month+1, 0, $year));

$Producto = 1212333312.123123123;
$Producto = number_format($Producto,2,'.',',');

echo $Producto."<br>";
$lastDayOfMonth= date('m/d/Y', mktime(0,0,0, $month, $day, $year));
echo $lastDayOfMonth;

if(date('m/d/Y')==$lastDayOfMonth){
    echo "yes";
}

$month = date('m');
$year = date('Y');
$PrimerDiaMes = date('m/d/Y', mktime(0,0,0, $month, 1, $year));
echo $PrimerDiaMes ; 
if(date('m/d/Y')==$PrimerDiaMes){
    echo "yes";
}


?>