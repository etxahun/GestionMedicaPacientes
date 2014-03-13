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

// Si queremos que busque cualquier coincidencia de la cadena "$busqueda" pondremos los porcentajes "%".
//$query_id = "SELECT id FROM pacientedatos WHERE ".$evo." LIKE '%".$busqueda."%'"; 
// Si queremos que la búsqueda sea estricta: 
$query_id = "SELECT id FROM pacientedatos WHERE ".$evo." LIKE '".$busqueda."'";
$res_id=$mysqli->query( $query_id );
$row = $res_id->fetch_row();

/** Almacenamos en una variable la ID del paciente */
$id=$row[0]; // Guardamos el valor del ID.

$query_nombre = "SELECT nombre FROM pacientedatos WHERE id='".$id."'";
$res_nombre = $mysqli->query( $query_nombre );
$row_nombre = $res_nombre->fetch_row();
$nombre=$row_nombre[0];
		
// Ciframos los valores de las variables "id" y "busqueda":
$id_cifrado = base64_encode($id);         
$busqueda_cifrada = base64_encode($busqueda);

//Buscamos los evolutivos del paciente con id "id_cifrado":
$q = "SELECT * FROM evolutivos WHERE paciente_id='".$id_cifrado."' ORDER BY fecha_evolutivo DESC"; 
$res_busqueda=$mysqli->query( $q );
$datos_evol = array();

  

while( $row = $res_busqueda->fetch_row() ) 
    {
        $datos_evol[] = array(
                'id_evolutivo'       => $row[0],
                'nombre'			 => $nombre,
                'fecha_evolutivo'	 => $row[1],
                'evolutivo'          => $row[2],
                'paciente_id'        => $row[3]                
        );
    }
	    
//$result = array_merge($datos_pers, $datos_hist_otros, $datos_evol);
//print_r ($result);
echo json_encode($datos_evol);

?>