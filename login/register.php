<?php
/**
 * Register.php
 * 
 * Displays the registration form if the user needs to sign-up, or lets the 
 * user know, if he's already logged in, that he can't register another name.
 * 
 * Originally written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated by The Angry Frog : April 4th, 2012
 * 
 */

include("include/session.php");
$config = $database->getConfigs();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $config['SITE_NAME']; ?> - Register Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Hamabide Base de Datos de Paciente">
<meta name="author" content="ESB">
<link type="image/x-icon" rel="shortcut icon" href="../images/favicons.png">
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<style type="text/css">
<!--
body {
	font: 12px/1.5 Lucida Grande, Arial, Helvetica, 'Liberation Sans', FreeSans, sans-serif;	
}
-->
</style>

<?php 
$id = isset($_GET['id']) ? $_GET['id'] : 1;
if ($config['ENABLE_CAPTCHA']){
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="captcha/jquery/QapTcha.jquery.css" type="text/css" />	



<?php 
} 
?>
    
</head>
<body>
<?php
/**
 * The user is already logged in, not allowed to register.
 */
if($session->logged_in){
   echo "<h1>Registered</h1>";
   echo "<p>We're sorry <b>$session->username</b>, but you've already registered. "
       ."<a href=\"main.php\">Main</a>.</p>";
}
/**
 * The user has submitted the registration form and the
 * results have been processed.
 */

	else if(isset($_SESSION['regsuccess'])){
	
	if ($_SESSION['regsuccess']==6){
      echo "<h1>Registration is currently disabled!</h1>";
      echo "<p>We're sorry <b>".$_SESSION['reguname']."</b> but registration to this site is currently disabled."
          ."<br>Please try again at a later time or contact the website owner.</p>";
	}
	/* Registration was successful */
	else if($_SESSION['regsuccess']==0 || $_SESSION['regsuccess']==5){
      echo "<div id=\"user_register\">";
		echo "<h1>Registered!</h1>";
		/*echo "<p>Thank you <b>".$_SESSION['reguname']."</b>, your information has been added to the database, "
          ."you may now <a href=\"main.php\">log in</a>.</p>";*/
		echo "<p>Gracias <b>".$_SESSION['reguname']."</b>, tu información ha sido introducida en la base de datos. "
		  ."Para acceder a Hamabide hazlo a través de la <a href=".$config['WEB_ROOT'].$config['home_page'].">Página de Login</a>.</p>";
		  
	  echo "</div>";
	}
	else if($_SESSION['regsuccess']==3){
      echo "<h1>Registered!</h1>";
      echo "<p>Thank you <b>".$_SESSION['reguname']."</b>, your account has been created. "
          ."However, this board requires account activation, an activation key has been sent to the e-mail address you provided. "
          ."Please check your e-mail for further information.</p>";
	}
	else if($_SESSION['regsuccess']==4){
      echo "<h1>Registered!</h1>";
      echo "<p>Thank you <b>".$_SESSION['reguname']."</b>, your account has been created. "
          ."However, this board requires account activation by an Admin. An e-mail has been sent to them and you will be informed "
          ."when your account has been activated.</p>";
   }
   /* Registration failed */
   else if ($_SESSION['regsuccess']==2){
      echo "<h1>Registration Failed</h1>";
      echo "<p>We're sorry, but an error has occurred and your registration for the username <b>".$_SESSION['reguname']."</b>, "
          ."could not be completed.<br>Please try again at a later time.</p>";
   }
   unset($_SESSION['regsuccess']);
   unset($_SESSION['reguname']);
   } 
    else if ((isset($_GET['mode'])) && ($_GET['mode'] == 'activate')) {
	$user = $_GET['user'];
	$actkey = $_GET['activatecode'];
	
	$sql = $database->connection->prepare("UPDATE ".TBL_USERS." SET USERLEVEL = '3' WHERE username=:user AND actkey=:actkey");
	$sql->bindParam(":user",$user);
	$sql->bindParam(":actkey",$actkey);
	$sql->execute();
	
	echo 'Your account is now activated.';
	// some warning if not successful
}
/**
 * The user has not filled out the registration form yet.
 * Below is the page with the sign-up form, the names
 * of the input fields are important and should not
 * be changed.
 */
