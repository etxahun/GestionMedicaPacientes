<?php
require('conexion.php');

/** GET USERS from database */	
$res_users = $mysqli->query("SELECT id, nombre, apellidos, dni, telefono_habitual, estado_alta, facultativo FROM pacientedatos" );
?>
<table id="historico" class="tablesorter">
<thead>
	<tr>
		<th><b>Acción</b></th>
        <th><b>Num. Historial</b></th>
		<th><b>Nombre</b></th>
		<th><b>Apellidos</b></th>
		<th><b>DNI</b></th>
		<th><b>Teléfono Habitual</b></th>
		<th><b>Situación Paciente</b></th>
		<th><b>Facultativo</b></th>
	</tr>
</thead>
<tbody>

<?php
while( $row = $res_users->fetch_row() ) {
?>
	<tr>
		<!-- td><?php echo($row[0])?></td>  ID -->
		<td>
        	<a href="javascript: fn_eliminar(<?php echo "$row[0]" ?>);"><img src="ico/delete.png" /></a>
            <a href="javascript: fn_mostrar_frm_modificar(<?php echo "$row[0]" ?>);"><img src="ico/page_edit.png" /></a>
		</td> <!-- Acción -->
        <td><?php echo($row[0])?></td>
		<td>
            <a href="javascript: fn_mostrar_frm_modificar(<?php echo "$row[0]" ?>);"><?php echo(base64_decode($row[1]))?></a>
        </td> <!-- Nombre -->
		<td><?php echo(base64_decode($row[2]))?></td> <!-- Apellidos -->
		<td><?php echo(base64_decode($row[3]))?></td> <!-- DNI -->
		<td><?php echo(base64_decode($row[4]))?></td> <!-- Teléfono Habitual -->
		<td><?php echo($row[5])?></td> <!-- Situación del Paciente --> 
		<td><?php echo(base64_decode($row[6]))?></td> <!-- Facultativo-->
	</tr>
<?php
}
?>
</tbody>
</table>