<?php   
 
class configDB{
    function __construct(){

    }

    function Conectar(){

        $conn = new mysqli('localhost', 'root', '','DB_Desarrollo');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }else {
            return $conn;
        }
    }
}


?>