<?php
class LoginModelo{
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

            /* ligar par�metros para marcadores */
            $stmt->bind_param("ss", $Usuario, $Contrasena);

            /* ejecutar la consulta */
            $stmt->execute();

            /* ligar variables de resultado */
            $stmt->bind_result($resultadoUsuario,$resultadoContrasena);

            /* obtener valor */
            $stmt->fetch();

            // printf("%s is in district %s\n", $resultado);

            /* cerrar sentencia */
            $stmt->close();
        }
        if($Usuario==$resultadoUsuario && $Contrasena==$resultadoContrasena ){
            return true;
        }else{
            return false;
        }

        /* cerrar conexi�n */
        $this->conn->close();
        if($resultado==1){
            return true;
        }else{
            return false;
        }


    }
}

?>