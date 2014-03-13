<?php
/**
 * UserInfo.php
 *
 * This page is for users to view their account information
 * with a link added for them to edit the information.
 *
 * Updated by: The Angry Frog
 * Last Updated: October 26, 2011
 */
include("include/session.php");
global $database;
$config = $database->getConfigs();
if (!isset($_GET['user'])) { 
	header("Location: ".$config['WEB_ROOT'].$config['home_page']);
}
?>

<html>
<head>
	<title><?php echo $config['SITE_NAME']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="Hamabide Base de Datos de Paciente">
    <meta name="author" content="ESB">
	<link type="image/x-icon" rel="shortcut icon" href="../images/favicons.png">
	
	<link rel="stylesheet" type="text/css" href="../css/style.css" />

<style type="text/css">
</style>
</head>
<body>
	<div id="user_info">
		<?php
		/* Requested Username error checking */
		$req_user = trim($_GET['user']);
		if(!$req_user || strlen($req_user) == 0 ||
		   !preg_match("/^[a-z0-9]([0-9a-z_-\s])+$/i", $req_user) ||
		   !$database->usernameTaken($req_user)){
		   die("Usuario no registrado");
		}
		
		/* Logged in user viewing own account */
		if(strcmp($session->username,$req_user) == 0){
		   echo "<h1>Mis Datos</h1>";
		   echo "<hr>";
		}
		/* Visitor not viewing own account */
		else{
		   echo "<h1>Información del Usuario</h1>";
		}
		
		/* Display requested user information - add/delete as applicable */
		$req_user_info = $database->getUserInfo($req_user);
		
		/* Username */
		echo "<b>Usuario: ".$req_user_info['username']."</b><br><br>";
		
		/* Email */
		echo "<b>Email:</b> ".$req_user_info['email']."<br>";
		
		/**
		 * Note: when you add your own fields to the users table
		 * to hold more information, like homepage, location, etc.
		 * they can be easily accessed by the user info array.
		 *
		 * $session->user_info['location']; (for logged in users)
		 *
		 * $req_user_info['location']; (for any user)
		 */
		
		/* If logged in user viewing own account, give link to edit */
		if(strcmp($session->username,$req_user) == 0){
			echo '<br><br><a href="useredit.php">Editar Información</a><br>';
		}
		
		/* Link back to main */
		echo "<br>";
		echo "<hr>";
		
		
		echo "<ul class=\"pager\">";
		echo	"<li>";
		echo	"<a style=\"margin-top: 0px;\" id=\"vuelve_edit\" href='".$config['WEB_ROOT'].$config['home_page']."'>Volver a Hamabide</a>";
		echo	"</li>";
		echo "</ul>";
		
		//echo "Volver a [<a href='".$config['WEB_ROOT'].$config['home_page']."'>Hamabide</a>]<br>";
		
		?>

		<div id="imagen_medico_dcha">    
			<img src = "../images/usuario_medico.png" width="102" height="102" alt = "DatosMedico" />
		</div>

	</div>
	


</body>
</html>
