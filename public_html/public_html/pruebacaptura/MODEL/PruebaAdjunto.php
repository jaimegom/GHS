<?php 
require_once ('Classes/PHPExcel.php');
 // Creamos el nuevo objeto de PHPExcel
        $objPHPExcel = new PHPExcel();
         
        // Insertaremos las propiedades del documento
        $objPHPExcel->getProperties()->setCreator("QualityInfoSolutions")
            ->setLastModifiedBy("QualityInfoSolutions")
            ->setTitle("Test Document")
            ->setSubject("Excel")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Excel");
         
        // Agregaremos los datos de nuestro documento
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'El yoltic ')
                    ->setCellValue('B2', 'Es ')
                    ->setCellValue('C1', 'bien')
                    ->setCellValue('D2', 'jotooooo!');
         
        // Renombrando hoja activa
        $objPHPExcel->getActiveSheet()->setTitle('Ejemplo nfoSolutions');
         
        //Seleccionamos la hoja que estara seleccionada al abrir el documento
        $objPHPExcel->setActiveSheetIndex(0);
         
        // Guardamos el archivo Excel
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
   



require_once('PHPMailer-master/class.phpmailer.php');

$correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()
 
//Usamos el SetFrom para decirle al script quien envia el correo
$correo->SetFrom("ghsmetri@server96.neubox.net", "Yoltic es joto");
 
//Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
$correo->AddReplyTo("ghsmetri@server96.neubox.net","yoltic mlp");
 
//Usamos el AddAddress para agregar un destinatario
$correo->AddAddress("frankymr11@gmail.com", "Prueba de que yoltic me la pela");

$correo->AddAddress("jaimegomez10@live.com", "x");
 
//Ponemos el asunto del mensaje
$correo->Subject = "El yoltic me la pela";
 
/*
 * Si deseamos enviar un correo con formato HTML utilizaremos MsgHTML:
 * $correo->MsgHTML("<strong>Mi Mensaje en HTML</strong>");
 * Si deseamos enviarlo en texto plano, haremos lo siguiente:*/
 $correo->IsHTML(false);
  $correo->Body = "Yoltic es jotillo";
 
 
//Si deseamos agregar un archivo adjunto utilizamos AddAttachment
$correo->AddAttachment("PruebaAdjunto.xlsx");
 
//Enviamos el correo
if(!$correo->Send()) {
  echo "Hubo un error: " . $correo->ErrorInfo;
} else {
  echo "Mensaje enviado con exito.";
}









?>




















