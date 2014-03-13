<?php
include("login/include/session.php");
global $database;
$config = $database->getConfigs();

if(!$session->logged_in)
	{ 
	 header("Location: main.php"); 
	}else{	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Hamabide - Histórico</title>
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

	<script type="text/javascript">		
	
		function btnSubmitOnClick()
		{
			var cat = $("#select_categoria option:selected").val();                           
			var busq = $("#input_busqueda").val(); 
			if (cat == 0){
				
				alert("Debes seleccionar una categoria de búsqueda.");
			
			}else if(busq == ''){
											 
				alert("Debes introducir el valor a buscar.");
			
			}else{    
				$.ajax({
					url: 'realiza_busqueda_historicos.php',
					data: {
							categoria: cat,
							busqueda: busq
						  },  
					type: 'POST',
					dataType: 'json',
					success: function(data){			
						var html = '';
						
						if(data.length > 0){
							$.each(data, function(i,item){
							html += '<tr>'
									html += '<td><a href="javascript: fn_eliminar('+item.numhistorial+');"><img src="ico/delete.png" /></a>'
									html += '<a href="javascript: fn_mostrar_frm_modificar('+item.numhistorial+');"><img src="ico/page_edit.png" /></a></td>'
									html += '<td>'+Base64.decode(item.numhistorial)+'</td>'
									html += '<td>'+Base64.decode(item.nombre)+'</td>'
									html += '<td>'+Base64.decode(item.apellido)+'</td>'                                                        
									html += '<td>'+Base64.decode(item.dni)+'</td>'
									html += '<td>'+Base64.decode(item.telefhab)+'</td>'                                                        
									html += '<td>'+item.situacion+'</td>'
									html += '<td>'+Base64.decode(item.facultativo)+'</td>'
							html += '</tr>';
							});					
						}
					if(html == '') html = '<tr><td colspan="8" align="center">No se han encontrado registros de pacientes.</td></tr>'
					$("#historico tbody").html(html);
					}
				});
			}//Fin del else
		}// Fin de la funcion btnSubmitOnClick
		
                
		function fn_eliminar(id){
		        var respuesta = confirm("¿Deseas eliminar este paciente?");
		        if (respuesta){
		                $.ajax({
		                        type: 'POST',
		                        url: 'eliminar_paciente.php',
		                        data: {
		                                id: id
		                        },
		                        success: function(data){
		                                if(data!="")
		                                        alert(data);
                                                        $('#content_historicos').load("listar.php");
		                        	   }
		                }); <!-- Fin del $.ajax -->
		        } <!-- Fin del if -->
		} <!-- Fin de la función fn_eliminar -->
		
		function fn_mostrar_frm_modificar(id){
		        $("#div_oculto").load("form_modificar_paciente.php", {id: id}, function(){
		                $.blockUI({
		                        message: $('#div_oculto'),
		                        css:{
		                             padding: 20,
                                             top: '15%',
                                             left: '20%',
                                             '-webkit-border-radius': '10px',
                                             '-moz-border-radius': '10px',
                                             width: '720px'
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
		
		$(document).ready(function(){	
			$('#content_historicos').load("listar.php");
			$("#historico").tablesorter();			
			
			//Cuando pulsamos el boton de Filtrar
			$("#btn_submit_historicos").click(function(){ btnSubmitOnClick() });
			
			//Para introducir los datos seguidos del boton "Enter"
			$('form').submit(function(e){
				e.preventDefault();
				btnSubmitOnClick();
				return false;
			});	
			
			//Cuando queremos mostrar todos los pacientes
			$("#muestratodos").click(function(){ 
				$("#input_busqueda").val('');
				$("select").find("option[value='0']").attr("selected",true);
				$('#content_historicos').load("listar.php");
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
				<li class="menuitem"><a style="color:#F7AA0A; font-weight:bold" href="historicos.php">Históricos</a></li>				
				<?php
					if($session->isAdmin()) { 
				?>	
			    <li class="menuitem"><a href="altas.php">Altas</a></li>
	            <li class="menuitem"><a href="evolutivos.php">Evolutivos</a></li>
				<?php
					}
				?>
	        </ul>
		</div>
		
		<div id="menu-logo">
			<a id="rt-logo" href="/hamabide9/index.php"></a>
		</div>
		
	</div><!--menu end-->
	<div id="div_oculto" style="display: none;"></div>
	<div id="resultados">
		<div id="select-busqueda">	
			<form id="busqueda_form">
				<table>					
					<tr>
						<p><b>Selecciona el criterio de búsqueda:</b></p>
					</tr>
					<tr>
						<td>
							<select id="select_categoria">
								<option selected value="0">(Selecciona)</option>		
								<option value="id">Nº Historial</option>		
								<option value="nombre">Nombre</option>
								<option value="dni">DNI</option>		
								<option value="estado_alta">Situación</option>		
								<option value="facultativo">Facultativo</option>								
							</select>
						</td>
						<td>
							<input type="text" name="input_busqueda" id="input_busqueda" class="required" placeholder="Buscar..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Buscar...'" autofocus="autofocus">
						</td>
						<td>
                            <button type="button" id="btn_submit_historicos">Filtrar</button>
                        </td>
                        <td>
                            <button type="button" id="muestratodos">Muestra Todos</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
       		<div id="content_historicos">
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
                        <tbody></tbody>
                    </table>
                </div>
	</div>
</div><!--container end-->
</body>
</html>
<?php
	}
?>