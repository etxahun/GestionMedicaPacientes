<?php
	/** Connect to database */
	require('conexion.php');

	/** PRIMERA QUERY */
	$id = $_POST['id'];
	$query = "SELECT * FROM pacientedatos WHERE id=".$id;
	if ($result = $mysqli->query($query)) {

		$row = $result->fetch_assoc();

	    /* liberar el resultset */
	    $result->free();
	}
?>

<html>
	<head>
		<script src="js/jquery-ui-1.9.1.custom.js" type="text/javascript"></script>
		<script language="javascript" type="text/javascript">

			$(document).ready(function(){
				$("#frm_per").validate({
					submitHandler: function(form) {
						//var respuesta = confirm('\xBFDeseas modificar el peso de esta persona?')
						//if (respuesta)
							form.submit();
					}
				});
				$(function() {
					$( "#input_fecha_nac" ).datepicker({
						dateFormat: 'yy-mm-dd',
						yearRange: "1970:2000",
						changeMonth: true,
						changeYear: true,
                        // Dias Largo en castellano
                        dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
                        // Dias cortos en castellano
                        dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
                        // Nombres largos de los meses en castellano
                        monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
                        // Nombres de los meses en formato corto
                        monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ],
                        firstDay: 1
						});
						
					$( "#input_fecha_prim_cons" ).datepicker({
						dateFormat: 'yy-mm-dd',
						changeMonth: true,
						changeYear: true,
                        // Dias Largo en castellano
                        dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
                        // Dias cortos en castellano
                        dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
                        // Nombres largos de los meses en castellano
                        monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
                        // Nombres de los meses en formato corto
                        monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ],
                        firstDay: 1
						});
						
					$( "#input_fecha_alta" ).datepicker({
						dateFormat: 'yy-mm-dd',
						changeMonth: true,
						changeYear: true,
	                    // Dias Largo en castellano
	                    dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
	                    // Dias cortos en castellano
	                    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
	                    // Nombres largos de los meses en castellano
	                    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
	                    // Nombres de los meses en formato corto
	                    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ],
	                    firstDay: 1
						});
				});
			});

			function fn_modificar(){
				var str = $("#frm_per").serialize();
				var str = "input_id=" + <?php echo $id?> + "&" + str;
				//alert(str);
				$.ajax({
					url: 'modificar_paciente.php',
					data: str,
					type: 'post',
					success: function(data){
						if(data != "")
							alert(data);
						fn_cerrar();
						$('#content_historicos').load("listar.php");
					}
				});
			};
		</script>	
	</head>
