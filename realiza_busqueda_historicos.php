<?php

// DATOS PERSONALES ========================================

if(isset($_POST['categoria'])){
	$cat=$_POST['categoria'];
} else{
	$cat="";
}

if(isset($_POST['busqueda'])){
	$busqueda=$_POST['busqueda'];
} else{
	$busqueda="";
}

/** Connect to database */
require('conexion.php');

if ($busqueda==""){
    
    $q = "SELECT * FROM pacientedatos";
    $res_busqueda=$mysqli->query( $q );
    $datos = array();
    
    while( $row = $res_busqueda->fetch_row() )
        {
            $datos[] = array(
                'numhistorial'       => $row[0],
                'nombre'             => $row[1],
                'apellido'           => $row[2],
                'dni'                => $row[5],
                'telefhab'           => $row[6],
                'situacion'          => $row[11],
                'facultativo'        => $row[13]
            );
        }
    echo json_encode($datos);
}else{    
    /**QUERY QUE HACE LA BUSQUEDA */
    $q = "SELECT * FROM pacientedatos WHERE ".$cat." LIKE '%".$busqueda."%'"; 

    $res_busqueda=$mysqli->query( $q );
    $datos = array();

    while( $row = $res_busqueda->fetch_row() ) 
        {
            $datos[] = array(
                    'numhistorial'       => $row[0],
                    'nombre'             => $row[1],
                    'dni'                => $row[5],
                    'situacion'          => $row[11],
                    'facultativo'        => $row[13]
            );
        }
    echo json_encode($datos);
}
?>