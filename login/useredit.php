<?php
/**
 * UserEdit.php
 *
 * This page is for users to edit their account information such as their password, 
 * email address, etc. Their usernames can not be edited. When changing their
 * password, they must first confirm their current password.
 *
 * Updated by: The Angry Frog - Last Updated: December 29th, 2011
 */
include("include/session.php");
global $database;
$config = $database->getConfigs();

/**
 * User has submitted form without errors and user's
 * account has been edited successfully.
 */
if(isset($_SESSION['useredit'])){
   unset($_SESSION['useredit']);
   
   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../css/style.css\" />";
   echo "<div id=\"user_edit_informa\">";
   		echo "<h1>Los datos se han guardado correctamente!</h1>";
   		echo "<br><br>";
   		echo "<p><b>".ucfirst($session->username)."</b>, los datos de tu cuenta se han actualizado. ";
   		echo "<ul class=\"pager\">";
   		echo "		<li>";
   		echo "			<a style=\"background-color: #F3A820; font-weight: bold;\" href=".$config['WEB_ROOT'].$config['home_page'].">Volver a Hamabide </a>";
   		echo "		</li>";
   		echo "</ul>";
   echo "</div>";
}
else{

/**
 * If user is not logged in, then do not display anything.
 * If user is logged in, then display the form to edit
 * account information, with the current email address
 * already in the field.
 */
if(!$session->logged_in){
	header("Location: ".$config['WEB_ROOT'].$config['home_page']);
} else {	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $config['SITE_NAME']; ?> - Edición Usuario</title>
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
</head>
<body>
	<div id="user_edit">
		<h1>Edición de datos: <?php $nombre = ucfirst($session->username) ;echo "<i>".$nombre."</i>"; ?></h1>
		<hr>
		<?php
		if($form->num_errors > 0){
		   echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
		}
		?>
		<form action="process.php" method="POST">
			<table id="edita_tabla" align="left" border="0" cellspacing="0" cellpadding="3">
				<tr>
					<td style="text-align: right; font-weight: bold;">Contraseña Actual:</td>
					<td><input type="password" name="curpass" maxlength="30" placeholder="Introduce tu contraseña actual" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Introduce tu contraseña actual'" value="<?php echo $form->value("curpass"); ?>"></td>
					<td><?php echo $form->error("curpass"); ?></td>
				</tr>
				
				<tr>
					<td style="text-align: right; font-weight: bold;">Nueva Contraseña:</td>
					<td><input type="password" name="newpass" maxlength="30" placeholder="Introduce tu nueva contraseña"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Introduce tu nueva contraseña'" value="<?php echo $form->value("newpass"); ?>"></td>
					<td><?php echo $form->error("newpass"); ?></td>
				</tr>
		
				<tr>
					<td style="text-align: right; font-weight: bold;">Confirma Nueva Contraseña:</td>
					<td><input type="password" name="conf_newpass" maxlength="30" placeholder="Confirma tu nueva contraseña" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Confirma tu nueva contraseña'" value="<?php echo $form->value("newpass"); ?>"></td>
					<td><?php echo $form->error("newpass"); ?></td>
				</tr>
		
				<tr>
					<td style="text-align: right; font-weight: bold;">Email:</td>
					<td><input type="text" name="email" maxlength="50" value="<?php	if($form->value("email") == ""){
						echo $session->userinfo['email'];
						}else{
								echo $form->value("email");
							}
						?>">
					</td>
					<td><?php echo $form->error("email"); ?></td>
				</tr>
			</table>
			
			<hr>
			
			<input type="hidden" name="subedit" value="1">
			<ul class="pager">

		
				<li>
					<a style="margin-top: 0px;" id="vuelve_edit" <?php echo "href=".$config['WEB_ROOT'].$config['home_page'].">Volver a Hamabide" ?></a>
				</li>
				
				<li>
					<input type="submit" value="Guardar Cambios">
				</li>
			</ul>
		</form>
		<?php
		} 
		}
		?>
	</div>
</body>
</html>
