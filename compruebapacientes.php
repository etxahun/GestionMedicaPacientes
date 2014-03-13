<?php
/** Connect to database */
require('conexion.php');


if(isset($_POST['valor_busqueda'])){
	$valor_busqueda=$_POST['valor_busqueda'];
} else{
	$id="";
}

$q= "SELECT id FROM pacientedatos where id='".$valor_busqueda."'";

$res=$mysqli->query($q);

$num_filas=$res->num_rows;

echo json_encode($num_filas); 

?>