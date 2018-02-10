<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/ajaxSalones.js"); ?>"></script>

<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'sitios/cargarModalContactos',
                data: {'idSitio': oID, 'idContacto': 'x'},
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
				url: base_url + 'sitios/cargarModalContactos',
                data: {'idSitio': '', 'idContacto': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
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
					<a class="btn btn-info btn-xs" href=" <?php echo base_url().'sitios'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
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
								
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>Listado de contactos</strong>
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<div class="table-responsive">
						
							<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal" id="<?php echo $infoSitio[0]['id_sitio']; ?>">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Contacto
							</button><br>
						

					<?php
						if($infoContactos){
					?>
							<table width="100%" class="table table-striped table-hover">
								<thead>
									<tr>
										<th class='text-center'>Nombres</th>
										<th class='text-center'>Apellidos</th>
										<th class='text-center'>Cargo</th>
										<th class='text-center'>Documento</th>
										<th class='text-center'>Teléfono</th>
										<th class='text-center'>Email</th>
										<th class='text-center'>Editar</th>
									</tr>
								</thead>
								<tbody>							
								<?php
									foreach ($infoContactos as $lista):
											echo "<tr>";
											echo "<td class='text-center'>" . $lista['nombre_contacto'] . "</td>";
											echo "<td class='text-center'>" . $lista['apellido_contacto'] . "</td>";
											echo "<td class='text-center'>" . $lista['cargo_contacto'] . "</td>";
											echo "<td class='text-center'>" . $lista['documento'] . "</td>";
											echo "<td class='text-center'>" . $lista['telefono_contacto'] . "</td>";
											echo "<td class='text-center'>" . $lista['email_contacto'] . "</td>";
											
											echo "<td class='text-center'>";									
								?>
											<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_sitio_contacto']; ?>" >
												<span class="glyphicon glyphicon-edit" aria-hidden="true">
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
	
</div>
<!-- /#page-wrapper -->

<!--INICIO Modal-->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal-->

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