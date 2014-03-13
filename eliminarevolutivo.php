<?php
	/** Connect to database */
	require('conexion.php');
	
	$mysqli->query("DELETE FROM evolutivos WHERE id='".$_POST['id_evolutivo']."'");
?>