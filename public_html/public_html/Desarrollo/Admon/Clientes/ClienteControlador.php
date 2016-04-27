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
?>