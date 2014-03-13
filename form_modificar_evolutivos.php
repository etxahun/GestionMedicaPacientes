<?php
	/** Connect to database */
	require('conexion.php');

	/** PRIMERA QUERY */
	$id_evolutivo = $_POST['id_evolutivo'];
	$query = "SELECT * FROM evolutivos WHERE id=".$id_evolutivo;
	if ($result = $mysqli->query($query)) {

		$row = $result->fetch_assoc();

	    /* liberar el resultset */
	    $result->free();
	}
	
	$query2 = "SELECT nombre FROM pacientedatos WHERE id='".base64_decode($row['paciente_id'])."'";
	if ($result2 = $mysqli->query($query2)) {
		
		$row2 = $result2->fetch_assoc();
		$result2->free();
	}
?>

<html>
	<head>
		<script src="js/jquery-ui-1.9.1.custom.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="css/jquery-ui/jquery-ui.css" />	
		<script language="javascript" type="text/javascript">

			$(document).ready(function(){
            
            	$( "#input_fecha_evolutivo" ).datepicker({
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

			function fn_modificar(){
				var str = $("#frm_evol").serialize();
				var str = "input_id=" + <?php echo $id_evolutivo?> + "&" + str;
				//alert(str);
				$.ajax({
					url: 'modificar_evolutivo.php',
					data: str,
					type: 'post',
					success: function(data){
						if(data != "")
							alert(data);
							fn_cerrar();
							$('#res_evol').load("listarevolutivos.php");
					}
				});
			};
		</script>	
	</head>
<body>
<h2>Modificar Evolutivo del paciente</h2>
<hr/>
<!--<p>Por favor rellena el siguiente formulario:</p>-->
<div id="contenedor">
	<form action="javascript: fn_modificar();" method="post" id="frm_evol">
		<table id="general">
			<tbody>
                <td>
                    <tr>
                            <td style="text-align: right"><b>ID Evolutivo: </b></td>
                            <td><b><?php echo $_POST['id_evolutivo']?></b></td>
                    </tr>
                    <tr>
                            <td style="text-align: right"><b>Paciente ID: </b></td>
                            <td><input type="text" style="text-align: center" name="input_paciente_id" id="input_paciente_id" autofocus="autofocus" required value="<?php echo base64_decode($row['paciente_id'])?>"></td>
                    </tr>
                    <tr>
                            <td style="text-align: right"><b>Nombre: </b></td>
                            <td><input type="text" style="text-align: center" name="input_paciente_id" id="input_paciente_id" autofocus="autofocus" required value="<?php echo base64_decode($row2['nombre'])?>"></td>
                    </tr>
                    <tr>
                    		<td style="text-align: right"><b>Fecha Evolutivo: </b></td>
                    		<td><input type="text" style="text-align: center" name="input_fecha_evolutivo" id="input_fecha_evolutivo" required value="<?php echo base64_decode($row['fecha_evolutivo'])?>"></td>
                    </tr>
                    
                    <tr>
                            <td style="text-align: right"><b>Evolutivo: </b></td>
                            <td>
                                <textarea name="input_evolutivo" id="input_evolutivo" rows="8" cols="29" required><?php echo base64_decode($row['evolutivo'])?></textarea>
                            </td>
                    </tr>
                </td>
			</tbody>
		</table>

        <hr> 
                                     
		<ul class="pager">
			<li><a style="type="cancelar" id="cacelar" onclick="fn_cerrar();" ><strong>Cancelar</strong></a></li>
			<li><a style="font-weight: bold;" type="enviar_evolutivo" id="enviar_evolutivo"><strong>Guardar</strong></a></li>
		</ul>								
	</form>
</div> <!-- Fin de div "wrap" -->
</body>
</html>