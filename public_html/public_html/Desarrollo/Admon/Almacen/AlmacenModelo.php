<?php
require_once "../init.php";
class AlmacenModelo{
    private $conn;

    function __construct()
    {
        $this->conn = new mysqli('localhost', 'root', '', 'DB_Desarrollo');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    //dataview
    public function dataview($query)
    {

        $stmt = $this->conn->query($query);


        if($stmt->num_rows>0)
        {
            while($row=$stmt->fetch_array(MYSQLI_ASSOC))
            {
                ?>
                <tr>
                    <td><?php print($row['id_almacen']); ?></td>
                    <td><?php print($row['capacidad']); ?></td>
                    <td><?php print($row['tipo']); ?></td>
                    <td><?php print($row['precision_']); ?></td>
                    <td><?php print($row['um1']); ?></td>
                    <td><?php print($row['factor']); ?></td>
                    <td><?php print($row['act']); ?></td>
                    <td><?php print($row['um2']); ?></td>
                    <td><?php print($row['factor2']); ?></td>

                    <td><?php
                       // print("a");
                       $a=  new AlmacenModelo();
                       print($a->getNombreByIDPlaza($row['id_plaza']));
                        ?></td>

                    <td><?php
                     print($a->getNombreByIDCliente($row['id_cliente']));
                     //   print("a");
                        ?></td>


                    <td align="center">
                        <a href="AlmacenModificar.php?edit_id=<?php print($row['id_almacen']); ?>&edit_id_plaza=<?php print($row['id_plaza']); ?>&edit_id_cliente=<?php print($row['id_cliente']); ?>"><i class="glyphicon glyphicon-edit"></i></a>
                    </td>
                    <td align="center">
                        <a href="AlmacenEliminar.php?delete_id=<?php print($row['id_almacen']); ?>&edit_id_plaza=<?php print($row['id_plaza']); ?>&edit_id_cliente=<?php print($row['id_cliente']); ?>"><i class="glyphicon glyphicon-remove-circle"></i></a>
                    </td>
                </tr>
                <?php
            }
        }
        else
        {
            ?>
            <tr>
                <td>Nothing here...</td>
            </tr>
            <?php
        }

    }

    //paging
    public function paging($query)
    {
        $records_per_page=10;
        $starting_position=0;
        if(isset($_GET["page_no"]))
        {
            $starting_position=($_GET["page_no"]-1)*$records_per_page;
        }
        $query2=$query." limit $starting_position,$records_per_page";
        return $query2;
    }


    public function paginglink($query,$records_per_page)
    {

        $self = $_SERVER['PHP_SELF'];

        $stmt = $this->conn->query($query);

        $total_no_of_records = $stmt->num_rows;

        if($total_no_of_records > 0)
        {
            ?><ul class="pagination"><?php
            $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
            $current_page=1;
            if(isset($_GET["page_no"]))
            {
                $current_page=$_GET["page_no"];
            }
            if($current_page!=1)
            {
                $previous =$current_page-1;
                echo "<li><a href='".$self."?page_no=1'>Primera</a></li>";
                echo "<li><a href='".$self."?page_no=".$previous."'>Anterior</a></li>";
            }
            for($i=1;$i<=$total_no_of_pages;$i++)
            {
                if($i==$current_page)
                {
                    echo "<li><a href='".$self."?page_no=".$i."' style='color:red;'>".$i."</a></li>";
                }
                else
                {
                    echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
                }
            }
            if($current_page!=$total_no_of_pages)
            {
                $next=$current_page+1;
                echo "<li><a href='".$self."?page_no=".$next."'>Siguiente</a></li>";
                echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Ultima</a></li>";
            }
            ?></ul><?php
        }
    }

    public function agregarAlmacenModelo($cliente,$almacen, $plaza,$capacidad, $tipo, $precision, $um1,$factor2, $factor, $act, $um2){
        if ($stmt = $this->conn->prepare("insert into almacen(id_cliente,id_almacen,id_plaza,capacidad,tipo,precision_,um1,factor2, factor, act, um2 ) VALUES(?,?,?,?,?,?,?,?,?,?,?)")) {

            /* ligar par?metros para marcadores */
            if(!$stmt->bind_param("iiiisisiiss",$cliente,$almacen, $plaza,$capacidad, $tipo, $precision, $um1,$factor2, $factor, $act, $um2)){
                return false;
            }


            /* ejecutar la consulta */
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }


            /* cerrar sentencia */
            $stmt->close();
        }else{
            return false;
        }




    }

