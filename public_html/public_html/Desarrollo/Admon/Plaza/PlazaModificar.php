<?php
require_once "../init.php";
include_once 'PlazaControlador.php';
if(isset($_POST['btn-update']))
{
    $id_Plaza = $_GET['edit_id'];
    $id_cliente = $_GET['edit_id2'];
    $nombrePlaza = $_POST['nombrePlaza'];
    $direccion = $_POST['direccion'];
    

    if(modificarPlaza($nombrePlaza,$direccion,$id_Plaza,$id_cliente)){
        $msg = "<div class='alert alert-info'>
				<strong>WOW!</strong> Record was updated successfully <a href='index.php'>HOME</a>!
				</div>";
    }else{
        $msg = "<div class='alert alert-warning'>
				<strong>SORRY!</strong> ERROR while updating record !
				</div>";
    }
    /*
    if($crud->update($id,$fname,$lname,$email,$contact))
    {
        $msg = "<div class='alert alert-info'>
				<strong>WOW!</strong> Record was updated successfully <a href='index.php'>HOME</a>!
				</div>";
    }
    else
    {
        $msg = "<div class='alert alert-warning'>
				<strong>SORRY!</strong> ERROR while updating record !
				</div>";
    }
    */
}

if(isset($_GET['edit_id']))
{

 
    $id_Plaza = $_GET['edit_id'];
    $id_cliente = $_GET['edit_id2'];
    $rowPlaza = getByIDPlaza($id_Plaza,$id_cliente);
    $nombrePlaza=$rowPlaza['nombre_plaza'];
    $direccion = $rowPlaza['direccion_plaza'];
    $NombreCliente = $rowPlaza['Cliente'];
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

        <table class='table table-bordered'>
            <tr>
                <td>Nombre del Plaza</td>
                <td><input type='text' name='nombrePlaza' class='form-control' value="<?php echo $nombrePlaza; ?>" required></td>
            </tr>



            <tr>
                <td>Direccion</td>
                <td><input type='text' name='direccion' class='form-control' value="<?php echo $direccion; ?>" required></td>
            </tr>

             <tr>
                <td>Cliente</td>
                <td><input type='text' name='Cliente' class='form-control' value="<?php echo $NombreCliente; ?>" required></td>
            </tr>


             

            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-primary" name="btn-update">
                        <span class="glyphicon glyphicon-edit"></span>  Update this Record
                    </button>
                    <a href="index.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; CANCEL</a>
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
