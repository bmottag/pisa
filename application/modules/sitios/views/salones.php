<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/ajaxSalones.js"); ?>"></script>

<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'sitios/cargarModalNumeroSalones',
                data: {'idSitio': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});	
	
	$(".btn-warning").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'sitios/cargarModalSalonesV2',
                data: {'idSitio': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatosSalon').html(data);
                }
            });
	});
	
	$(".btn-primary").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'sitios/cargarModalSalones',
                data: {'idSitio': oID, 'idSalon': 'x'},
                cache: false,
                success: function (data) {
                    $('#tablaDatosSalon').html(data);
                }
            });
	});

	$(".btn-default").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'sitios/cargarModalSalones',
                data: {'idSitio': '', 'idSalon': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatosSalon').html(data);
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
				
<?php
	$idSitio = $infoSitio[0]['id_sitio'];

	$userRol = $this->session->userdata("rol");
	if($userRol!=7){//USUARIOS QUE NO SON PISA les muestro en enlace de regresar
?>

					<a class="btn btn-info btn-xs" href=" <?php echo base_url().'sitios'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
<?php
	}
?>
					<i class="fa fa-cube"></i> <strong>Salas de cómputo</strong>
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
							<strong>Departemanto: </strong><?php echo $infoSitio[0]['departamento']; ?><br>
							<strong>Municipio: </strong><?php echo $infoSitio[0]['municipio']; ?>
						</div>
					</div>
					
					<div class="col-lg-4">	
						<div class="alert alert-info">
							<strong>No. de salas de cómputo: </strong><?php echo $infoSitio[0]['numero_salas']; ?><br>
			<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $infoSitio[0]['id_sitio']; ?>">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Número de salas de cómputo
			</button><br>
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
	$numeroSalones = $infoSitio[0]['numero_salas'];//numero de salones 
	$noSalones = $noSalones;//salones guardados
	
	$salonesFaltantes = $numeroSalones - $noSalones;
	
	if($numeroSalones > 0){
?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>Listado de salas de cómputo</strong>
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<div class="table-responsive" >
				
							<table width="100%" class="table table-striped table-hover" >
								<thead>
									<tr>
										<th class='text-center'>No.</th>
										<th class='text-center'>Nombre o identificación sala de cómputo</th>
										<th class='text-center'>No. Computadores</th>
										<th class='text-center'>No. Computadores actualizados</th>
										<th class='text-center'>No. Computadores NO actualizados</th>
										<th class='text-center'>No. Computadores cumplen diagnóstico</th>
										<th class='text-center'>No. Computadores NO cumplen diagnóstico</th>
										<th class='text-center'>Enlaces</th>
									</tr>
								</thead>
								<tbody id="salones">							
<?php
	if($infoSalones){
?>
								<?php
									$i=0;
									
									$ci = &get_instance();
									$ci->load->model("general_model");
									
									foreach ($infoSalones as $lista):
										$i++;
$arrParam = array("idSalon" => $lista['id_sitio_salon'],
					"conFoto" => 1);
$conteoComputadoresActualizado = $ci->general_model->countComputadores($arrParam);

$arrParam["adecuado"] = 1; 
$conteoComputadoresAdecuados = $ci->general_model->countComputadores($arrParam);

$conteoComputadoresNOActualizado = $lista['computadores'] - $conteoComputadoresActualizado;
$conteoComputadoresNOAdecuados = $lista['computadores'] - $conteoComputadoresAdecuados;
									
										echo "<tr>";
										echo "<td class='text-center text-success'>" . $i . "</td>";
										echo "<td class='text-center text-success'>" . $lista['nombre_salon'] . "</td>";
										echo "<td class='text-center text-success'>" . $lista['computadores'] . "</td>";
										echo "<td class='text-center text-success'>" . $conteoComputadoresActualizado . "</td>";
										echo "<td class='text-center text-success'>" . $conteoComputadoresNOActualizado . "</td>";
										echo "<td class='text-center text-success'>" . $conteoComputadoresAdecuados . "</td>";
										echo "<td class='text-center text-success'>" . $conteoComputadoresNOAdecuados . "</td>";

										echo "<td class='text-center'>";									
								?>
										<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal_salon" id="<?php echo $lista['id_sitio_salon']; ?>" >
											Actualizar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
										</button>

<a class='btn btn-default btn-xs' href='<?php echo base_url('sitios/computadores_salon/' . $lista['id_sitio_salon'] ); ?>'>
	Computadores <span class='glyphicon glyphicon-plus' aria-hidden='true'>
</a>

<a class='btn btn-danger btn-xs' href='<?php echo base_url('sitios/deleteSala/' . $idSitio . '/' . $lista['id_sitio_salon'] ); ?>'>
	Eliminar <span class="fa fa-times fa-fw" aria-hidden="true">
</a>
								<?php
										echo "</td>";
										echo "</tr>";								
									endforeach;
								?>

<?php 
	}
?>
								
								
								<?php
									for ($i = 1; $i <= $salonesFaltantes; $i++)
									{
											echo "<tr>";
											echo "<td class='text-center text-danger'>Falta información</td>";
											echo "<td class='text-center text-danger'>Falta información</td>";
											echo "<td class='text-center text-danger'>Falta información</td>";
											echo "<td class='text-center text-danger'>Falta información</td>";
											echo "<td class='text-center text-danger'>Falta información</td>";
											echo "<td class='text-center text-danger'>Falta información</td>";
											echo "<td class='text-center text-danger'>Falta información</td>";
	
											echo "<td class='text-center'>";								
								?>
				<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal_salon" id="<?php echo $idSitio; ?>">
						Actualizar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
				</button>
				
<a class='btn btn-danger btn-xs' href='<?php echo base_url('sitios/deleteSala/' . $idSitio); ?>'>
	Eliminar <span class="fa fa-times fa-fw" aria-hidden="true">
</a>
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
		
		<button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#modal_salon" id="<?php echo $idSitio; ?>">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar sala de cómputo
		</button>	
		<br>
		
		
<?php
	}
?>


	
</div>
<!-- /#page-wrapper -->

<!--INICIO Modal Bloques-->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal Bloques-->

<!--INICIO Modal Salones-->
<div class="modal fade text-center" id="modal_salon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="tablaDatosSalon">

		</div>
	</div>
</div>                       
<!--FIN Modal Salones-->


    <!-- Tables -->
    <script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            responsive: true,
			 "ordering": false,
			 paging: false,
			"searching": false,
			"info": false
        });
    });
    </script>