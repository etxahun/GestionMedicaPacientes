<?php
require('conexion.php');

$id = $_GET["id"];

/** GET EVOLUTIVOS from database */	
$res_evol = $mysqli->query("SELECT id,fecha_evolutivo,evolutivo,paciente_id FROM evolutivos WHERE paciente_id='".$id."' ORDER BY fecha_evolutivo DESC");

$query_nombre = "SELECT nombre FROM pacientedatos WHERE id='".base64_decode($id)."'";
$res_nombre = $mysqli->query( $query_nombre );
$row_nombre = $res_nombre->fetch_row();
$nombre=$row_nombre[0];

?>
<table id="historico" class="tablesorter">
<thead>
	<tr>
		<th><b>Acción</b></th>
		<th><b>Nombre</b></th>
		<th><b>Fecha Evolutivo</b></th>
        <th><b>Paciente ID</b></th>
		<th><b>Evolutivo</b></th>
	</tr>
</thead>
<tbody>

<?php
while( $row = $res_evol->fetch_row() ) {
?>
	<tr>
		<!-- td><?php echo($row[0])?></td>  ID -->
		<td>
			<a href="javascript: fn_eliminar(<?php echo "$row[0]" ?>);"><img src="ico/delete.png" /></a>
			<a href="javascript: fn_mostrar_frm_modificar(<?php echo "$row[0]" ?>);"><img src="ico/page_edit.png" /></a>
		</td> <!-- Acción -->
		<td><?php echo base64_decode($nombre)?></td> <!--Nombre Paciente-->
		<td><?php echo base64_decode($row[1])?></td> <!--Fecha_Evolutivo-->
        <td><?php echo base64_decode($row[3])?></td> <!--Paciente ID-->
		<td><?php echo base64_decode($row[2])?></td> <!--Evolutivo-->
	</tr>
<?php
}
?>
</tbody>
</table>