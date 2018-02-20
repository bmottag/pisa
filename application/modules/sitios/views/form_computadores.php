<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/computadores.js"); ?>"></script>

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
	
	$(".btn-warning").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'sitios/cargarModalComputadoresV2',
                data: {'idSalon': oID},
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

</script>

<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<a class="btn btn-info btn-xs" href=" <?php echo base_url().'sitios/salones/' . $idSitio; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="glyphicon glyphicon-screenshot"></i> Sala de cómputo
				</div>
				<div class="panel-body">
					
					<div class="col-lg-4">	
						<div class="alert alert-info">
							<strong>Sitio: </strong><?php echo $infoSitio[0]['nombre_sitio']; ?><br>
							<strong>ID: </strong><?php echo $infoSitio[0]['national_school_id']; ?>
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
							<strong>Sala de cómputo: </strong><?php echo $infoSalon[0]['nombre_salon']; ?><br>
							<?php $numeroComputadores = $infoSalon[0]['computadores']?$infoSalon[0]['computadores']:0; ?>
							<strong>No. computadores: </strong><?php echo $numeroComputadores; ?>
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

<?php
	$idSitio = $infoSitio[0]['id_sitio'];
	
	$computadoresFaltantes = $numeroComputadores - $noComputadores;
	
	if($numeroComputadores > 0){
?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>Listado de computadores</strong>
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<div class="table-responsive" >
				
							<table width="100%" class="table table-striped table-hover" >
								<thead>
									<tr>
										<th class='text-center'>No.</th>
										<th class='text-center'>Identificación del computador</th>
										<th class='text-center'>¿Se actualizó Windows Defender? </th>
										<th class='text-center'>CPU</th>
										<th class='text-center'>OS</th>
										<th class='text-center'>Memoria del sistema</th>
										<th class='text-center'>Resolución de la pantalla</th>
										<th class='text-center'>Skype NO se está ejecutando </th>
										<th class='text-center'>Velocidad de transferecia de datos a la USB</th>
										<th class='text-center'>Virus SCAN</th>
										<th class='text-center'>Unidad USB </th>
										<th class='text-center'>¿El computador cumple los requisitos para aplicar PISA? </th>
										<th class='text-center'>Foto</th>
										<th class='text-center'>Enlaces</th>
									</tr>
								</thead>
								<tbody>
								
<?php
	if($information){
?>
						<?php
							$i=0;
							foreach ($information as $lista):
									$i++;
									echo "<tr>";
									echo "<td class='text-center text-success'>" . $i . "</td>";
									echo "<td class='text-center text-success'>" . $lista['identificacion'] . "</td>";

									switch ($lista['windows_defender']) {
										case 1:
											$cpu = 'Si';
											break;
										case 2:
											$cpu = 'No';
											break;
										case 3:
											$cpu = 'No aplica';
											break;
									}
									echo "<td class='text-center text-success'>" . $cpu . "</td>";
									
									switch ($lista['cpu']) {
										case 1:
											$cpu = 'Ok';
											break;
										case 2:
											$cpu = 'Falló';
											break;
									}
									echo "<td class='text-center text-success'>" . $cpu . "</td>";
									
									switch ($lista['os']) {
										case 1:
											$os = 'Ok';
											break;
										case 2:
											$os = 'Falló';
											break;
									}
									echo "<td class='text-center text-success'>" . $os . "</td>";
									
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
									echo "<td class='text-center text-success'>" . $memoria . "</td>";
									
									switch ($lista['resolucion']) {
										case 1:
											$resolucion = 'Ok';
											break;
										case 2:
											$resolucion = 'Falló';
											break;
									}
									echo "<td class='text-center text-success'>" . $resolucion . "</td>";
									
									switch ($lista['skype']) {
										case 1:
											$skype = 'Ok';
											break;
										case 2:
											$skype = 'Falló';
											break;
									}
									echo "<td class='text-center text-success'>" . $skype . "</td>";
									
									switch ($lista['transferencia_usb']) {
										case 1:
											$transferencia_usb = 'Ok';
											break;
										case 2:
											$transferencia_usb = 'Falló';
											break;
									}
									echo "<td class='text-center text-success'>" . $transferencia_usb . "</td>";
									
									switch ($lista['virus_scan']) {
										case 1:
											$virus_scan = 'Ok';
											break;
										case 2:
											$virus_scan = 'Falló';
											break;
									}
									echo "<td class='text-center text-success'>" . $virus_scan . "</td>";
									
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
									echo "<td class='text-center text-success'>" . $unidad_usb . "</td>";
									
									switch ($lista['adecuado']) {
										case 1:
											$adecuado = 'Si';
											break;
										case 2:
											$adecuado = 'No';
											break;
									}
									echo "<td class='text-center text-success'>" . $adecuado . "</td>";
									
									echo "<td class='text-center text-danger'>";
																		
						//si hay una foto la muestro
						if($lista["foto_computador"]){ 
							$estiloFoto = "btn btn-primary btn-xs";
							$textoFoto = "Foto";
						?>
						
<a href='<?php echo base_url($lista["foto_computador"]); ?>' target="_blanck">
	<img src="<?php echo base_url($lista["foto_computador"]); ?>" class="img-rounded" width="42" height="42" />
</a>
						<?php }else{ 
								$estiloFoto = "btn btn-warning btn-xs";
								$textoFoto = "Falta Foto";
							} 
						?>
<a href="<?php echo base_url("sitios/foto_computador/" . $infoSalon[0]['id_sitio_salon'] . "/" . $lista['id_sitio_computador']); ?>" class="<?php echo $estiloFoto; ?>"><?php echo $textoFoto; ?></a>
									
						<?php
									echo "</td>";
									
									echo "<td class='text-center'>";									
						?>
									
<a class='btn btn-default btn-xs' href='<?php echo base_url('sitios/add_computador/' . $infoSalon[0]['id_sitio_salon'] . '/2/' . $lista['id_sitio_computador']); ?>'>
	Actualizar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
</a>
									

<button type="button" id="<?php echo $infoSalon[0]['id_sitio_salon'] . '-' . $lista['id_sitio_computador']; ?>" class='btn btn-danger btn-xs'>
		Eliminar <span class="fa fa-times fa-fw" aria-hidden="true">
</button>


						<?php
									echo "</td>";
									echo "</tr>";								
							endforeach;
						?>
								
								

<?php 
	}
?>
								
								<?php
									for ($i = 1; $i <= $computadoresFaltantes; $i++)
									{
											echo "<tr>";
											echo "<td class='text-danger text-center'>Falta Información</td>";
											echo "<td class='text-danger text-center'>Falta Información</td>";
											echo "<td class='text-danger text-center'>Falta Información</td>";
											echo "<td class='text-danger text-center'>Falta Información</td>";
											echo "<td class='text-danger text-center'>Falta Información</td>";
											echo "<td class='text-danger text-center'>Falta Información</td>";
											echo "<td class='text-danger text-center'>Falta Información</td>";
											echo "<td class='text-danger text-center'>Falta Información</td>";
											echo "<td class='text-danger text-center'>Falta Información</td>";
											echo "<td class='text-danger text-center'>Falta Información</td>";
											echo "<td class='text-danger text-center'>Falta Información</td>";
											echo "<td class='text-danger text-center'>Falta Información</td>";

									echo "<td class='text-center'>";									
						?>
									
<a class='btn btn-warning btn-xs' href='<?php echo base_url('sitios/add_computador/' . $infoSalon[0]['id_sitio_salon'] . '/2'); ?>'>
	Falta foto <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
</a>

						<?php
									echo "</td>";
	
											echo "<td class='text-center'>";								
								?>

				
<a class='btn btn-primary btn-xs' href='<?php echo base_url('sitios/add_computador/' . $infoSalon[0]['id_sitio_salon'] . '/2'); ?>'>
	Actualizar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
</a>
				

<button type="button" id="<?php echo $infoSalon[0]['id_sitio_salon'] . '-x'; ?>" class='btn btn-danger btn-xs'>
		Eliminar <span class="fa fa-times fa-fw" aria-hidden="true">
</button>


								<?php
											echo "</td>";
											echo "</tr>";								
									}
								?>
								

								</tbody>
							</table>
					
						</div>
					</div>
				</div>
			</div>
		</div>
		

<a class='btn btn-warning btn-block' href='<?php echo base_url('sitios/add_computador/' . $infoSalon[0]['id_sitio_salon'] . '/1'); ?>'>
	Agregar computador <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
</a>		
<br>
		
<?php
	}
?>


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