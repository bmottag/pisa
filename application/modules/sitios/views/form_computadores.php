<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/dias_computador.js"); ?>"></script>

<script>
$(function(){ 
	
	$(".btn-primary").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'sitios/cargarModalComputadores',
                data: {'idSalon': oID, 'idComputador': 'x'},
                cache: false,
                success: function (data) {
                    $('#tablaDatosComputador').html(data);
                }
            });
	});

	$(".btn-default").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'sitios/cargarModalComputadores',
                data: {'idSalon': '', 'idComputador': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatosComputador').html(data);
                }
            });
	});
	
});

function valid_disponibilidad() 
{
	if(document.getElementById('lunes').checked || document.getElementById('martes').checked || document.getElementById('miercoles').checked || document.getElementById('jueves').checked || document.getElementById('viernes').checked || document.getElementById('sabado').checked || document.getElementById('domingo').checked){
		document.getElementById('ninguno').checked = false;
	}else{
		document.getElementById('ninguno').checked = true;
	}
	
	if(document.getElementById('lunes').checked && document.getElementById('martes').checked && document.getElementById('miercoles').checked && document.getElementById('jueves').checked && document.getElementById('viernes').checked && document.getElementById('sabado').checked && document.getElementById('domingo').checked){
		document.getElementById('todos').checked = true;
	}else{
		document.getElementById('todos').checked = false;
	}
}

function valid_ninguno() 
{   
	if(document.getElementById('ninguno').checked){
		document.getElementById('lunes').checked = false;
		document.getElementById('martes').checked = false;
		document.getElementById('miercoles').checked = false;
		document.getElementById('jueves').checked = false;
		document.getElementById('viernes').checked = false;
		document.getElementById('sabado').checked = false;
		document.getElementById('domingo').checked = false;
		document.getElementById('todos').checked = false;
	}
}

function valid_todos() 
{   
	if(document.getElementById('todos').checked){
		document.getElementById('lunes').checked = true;
		document.getElementById('martes').checked = true;
		document.getElementById('miercoles').checked = true;
		document.getElementById('jueves').checked = true;
		document.getElementById('viernes').checked = true;
		document.getElementById('sabado').checked = true;
		document.getElementById('domingo').checked = true;
		document.getElementById('ninguno').checked = false;
	}
}

</script>

<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<a class="btn btn-info btn-xs" href=" <?php echo base_url().'sitios/salones/' . $idSitio; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="glyphicon glyphicon-screenshot"></i> Salon
				</div>
				<div class="panel-body">
					
					<div class="col-lg-4">	
						<div class="alert alert-info">
							<strong>Sitio: </strong><?php echo $infoSitio[0]['nombre_sitio']; ?><br>
							<strong>Código DANE: </strong><?php echo $infoSitio[0]['codigo_dane']; ?><br>
						</div>
					</div>
					<div class="col-lg-4">	
						<div class="alert alert-info">
							<strong>Departemanto: </strong><?php echo $infoSitio[0]['dpto_divipola_nombre']; ?><br>
							<strong>Municipio: </strong><?php echo $infoSitio[0]['mpio_divipola_nombre']; ?>
						</div>
					</div>
					<div class="col-lg-4">	
						<div class="alert alert-info">
							<strong>Bloque: </strong><?php echo $infoSalon[0]['nombre_salon']; ?><br>
							<strong>Salón: </strong><?php echo $infoSalon[0]['nombre_bloque']; ?><br>
							<?php $noComputadores = $infoSalon[0]['computadores']?$infoSalon[0]['computadores']:0; ?>
							<strong>No. computadores: </strong><?php echo $noComputadores; ?>
						</div>
					</div>
									
				</div>
					
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->								
	
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-success">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<?php echo $retornoExito ?>		
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-danger ">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<?php echo $retornoError ?>
		</div>
	</div>
    <?php
}
?> 

<form  name="form_disponibilidad" id="form_disponibilidad" class="form-horizontal" method="post"  >
	<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $infoSalon[0]['id_sitio_salon']; ?>"/>

	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Disponibilidad computadores</strong>
				</div>
				<div class="panel-body">
					<div class="form-group">
						
						<div class="col-sm-2">
						
