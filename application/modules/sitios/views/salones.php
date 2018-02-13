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
					<i class="fa fa-cube"></i> <strong>Salas de computo</strong>
				</div>
				<div class="panel-body">
					
					<div class="col-lg-4">	
						<div class="alert alert-info">
							<strong>Sitio: </strong><?php echo $infoSitio[0]['nombre_sitio']; ?><br>
							<strong>Código DANE: </strong><?php echo $infoSitio[0]['codigo_dane']; ?>
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
							<strong>No. de salas de computo: </strong><?php echo $infoSitio[0]['numero_salas']; ?><br>
			<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $infoSitio[0]['id_sitio']; ?>">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Número de salas de computo
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
						<strong>Listado de salas de computo</strong>
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<div class="table-responsive" >
				
							<table width="100%" class="table table-striped table-hover" >
								<thead>
									<tr>
										<th class='text-center'>No.</th>
										<th class='text-center'>Nombre o identificación sala de computo</th>
										<th class='text-center'>No. Computadores</th>
										<th class='text-center'>Actualizar</th>
									</tr>
								</thead>
								<tbody id="salones">							
								<?php
									$i=0;

									for ($i = 1; $i <= $salonesFaltantes; $i++)
									{
											echo "<tr>";
											echo "<td class='text-center text-danger'>" . $i . "</td>";
											echo "<td class='text-center text-danger'>Falta información</td>";
											echo "<td class='text-center text-danger'>Falta información</td>";
	
											echo "<td class='text-center'>";								
								?>
				<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal_salon" id="<?php echo $idSitio; ?>">
						Actualizar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
				</button>
								<?php
											echo "</td>";
											echo "</tr>";								
									}
								?>
								
<?php
	if($infoSalones){
?>
								<?php
									$i=$salonesFaltantes;
									foreach ($infoSalones as $lista):
											$i++;
									
											echo "<tr>";
											echo "<td class='text-center text-success'>" . $i . "</td>";
											echo "<td class='text-center text-success'>" . $lista['nombre_salon'] . "</td>";
											echo "<td class='text-center text-success'>" . $lista['computadores'] . "</td>";
	
											echo "<td class='text-center'>";									
								?>
											<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal_salon" id="<?php echo $lista['id_sitio_salon']; ?>" >
												Actualizar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
											</button>

<a class='btn btn-danger btn-xs' href='<?php echo base_url('sitios/computadores_salon/' . $lista['id_sitio_salon'] ); ?>'>
											Computadores <span class='glyphicon glyphicon-plus' aria-hidden='true'>
							</a>							
								<?php
											echo "</td>";
											echo "</tr>";								
									endforeach;
								?>

<?php 
	}
?>
								</tbody>
							</table>
					
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
?>


		<button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#modal_salon" id="<?php echo $idSitio; ?>">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar sala de computo
		</button>	
		<br>

	
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
	<div class="modal-dialog" role="document">
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