<?php
include("login/include/session.php");
global $database;
$config = $database->getConfigs();

if(!$session->isAdmin())
	{ 
	 header("Location: main.php"); 
	}else{	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Hamabide</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<meta name="description" content="Hamabide Base de Datos de Paciente">
    <meta name="author" content="ESB">
	<link type="image/x-icon" rel="shortcut icon" href="images/favicons.png">
		
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" href="css/jquery-ui/jquery-ui.css"/>
	
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-ui-1.10.1.js"></script>
	<script src="js/jquery.validate.js" type="text/javascript"></script>
	<script src="js/messages_es.js" type="text/javascript"></script>
	
	<script src="js/res/base64.js"></script>
		
	<script type="text/javascript" >
		
		/** Función que vacia los inputs del formulario */
		var vacia_input_datos = function (){
			$("#form_datos, #form_anamnesis, #form_otros").find("input[type=text], textarea").val("");
			$('select').val('-1');
		}
		
		/** Funcion que es invocada cuando se pulsa sobre el botón "Enviar" (id="btn_submit") */
		var btnSubmitOnClick = function(evento)
		{
			//$('#respuesta').hide();
			//evento.preventDefault();
			var datos_total = $("#form_datos, #form_anamnesis, #form_otros").serialize();
			//var datos_cifrado = Base64.encode(datos_total);
			//alert(datos_cifrado);
			
			var a = $("#input_nombre").val();
			var b = $("#input_apellidos").val();
			var c = $("#input_direccion").val();
			var d = $("#input_dni").val();
			var e = $("#input_telef_hab").val();
			var f = $("#input_telef_alt").val();
			var g = $("#input_email").val();
			var h = $("#input_derivacion").val();
			
			var i = $("#input_motivo").val();
			var j = $("#input_antec_per").val();
			var k = $("#input_antec_fam").val();
			var l = $("#input_exp_psico").val();
			var m = $("#input_compl").val();
			var n = $("#input_diag").val();
			var o = $("#input_farma").val();
			var p = $("#input_alertas").val();
			
			if (a == '') { alert("No has rellenado el campo \"Nombre\".");}
			else if (b == ''){ alert("No has rellenado el campo \"Apellidos\".");}
			else if (c == ''){ alert("No has rellenado el campo \"Dirección\".");}
			else if (d == ''){ alert("No has rellenado el campo \"DNI\".");}
			else if (e == ''){ alert("No has rellenado el campo \"Número de Teléfono Habitual\".");}
			else if (f == ''){ alert("No has rellenado el campo \"Número de Teléfono Alternativo\".");}
			else if (g == ''){ alert("No has rellenado el campo \"Email\".");}
			else if (h == ''){ alert("No has rellenado el campo \"Derivación\".");}
			else if (i == ''){ alert("No has rellenado el campo \"Motivo\".");}
			else if (j == ''){ alert("No has rellenado el campo \"Antecedentes Personales\".");}
			else if (k == ''){ alert("No has rellenado el campo \"Antecedentes Familiares\".");}
			else if (l == ''){ alert("No has rellenado el campo \"Exploración Psicopatológica\".");}
			else if (m == ''){ alert("No has rellenado el campo \"Pruebas Complementarias\".");}
			else if (n == ''){ alert("No has rellenado el campo \"Diagnóstico\".");}
			else if (o == ''){ alert("No has rellenado el campo \"Tratamiento Farmacológico\".");}
			else if (p == ''){ alert("No has rellenado el campo de \"Alertas/Alergias\".");}
			else
				{				
					$.ajax({
								url: 'altapaciente.php',
								data: datos_total,
								type: 'POST',
								dataType: 'json',
								success: function(datos){
									alert(datos);			
									vacia_input_datos();
			                        $('#tabs-altas').tabs({active:0});
			                       }
						});
				} // Fin del else.
			
		}
		
		/** Returns the current date in the correct format */
		var getCurrentDate = function()
		{
			var d = new Date();
			var dd = d.getDate();
			var mm = d.getMonth()+1;
			var yyyy = d.getFullYear();

			if( dd<10 ) {
				dd = '0' + dd;
			}

			if( mm<10 ) {
				mm = '0' + mm;
			}

			return yyyy+"-"+mm+"-"+dd;
		}

		/** Main function, loads when the page is fully loaded */
		$(document).ready( function() {
			vacia_input_datos();
			
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
			});
			
			/*
			$("#form_datos").validate({ 
				rules: {
					input_fecha_nac: {
						required: true,
						date: true 
					},
					
					input_fecha_prim_cons: {
						required: true,
						date: true
					},
					 
					input_email: {
					 	required: true,
						email: true
					}
				}
			}); */
						
			$("#input_fecha_prim_cons").val( getCurrentDate() );
			
			var $tabs = $('#tabs-altas').tabs();
			
			$(".nexttab").click(function() {
				//var a = $("#lista").children().length;
				var selected = $("#tabs-altas").tabs("option", "active");
				 $("#tabs-altas").tabs("option", "active", selected + 1);
				});
				
			$(".antetab").click(function() {
				var selected = $("#tabs-altas").tabs("option", "active");
				$("#tabs-altas").tabs("option", "active", selected - 1);
			});
		   //Al pulsar el botón "Enviar":
			$("#btn_submit_altas").click( btnSubmitOnClick );

		});
	</script>	
