<?php
	include("login/include/session.php");
	global $database;
	$config = $database->getConfigs();
	
	if($session->logged_in)
		{
		 header("Location: index.php"); 
		}else
		{
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Hamabide Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Hamabide Base de Datos de Paciente">
    <meta name="author" content="ESB">
	<link type="image/x-icon" rel="shortcut icon" href="bootstrap/images/favicons.png">
	
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="bootstrap/css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
  </head>

  <body>
  <!--
	<?php
	/**
	 * User not logged in, display the login form.
	 * If user has already tried to login, but errors were
	 * found, display the total number of errors.
	 * If errors occurred, they will be displayed.
	 */
		if($form->num_errors > 0){
		   echo $form->num_errors." error(s) found";
		}
	?>
	-->
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<h1 class="text-center login-title">Inicia sesión para acceder a Hamabide</h1>
				<div class="account-wall">
					<!--<img class="profile-img" src="bootstrap/images/photo1.jpg">-->
					<img class="profile-img" src="bootstrap/images/photo2.jpg">
					<form action="login/process.php" method="POST" class="form-signin">
						<input type="username" class="form-control" name="user" placeholder="Usuario" required autofocus>
						&nbsp;
						<input type="password" class="form-control" name="pass" placeholder="Contraseña" required>
						&nbsp;
						<?php echo $form->error("user"); ?>
						<input type="hidden" name="sublogin" value="1">
						<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
					
						<label class="checkbox pull-left">
							<input type="checkbox" name="remember" value="remember-me" <?php if($form->value("remember") != ""){ echo "checked"; } ?>>	Recordar credenciales
						</label>						
					</form>
				</div>
				<a href="login/register.php" class="text-center new-account">Crear una cuenta nueva </a>
			</div>
		</div>
	</div>
	
	
	<!--
    <div id="login">

      <form action="process.php" method="POST" class="form-signin" role="form" >
        <h2 class="form-signin-heading">Login</h2>
        <input type="username" class="form-control" name="user" maxlength="20" value="<?php echo $form->value("user"); ?>" placeholder="Usuario" required autofocus>
        <input type="password" class="form-control" name="pass" maxlength="20" value="<?php echo $form->value("pass"); ?>" placeholder="Contraseña" required>
        <label class="checkbox">
          <input type="checkbox" name="remember" value="remember-me" <?php if($form->value("remember") != ""){ echo "checked"; } ?>> Remember me
        </label>
		<input type="hidden" name="sublogin" value="1">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
<?php
	}
?>