<input type="checkbox" id="lunes" name="lunes" value=1 <?php if($infoSalon && $infoSalon[0]["lunes"]){echo "checked";} ?> onclick="valid_disponibilidad()"> Lunes<br>
<input type="checkbox" id="martes" name="martes" value=1 <?php if($infoSalon && $infoSalon[0]["martes"]){echo "checked";} ?> onclick="valid_disponibilidad()"> Martes

						</div>
						
						<div class="col-sm-2">

<input type="checkbox" id="miercoles" name="miercoles" value=1 <?php if($infoSalon && $infoSalon[0]["miercoles"]){echo "checked";} ?> onclick="valid_disponibilidad()"> Miércoles<br>
<input type="checkbox" id="jueves" name="jueves" value=1 <?php if($infoSalon && $infoSalon[0]["jueves"]){echo "checked";} ?> onclick="valid_disponibilidad()"> Jueves

						</div>
						
						<div class="col-sm-2">
						
<input type="checkbox" id="viernes" name="viernes" value=1 <?php if($infoSalon && $infoSalon[0]["viernes"]){echo "checked";} ?> onclick="valid_disponibilidad()"> Viernes<br>
<input type="checkbox" id="sabado" name="sabado" value=1 <?php if($infoSalon && $infoSalon[0]["sabado"]){echo "checked";} ?> onclick="valid_disponibilidad()"> Sabado

						</div>
						
						<div class="col-sm-2">

<input type="checkbox" id="domingo" name="domingo" value=1 <?php if($infoSalon && $infoSalon[0]["domingo"]){echo "checked";} ?> onclick="valid_disponibilidad()"> Domingos<br>

						</div>
						
						<div class="col-sm-2">

<?php 
$todos = "";
$ninguno = 1;
if($infoSalon)
{
	if($infoSalon[0]["lunes"] && $infoSalon[0]["martes"] && $infoSalon[0]["miercoles"] && $infoSalon[0]["jueves"] && $infoSalon[0]["viernes"] && $infoSalon[0]["sabado"] && $infoSalon[0]["domingo"])
	{
		$todos = 1;
	}
	
	if($infoSalon[0]["lunes"] || $infoSalon[0]["martes"] || $infoSalon[0]["miercoles"] || $infoSalon[0]["jueves"] || $infoSalon[0]["viernes"] || $infoSalon[0]["sabado"] || $infoSalon[0]["domingo"])
	{
		$ninguno = "";
	}
}
?>
						
<input type="checkbox" id="todos" name="todos" value=1 <?php if($infoSalon && $todos){echo "checked";} ?> onclick="valid_todos()"> Todos<br>
<input type="checkbox" id="ninguno" name="ninguno" value=1 <?php if($infoSalon && $ninguno){echo "checked";} ?> onclick="valid_ninguno()"> Ninguno


						</div>
						
						<div class="col-sm-2">
							<div class="form-group">
								<div class="row" align="center">
									<div style="width:100%;" align="center">
										<input type="button" id="btnSubmitDisponibilidad" name="btnSubmitDisponibilidad" value="Guardar" class="btn btn-primary"/>
									</div>
								</div>
							</div>
						
							<div class="form-group">
								<div class="row" align="center">
									<div style="width:80%;" align="center">
										<div id="div_load" style="display:none">		
											<div class="progress progress-striped active">
												<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
													<span class="sr-only">45% completado</span>
												</div>
											</div>
										</div>
										<div id="div_error" style="display:none">			
											<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">&nbsp;</span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Computadores</strong>
				</div>
				<div class="panel-body">
<?php
	$cuentaActual = $information?count($information):0;

	if($noComputadores > 0 && $cuentaActual < $noComputadores){
?>									
				<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_computador" id="<?php echo $infoSalon[0]['id_sitio_salon']; ?>">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar computador
				</button>					
<?php 
	}elseif($noComputadores == 0){
			echo "Indique el número de computadores en la información del salón.";
	}
?>
				
				
					
