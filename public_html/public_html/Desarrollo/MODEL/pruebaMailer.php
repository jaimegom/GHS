<?php
//incluimos la clase PHPMailer
require_once('PHPMailer-master/class.phpmailer.php');

$correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()
 
//Usamos el SetFrom para decirle al script quien envia el correo
$correo->SetFrom("ghsmetri@server96.neubox.net", "Mi Codigo PHP");
 
//Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
$correo->AddReplyTo("ghsmetri@server96.neubox.net","Mi Codigo PHP");
 
//Usamos el AddAddress para agregar un destinatario
$correo->AddAddress("jaimegomez10@live.com", "Prueba");
 
//Ponemos el asunto del mensaje
$correo->Subject = "Mi primero correo con PHPMailer";
 
/*
 * Si deseamos enviar un correo con formato HTML utilizaremos MsgHTML:
 * $correo->MsgHTML("<strong>Mi Mensaje en HTML</strong>");
 * Si deseamos enviarlo en texto plano, haremos lo siguiente:*/
 $correo->IsHTML(false);
  $correo->Body = "Mi mensaje en Texto Plano";
 
 
//Si deseamos agregar un archivo adjunto utilizamos AddAttachment
$correo->AddAttachment("pruebaAdjunto.php");
 
//Enviamos el correo
if(!$correo->Send()) {
  echo "Hubo un error: " . $correo->ErrorInfo;
} else {
  echo "Mensaje enviado con exito.";
}

?>