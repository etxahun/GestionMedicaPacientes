<?php
/** Connect to database */
require('conexion.php');


if(isset($_POST['input_id'])){
	$id=$_POST['input_id'];
} else{
	$id="";
}

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
	$fecha_nac=$_POST['input_fecha_nac'];
} else{
	$fecha_nac="";
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

if(isset($_POST['input_telefono_habitual'])){
	$telefono_habitual_claro=$_POST['input_telefono_habitual'];
	$telefono_habitual=base64_encode($telefono_habitual_claro);
} else{
	$telefono_habitual="";
}

if(isset($_POST['input_telefono_alternativo'])){
	$telefono_alternativo_claro=$_POST['input_telefono_alternativo'];
	$telefono_alternativo=base64_encode($telefono_alternativo_claro);
} else{
	$telefono_alternativo="";
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
	$fecha_prim_consulta=$_POST['input_fecha_prim_cons'];
} else{
	$fecha_prim_consulta="";
}

if(isset($_POST['input_fecha_alta'])){
	$fecha_alta=$_POST['input_fecha_alta'];
} else{
	$fecha_alta="";
}

if(isset($_POST['input_facultativo'])){
	$facultativo_claro=$_POST['input_facultativo'];
	$facultativo=base64_encode($facultativo_claro);
} else{
	$facultativo="";
}


/*
$id=mysql_real_escape_string($_POST['input_id']);
$nombre=mysql_real_escape_string($_POST['input_nombre']);
$apellidos=mysql_real_escape_string($_POST['input_apellidos']);
$fecha_nac=mysql_real_escape_string($_POST['input_fecha_nac']);
$direccion=mysql_real_escape_string($_POST['input_direccion']);
$dni=mysql_real_escape_string($_POST['input_dni']);
$telefono_habitual=mysql_real_escape_string($_POST['input_telefono_habitual']);
$telefono_alternativo=mysql_real_escape_string($_POST['input_telefono_alternativo']);
$email=mysql_real_escape_string($_POST['input_email']);
$derivacion=mysql_real_escape_string($_POST['input_derivacion']);
$fecha_prim_consulta=mysql_real_escape_string($_POST['input_fecha_prim_cons']);
$fecha_alta=mysql_real_escape_string($_POST['input_fecha_alta']);
$facultativo=mysql_real_escape_string($_POST['input_facultativo']);
*/

/*
$modifica1 = sprintf("UPDATE pacientedatos SET nombre='%s', apellidos='%s', fecha_nac='%s', direccion='%s', dni='%s', telefono_habitual='%s', telefono_alternativo='%s', email='%s', derivacion='%s', fecha_prim_consulta='%s', fecha_alta='%s', facultativo='%s' WHERE id='%s'",$nombre,$apellidos,$fecha_nac,$direccion,$dni,$telefono_habitual,$telefono_alternativo,$email,$derivacion,$fecha_prim_consulta,$fecha_alta,$facultativo,$id);
*/

$modifica= "UPDATE pacientedatos SET nombre='".$nombre."',apellidos='".$apellidos."',fecha_nac='".$fecha_nac."',direccion='".$direccion."',dni='".$dni."',telefono_habitual='".$telefono_habitual."',telefono_alternativo='".$telefono_alternativo."',email='".$email."',derivacion='".$derivacion."',fecha_prim_consulta='".$fecha_prim_consulta."',fecha_alta='".$fecha_alta."',facultativo='".$facultativo."' WHERE id='".$id."'";

//print_r($modifica);


/** PRIMERA QUERY */
$mysqli->query($modifica);

?>