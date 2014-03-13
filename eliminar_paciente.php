<?php
	/** Connect to database */
	require('conexion.php');
	
	$mysqli->query("DELETE FROM pacientedatos WHERE id='".$_POST['id']."'");
?>