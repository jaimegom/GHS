<?php
$err = isset($_GET['error']) ? $_GET['error'] : null ;
session_start();
if (isset($_COOKIE['username']) && isset($_COOKIE['password']) ||  isset($_SESSION['username'])) {
    if (!isset($_SESSION['username'])) {
        session_start();
        $_SESSION['username'] = $_COOKIE['username'];
        //se va a agregar.php porque aun no hay un menu
    }
    //header('Location:Desarrollo/Admon/Clientes/Clientes.php');


    header('Location:Desarrollo/Admon/Clientes/Plaza.php');
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
        <link rel="stylesheet" href="Desarrollo/Admon/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="Desarrollo/Admon/assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="Desarrollo/Admon/assets/css/form-elements.css">
        <link rel="stylesheet" href="Desarrollo/Admon/assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        //
        <script src="Desarrollo/Admon/jquery-2.1.4.js"></script>

        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="Desarrollo/Admon/assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="Desarrollo/Admon/assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="Desarrollo/Admon/assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="Desarrollo/Admon/assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="Desarrollo/Admon/assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">

            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>GHS</strong> Login </h1>
                            <div class="description">
                            	<!--
                                <p>
	                            	This is a free responsive login form made with Bootstrap.
	                            	Download it on <a href="http://azmind.com"><strong>AZMIND</strong></a>, customize and use it as you like!
                            	</p>
                            -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Accede al sitio</h3>
                            		<p>Ingresa tu usuario y contraseña para iniciar sesion:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-key"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="Desarrollo/Admon/Login/loginController.php" method="post" class="login-form" >
			                    	<div class="form-group">
		 	                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="form-username" placeholder="Username..." class="form-username form-control" id="form-username">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>

			                        	<input type="password" name="form-password" placeholder="Password..." class="form-password form-control" id="form-password">
                                        Recordad usuario y contraseña: <input type="checkbox" name="rememberme" value="1"><br>
			                         </div>
                                    <?php
                                    if($err==1){
                                        echo "Usuario o Contraseña Erróneos <br />";
                                    }
                                    if($err==2){
                                        echo "Debe iniciar sesion para poder acceder el sitio. <br />";
                                    }
                                    ?>
                                    <button  type="submit" class="btn">Sign in!</button>
                                          </form>
                                     </div>
                                 </div>
                             </div>


                </div>
            </div>

        </div>


        <!-- Javascript -->
        <script src="Desarrollo/Admon/assets/js/jquery-1.11.1.min.js"></script>
        <script src="Desarrollo/Admon/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="Desarrollo/Admon/assets/js/jquery.backstretch.min.js"></script>
        <script src="Desarrollo/Admon/assets/js/scripts.js"></script>

        <!--[if lt IE 10]>
        <script src="Desarrollo/Admon/assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>