<body>
<h2>Modificar datos del paciente</h2>
<hr/>
<!--<p>Por favor rellena el siguiente formulario:</p>-->
<div id="contenedor">
	<form action="javascript: fn_modificar();" method="post" id="frm_per">
		<table id="general">
			<tbody>
				<tr>
					<td>
						<table id="table-edit-1"> <!-- Tabla de la izquierda -->
							<tbody>
								<tr>
									<td style="text-align: right"><b>ID: </b></td>
									<td><?php echo $_POST['id']?></td>
								</tr>
								<tr>
									<td style="text-align: right"><b>Nombre: </b></td>
									<td><input type="text" name="input_nombre" id="input_nombre" autofocus="autofocus" required value="<?php echo base64_decode($row['nombre'])?>"></td>
								</tr>
								
								<tr>
									<td style="text-align: right"><b>Apellidos: </b></td>
									<td><input type="text" name="input_apellidos" id="input_apellidos" required value="<?php echo base64_decode($row['apellidos'])?>"></td>
								</tr>
								
								<tr>
									<td style="text-align: right"><b>Fecha de Nacimiento: </b></td>
									<td><input type="text" name="input_fecha_nac" id="input_fecha_nac" class="fecha" value="<?php echo $row['fecha_nac']?>"></td>
								</tr>
								
								<tr>
									<td style="text-align: right"><b>Dirección: </b></td>
									<td>
										<textarea name= "input_direccion" id="input_direccion" rows="4" cols="28" required><?php echo base64_decode($row['direccion'])?></textarea>
									</td>
								</tr>
								
								<tr>
									<td style="text-align: right"><b>DNI: </b></td>
									<td><input type="text" name="input_dni" id="input_dni" required value="<?php echo base64_decode($row['dni'])?>"></td>
								</tr>
								
								<tr>
									<td style="text-align: right"><b>Teléfono Habitual: </b></td>
									<td><input type="text" name="input_telefono_habitual" id="input_telefono_habitual" required value="<?php echo base64_decode($row['telefono_habitual'])?>"></td>
								</tr>
								
								<tr>
									<td style="text-align: right"><b>Teléfono Alternativo: </b></td>
									<td><input type="text" name="input_telefono_alternativo" id="input_telefono_alternativo" required value="<?php echo base64_decode($row['telefono_alternativo'])?>"></td>
								</tr>
								
								<tr>
									<td style="text-align: right"><b>E-mail: </b></td>
									<td><input type="text" name="input_email" id="input_email" required value="<?php echo base64_decode($row['email'])?>"></td>
								</tr>
							</tbody>
						</table><!-- Fin de la Tabla de la Izquierda -->
					</td>
				
					<td>
						<table id="table-edit-2"> <!-- Tabla de la derecha -->
							<tbody>
								<tr>
									<td style="text-align: right"><b>Derivación: </b></td>
									<td>
										<textarea name="input_derivacion" id="input_derivacion" rows="8" cols="28" required><?php echo base64_decode($row['derivacion'])?></textarea>
									</td>
								</tr>
								
								<tr>
									<td style="text-align: right"><b>Fecha Primera Consulta: </b></td>
									<td><input type="text" name="input_fecha_prim_cons" id="input_fecha_prim_cons" class="fecha" required value="<?php echo $row['fecha_prim_consulta']?>"></td>
								</tr>
								
								<tr>
									<td style="text-align: right"><b>Fecha de Alta: </b></td>
									<td><input type="text" name="input_fecha_alta" id="input_fecha_alta" class="fecha" required value="<?php echo $row['fecha_alta']?>"></td>
								</tr>
								
								<tr>
									<td style="text-align: right"><b>Situacion Paciente: </b></td>
									<td>
										<select id="input_select" name="input_facultativo" required>
											<option value="<?php echo $row['estado_alta']?>"><?php echo $row['estado_alta']?></option>
											<?php
												if($row['estado_alta']=='En Tratamiento') {
													 echo "<option value='Alta'>Alta</option>";
													}
												else {
													echo "<option value='En Tratamiento'>En Tratamiento</option>";
												}
											?>
										</select>	
										<!--
										<input type="text" name="input_fecha_alta" id="input_fecha_alta" class="fecha" required value="<?php echo $row['facultativo']?>"> -->
									</td>
								</tr>
								
								<tr>
									<td style="text-align: right"><b>Facultativo: </b></td>
									<td>
										<select id="input_select" name="input_facultativo" required>
											<option value="<?php echo base64_decode($row['facultativo'])?>"><?php echo base64_decode($row['facultativo'])?></option>
											<?php
												if($row['facultativo']=='Elida') {
													 echo "<option value='Amaia'>Amaia</option>";
													}
												else {
													echo "<option value='Elida'>Elida</option>";
												}
											?>
										</select>	
										<!--
										<input type="text" name="input_fecha_alta" id="input_fecha_alta" class="fecha" required value="<?php echo $row['facultativo']?>"> -->
									</td>
								</tr>
							</tbody>
						</table><!-- Fin de la Tabla de la Derecha -->
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<hr />
					</td>
				</tr>
			</tbody>
		</table>
				
		<ul class="pager">			
			<li>
				<input style="text-align: center;" name="cancelar" type="button" id="cancelar" value="Cancelar" onclick="fn_cerrar();" />
			</li>
			
			<li>
				<input id="guardar_cambios_historico" type="submit" value="Guardar Cambios">
			</li>
		</ul>

	</form>
</div> <!-- Fin de div "wrap" -->
</body>
</html>