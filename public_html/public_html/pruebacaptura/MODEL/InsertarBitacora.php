<?php 
				           
require_once "CLS_DATABASE.php"; 
date_default_timezone_set('America/Monterrey'); 
AbrirConexion();


function InsertarBitacoraReporte1($Correo,$TipoReporte,$CortarFecha,$CortarHora,$Id_cliente,$ID_plaza,$Producto,$Id_almacen, $Porcentaje_final,$Producto2, $TQE1Volumen){
//Se genera el insert a la base de datos 
        $SentenciaInsertar= "INSERT INTO `detalle_reportes`(`tipo_reporte`, `hora_envio`, `fecha_envio`, `Producto1`, `Correo_envio`,`id_plaza`,`id_cliente`,`id_almacen`,`porcentaje_final`,`Producto2`,`TQE1Volumen`) 
VALUES ('$TipoReporte', '$CortarFecha' ,'$CortarFecha', '$Producto', '$Correo','$ID_plaza','$Id_cliente','$Id_almacen', '$Porcentaje_final','$Producto2','$TQE1Volumen')";

	  		//Se ejecuta el insert a la base de datos
	        		 $InsertandoEnlaBitacora= mysql_query($SentenciaInsertar);
//TQE1Volumen	Producto2

}

function InsertarBitacoraReporte2($Correo,$TipoReporte,$CortarFecha,$CortarHora,$Id_cliente,$ID_plaza,$Producto,$Id_almacen,$Prodcuto2){

//Se genera el insert a la base de datos 
$SentenciaInsertar2= "INSERT INTO `detalle_reportes`(`tipo_reporte`, `hora_envio`, `fecha_envio`, `Producto1`, `Correo_envio`,`id_plaza`,`id_cliente`,`id_almacen`,`Producto2`) 
VALUES ('$TipoReporte', '$CortarFecha' ,'$CortarFecha', '$Producto', '$Correo','$ID_plaza','$Id_cliente','$Id_almacen','$Producto2')";

 $InsertandoEnlaBitacora2= mysql_query($SentenciaInsertar2);
				   }
                                        

function InsertarBitacoraReporteRecarga($Correo,$TipoReporte,$CortarFecha,$CortarHora,$Id_cliente,$ID_plaza,$Porcentaje_final,$Producto,$Id_almacen,$Producto2,$TQE1Volumen,$data){

//Se genera el insert a la base de datos 
$SentenciaInsertar2= "INSERT INTO `detalle_reportes`(`tipo_reporte`, `hora_envio`, `fecha_envio`, `Producto1`, `Correo_envio`,`id_plaza`,`id_cliente`,`id_almacen`,`porcentaje_final`,`Producto2`,`TQE1Volumen`,`data`) 
VALUES ('$TipoReporte', '$CortarHora' ,'$CortarFecha', '$Producto', '$Correo','$ID_plaza','$Id_cliente','$Id_almacen','$Porcentaje_final','$Producto2','$TQE1Volumen','$data')";

 $InsertandoEnlaBitacora2= mysql_query($SentenciaInsertar2);
				   }



?>