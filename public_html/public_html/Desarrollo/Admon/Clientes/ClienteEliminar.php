<?php
require_once "../init.php";
include_once 'ClienteControlador.php';
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
    if(isset($_GET['deleted']))
    {
        ?>
        <div class="alert alert-success">
            <strong>Hecho!</strong> cliente fue eliminado...
        </div>
        <?php
    }
    else
    {
        ?>
        <div class="alert alert-danger">
            Quisiera <strong>eliminar</strong> el siguiente cliente ?
        </div>
        <?php
    }
    ?>

    <?php
    if(isset($_POST['btn-del']))
    {
        $id = $_GET['delete_id'];
        if(deleteClienteByID($id)) {
            header("Location: ClienteEliminar.php?deleted");
        }else{
            //no se elimino
        }
    }

    ?>
</div>

<div class="clearfix"></div>

<div class="container">

    <?php
    if(isset($_GET['delete_id']))
    {
        ?>
        <table class='table table-bordered'>
            <tr>
                <th>ID Cliente</th>
                <th>Nombre</th>
                <th>Correo electronico</th>
                <th>Telefono</th>
                <th>Direccion</th>
            </tr>
            <?php
            $row = getByIDCliente($_GET['delete_id']);
                ?>
                <tr>
                    <td><?php print($row['id_cliente']); ?></td>
                    <td><?php print($row['nombre_cliente']); ?></td>
                    <td><?php print($row['correo_electronico']); ?></td>
                    <td><?php print($row['telefono']); ?></td>
                    <td><?php print($row['direccion']); ?></td>
                </tr>
                <?php

            ?>
        </table>
        <?php
    }
    ?>
</div>

<div class="container">
    <p>
        <?php
        if(isset($_GET['delete_id']))
        {
        ?>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $row['id_cliente']; ?>" />
        <button class="btn btn-large btn-primary" type="submit" name="btn-del"><i class="glyphicon glyphicon-trash"></i> &nbsp; Eliminar</button>
        <a href="Clientes.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; No</a>
    </form>
    <?php
    }
    else
    {
        ?>
        <a href="clientes.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Regresar al Menu</a>
        <?php
    }
    ?>
    </p>
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