<?php
	if($information){
?>
					<table width="100%" class="table table-striped table-hover" >
						<thead>
							<tr>
								<th class='text-center'>ID</th>
								<th class='text-center'>CPU</th>
								<th class='text-center'>OS</th>
								<th class='text-center'>Memoria del sistema</th>
								<th class='text-center'>Resolución de la pantalla</th>
								<th class='text-center'>¿Está funcionando Skype?</th>
								<th class='text-center'>Velocidad de transferecia de datos a la USB</th>
								<th class='text-center'>Virus SCAN</th>
								<th class='text-center'>Unidad USB </th>
								<th class='text-center'>¿El computador es adecuado? </th>
								<th class='text-center'>Foto</th>
								<th class='text-center'>Editar</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($information as $lista):
							
									echo "<tr>";
									echo "<td class='text-center'>" . $lista['id_sitio_computador'] . "</td>";
									
									switch ($lista['cpu']) {
										case 1:
											$cpu = 'Ok';
											break;
										case 2:
											$cpu = 'Falló';
											break;
									}
									echo "<td class='text-center'>" . $cpu . "</td>";
									
									switch ($lista['os']) {
										case 1:
											$os = 'Ok';
											break;
										case 2:
											$os = 'Falló';
											break;
									}
									echo "<td class='text-center'>" . $os . "</td>";
									
									switch ($lista['memoria']) {
										case 1:
											$memoria = 'Ok';
											break;
										case 2:
											$memoria = 'Al límite';
											break;
										case 3:
											$memoria = 'Falló';
											break;
									}
									echo "<td class='text-center'>" . $memoria . "</td>";
									
									switch ($lista['resolucion']) {
										case 1:
											$resolucion = 'Ok';
											break;
										case 2:
											$resolucion = 'Falló';
											break;
									}
									echo "<td class='text-center'>" . $resolucion . "</td>";
									
									switch ($lista['skype']) {
										case 1:
											$skype = 'Ok';
											break;
										case 2:
											$skype = 'Falló';
											break;
									}
									echo "<td class='text-center'>" . $skype . "</td>";
									
									switch ($lista['transferencia_usb']) {
										case 1:
											$transferencia_usb = 'Ok';
											break;
										case 2:
											$transferencia_usb = 'Falló';
											break;
									}
									echo "<td class='text-center'>" . $transferencia_usb . "</td>";
									
									switch ($lista['virus_scan']) {
										case 1:
											$virus_scan = 'Ok';
											break;
										case 2:
											$virus_scan = 'Falló';
											break;
									}
									echo "<td class='text-center'>" . $virus_scan . "</td>";
									
									switch ($lista['unidad_usb']) {
										case 1:
											$unidad_usb = 'Ok';
											break;
										case 2:
											$unidad_usb = 'Falló, pero se corrigió';
											break;
										case 3:
											$unidad_usb = 'Falló';
											break;
									}
									echo "<td class='text-center'>" . $unidad_usb . "</td>";
									
									switch ($lista['adecuado']) {
										case 1:
											$adecuado = 'Ok';
											break;
										case 2:
											$adecuado = 'Falló';
											break;
									}
									echo "<td class='text-center'>" . $adecuado . "</td>";
									
									echo "<td class='text-center'>";
																		
						//si hay una foto la muestro
						if($lista["foto_computador"]){ ?>
<img src="<?php echo base_url($lista["foto_computador"]); ?>" class="img-rounded" width="42" height="42" />
						<?php } ?>
<a href="<?php echo base_url("sitios/foto_computador/" . $infoSalon[0]['id_sitio_salon'] . "/" . $lista['id_sitio_computador']); ?>" class="btn btn-primary btn-xs">Foto</a>						
									
						<?php
									echo "</td>";
									
									echo "<td class='text-center'>";									
						?>
									<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal_computador" id="<?php echo $lista['id_sitio_computador']; ?>" >
										Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</button>
						<?php
									echo "</td>";
									echo "</tr>";								
							endforeach;
						?>
						</tbody>
					</table>
<?php } ?>
					
				</div>
			</div>
		</div>
	</div>


</div>
<!-- /#page-wrapper -->


<!--INICIO Modal Computadores-->
<div class="modal fade text-center" id="modal_computador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="tablaDatosComputador">

		</div>
	</div>
</div>                       
<!--FIN Modal Computadores-->