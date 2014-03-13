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
	<title>Hamabide - Evolutivos</title>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<meta name="description" content="Hamabide Base de Datos de Paciente">
    <meta name="author" content="ESB">
	<link type="image/x-icon" rel="shortcut icon" href="images/favicons.png">
	
    <link rel="stylesheet" type="text/css" href="css/style.css" />	
	<link rel="stylesheet" href="css/tablesorter/blue/style.css" type="text/css" media="print, projection, screen" />
	<link rel="stylesheet" type="text/css" href="css/jquery-ui/jquery-ui.css" />
		
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script> 	
	<script src="js/jquery.validate.js" type="text/javascript"></script>
	<script src="js/messages_es.js" type="text/javascript"></script>
	<script src="js/jquery.tablesorter.js" type="text/javascript"></script>
	<script src="js/jquery.blockUI.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.9.1.custom.js" type="text/javascript"></script>
	
	<script src="js/res/base64.js"></script>
		
	<script type="text/javascript" >	
	
	/** Cargamos los "tabs" */
	$(function() 
		{
			$( "#tabs-evolutivos" ).tabs();
		});
		
	/** Función que vacia los inputs del formulario */
	var vacia_input_datos = function ()
		{
			$("#input_evolutivo").val("");
		}		
		
	function btnSubmitOnClick()
		{
			
			$('#tabs-evolutivos').tabs({active:0});
			$("#tabs-evolutivos").tabs( "option", "disabled", [3] ); 
			
			var evo = $("#select_evolutivo option:selected").val();  // Es la opción de la Búsqueda: 1)NºHistoria (=id),2)DNI, 3)NºTelefonoHabitual.
			var evo_cifrado = Base64.encode(evo);                         
			
			var busq = $("#input_busqueda").val(); // Es el valor de la Búsqueda
			var busq_cifrado = Base64.encode(busq);
			
			if (evo == 0){
				
				alert("Debes seleccionar una categoria de búsqueda.");
			
			}else if(busq == ''){
											 
				alert("Debes introducir el valor a buscar.");
			
			}else{    
				$.ajax({
						url: 'realiza_busqueda_evolutivos.php',
						data: {
								evolutivo: evo,
								busqueda: busq
							  },  
						type: 'POST',
						dataType: 'json',
						success: function(data){

								if(data.length > 0){
									$.each(data, function(i,item){
										//Datos Personales
										$("#evol_numhist").html(item.numhistorial);
										$("#evol_nombre").html(item.nombre);
										$("#evol_apell").html(item.apellido);
										$("#evol_fechanac").html(item.fecha_nac);
										$("#input_direccion").html(item.direccion);
										$("#evol_dni").html(item.dni);
										$("#evol_telhab").html(item.telefono_habitual);
										$("#evol_telalt").html(item.telefono_alternativo);
										$("#evol_email").html(item.email);
										$("#input_derivacion").html(item.derivacion);
										$("#evol_primconsul").html(item.fecha_prim_consulta);
										$("#evol_fechalta").html(item.fecha_alta);
										$("#evol_facultativo").html(item.facultativo);
										
										//Historia Clinica
										$("#input_motivo").html(item.motivoconsulta);
										$("#input_antec_per").html(item.antecper);
										$("#input_antec_fam").html(item.antecfam);
										$("#input_exp_psico").html(item.explpsico);
																					
										//Otros Datos
										$("#input_compl").html(item.compl);
										$("#input_diag").html(item.diagnostico);
										$("#input_farma").html(item.farma);
										$("#input_alertas").html(item.alertas);
										
										$( "#btn_nuevo_evolutivo").show();

									});//Fin del "each(data....)"
								} else{
									
									alert("No se ha encontrado ningún paciente. Inténtalo de nuevo.");
								}
	

						} //Fin del "success"
				});
			}//Fin del else
		}// Fin de la funcion btnSubmitOnClick
		
		
	function muestraEvolutivos()
		{
		
		 var evo = $("#select_evolutivo option:selected").val();  // Es la opción de la Búsqueda: 1)NºHistoria (=id),2)DNI, 3)NºTelefonoHabitual.	
		 var busq = $("#input_busqueda").val(); // Es el valor de la Búsqueda
			
		 if (evo == 0){
				alert("Debes seleccionar una categoria de búsqueda.");
		 }else if(busq == ''){								 
			 	alert("No has seleccionado ningún paciente.");
		 }else{ 	 
		 	 $.ajax({
			 	 url: 'compruebapacientes.php',
			 	 data: {
				 	 	valor_busqueda: busq
			 	 	   },
			 	 type: 'POST',
			 	 datatype: 'json',
			 	 success: function(data){		 
				 	if(data == 0){
					 	alert("No existe ningún paciente asociado.");
				 	}else{
						 //Mostramos la pestaña "Evolutivos":
						 $( "#tabs-evolutivos" ).tabs("enable", 3);
			
						 // Cambiamos a la pestaña "Evolutivos":
						 $('#tabs-evolutivos').tabs({active:3}); 
						 
						 $('#evolutivos').show();
						 
						 //var evo = $("#select_evolutivo option:selected").val();  // Es la opción de la Búsqueda: 1)NºHistoria (=id),2)DNI, 3)NºTelefonoHabitual.                      
						 //var busq = $("#input_busqueda").val(); // Es el valor de la Búsqueda
					 	 
						 $.ajax({
								url: 'muestra_evolutivos.php',
								data: {
										evolutivo: evo,
										busqueda: busq
									  },  
								type: 'POST',
								dataType: 'json',
								success: function(data){
										var html="";
				
										if(data.length > 0){
											var html="";
											
											$.each(data, function(i,item){
												//Dibujamos la tabla con el listado de Evolutivos
												html += '<tr>'
													html += '<td><a href="javascript: fn_eliminar('+item.id_evolutivo+');"><img src="ico/delete.png" /></a>'
													html += '<a href="javascript: fn_mostrar_frm_modificar('+item.id_evolutivo+');"><img src="ico/page_edit.png" /></a></td>'
													html += '<td>'+Base64.decode(item.nombre)+'</td>'
													html += '<td>'+Base64.decode(item.fecha_evolutivo)+'</td>'
													html += '<td>'+Base64.decode(item.paciente_id)+'</td>'
													html += '<td>'+Base64.decode(item.evolutivo)+'</td>'
												html += '</tr>';
				
											});//Fin del "each(data....)"
										} else{
											 html = '<tr><td colspan="5" align="center">No se han encontrado evolutivos del paciente.</td></tr>';
											 alert("El paciente no tiene ningún evolutivo asociado. Pulsa \"Nuevo Evolutivo\" para crear uno.");
										}
										$("#res_evol tbody").html(html);
								} //Fin del "success" del AJAX inerno
							}); // Fin del "Ajax" interno
									 
				 	} //Fin del "else" del AJAX externo				 
			 	 } //Fin del "Success" del AJAX externo		 	 
		 	 }); //Fin del AJAX externo
		   
		   } //Fin del "ELSE" principal

		} // Fin de la función "MuestraEvolutivos"
			
			 
	function fn_eliminar(id_evolutivo)
		{
			var respuesta = confirm("¿Deseas eliminar este evolutivo?");
			var id_claro = $("#evol_numhist").text();
		
			var id = Base64.encode(id_claro);
			
			if (respuesta){
				$.ajax({
						type: 'POST',
						url: 'eliminarevolutivo.php',
						data: {
								id_evolutivo: id_evolutivo
						},
						success: function(data){
								if(data!="")
										alert(data);
										$('#res_evol').load("listarevolutivos.php?id="+id);
							   }
				}); <!-- Fin del $.ajax -->
			} <!-- Fin del if -->
		} <!-- Fin de la función fn_eliminar -->
		

	function fn_mostrar_frm_modificar(id)
		{
			$("#div_oculto").load("form_modificar_evolutivos.php", {id_evolutivo: id}, function(){
				$.blockUI({
							message: $('#div_oculto'),
							css:{
									padding: 10,
									top: '15%',
									left: '27%',
									'-webkit-border-radius': '10px',
									'-moz-border-radius': '10px',
									width: '520px'
								}
						});
			});
		};

	function fn_cerrar(){
			$.unblockUI({
					onUnblock: function(){
							$("#div_oculto").html("");
					}
			});
	}; 
                 
	function runEffectDesaparece() 
		{
			var sel = $("#evol_numhist").text();
			//console.log(sel);
	
			if(sel==""){
				 alert("No has seleccionado ningún paciente.");
			}else{
				  // get effect type from
				  var selectedEffect = "blind";
				  // most effect types need no options passed by default
				  var options = { to: { width: 280, height: 485 } };
				  // run the effect
				  $( "#effect" ).hide( selectedEffect, options, 500 );	
				  $( "#button_bueno").show();		  
		
				}
		};
	
	function runEffectBueno() 
		{
			var sel = $("#evol_numhist").text();
			//console.log(sel);
			
			if(sel==""){
				 alert("No has seleccionado ningún paciente.");
			}else{
				// get effect type from
				var selectedEffect = "blind";
				// most effect types need no options passed by default
				var options = { to: { width: 280, height: 485 } };
				// run the effect
				$( "#effect" ).show( selectedEffect, options, 500 );		
				$( "#button_bueno").hide();
				$( "#input_evolutivo").focus();	
			}
		};
	
	function insertaEvolutivo() 
		{
			var id_claro = $("#evol_numhist").text();
			var evol_claro = $("#input_evolutivo").val();
			var fecha_claro = $("#input_fecha_evol").val();
			var alta = $("#select_dar_alta option:selected").val();  // Es la opción de la Búsqueda: 1)NºHistoria (=id),2)DNI, 3)NºTelefonoHabitual.
			//console.log(sel);
			
			var id = Base64.encode(id_claro);
			var evol = Base64.encode(evol_claro);
			var fecha = Base64.encode(fecha_claro);
			//var alta = Base64.encode(alta_claro);                         

					
			$.ajax({
						url: 'insertaevolutivos.php',
						data: {
								id: id,
								evolutivo: evol,
								fecha: fecha,
								alta: alta
							  },  
						type: 'POST',
						dataType: 'json',
						success: function(datos){
									alert(datos);			
									vacia_input_datos();
									runEffectDesaparece();
									$('#res_evol').load("listarevolutivos.php?id="+id);
						} //Fin del "success"
			});//Fin de "Ajax"
		};
                
	/** Main function, loads when the page is fully loaded */
	$(document).ready( function() 
		{
			$( "#btn_nuevo_evolutivo").hide();
			$( "#tabs-evolutivos" ).tabs( "option", "disabled", [3] ); 
			$( "#evolutivos" ).hide();
			
			$( "#input_fecha_evol" ).datepicker({
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
			
			//$("#historico").tablesorter();
			
			//$( "#evolutivos" ).hide();
			
			//Ocultamos el div de la seccion "Evolutivos"
			$( "#effect" ).hide();

			//SECCION: BUSQUEDA INICIAL
			//Cuando pulsamos el boton de "Seleccionar"
			$("#btn_submit_evolutivos").click(function(){ btnSubmitOnClick() });

			//Para introducir los datos seguidos del boton "Enter"
			$('form').submit(function(e){
				e.preventDefault();
				btnSubmitOnClick();
				return false;
			});
			
			//SECCION: CUANDO PULSAMOS "NUEVO EVOLUTIVO"
			//Cuando pulsamos el boton de "Seleccionar"
			$("#btn_nuevo_evolutivo").click(function(){ muestraEvolutivos() });

			
			//SECCION: "NUEVO EVOLUTIVO (BUENO)"
			//El pulsar sobre el boton "Nuevo Evolutivo"                    
			$( "#button_bueno" ).click(function() {
				runEffectBueno();
				return false;
			});
			
			//Al pulsar el boton "Enviar" dentro de "Nuevo Evolutivo"
			$( "#enviar_evolutivo" ).click(function() {
				insertaEvolutivo();
				return false;
			}); 
			
			//Al pulsar el botón "Cancelar" dentro del apartado "Nuevo Evolutivo"
			$( "#cancelar" ).click(function() {
				runEffectDesaparece();
				return false;
			}); 
				
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
				<li class="menuitem"><a href="altas.php">Altas</a></li>
	            <li class="menuitem"><a style="color:#F7AA0A; font-weight:bold" href="evolutivos.php">Evolutivos</a></li>
	        </ul>
		</div>
		
		<div id="menu-logo">
			<a id="rt-logo" href="/hamabide9/index.php"></a>
		</div>		
	</div><!--menu end-->
	
	<div id="tabs-evolutivos">
		<div id="select-evolutivos">	
			<form id="busqueda_form">
				<table>					
					<tr>
						<p><b>Selecciona el criterio de búsqueda:</b></p>
					</tr>
					<tr>
						<td>
							<select id="select_evolutivo">
									<option selected value="0">(Selecciona)</option>		
									<option value="id">Nº Historial</option>		
									<option value="dni">DNI</option>		
									<option value="telefono_habitual">Teléfono Habitual</option>		
							</select>
						</td>
						<td>
							<input type="text" name="input_busqueda" id="input_busqueda" class="required" placeholder="Buscar..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Buscar...'" autofocus="autofocus">	
						</td>
						<td>
							<button type="button" id="btn_submit_evolutivos">Buscar</button>
						</td>
						<td>
							<button type="button" id="btn_nuevo_evolutivo">Mostrar Evolutivos</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<ul>
			<li><a href="#tabs-1">Datos Personales</a></li>
			<li><a href="#tabs-2">Historia Clínica</a></li>
			<li><a href="#tabs-3">Otros Datos</a></li>
            <li><a href="#tabs-4">Evolutivos</a></li>
		</ul>
		
		<div id="tabs-1">
			<table id="general-evolutivos">
				<tbody>
					<tr>
						<td>
							<table id="table-evolutivos-1">
								<tbody>
										<tr>
											<td style="text-align: right"><b>Numero de Historial: </b></td>
											<td id="evol_numhist"></td>
										</tr>
										<tr>
											<td style="text-align: right"><b>Nombre: </b></td>
											<td id="evol_nombre"></td>
										</tr>
										
										<tr>
											<td style="text-align: right"><b>Apellidos: </b></td>
											<td id="evol_apell"></td>
										</tr>
										
										<tr>
											<td style="text-align: right"><b>Fecha de Nacimiento: </b></td>
											<td id="evol_fechanac"></td>
										</tr>
										
										<tr>
											<td style="text-align: right"><b>Dirección: </b></td>
											<td>
												<textarea name= "input_direccion" id="input_direccion" rows="4" cols="28"></textarea>
											</td>
										</tr>
										
										<tr>
											<td style="text-align: right"><b>DNI: </b></td>
											<td id="evol_dni"></td>
										</tr>
										
										<tr>
											<td style="text-align: right"><b>Teléfono Habitual: </b></td>
											<td id="evol_telhab"></td>
										</tr>
										
										<tr>
											<td style="text-align: right"><b>Teléfono Alternativo: </b></td>
											<td id="evol_telalt"></td>
										</tr>
										
										<tr>
											<td style="text-align: right"><b>E-mail: </b></td>
											<td id="evol_email"></td>
										</tr>
								</tbody>
							</table>
						</td>
						
						<td>
								<div id="linea_vertical"></div>
						</td>

						<td>
							<table id="table-evolutivos-2">
									<tbody>
											<tr>
												<td style="text-align: right"><b>Derivación: </b></td>
												<td>
													<textarea name="input_derivacion" id="input_derivacion" rows="8" cols="28"></textarea>
												</td>
											</tr>
											
											<tr>
												<td style="text-align: right"><b>Fecha Primera Consulta: </b></td>
												<td id="evol_primconsul"></td>
											</tr>
											
											<tr>
												<td style="text-align: right"><b>Fecha de Alta: </b></td>
												<td id="evol_fechalta"></td>
											</tr>
											
											<tr>
												<td style="text-align: right"><b>Facultativo: </b></td>
												<td id="evol_facultativo"></td>
											</tr>
									</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table> <!-- Fin de la tabla "General Evolutivos" -->
		</div> <!-- Fin del div "tabs-1" -->
		
		<div id="tabs-2">
			<div id="form-altas">
				<div id="tabla">
					<form id="form_anamnesis">
						<div id="titulo-seccion">
							<h2><b>Anamnesis</b></h2>
							<hr />
						</div>
						
						<table id="myTable">
							<tr>
								<td style="text-align: right">Motivo Consulta: </td>
								<td>
									<textarea name="input_motivo" id="input_motivo" rows="7" cols="80"></textarea>
								</td>
							</tr>
							
							<tr>
								<td style="text-align: right">Antecedentes Personales: </td>
								<td>
									<textarea name="input_antec_per" id="input_antec_per" rows="7" cols="80"></textarea>
								</td>
							</tr>
							
							<tr>
								<td style="text-align: right">Antecedentes Familiares: </td>
								<td>
									<textarea type="text" name="input_antec_fam" id="input_antec_fam" rows="7" cols="80"></textarea>
								</td>
							</tr>
							
							<tr>
								<td style="text-align: right">Exploración Psicopatológica: </td>
								<td>
									<textarea name= "input_exp_psico" id="input_exp_psico" rows="7" cols="80" ></textarea>
								</td>
							</tr>
						</table>				
					</form>
				</div> <!-- Fin del div "tabla" -->
			</div> <!-- Fin div id=form-altas -->			
		</div> <!-- Fin del div "tabs-2" -->
		
		<div id="tabs-3">
			<div id="form-altas">
				<div id="tabla">
					<form id="form_otros">
						<div id="titulo-seccion">
							<h2><b>Otros datos de Interés</b></h2>
							<hr />
						</div>
						
						<table id="myTable">
							<tr>
								<td style="text-align: right">Pruebas Complementarias: </td>
								<td>
									<textarea name="input_compl" id="input_compl" rows="7" cols="80" ></textarea>
								</td>
							</tr>
							
							<tr>
								<td style="text-align: right">Diagnóstico: </td>
								<td>
									<textarea name="input_diag" id="input_diag" rows="7" cols="80" ></textarea>
								</td>
							</tr>
							
							<tr>
								<td style="text-align: right">Tratamiento Farmacológico: </td>
								<td>
									<textarea name="input_farma" id="input_farma" rows="7" cols="80" ></textarea>
								</td>
							</tr>
							
							<tr>
								<td style="text-align: right">Alertas: </td>
								<td>
									<textarea name= "input_alertas" id="input_alertas" rows="7" cols="80" ></textarea>
								</td>
							</tr>
						</table> <!-- Fin de la tabla "myTable" -->
					</form> <!-- Fin del form "form_otros" -->
				</div> <!-- Fin del div "tabla" -->
            </div> <!-- Fin del "form-altas" -->
		</div> <!-- Fin del div "tabs-3" -->
                
        <div id="tabs-4">
			<div id="evolutivos">
                            <p>A continuación se muestra el listado de <b>Evolutivos</b> del paciente:</p>
                            <div id="res_evol">
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
                                    <tbody></tbody>
                                </table>
                            </div>
                            
                            <button style="font-weight: bold;" type="button" id="button_bueno">Nuevo Evolutivo</button>

                            <div id="effect">
                                <p style="padding-left: 27px;">Introduce el evolutivo del paciente:</p>
                                <table>
                                	<tr>
                                		<td style="text-align: left; width: 131px;">Fecha de Evolutivo: </td>
										<td>
											<input title="Introduce Fecha de Evolutivo" style="text-align: center;float: left;" type="text" name="input_fecha_evol" id="input_fecha_evol" placeholder="aaaa-mm-dd" onfocus="this.placeholder = ''" onblur="this.placeholder = 'aaaa-mm-dd'" required>
										</td>
										
										<td style="text-align: right;margin-left: 20px;">¿Dar de Alta al paciente?: </td>
										<td>
											<select id="select_dar_alta">
													<option selected value="0">(Selecciona)</option>		
													<option value="si">SI</option>		
													<option value="no">NO</option>		
											</select>
										</td>
										
                                	</tr>
									
									<br>
											
                                	<tr>
                                		<td colspan="4">
                                			<textarea name="input_evolutivo" id="input_evolutivo" rows="20" cols="100"></textarea>
                                		</td>
                                	</tr>
                                	
                                	<tr>
                                		<td colspan="4">
                                			<ul class="pager">
												<li><a style="type="cancelar" id="cancelar"><strong>Cancelar</strong></a></li>
												<li><a style="font-weight: bold;" type="enviar_evolutivo" id="enviar_evolutivo"><strong>Enviar</strong></a></li>
											</ul>								
                                		</td>
                                	</tr>
                                </table>
                            </div>
							
                        <!--<button type="button" id="button_ini">Nuevo Evolutivo</button>-->
                        <div id="div_oculto"></div>
             </div> <!-- Fin de "evolutivos" -->  
		</div> <!-- Fin del div "tabs-4" -->		
	</div> <!-- Fin del general div "tabs-evolutivos" -->
</div><!--container end-->    
</body>
</html>
<?php
	}
?>