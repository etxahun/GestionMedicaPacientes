<?php
	/** Connect to database */
	require('conexion.php');
	
	
	if(isset($_POST['input_id'])){
		$id_evolutivo=$_POST['input_id'];
	} else{
		$id_evolutivo="";
	}
	
	if(isset($_POST['input_fecha_evolutivo'])){
		$fecha_evol_claro=$_POST['input_fecha_evolutivo'];
	} else{
		$fecha_evol_claro="";
	}
	
	if(isset($_POST['input_paciente_id'])){
		$paciente_id_claro=$_POST['input_paciente_id'];
	} else{
		$paciente_id_claro="";
	}
	
	if(isset($_POST['input_evolutivo'])){
		$evolutivo_claro=$_POST['input_evolutivo'];
	} else{
		$evolutivo_claro="";
	}
	
	$fecha_evol=base64_encode($fecha_evol_claro);
	$paciente_id=base64_encode($paciente_id_claro);
	$evolutivo=base64_encode($evolutivo_claro);
	
	$modifica= "UPDATE evolutivos SET fecha_evolutivo='".$fecha_evol."',evolutivo='".$evolutivo."',paciente_id='".$paciente_id."' WHERE id='".$id_evolutivo."'";

	
	/** PRIMERA QUERY */
	$mysqli->query($modifica);

?>