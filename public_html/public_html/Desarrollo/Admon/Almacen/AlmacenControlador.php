<?php
require_once "../init.php";

require_once "AlmacenModelo.php";
/**
 * Created by PhpStorm.
 * User: Jaime
 * Date: 26/04/2016
 * Time: 06:36 PM
 */


if(isset($_GET['id_cliente'])){
    $almacenModelo = new AlmacenModelo();
    $almacenModelo->getAllByIDPlaza($_GET['id_cliente']);
}

function llenarTabla(){
    $query = "SELECT * FROM almacen";
    $almacenModelo = new AlmacenModelo();

    $newquery = $almacenModelo->paging($query);
    $almacenModelo->dataview($newquery);
    //$records_per_page=10;
    // $almacenModelo->paginglink($query,$records_per_page);

}

function paginglink(){
    $query = "SELECT * FROM almacen";
    $almacenModelo = new AlmacenModelo();
    $records_per_page=10;
    $almacenModelo->paginglink($query,$records_per_page);
}

function agregarAlmacen($cliente, $plaza,$capacidad, $tipo, $precision, $um1, $factor, $act, $um2,$factor2){
    $almacenModelo = new AlmacenModelo();
    //verificar que solo haya dos alamacenes
    //$IPAlmacen    id proposed almacen
    $IPAlmacen = $almacenModelo->cantidadAlmacenes($plaza,$cliente);

    if($IPAlmacen < 2){
        $IPAlmacen++;

        if($almacenModelo->agregarAlmacenModelo($cliente,$IPAlmacen, $plaza,$capacidad, $tipo, $precision, $um1, $factor, $act, $um2,$factor2)){
            return 1;
        }else{
            return 0;
        }
    }else{
        return 2;
    }
    //0 error
    //1 se inserto correctamente
    //2 ya hay dos almacenes
    //sacar la fecha





    //el id es autoincrementable
}
function modificarAlmacen($capacidad, $tipo, $precision,$um1,$factor,$act,$um2,$factor2,$id_cliente,$id_almacen,$id_plaza){
    $clienteModelo = new AlmacenModelo();
    //validaciones

    if($clienteModelo->modificarAlmacenModelo($capacidad, $tipo, $precision,$um1,$factor,$act,$um2,$factor2,$id_cliente,$id_almacen,$id_plaza)){
        return true;
    }else{
        return false;
    }

}

function getByIDCliente($id_cliente){
    $AlmacenModelo = new AlmacenModelo();
    //validaciones

    $array = $AlmacenModelo->getByIDCliente($id_cliente);
    if(count($array)>0){
        return $array;//regresar error
    }else{
        return false;
    }
}

function getPlazaByID($id_plaza){
    $AlmacenModelo = new AlmacenModelo();
    //validaciones

    $array = $AlmacenModelo->getPlazaByID($id_plaza);
    if(count($array)>0){
        return $array;//regresar error
    }else{
        return false;
    }
}


function getRowByIDCliente($id_cliente){
    $AlmacenModelo = new AlmacenModelo();
    //validaciones

    $array = $AlmacenModelo->getByIDCliente($id_cliente);
    if(count($array)>0){
        return $array;//regresar error
    }else{
        return false;
    }
}

function getAlmacenByID($id_cliente,$id_plaza,$id_almacen){
    $AlmacenModelo = new AlmacenModelo();
    //validaciones

    $array = $AlmacenModelo->getAlmacenByID($id_cliente,$id_plaza,$id_almacen);
    if(count($array)>0){
        return $array;//regresar error
    }else{
        return false;
    }
}

function getAllByIDCliente(){
    $AlmacenModelo = new AlmacenModelo();
    //validaciones

    $array = $AlmacenModelo->getAllByIDCliente();
    if(count($array)>0){
        return $array;//regresar error
    }else{
        return false;
    }

}

function getAllByIDPlaza($id_cliente){
    $AlmacenModelo = new AlmacenModelo();
    //validaciones

    $array = $AlmacenModelo->getAllByIDPlaza($id_cliente);
    if(count($array)>0){
        return $array;//regresar error
    }else{
        return false;
    }

}

function deleteAlmacenById($id_cliente,$id_plaza,$id_almacen){
    $AlmacenModelo = new AlmacenModelo();
    //validaciones
    //validar que no tenga ningun usuario
    if($AlmacenModelo->usuariosByAlmacenID($id_cliente,$id_plaza,$id_almacen)==0) {
        if ($AlmacenModelo->deleteAlmacenByIdModelo($id_almacen,$id_plaza,$id_cliente)) {
            return 1;
        } else {
            return 2;
        }
    }else{
        return 0;
    }
    /*
    0 hay usuarios
    1 correcto
    2 falla en el sistem
    3
     * */
}

?>