    public function modificarAlmacenModelo($capacidad, $tipo, $precision,$um1,$factor,$act,$um2,$factor2,$id_cliente,$id_almacen,$id_plaza){
        if ($stmt = $this->conn->prepare("update almacen set capacidad=?,tipo= ?, precision_=?, um1=?,factor=?, act=?, um2=?,factor2=? where id_cliente=? and id_almacen=? and id_plaza=?")) {

            /* ligar par?metros para marcadores */
            if(!$stmt->bind_param("isisissiiii",$capacidad, $tipo, $precision,$um1,$factor,$act,$um2,$factor2,$id_cliente,$id_almacen,$id_plaza)){
                return false;
            }


            /* ejecutar la consulta */
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }


            /* cerrar sentencia */
            $stmt->close();
        }else{
            return false;
        }
    }

    public function getByIDCliente($id_cliente){
            $query="select *  from cliente where id_cliente = $id_cliente";
         $stmt = $this->conn->query($query);
        $row=$stmt->fetch_array(MYSQLI_ASSOC);
      //  $row = mysql_fetch_assoc($result);
        return $row;
        /*
        if ($stmt = $this->conn->prepare("select *  from cliente where id_cliente = ?")) {

            // ligar par?metros para marcadores 
            if(!$stmt->bind_param("i",$id_cliente)){
                return false;
            }

            //ejecutar la consulta 
            if(!$stmt->execute()){
                return false;
            }

            $result = $stmt->get_result();
            $row = $result->fetch_array(MYSQLI_ASSOC);

            // cerrar sentencia 
            $stmt->close();
            return $row;
        }else{
            return false;
        }*/
    }

    public function getPlazaByID($id_plaza){
                  $query="select *  from plaza where id_plaza = $id_plaza";
         $stmt = $this->conn->query($query);
        $row=$stmt->fetch_array(MYSQLI_ASSOC);
      //  $row = mysql_fetch_assoc($result);
        return $row;
        /*
        if ($stmt = $this->conn->prepare("select *  from plaza where id_plaza = ?")) {

            // ligar par?metros para marcadores 
            if(!$stmt->bind_param("i",$id_plaza)){
                return false;
            }

            //ejecutar la consulta 
            if(!$stmt->execute()){
                return false;
            }

            $result = $stmt->get_result();
            $row = $result->fetch_array(MYSQLI_ASSOC);

            //cerrar sentencia 
            $stmt->close();
            return $row;
        }else{
            return false;
        }*/
    }


    public function getAlmacenByID($id_cliente,$id_plaza,$id_almacen){
        $query="SELECT * FROM almacen WHERE id_cliente =$id_cliente AND id_plaza =$id_plaza AND id_almacen =$id_almacen";
         $stmt = $this->conn->query($query);
        $row=$stmt->fetch_array(MYSQLI_ASSOC);
      //  $row = mysql_fetch_assoc($result);
        return $row;
        /*
        if ($stmt = $this->conn->prepare("SELECT * FROM almacen WHERE id_cliente ='id_cliente' AND id_plaza ='id_plaza' AND id_almacen ='id_almacen'")) {
            // ligar par?metros para marcadores 
            if(!$stmt->bind_param("iii",$id_cliente,$id_plaza,$id_almacen)){
                return false;
            }
            //ejecutar la consulta 
            if(!$stmt->execute()){
                return false;
            }
            $result = $stmt->get_result();
            $row = $result->fetch_array(MYSQLI_ASSOC);
            cerrar sentencia 
            $stmt->close();
            return $row;
        }else{
            return false;
        }*/
    }

    public function getAllByIDCliente(){
        
        
            $query="select *  from cliente ";
         $stmt = $this->conn->query($query);

        while ($row=$stmt->fetch_array(MYSQLI_ASSOC)) {
                echo '<option class="form-control" name = "id_cliente" id = "id_cliente" required value="'. $row["id_cliente"].'" >'.$row["nombre_cliente"].'</option>';
            }

            $stmt->close();
            return $row;

    }
    public function getAllByIDPlaza($id_cliente){
  query = "select *  from plaza where id_cliente = $id_cliente";
                $stmt = $this->conn->query($query);

            while ($row=$stmt->fetch_array(MYSQLI_ASSOC)) {
                echo '<option class="form-control" required value="'. $row["id_plaza"].'" >'.$row["nombre_plaza"].'</option>';
            }

            $stmt->close();
            return $row;
    }


    public function deleteAlmacenByIdModelo($id_almacen,$id_plaza,$id_cliente){

        if ($stmt = $this->conn->prepare("delete from almacen where id_almacen =? and id_plaza=? and id_cliente=?")) {

            /* ligar par?metros para marcadores */
            if(!$stmt->bind_param("iii",$id_almacen,$id_plaza,$id_cliente)){
                return false;
            }


            /* ejecutar la consulta */
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }


            /* cerrar sentencia */
            $stmt->close();
        }else{
            return false;
        }
    }

    public function getNombreByIDCliente($id_cliente){
        if ($stmt = $this->conn->prepare("select nombre_cliente  from cliente where id_cliente = ?")) {

            /* ligar par?metros para marcadores */
            $stmt->bind_param("i", $id_cliente);

            /* ejecutar la consulta */
            $stmt->execute();

            /* ligar variables de resultado */
            $stmt->bind_result($resultadoNombre);

            /* obtener valor */
            $stmt->fetch();

            // printf("%s is in district %s\n", $resultado);

            /* cerrar sentencia */
            $stmt->close();
            return $resultadoNombre;
        }//getNombreByIDPlaza

    }/*                    <td><?php print(getNombreByIDPlaza($row['id_plaza'])); ?></td>
                    BUSCAR EL NOMBRE DEL CLIENTE MEDIANTE EL ID
                    <td><?php print(getNombreByIDCliente($row['id_cliente'])); ?></td>*/


    public function getNombreByIDPlaza($id_plaza){
        if ($stmt = $this->conn->prepare("select nombre_plaza  from plaza where id_plaza = ?")) {

            /* ligar par?metros para marcadores */
            $stmt->bind_param("i", $id_plaza);

            /* ejecutar la consulta */
            $stmt->execute();

            /* ligar variables de resultado */
            $stmt->bind_result($resultadoNombre);

            /* obtener valor */
            $stmt->fetch();

            // printf("%s is in district %s\n", $resultado);

            /* cerrar sentencia */
            $stmt->close();
            return $resultadoNombre;
        }

    }

    public function cantidadAlmacenes($id_plaza,$id_cliente){
        if ($stmt = $this->conn->prepare("SELECT COUNT( id_plaza ) FROM almacen WHERE id_plaza =? AND id_cliente =?")) {

            /* ligar par?metros para marcadores */
            $stmt->bind_param("ii", $id_plaza,$id_cliente );

            /* ejecutar la consulta */
            $stmt->execute();

            /* ligar variables de resultado */
            $stmt->bind_result($cantidadAlmecenes);

            /* obtener valor */
            $stmt->fetch();

            // printf("%s is in district %s\n", $resultado);

            /* cerrar sentencia */
            $stmt->close();
            return $cantidadAlmecenes;
        }
        return 10;
    }

    public function usuariosByAlmacenID($id_cliente,$id_plaza,$id_almacen){
        if ($stmt = $this->conn->prepare("SELECT COUNT( id_cliente ) FROM usuarios_detail WHERE id_cliente =? AND id_plaza =? AND id_almacen =?")) {

            /* ligar par?metros para marcadores */
            $stmt->bind_param("iii", $id_cliente,$id_plaza,$id_almacen );

            /* ejecutar la consulta */
            $stmt->execute();

            /* ligar variables de resultado */
            $stmt->bind_result($cantidadUsarios);

            /* obtener valor */
            $stmt->fetch();

            // printf("%s is in district %s\n", $resultado);

            /* cerrar sentencia */
            $stmt->close();
            return $cantidadUsarios;
        }
        return 10;
    }
}

?>