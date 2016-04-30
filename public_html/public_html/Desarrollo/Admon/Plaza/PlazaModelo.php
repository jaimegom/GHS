<?php
require_once "../init.php";
class PlazaModelo
{
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
                    <td><?php print($row['id_plaza']); ?></td>
                    <td><?php print($row['nombre_plaza']); ?></td>
                    <td><?php print($row['direccion_plaza']); ?></td>
                    <td><?php print($row['nombre_cliente']); ?></td>
                    <td><?php print($row['id_cliente']); ?></td>
                    <td align="center">
                        <a href="PlazaModificar.php?edit_id=<?php print($row['id_plaza']); ?>&edit_id2=<?php print($row['id_cliente']); ?>  "><i class="glyphicon glyphicon-edit"></i></a>
                    </td>
                    <td align="center">
                        <a href="PlazaEliminar.php?delete_id=<?php print($row['id_plaza']); ?>"><i class="glyphicon glyphicon-remove-circle"></i></a>
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
                echo "<li><a href='".$self."?page_no=1'>First</a></li>";
                echo "<li><a href='".$self."?page_no=".$previous."'>Previous</a></li>";
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
                echo "<li><a href='".$self."?page_no=".$next."'>Next</a></li>";
                echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last</a></li>";
            }
            ?></ul><?php
        }
    }

    public function agregarPlazaModelo($nombrePlaza , $direccion,$fecha){
        if ($stmt = $this->conn->prepare("insert into Plaza(nombre_Plaza,direccion_plaza,fecha_creacion) VALUES(?,?,?,?,?)")) {

            /* ligar par?metros para marcadores */
            if(!$stmt->bind_param("sssss",$nombrePlaza , $direccion,$fecha)){
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

    public function modificarPlazaModelo($nombrePlaza,$direccion,$id_Plaza,$id_cliente){
        if ($stmt = $this->conn->prepare("update Plaza set nombre_plaza =? direccion_plaza=? where id_Plaza=? and id_cliente =?")) {

            /* ligar par?metros para marcadores */
            if(!$stmt->bind_param("ssii",$nombrePlaza , $direccion,$id_Plaza,$id_cliente)){
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



    public function getByIDPlaza($id_plaza,$id_cliente){
        if ($stmt = $this->conn->prepare("Select p.id_plaza,nombre_plaza,direccion_plaza,c.nombre_cliente   as Cliente , c.id_cliente as id_cliente from plaza p left JOIN cliente c on p.id_cliente = c.id_cliente where p.id_plaza = ? and c.id_cliente = ? ")) {

//
            /* ligar par?metros para marcadores */
            if(!$stmt->bind_param("ii",$id_plaza,$id_cliente)){
                return false;
            }


            /* ejecutar la consulta */
            if(!$stmt->execute()){
                return false;
            }

           
           
            $result = $stmt->get_result();
            $row = $result->fetch_array(MYSQLI_ASSOC);

            //$stmt->bind_result( $nombre_Plaza, $correo_electronico, $telefono, $direccion);
            //$result = $stmt->fetch();
            /* cerrar sentencia */
            $stmt->close();
            return $row;
        }else{
            return false;
        }
    }
}

?>