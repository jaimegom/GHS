<?php
require_once "../init.php";

require_once "ClienteModelo.php";
/**
 * Created by PhpStorm.
 * User: Jaime
 * Date: 26/04/2016
 * Time: 06:36 PM
 */
function llenarTabla(){
    $query = "SELECT * FROM cliente";
    $clienteModelo = new ClienteModelo();

    $newquery = $clienteModelo->paging($query);
    $clienteModelo->dataview($newquery);
    //$records_per_page=10;
   // $clienteModelo->paginglink($query,$records_per_page);

}

function paginglink(){
    $query = "SELECT * FROM cliente";
    $clienteModelo = new ClienteModelo();
    $records_per_page=10;
    $clienteModelo->paginglink($query,$records_per_page);
}

function agregarCliente($nombreCliente, $correoElectronico, $telefono, $direccion){
    //verificar que el nombre no se repita
    //sacar la fecha

    $clienteModelo = new ClienteModelo();

    if($clienteModelo->agregarClienteModelo($nombreCliente, $correoElectronico, $telefono, $direccion,date("d,m,y H:i"))){
        return true;
    }else{
        return false;
    }

    //el id es autoincrementable
}
function modificarCliente($nombreCliente, $correoElectronico, $telefono, $direccion,$id_cliente){
    $clienteModelo = new ClienteModelo();
    //validaciones

    if($clienteModelo->modificarClienteModelo($nombreCliente, $correoElectronico, $telefono, $direccion,$id_cliente)){
        return true;
    }else{
        return false;
    }

}

function getByIDCliente($id_cliente){
    $clienteModelo = new ClienteModelo();
    //validaciones

    $array = $clienteModelo->getByIDCliente($id_cliente);
    if(count($array)>0){
        return $array;//regresar error
    }else{
        return false;
    }

}

function deleteClienteByID($id_cliente){
    $clienteModelo = new ClienteModelo();
    //validaciones

    if($clienteModelo->deleteClienteByID($id_cliente)){
        return true;
    }else{
        return false;
    }

}

?>