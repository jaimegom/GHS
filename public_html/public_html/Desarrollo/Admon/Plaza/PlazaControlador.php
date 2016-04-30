<?php
require_once "../init.php";

require_once "PlazaModelo.php";
/**
 * Created by PhpStorm.
 * User: Jaime
 * Date: 26/04/2016
 * Time: 06:36 PM
 */
function llenarTabla(){
    $query = "SELECT * FROM Plaza p left join cliente c on p.id_cliente = c.id_cliente ";
    $PlazaModelo = new PlazaModelo();

    $newquery = $PlazaModelo->paging($query);
    $PlazaModelo->dataview($newquery);
    //$records_per_page=10;
   // $PlazaModelo->paginglink($query,$records_per_page);

}

function paginglink(){
    $query = "SELECT * FROM Plaza";
    $PlazaModelo = new PlazaModelo();
    $records_per_page=10;
    $PlazaModelo->paginglink($query,$records_per_page);
}

function agregarPlaza($nombrePlaza, $correoElectronico, $telefono, $direccion){
    //verificar que el nombre no se repita
    //sacar la fecha

    $PlazaModelo = new PlazaModelo();

    if($PlazaModelo->agregarPlazaModelo($nombrePlaza, $correoElectronico, $telefono, $direccion,date("d,m,y H:i"))){
        return true;
    }else{
        return false;
    }

    //el id es autoincrementable
}
function modificarPlaza($nombrePlaza,$direccion,$id_Plaza,$id_cliente){
    $PlazaModelo = new PlazaModelo();
    //validaciones

    if($PlazaModelo->modificarPlazaModelo($nombrePlaza,$direccion,$id_Plaza,$id_cliente)){
        return true;
    }else{
        return false;
    }

}

function getByIDPlaza($id_Plaza,$id_cliente){
    $PlazaModelo = new PlazaModelo();
    //validaciones

    $array = $PlazaModelo->getByIDPlaza($id_Plaza,$id_cliente);
    if(count($array)>0){
        return $array;//regresar error
    }else{
        return false;
    }

}

?>