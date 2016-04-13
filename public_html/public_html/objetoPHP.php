<?php
class objetoPHP{
    private $conn;
    function __construct(){
        $this->conn = new mysqli('localhost', 'root', '','DB_Desarrollo');
        if ($this->conn ->connect_error) {
            die("Connection failed: " . $this->conn ->connect_error);
        }
    }

    function usuarioValido($Usuario,$Contrasena){

        /* crear una sentencia preparada */
        if ($stmt = $this->conn->prepare("SELECT nombre_usuario,password FROM usuarios_header WHERE nombre_usuario=? and password=?")) {

            /* ligar par?metros para marcadores */
            $stmt->bind_param("ss", $Usuario, $Contrasena);

            /* ejecutar la consulta */
            $stmt->execute();

            /* ligar variables de resultado */
            $stmt->bind_result($resultado,$resultado2);

            /* obtener valor */
            $stmt->fetch();
            echo $resultado."<br/>".$resultado2 ;
          // printf("%s is in district %s\n", $resultado);

            /* cerrar sentencia */
            $stmt->close();
        }

        /* cerrar conexi?n */
        $this->conn->close();
        if($resultado==1){
            return true;
        }else{
            return false;
        }


    }
}

?>