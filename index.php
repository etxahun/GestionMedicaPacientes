<?php
include("login/include/session.php");
global $database;
$config = $database->getConfigs();

if(!$session->logged_in)
	{ 
	 header("Location: main.php"); 
	}else{	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Hamabide</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="Hamabide Base de Datos de Paciente">
    <meta name="author" content="ESB">
	<link type="image/x-icon" rel="shortcut icon" href="images/favicons.png">
	
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" href="css/tablesorter/blue/style.css" type="text/css" media="print, projection, screen"/>
	
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>    
	<script src="js/jquery.tablesorter.js" type="text/javascript"></script>
	<script type="text/javascript" >					
		$(document).ready(function(){			
			$("#resumen").tablesorter({widgets: ['zebra']}); 
		})
	</script>
</head>

<body>
<div id="user_login_wrapper">
	<div id="user_login">
		<?php 
			$nombre = ucfirst($session->username);
			echo "Kaixo <a  href=\"login/userinfo.php?user=$session->username\"><b>".$nombre."</b></a>";
		?>
		&nbsp;
		<b div style="border-right: 2px dotted black; margin-right: 2px;"></b>
		&nbsp;
		<a style="color: black;" href="login/process.php/">Logout</a>
	</div>	
</div>
<div id="container">
   <div id="menu">
		<div id="menu-items">
	        <ul>
				<li class="menuitem"><a style="color:#F7AA0A; font-weight:bold" href="index.php">Inicio</a></li>            
				<li class="menuitem"><a href="historicos.php">Históricos</a></li>
				<?php
					if($session->isAdmin()) { 
				?>
			    <li class="menuitem"><a href="altas.php">Altas</a></li>
			    <li class="menuitem"><a href="evolutivos.php">Evolutivos</a></li>							
				<?php
				}
				?>
	        </ul>
		</div>
		
		<div id="menu-logo">
			<a id="rt-logo" href="/hamabide9/index.php"></a>
		</div>
		
   </div><!--menu end-->

	<div id="content_index">
 		<p>Bienvenida a <b>Hamabide</b>, a continuación se listan los pacientes más recientes que están siendo tratados:</p>
		<?php
		require('conexion.php');
		/** GET USERS from database */	
		$res_users = $mysqli->query("SELECT id,nombre, apellidos, dni, telefono_habitual, estado_alta, facultativo 
									 FROM pacientedatos 
									 WHERE estado_alta ='En Tratamiento'" );
		?>
		<table id="resumen" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
		<thead>
			<tr>
				<th><b>Num. Historial</b></th>
                <th><b>Nombre</b></th>
				<th><b>Apellidos</b></th>
				<th><b>DNI</b></th>
				<th><b>Teléfono Habitual</b></th>
				<th><b>Situación</b></th>
				<th><b>Facultativo</b></th>
			</tr>
		</thead>
		<tbody>

		<?php
		while( $row = $res_users->fetch_row() ) {
		?>
			<tr>
				<td><?php echo($row[0])?></td> <!-- ID = Num Historial -->
                <td id="nombre_index"><?php echo(base64_decode($row[1]))?></td> <!-- Nombre -->
				<td><?php echo(base64_decode($row[2]))?></td> <!-- Apellidos -->
				<td><?php echo(base64_decode($row[3]))?></td> <!-- DNI -->
				<td><?php echo(base64_decode($row[4]))?></td> <!-- Teléfono Habitual -->
				<td id="situacion_index"><?php echo($row[5])?></td> <!-- Situación del Paciente --> 
				<td><?php echo(base64_decode($row[6]))?></td> <!-- Facultativo-->
			</tr>
		<?php
		}
		 $num_rows = mysqli_num_rows($res_users);
		 if ($num_rows==0){
			?><tr><td colspan="7" align="center">No hay pacientes que se encuentren "En Tratamiento".</td></tr><?php
		 }
		?>
		</tbody>

	</div><!--content end-->
	
</div><!--container end-->
</body>
</html>
<?php
	}
?>