else{
?>
	<div id="user_register">
		<h1>Nuevo Usuario</h1>
		<hr>
		<?php
		if($form->num_errors > 0){
		   echo "<p style=\"color:#ff0000;margin: 0;\">".$form->num_errors." error(s) found</p>";
		}
		?>
		<form action="process.php" method="post">
		<table id="tabla_registra_usuario" align="left" border="0" cellspacing="0" cellpadding="3">
		<tr>
			<td style="text-align: right"><b>Nombre de Usuario:</b></td>
			<td><input type="text" name="user" placeholder="Introduce tu nombre de usuario" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Introduce tu nombre de usuario'" value="<?php echo $form->value("user"); ?>" /></td>
			<td><?php echo $form->error("user"); ?></td>
		</tr>
		<tr>
			<td style="text-align: right"><b>Contraseña:</b></td>
			<td><input type="password" name="pass" placeholder="Introduce una contraseña"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Introduce una contraseña'" value="<?php echo $form->value("pass"); ?>" /></td>
			<td><?php echo $form->error("pass"); ?></td></tr>
		<tr>
			<td style="text-align: right"><b>Confirma contraseña:</b></td>
			<td><input type="password" name="conf_pass" placeholder="Confirma la contraseña"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Confirma la contraseña'" value="<?php echo $form->value("conf_pass"); ?>" /></td>
			<td><?php echo $form->error("pass"); ?></td>
		</tr>
		<tr>
			<td style="text-align: right"><b>E-mail:</b></td>
			<td><input type="text" name="email" placeholder="Introduce una dirección de E-mail"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Introduce una dirección de E-mail'" value="<?php echo $form->value("email"); ?>" /></td>
			<td><?php echo $form->error("email"); ?></td>
		</tr>
		<tr>
			<td style="text-align: right"><b>Confirma E-mail:</b></td>
			<td><input type="text" name="conf_email" placeholder="Confirma la dirección de E-mail"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Confirma la dirección de E-mail'" value="<?php echo $form->value("conf_email"); ?>" /></td>
			<td><?php echo $form->error("email"); ?></td>
		</tr>
		<?php 
		if ($config['ENABLE_CAPTCHA']){
			echo "<tr><td colspan=\"2\"><div class=\"QapTcha\"></div></td></tr>";
		}
		?>
		
		</table>
		<hr>
		<!-- The following div tag displays a hidden form field in an attempt at tricking automated bots. -->
		<div style='display:none; visibility:hidden;'><input type='text' name='killbill' maxlength='50' /></div>			
		
		<input type="hidden" name="subjoin" value="1">
			<ul class="pager_register">
				<li>
					<a style="margin-top: 0px;" id="vuelve_edit" <?php echo "href=".$config['WEB_ROOT'].$config['home_page'].">Volver a Hamabide" ?></a>
				</li>
				
				<li>
					<input type="submit" value="Guardar">
				</li>
			</ul>
		</form>

		<?php 
		if ($config['ENABLE_CAPTCHA']){
		?>
		<!-- QapTcha and jQuery files -->
		<script type="text/javascript" src="captcha/jquery/jquery.js"></script>
		<script type="text/javascript" src="captcha/jquery/jquery-ui.js"></script>
		<script type="text/javascript" src="captcha/jquery/jquery.ui.touch.js"></script>
		<script type="text/javascript" src="captcha/jquery/QapTcha.jquery.js"></script>
		<script type="text/javascript">
				$('.QapTcha').QapTcha({});
			</script>
		<?php
		}
		}
		?>
	</div>
</body>
</html>
