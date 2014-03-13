<?php

// DATOS PERSONALES ========================================

if(isset($_POST['evolutivo'])){
	$evo=$_POST['evolutivo'];
} else{
	$evo="";
}

if(isset($_POST['busqueda'])){
	$busqueda=$_POST['busqueda'];
} else{
	$busqueda="";
}

/** Connect to database */
require('conexion.php');

/** Almacenamos en una variable la ID del paciente */


// Si queremos que busque cualquier coincidencia de la cadena "$busqueda" pondremos los porcentajes "%".
//$query_id = "SELECT id FROM pacientedatos WHERE ".$evo." LIKE '%".$busqueda."%'"; 
// Si queremos que la búsqueda sea estricta: 
$query_id = "SELECT id FROM pacientedatos WHERE ".$evo." LIKE '".$busqueda."'";
$res_id=$mysqli->query( $query_id );
$row = $res_id->fetch_row();
$num_rows = mysqli_num_rows($res_id);

if($num_rows==0){

	$result='';
	echo json_encode($result);
	
} else{
		$id=$row[0]; // Guardamos el valor del ID.
		
		//$id_cifrado = base64_encode($id);         
		//$busqueda_cifrada = base64_encode($busqueda);  
		              
		/**QUERY DATOS PERSONALES */
		$q = "SELECT * FROM pacientedatos WHERE ".$evo." LIKE '".$busqueda."'"; 
		$res_busqueda=$mysqli->query( $q );
		$datos_pers = array();
		
		while( $row = $res_busqueda->fetch_row() ) 
		    {
		        $datos_pers[] = array(
		                'numhistorial'         => $row[0],
		                'nombre'               => base64_decode($row[1]),
		                'apellido'             => base64_decode($row[2]),
		                'fecha_nac'            => $row[3],
		                'direccion'            => base64_decode($row[4]),                
		                'dni'                  => base64_decode($row[5]),
		                'telefono_habitual'    => base64_decode($row[6]),
		                'telefono_alternativo' => base64_decode($row[7]),
		                'email'                => base64_decode($row[8]),
		                'derivacion'           => base64_decode($row[9]),                
		                'fecha_prim_consulta'  => $row[10],
		                'fecha_alta'           => $row[12],
		                'facultativo'          => base64_decode($row[13])
		        );
		    }
		
		
		/**QUERY HISTORIA CLINICA + OTROS DATOS*/
		$q2 = "SELECT * FROM historiaclinica WHERE paciente_id=".$id; 
		$res_busqueda2=$mysqli->query( $q2 );
		$datos_hist_otros = array();
		
		while( $row2 = $res_busqueda2->fetch_row() ) 
		    {
		        $datos_hist_otros[] = array(
		                'motivoconsulta'     => base64_decode($row2[2]),
		                'antecper'           => base64_decode($row2[3]),
		                'antecfam'           => base64_decode($row2[4]),
		                'explpsico'          => base64_decode($row2[5]),
		                'compl'              => base64_decode($row2[6]),
		                'diagnostico'        => base64_decode($row2[7]),
		                'farma'              => base64_decode($row2[8]),
		                'alertas'            => base64_decode($row2[9])                
		        );
		    }
		
		
		$result = array_merge($datos_pers, $datos_hist_otros);
		
		//print_r ($result);
		echo json_encode($result);

}// Fin del "else"

?>