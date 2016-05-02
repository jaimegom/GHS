<?php
ob_start();
require_once "../init.php";
include_once 'AlmacenControlador.php';
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
   <!-- <script src="../jquery-2.1.4.js" ></script>-->
    <script src="../assets/js/jquery-1.11.1.js" ></script>

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
                <td>Cliente</td>
                <td>
                <select name="id_cliente" id="id_cliente" >
                <?php
                getAllByIDCliente();
                ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Plaza</td>d
                <td>
                    <select name="id_plaza" id="id_plaza">
                    <script type = "text/javascript">

                        $(document).on('change','#id_cliente',function(){


                            var val = $(this).val();

                            $.ajax({
                                url: 'AlmacenControlador.php',
                                data: {id_cliente:val},
                                type: 'GET',
                                dataType: 'html',
                                success: function(result){
                                    $('#id_plaza').html();
                                    $('#id_plaza').html(result);
                                }
                            });

                        });

                    </script>
                        </select>
                </td>
            </tr>

            <tr>
                <td>Capacidad</td>
                <td><input type='text' name='capacidad' class='form-control' required onkeypress='validate(event)'></td>
            </tr>

            <tr>
                <td>Tipo</td>
                <td><input type='text' name='tipo' class='form-control' required ></td>
            </tr>

            <tr>
                <td>Precision</td>
                <td><input type='text' name='precision' class='form-control' required onkeypress='validate(event)'></td>
            </tr>

            <tr>
                <td>Unidad de medida 1</td>
                <td><input type='text' name='um1' class='form-control' required></td>
            </tr>

            <tr>
                <td>Factor</td>
                <td><input type='text' name='factor' class='form-control' requiredonkeypress='validate(event)'></td>
            </tr>

            <tr>
                <td>Activar Unidad de Medida 2</td>
                <td><input type='text' name='act' class='form-control' ></td>
            </tr>

            <tr>
                <td>Unidad de Medida 2</td>
                <td><input type='text' name='um2' class='form-control' ></td>
            </tr>

            <tr>
                <td>Factor UM 2</td>
                <td><input type='text' name='factor2' class='form-control' onkeypress='validate(event)'></td>
            </tr>

            <tr>
                <td colspan="2">
                    <button type="submit" class="btn btn-primary" name="btn-save">
                        <span class="glyphicon glyphicon-plus"></span> Crear Almacen
                    </button>
                    <a href="Almacen.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Regresar al Menu</a>
                </td>
            </tr>

        </table>
    </form>


</div>
<script type = "text/javascript">
    function validate(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode( key );
        var regex = /[0-9]|\./;
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>

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
ob_start();
if(isset($_POST['btn-save']))
{
    //0 error
    //1 se inserto correctamente
    //2 ya hay dos almacenes
    //sacar la fecha

    if($_POST['id_cliente']&& $_POST['id_plaza']&& $_POST['capacidad']&&$_POST['tipo']&& $_POST['precision']&& $_POST['um1']&&$_POST['factor']&& $_POST['act']&& $_POST['um2']&& $_POST['factor2']){
        $almacenAgregado= agregarAlmacen($_POST['id_cliente'], $_POST['id_plaza'], $_POST['capacidad'],$_POST['tipo'], $_POST['precision'], $_POST['um1'],$_POST['factor'], $_POST['act'], $_POST['um2'], $_POST['factor2']);
        if($almacenAgregado==1){
            header("Location:AlmacenAgregar.php?inserted");
            echo "insertado";
        }elseif($almacenAgregado==2){
           header("Location:AlmacenAgregar.php?repetido");
            echo "repetido";
        }elseif($almacenAgregado==0){
            header("Location:AlmacenAgregar.php?failure");
        }
    }
}

?>
<?php
ob_start();
if(isset($_GET['inserted']))
{
    ?>
    <div class="container">
        <div class="alert alert-info">
            <strong>WOW!</strong> Almacen fue guardado exitosamente <a href="ClienteAgregar.php">Regresar al Menu</a>
        </div>
    </div>
    <?php
}
else if(isset($_GET['failure']))
{
    ?>
    <div class="container">
        <div class="alert alert-warning">
             ERROR mientras se insertaba!
        </div>
    </div>
    <?php
}else if(isset($_GET['repetido']))
{
    ?>
    <div class="container">
        <div class="alert alert-warning">
            Ya existen dos almacenes en esta plaza! No se puede agregar otro almacen.
        </div>
    </div>
    <?php
}
?>
