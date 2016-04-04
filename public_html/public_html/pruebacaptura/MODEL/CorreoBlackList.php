<?php
require_once ('CLS_DATABASE.php'); 
require_once('PHPMailer-master/PHPMailer-master/class.phpmailer.php');

require_once('PHPMailer-master/PHPMailer-master/class.smtp.php');
require_once ('Classes/PHPExcel.php');
require_once('PHPMailer-master/PHPMailer-master/PHPMailerAutoload.php');
//echo phpinfo();
/*
*/

$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'relay-hosting.secureserver.net';
$config['smtp_port'] = '456';
$config['mailtype'] = 'html';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug  = 3; 
//Ask for HTML-friendly debug output 
$mail->Debugoutput = 'html'; 
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
//$mail->Host = "smtp.gmail.com";

//$mail->Username = "jaimegomez1994@gmail.com";
//$mail->Password = "********";

//$mail->Username = "Factor64";
//$mail->Password = "ZaZ79070266t";

//$mail->Username = "fmartinez16";
//$mail->Password = "HolaMundo2016";

$mail->Port = 456;
$mail->From = "fmartinez16@a2plcpnl0544.prod.iad2.secureserver.net";
$mail->Subject = "Prueba de correo";
$mail->AltBody = "Este es el altbodyd";
$mail->MsgHTML("Este es el mensaje");
$mail->AddAddress("jaimegomez1994@gmail.com");
$mail->IsHTML(true);
 
if(!$mail->Send()) {
  echo "Error: " . $mail->ErrorInfo;
} else {
  echo "Mensaje enviado correctamente";
}


?>