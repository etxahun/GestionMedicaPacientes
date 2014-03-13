<?php

// DATOS PERSONALES ========================================

if(isset($_POST['input_nombre'])){
	$nombre_claro=$_POST['input_nombre'];
	$nombre=base64_encode($nombre_claro);
} else{
	$nombre="";
}

if(isset($_POST['input_apellidos'])){
	$apellidos_claro=$_POST['input_apellidos'];
	$apellidos=base64_encode($apellidos_claro);
} else{
	$apellidos="";
}

if(isset($_POST['input_fecha_nac'])){
	$fechanac_claro=$_POST['input_fecha_nac'];
	$fechanac=base64_encode($fechanac_claro);	
} else{
	$fechanac="";
}

if(isset($_POST['input_direccion'])){
	$direccion_claro=$_POST['input_direccion'];
	$direccion=base64_encode($direccion_claro);
} else{
	$direccion="";
}

if(isset($_POST['input_dni'])){
	$dni_claro=$_POST['input_dni'];
	$dni=base64_encode($dni_claro);
} else{
	$dni="";
}

if(isset($_POST['input_telef_hab'])){
	$telefhab_claro=$_POST['input_telef_hab'];
	$telefhab=base64_encode($telefhab_claro);
} else{
	$telefhab="";
}

if(isset($_POST['input_telef_alt'])){
	$telefalt_claro=$_POST['input_telef_alt'];
	$telefalt=base64_encode($telefalt_claro);
} else{
	$telefalt="";
}

if(isset($_POST['input_email'])){
	$email_claro=$_POST['input_email'];
	$email=base64_encode($email_claro);
} else{
	$email="";
}

if(isset($_POST['input_derivacion'])){
	$derivacion_claro=$_POST['input_derivacion'];
	$derivacion=base64_encode($derivacion_claro);
} else{
	$derivacion="";
}

if(isset($_POST['input_fecha_prim_cons'])){
	$fechaprimcons_claro=$_POST['input_fecha_prim_cons'];
	$fechaprimcons=base64_encode($fechaprimcons_claro);
} else{
	$fechaprimcons="";
}

if(isset($_POST['select_facultativo'])){
	$facultativo_claro=$_POST['select_facultativo'];
	$facultativo=base64_encode($facultativo_claro);
} else{
	$facultativo="";
}

// DATOS ANAMNESIS ========================================

if(isset($_POST['input_motivo'])){
	$motivo_claro=$_POST['input_motivo'];
	$motivo=base64_encode($motivo_claro);
} else{
	$motivo="";
}

if(isset($_POST['input_antec_per'])){
	$antecper_claro=$_POST['input_antec_per'];
	$antecper=base64_encode($antecper_claro);
} else{
	$antecper="";
}

if(isset($_POST['input_antec_fam'])){
	$antecfam_claro=$_POST['input_antec_fam'];
	$antecfam=base64_encode($antecfam_claro);
} else{
	$antecfam="";
}

if(isset($_POST['input_exp_psico'])){
	$explpsico_claro=$_POST['input_exp_psico'];
	$explpsico=base64_encode($explpsico_claro);
} else{
	$explpsico="";
}

// OTROS DATOS ========================================

if(isset($_POST['input_compl'])){
	$compl_claro=$_POST['input_compl'];
	$compl=base64_encode($compl_claro);
} else{
	$compl="";
}

if(isset($_POST['input_diag'])){
	$diag_claro=$_POST['input_diag'];
	$diag=base64_encode($diag_claro);
} else{
	$diag="";
}

if(isset($_POST['input_farma'])){
	$farma_claro=$_POST['input_farma'];
	$farma=base64_encode($farma_claro);
} else{
	$farma="";
}

if(isset($_POST['input_alertas'])){
	$alertas_claro=$_POST['input_alertas'];
	$alertas=base64_encode($alertas_claro);
} else{
	$alertas="";
}

/** Connect to database */

require('conexion.php');

/**INSERT de los "DATOS PERSONALES" del Paciente en la base de datos */
$q = "INSERT INTO pacientedatos (nombre,apellidos,fecha_nac,direccion,dni,telefono_habitual,telefono_alternativo,email,derivacion,fecha_prim_consulta,facultativo) VALUES ('$nombre','$apellidos','$fechanac','$direccion','$dni','$telefhab','$telefalt','$email','$derivacion','$fechaprimcons','$facultativo')";

$res_add=$mysqli->query( $q );
//echo ($q);
if( !$res_add ) {
   	echo "ERROR_FAILED_ADD_OPERATION 1";
}else{
 
	/**INSERT de los datos "Historica Clinica" del Paciente en la base de datos */

	/* Obtenemos el ID del paciente INSERTADO en la query anterior */
	$q2 = "SELECT id FROM pacientedatos WHERE dni='$dni'";	
	$resultadodni= $mysqli->query($q2);

	if(!is_object($resultadodni))
	{
		echo $mysqli->error;
	}
	else{
		$row = $resultadodni->fetch_row();
		$id_alta = $row[0];

		$q3 = "INSERT INTO historiaclinica (paciente_id,motivo_consulta,anteced_pers,anteced_fam,expl_psico,pruebas_compl,diagnostico,tratamiento_farma,alergias) VALUES  ('$id_alta','$motivo','$antecper','$antecfam','$explpsico','$compl','$diag','$farma','$alertas')";

		$res_add2 = $mysqli->query( $q3 );

		if( !$res_add2 ) {
			echo "ERROR_FAILED_ADD_OPERATION 2";
		}else {
			echo json_encode("El paciente ha sido dado de alta correctamente.");
		}
	} /* Fin del ELSE */
} /* Fin del ELSE principal */
//header('Location: http://localhost/hamabide4/contact.php');

?>