</head>
<body>
<div id="user_login_wrapper">
	<div id="user_login">
		<?php 
			$nombre = ucfirst($session->username);
			echo "Kaixo <a  href=\"login/userinfo.php?user=$session->username\"><b>".$nombre."</b></a>";
		?>
		&nbsp;
		<b div style="border-right: 2px dotted black; margin-right: 2px;"></b>
		&nbsp;
		<a style="color: black;" href="login/process.php/">Logout</a>
	</div>	
</div>
<div id="container">
	<div id="menu">
		<div id="menu-items">
	        <ul>
				<li class="menuitem"><a href="index.php">Inicio</a></li>            
				<li class="menuitem"><a href="historicos.php">Históricos</a></li>
			    <li class="menuitem"><a style="color:#F7AA0A; font-weight:bold" href="altas.php">Altas</a></li>
	            <li class="menuitem"><a href="evolutivos.php">Evolutivos</a></li>					
	        </ul>
		</div>
		
		<div id="menu-logo">
			<a id="rt-logo" href="/hamabide9/index.php"></a>
		</div>		
	</div><!--menu end-->
	
	<div id="tabs-altas">		
		<ul>
			<li><a class="tabref" href="#tabs-1">Datos Personales</a></li>
			<li><a class="tabref" href="#tabs-2">Historia Clínica - Anamnesis</a></li>
			<li><a class="tabref" href="#tabs-3">Historia Clínica - Otros Datos</a></li>
		</ul>
		<div id="tabs-1">
			<div id="form-altas">
				<div id="titulo-seccion">
					<h2><b>Nuevo Paciente</b></h2>
					<hr>
				</div>
				<div id="tabla">
					<form id="form_datos">
						<table id="myTable" class="tablesorter">
							<tr>
								<td style="text-align: right">Nombre: </td>
								<td>
									<input title="Introduce el nombre" type="text" name="input_nombre" id="input_nombre" autofocus="autofocus" required>
								</td>
							</tr>
							<tr>
								<td style="text-align: right">Apellidos: </td>
								<td>
									<input title="Introduce los apellidos" type="text" name="input_apellidos" id="input_apellidos" required>
								</td>
							</tr>
							<tr>
								<td style="text-align: right">Fecha de Nacimiento: </td>
								<td>
									<input title="Introduce Fecha de Nacimiento" style="text-align: center;" type="text" name="input_fecha_nac" id="input_fecha_nac" placeholder="aaaa-mm-dd" onfocus="this.placeholder = ''" onblur="this.placeholder = 'aaaa-mm-dd'" required>
								</td>
							</tr>
							<tr>
								<td style="text-align: right">Dirección: </td>
								<td><textarea title="Introduce Dirección" name= "input_direccion" id="input_direccion" rows="4" cols="25" required></textarea></td>
							</tr>
							<tr>
								<td style="text-align: right">DNI: </td>
								<td><input title="Introduce DNI" type="text" name="input_dni" id="input_dni" required></td>
							</tr>
							<tr>
								<td style="text-align: right">Teléfono Habitual: </td>
								<td><input title="Introduce Teléfono Habitual" type="text" name="input_telef_hab" id="input_telef_hab" required></td>
							</tr>
							<tr>
								<td style="text-align: right">Teléfono Alternativo: </td>
								<td><input title="Introduce Teléfono Alternativo" type="text" name="input_telef_alt" id="input_telef_alt" required></td>
							</tr>
							<tr>
								<td style="text-align: right">E-mail: </td>
								<td><input title="Introduce E-mail" type="text" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" name="input_email" id="input_email" required></td>
							</tr>
							<tr>
								<td style="text-align: right">Derivación: </td>
								<td><textarea title="Introduce Derivación" name="input_derivacion" id="input_derivacion" rows="8" cols="25" required></textarea></td>
							</tr>
							<tr>
								<td style="text-align: right">Fecha Primera Consulta: </td>
								<td><input title="Introduce Fecha Primera Consulta" type="date" name="input_fecha_prim_cons" id="input_fecha_prim_cons" class="fecha" placeholder="aaaa-mm-dd" onfocus="this.placeholder = ''" onblur="this.placeholder = 'aaaa-mm-dd'" required></td>
							</tr>
							<!--<tr><td style="text-align: right">Fechas Consultas Sucesivas: </td><td><input type="text" name="input_fecha_cons_suc" id="input_fecha_cons_suc" class="fecha" required placeholder="aaaa-mm-dd" onfocus="this.placeholder = ''" onblur="this.placeholder = 'aaaa-mm-dd'"></td></tr>-->
							<!--<tr><td style="text-align: right">Fecha de Alta: </td><td><input type="text" name="input_fecha_alta" id="input_fecha_alta" class="fecha" placeholder="aaaa-mm-dd" onfocus="this.placeholder = ''" onblur="this.placeholder = 'aaaa-mm-dd'"></td></tr>-->
							<tr>
								<td style="text-align: right">Facultativo Asignado: </td>
								<td>
									<select id="facultativo" name="select_facultativo">
										<option value="-1">(Selecciona)</option>
										<option value="Amaia">Amaia</option>
										<option value="Elida">Elida</option>
									</select>
								</td>
							</tr>
						</table>
					</form>
				</div>
				
				<div id="imagen_dcha">    
					<img src = "images/pacientes.png" alt = "Pacientes" />
				</div>
				
			</div> <!-- Fin div id=form-altas -->		

			<ul class="pager">
				<li><a style="margin-top: 10px;" class="nexttab" href="#"><strong>Siguiente</strong></a></li>
			</ul>
		</div> <!-- Fin div id=tabs-1 -->
		
		<div id="tabs-2">
			<div id="form-altas">
				<div id="tabla">
					<form id="form_anamnesis">
						<div id="titulo-seccion">
							<h2><b>Anamnesis</b></h2>
							<hr />
						</div>
						
						<table id="myTable" class="tablesorter">
							<tr>
								<td style="text-align: right">Motivo Consulta: </td>
								<td>
									<textarea title="Introduce Mmotivo Consulta" title="Introduce Fecha Primera Consulta" name="input_motivo" id="input_motivo" rows="7" cols="80" autofocus="autofocus" required></textarea>
								</td>
							</tr>
							
							<tr>
								<td style="text-align: right">Antecedentes Personales: </td>
								<td>
									<textarea title="Introduce Antecedentes Personales" title="Introduce Fecha Primera Consulta" name="input_antec_per" id="input_antec_per" rows="7" cols="80" required></textarea>
								</td>
							</tr>
							
							<tr>
								<td style="text-align: right">Antecedentes Familiares: </td>
								<td>
									<textarea title="Introduce Antecedentes Familiares" title="Introduce Fecha Primera Consulta" type="text" name="input_antec_fam" id="input_antec_fam" rows="7" cols="80" required></textarea>
								</td>
							</tr>
							
							<tr>
								<td style="text-align: right">Exploración Psicopatológica: </td>
								<td>
									<textarea title="Introduce Exploración Psicopatológica" name= "input_exp_psico" id="input_exp_psico" rows="7" cols="80" required></textarea>
								</td>
							</tr>
						</table>				
					</form>
				</div>
			</div> <!-- Fin div id=form-altas -->			
			
			<ul class="pager">
				<li><a class="antetab" href="#"><strong>Anterior</strong></a></li>
				<li><a class="nexttab" href="#"><strong>Siguiente</strong></a></li>
			</ul>
		</div> <!-- Fin div id=tabs-2 -->
		
		<div id="tabs-3">
			<div id="form-altas">
				<div id="tabla">
					<form id="form_otros">
						<div id="titulo-seccion">
							<h2><b>Otros datos de Interés</b></h2>
							<hr />
						</div>
						
						<table id="myTable" class="tablesorter">
							<tr>
								<td style="text-align: right">Pruebas Complementarias: </td>
								<td>
									<textarea title="Introduce Pruebas Complementarias" name="input_compl" id="input_compl" rows="7" cols="80" required></textarea>
								</td>
							</tr>
							
							<tr>
								<td style="text-align: right">Diagnóstico: </td>
								<td>
									<textarea title="Introduce Diagnóstico" name="input_diag" id="input_diag" rows="7" cols="80" required></textarea>
								</td>
							</tr>
							
							<tr>
								<td style="text-align: right">Tratamiento Farmacológico: </td>
								<td>
									<textarea title="Introduce Tratamiento Farmacológico" name="input_farma" id="input_farma" rows="7" cols="80" required></textarea>
								</td>
							</tr>
							
							<tr>
								<td style="text-align: right">Alertas: </td>
								<td>
									<textarea title="Introduce Alertas/Alergias" name= "input_alertas" id="input_alertas" rows="7" cols="80" required></textarea>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div><!-- Fin div id=form-altas -->

			<!--
			<button class="antetab" href="#"><strong>Anterior</strong></button>
            <input id="btn_submit" style="font-weight: bold; width: 90px; text-align: center;" type="submit" value="Enviar">
			-->
			<ul class="pager">
				<li><a class="antetab" href="#"><strong>Anterior</strong></a></li>
				<li><a id="btn_submit_altas" href="#"><strong>Enviar</strong></a></li>
			</ul>
			<!--<button id="btn_submit" class="submitab"><strong>Enviar</strong></button>-->
		</div><!-- Fin div id=tabs-3 -->

	</div> <!-- Fin div id=tabs-altas -->
</div><!--Fin de div id=container -->   
</body>
</html>
<?php
	}
?>
