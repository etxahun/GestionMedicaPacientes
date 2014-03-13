<?php

// DATOS PERSONALES ========================================

if(isset($_POST['id'])){
	$id=$_POST['id'];
} else{
	$id="";
}

if(isset($_POST['evolutivo'])){
	$evolutivo=$_POST['evolutivo'];
} else{
	$evolutivo="";
}

if(isset($_POST['fecha'])){
	$fecha=$_POST['fecha'];
} else{
	$fecha="";
}

if(isset($_POST['alta'])){
	$alta=$_POST['alta'];
} else{
	$alta="";
}

/** Connect to database */
require('conexion.php');



/** Almacenamos en la BBDD el evolutivo del paciente **/
$query_id = "INSERT INTO evolutivos (fecha_evolutivo,evolutivo,paciente_id) VALUES ('".$fecha."','".$evolutivo."','".$id."')";
$res_id=$mysqli->query( $query_id );
if( !$res_id ) {
   	echo "ERROR_FAILED_ADD_OPERATION";
}else{
		if($alta=="si"){		
			$today = date("Y-m-d");
			$texto_alta = "Alta";			
			$query_alta = "UPDATE pacientedatos SET fecha_alta='".$today."',estado_alta='".$texto_alta."' WHERE id='".base64_decode($id)."'";

			$res_alta=$mysqli->query( $query_alta );
			
			if( !$res_alta ) {
					echo "ERROR_DANDO_DE_ALTA_AL_PACIENTE";
			}else{
					echo json_encode("El evolutivo del paciente se ha guardado correctamente. El paciente ha sido dado de Alta.");
			}	
		}else{
			echo json_encode("El evolutivo del paciente se ha guardado correctamente.");
		}
}



?>