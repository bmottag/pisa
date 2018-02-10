<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/ajaxSalones.js"); ?>"></script>

<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'sitios/cargarModalBloques',
                data: {'idSitio': oID, 'idBloque': 'x'},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});	
	
	$(".btn-info").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'sitios/cargarModalBloques',
                data: {'idSitio': '', 'idBloque': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
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
	$userRol = $this->session->userdata("rol");
	if($userRol!=7){//USUARIOS QUE NO SON PISA les muestro en enlace de regresar
?>

					<a class="btn btn-info btn-xs" href=" <?php echo base_url().'sitios'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
<?php
	}
?>
					<i class="fa fa-cube"></i> <strong>Gestión de Bloques y Salones</strong>
				</div>
				<div class="panel-body">
					
					<div class="col-lg-6">	
						<div class="alert alert-info">
							<strong>Sitio: </strong><?php echo $infoSitio[0]['nombre_sitio']; ?><br>
							<strong>Código DANE: </strong><?php echo $infoSitio[0]['codigo_dane']; ?>
						</div>
					</div>
					<div class="col-lg-6">	
						<div class="alert alert-info">
							<strong>Departemanto: </strong><?php echo $infoSitio[0]['dpto_divipola_nombre']; ?><br>
							<strong>Municipio: </strong><?php echo $infoSitio[0]['mpio_divipola_nombre']; ?>
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

		<ul class="nav nav-pills">
			<li>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal" id="<?php echo $infoSitio[0]['id_sitio']; ?>">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar bloque
				</button>
			
			</li>
			<li>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_salon" id="<?php echo $infoSitio[0]['id_sitio']; ?>">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar salón
				</button>
			</li>
		</ul>
		
								
		<div class="row">
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>Listado de bloques</strong>
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<div class="table-responsive">
						
							<table width="100%" class="table table-striped table-hover">
								<thead>
									<tr>
										<th class='text-center'>Nombre</th>
										<th class='text-center'>Estado</th>
										<th class='text-center'>Editar</th>
									</tr>
								</thead>
								<tbody>							
								<?php
								if($infoBloques){
									
									foreach ($infoBloques as $lista):
											echo "<tr>";
											echo "<td class='text-center'>" . $lista['nombre_bloque'] . "</td>";										
											
											echo "<td class='text-center'>";
											switch ($lista['estado_bloque']) {
												case 1:
													$valor = 'Activo';
													$clase = "text-success";
													break;
												case 2:
													$valor = 'Inactivo';
													$clase = "text-danger";
													break;
											}
											echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
											echo "</td>";
											
											
											
											echo "<td class='text-center'>";									
								?>
											<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_sitio_bloque']; ?>" >
												<span class="glyphicon glyphicon-edit" aria-hidden="true">
											</button>									
								<?php
											echo "</td>";
											echo "</tr>";
									endforeach;
									
								} //Fin Info bloques
								?>
								</tbody>
							</table>
							
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-lg-6">	
				<div class="alert alert-info">
					<strong>No. de Bloques: </strong><?php echo $noBloques; ?><br>
					<strong>No. de Salones: </strong><?php echo $noSalones; ?>
				</div>
			</div>

		</div>

				
				<?php
					if($infoSalones){
				?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div class="col-sm-6">
								<strong>Listado de salones</strong>
							</div>
						
							<div class="col-sm-6">
								<div class="form-group text-left">
									<label class="control-label" for="bloques">Bloques : </label>
									<select name="bloques" id="bloques" class="form-control" >
										<option value=''>Seleccione...</option>
										<?php for ($i = 0; $i < count($infoBloques); $i++) { ?>
											<option value="<?php echo $infoBloques[$i]["id_sitio_bloque"]; ?>" ><?php echo $infoBloques[$i]["nombre_bloque"]; ?></option>	
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<div class="table-responsive" >
				
							<table width="100%" class="table table-striped table-hover" >
								<thead>
									<tr>
										<th class='text-center'>Bloque</th>
										<th class='text-center'>Salón</th>
										<th class='text-center'>Capacidad</th>
										<th class='text-center'>Tipo de salón</th>
										<th class='text-center'>Estado</th>
										<th class='text-center'>Edit</th>
									</tr>
								</thead>
								<tbody id="salones">							
								<?php
									$i=0;
									foreach ($infoSalones as $lista):
											$i++;
									
											echo "<tr>";
											echo "<td class='text-center'>" . $lista['nombre_bloque'] . "</td>";
											echo "<td class='text-center'>" . $lista['nombre_salon'] . "</td>";
											echo "<td class='text-center'>" . $lista['capacidad_salon'] . "</td>";
											
											switch ($lista['tipo_salon']) {
												case 1:
													$tipoSalon = 'Arquitectura';
													break;
												case 2:
													$tipoSalon = 'Computo';
													break;
												case 3:
													$tipoSalon = 'Electrónico';
													break;
												case 4:
													$tipoSalon = 'Papel';
													break;
											}
											echo "<td class='text-center'>" . $tipoSalon . "</td>";
	
											echo "<td class='text-center'>";
											switch ($lista['estado_salon']) {
												case 1:
													$valor = 'Activo';
													$clase = "text-success";
													break;
												case 2:
													$valor = 'Inactivo';
													$clase = "text-danger";
													break;
											}
											echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
											echo "</td>";
											
											echo "<td class='text-center'>";									
								?>
											<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal_salon" id="<?php echo $lista['id_sitio_salon']; ?>" >
												Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
											</button>

<a class='btn btn-info btn-xs' href='<?php echo base_url('sitios/add_info_salon/' . $lista['id_sitio_salon'] ); ?>'>
											Más <span class='glyphicon glyphicon-plus' aria-hidden='true'>
							</a>

<a class='btn btn-danger btn-xs' href='<?php echo base_url('sitios/computadores_salon/' . $lista['id_sitio_salon'] ); ?>'>
											Computadores <span class='glyphicon glyphicon-plus' aria-hidden='true'>
							</a>							
								<?php
											echo "</td>";
											echo "</tr>";								
									endforeach;
								?>
								</tbody>
							</table>
					
						</div>
					</div>
				</div>
			</div>
		</div>
				<?php } //Fin Info Salones ?>

	
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