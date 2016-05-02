<?php

require_once "../init.php";
include_once 'PlazaControlador.php';
$row;
$Add = 1;
$rowPlaza = LlenarComboCliente($Add);



 
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



<div class="clearfix"></div><br />

<div class="container">


    <form method='post'>

        <table class='table table-bordered'>

            <tr>
                <td>Nombre del Plaza</td>
                <td><input type='text' name='nombrePlaza' class='form-control' required></td>
            </tr>



            <tr>
                <td>Direccion</td>
                <td><input type='text' name='Direccion' class='form-control' required></td>
            </tr>

           

            

<tr>

    <td>Cliente </td>
          <td>  

            <SELECT name='Cliente' class='form-control'> 

<?php foreach ($rowPlaza as $row) {
        echo '<option value="'.$rowPlaza['id_cliente'].'">'.$rowPlaza['nombre_cliente'].'</option>';
    }?>

            </SELECT>

          </td>
</tr>
            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-primary" name="btn-save">
                        <span class="glyphicon glyphicon-plus"></span> Create New Record
                    </button>
                    <a href="index.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Back to index</a>
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
<?php

if(isset($_POST['btn-save']))
{
    if($_POST['nombrePlaza']&& $_POST['Direccion']&& $_POST['Cliente']){

        if(agregarPlaza($_POST['nombrePlaza'], $_POST['Direccion'], $_POST['Cliente'])){
           header("Location: PlazaAgregar.php?inserted");
       }else{
           header("Location: PlazaAgregar.php?failure");
       }



    }
    /*
    if($crud->create($fname,$lname,$email,$contact))
    {
        header("Location: add-data.php?inserted");
    }
    else
    {
        header("Location: add-data.php?failure");
    }*/
}

?>

<?php
if(isset($_GET['inserted']))
{
    ?>
    <div class="container">
        <div class="alert alert-info">
            <strong>WOW!</strong> Record was inserted successfully <a href="Plaza.php">HOME</a>!
        </div>
    </div>
    <?php
}
else if(isset($_GET['failure']))
{
    ?>
    <div class="container">
        <div class="alert alert-warning">
            <strong>SORRY!</strong> ERROR while inserting record !
        </div>
    </div>
    <?php
}
?>
