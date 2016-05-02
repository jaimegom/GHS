<?php
require_once "../init.php";
include_once 'AlmacenControlador.php';
if(isset($_POST['btn-update']))
{
    $id_almacen = $_POST['id_almacen'];
    $id_cliente = $_POST['id_cliente'];
    $id_plaza = $_POST['id_plaza'];
    $id_cliente = $_POST['id_cliente'];
    $capacidad = $_POST['capacidad'];
    $tipo = $_POST['tipo'];
    $precision = $_POST['precision'];
    $um1 = $_POST['um1'];
    $factor = $_POST['factor'];
    $act = $_POST['act'];
    $um2 = $_POST['um2'];
    $factor2 = $_POST['factor2'];


    if(modificarAlmacen($capacidad, $tipo, $precision,$um1,$factor,$act,$um2,$factor2,$id_cliente,$id_almacen,$id_plaza)){
        $msg = "<div class='alert alert-info'>
				Almacen fue modificado exitosamente <a href='Clientes.php'>Regresar al Menu</a>!
				</div>";
    }else{
        $msg = "<div class='alert alert-warning'>
				<strong></strong> ERROR mientras se actualizaba !
				</div>";
    }
}

if(isset($_GET['edit_id']) &&isset($_GET['edit_id_plaza'])&&isset($_GET['edit_id_cliente']))
{
    $id_almacen = $_GET['edit_id'];
    $id_plaza = $_GET['edit_id_plaza'];
    $id_cliente= $_GET['edit_id_cliente'];
    $rowAlmacen = getAlmacenByID($id_cliente,$id_plaza,$id_almacen);
    $id_almacen= $rowAlmacen['id_almacen'];
    $capacidad = $rowAlmacen['capacidad'];

    $tipo = $rowAlmacen['tipo'];
    $precision = $rowAlmacen['precision_'];
    $um1 = $rowAlmacen['um1'];
    $factor = $rowAlmacen['factor'];
    $act = $rowAlmacen['act'];
    $um2 = $rowAlmacen['um2'];
    $facto2 = $rowAlmacen['factor2'];
    $id_plaza = $rowAlmacen['id_plaza'];
    $rowPlaza= getPlazaByID($id_plaza);
    $nombrePlaza= $rowPlaza['nombre_plaza'];
    $id_cliente = $rowAlmacen['id_cliente'];
    $row= getRowByIDCliente($id_cliente);
    $nombreCliente = $row["nombre_cliente"];

}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Telemetria</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/form-elements.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    //
    <script src="../jquery-2.1.4.js"></script>

    <![endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">

</head>

<body>

<div class="container">
    <?php
    if(isset($msg))
    {
        echo $msg;
    }
    ?>
</div>

<div class="clearfix"></div><br />

<div class="container">

    <form method='post'>
        <input type="text" name="id_cliente" hidden value="<?php echo $id_cliente; ?>" > </input>
        <input type="text" name="id_plaza" hidden value="<?php echo $id_plaza; ?>" > </input>
        <table class='table table-bordered'>
            <tr>
                <td>Numero de Almacen</td>
                <td><input type='text' name='id_almacen' class='form-control' readonly value="<?php echo $id_almacen; ?>" required></td>
            </tr>

            <tr>
                <td>Nombre del cliente</td>
                <td><input type='text' name='nombreCliente' class='form-control' value="<?php echo $nombreCliente; ?>" required></td>
            </tr>

            <tr>
                <td>Nombre de plaza</td>
                <td><input type='text' name='nombreCliente' class='form-control' value="<?php echo $nombrePlaza; ?>" required></td>
            </tr>

            <tr>
                <td>Capacidad</td>
                <td><input type='text' name='capacidad' class='form-control' value="<?php echo $capacidad; ?>" required></td>
            </tr>

            <tr>
                <td>Tipo</td>
                <td><input type='text' name='tipo' class='form-control' value="<?php echo $tipo; ?>" required></td>
            </tr>

            <tr>
                <td>Precision</td>
                <td><input type='text' name='precision' class='form-control' value="<?php echo $precision; ?>" required></td>
            </tr>

            <tr>
                <td>Unidad de medida 1</td>
                <td><input type='text' name='um1' class='form-control' value="<?php echo $um1; ?>" required></td>
            </tr>

            <tr>
                <td>Factor</td>
                <td><input type='text' name='factor' class='form-control' value="<?php echo $factor; ?>" required></td>
            </tr>

            <tr>
                <td>Activar Unidad de Medida 2</td>
                <td><input type='text' name='act' class='form-control' value="<?php echo $act; ?>" required></td>
            </tr>

            <tr>
                <td>Unidad de Medida 2</td>
                <td><input type='text' name='um2' class='form-control' value="<?php echo $um2; ?>" required></td>
            </tr>

            <tr>
                <td>Factor UM 2</td>
                <td><input type='text' name='factor2' class='form-control' value="<?php echo $facto2; ?>" required></td>
            </tr>

            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-primary" name="btn-update">
                        <span class="glyphicon glyphicon-edit"></span>  Modificar Cliente
                    </button>
                    <a href="Almacen.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Regresar al Menu</a>
                </td>
            </tr>

        </table>
    </form>


</div>



<!-- Javascript -->
<script src="../assets/js/jquery-1.11.1.min.js"></script>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../assets/js/jquery.backstretch.min.js"></script>
<script src="../assets/js/scripts.js"></script>

<!--[if lt IE 10]>
<script src="../assets/js/placeholder.js"></script>
<![endif]-->

</body>

</html>
