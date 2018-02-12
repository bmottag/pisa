<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/ajaxSalones.js"); ?>"></script>

<script>
$(function(){ 
	$(".btn-info").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'sitios/cargarModalDisponibilidad',
                data: {'idSitio': oID},
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
					<i class="fa fa-briefcase"></i> Lista de sitios
					
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group text-left">
									<label class="control-label" for="depto">Departamento : </label>
									<select name="depto" id="depto" class="form-control" >
										<option value=''>Select...</option>
										<?php for ($i = 0; $i < count($departamentos); $i++) { ?>
											<option value="<?php echo $departamentos[$i]["dpto_divipola"]; ?>" ><?php echo $departamentos[$i]["dpto_divipola_nombre"]; ?></option>	
										<?php } ?>
									</select>
								</div>
							</div>
						
							<div class="col-sm-6">
								<div class="form-group text-left">
									<label class="control-label" for="mcpio">Municipio : </label>
									<select name="mcpio" id="mcpio" class="form-control" required>					
										<?php if($information){ ?>
										<option value=''>Select...</option>
											<option value="<?php echo $information[0]["fk_mpio_divipola"]; ?>" selected><?php echo $information[0]["mpio_divipola_nombre"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
				</div>
				<div class="panel-body">

				<?php
					if($info){
				?>	<input type="hidden" id="enlace_regreso" name="enlace_regreso" value="sitios"/>				
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>				
								<th>Departamento</th>
								<th>Municipio</th>
								<th>Sitio</th>
								<th>Código DANE</th>
								<th class="text-center">Editar</th>
								<th class="text-center">Gestión de Salones</th>
								<th class="text-center">Georreferenciación</th>
								<th class="text-center">Fotos</th>
							</tr>
						</thead>
						<tbody id="sitios">							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td >" . strtoupper($lista['dpto_divipola_nombre']) . "</td>";
									echo "<td >" . strtoupper($lista['mpio_divipola_nombre']) . "</td>";	
									echo "<td >" . $lista['nombre_sitio'] . "</td>";
									echo "<td class='text-center'>" . $lista['codigo_dane'] . "</td>";

									echo "<td class='text-center'>";
						?>																
									<a class='btn btn-success btn-xs' href='<?php echo base_url('sitios/sitio/' . $lista['id_sitio']) ?>'>
										Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</a>
									
						<?php
									echo "</td>";
									
									echo "<td class='text-center'>";
						?>
									<a class='btn btn-default btn-xs' href='<?php echo base_url('sitios/salones/' . $lista['id_sitio']) ?>'>
										Salones <span class="fa fa-cube" aria-hidden="true">
									</a>
						<?php
									echo "</td>";
									
									echo "<td class='text-center'>";
						?>
									<a class='btn btn-danger btn-xs' href='<?php echo base_url('sitios/georreferenciacion/' . $lista['id_sitio']) ?>'>
										Georreferenciación <span class="glyphicon glyphicon-screenshot" aria-hidden="true">
									</a>
						<?php
									echo "</td>";
									
									echo "<td class='text-center'>";
						?>
									<a class='btn btn-warning btn-xs' href='<?php echo base_url('sitios/fotos/' . $lista['id_sitio']) ?>'>
										Fotos <span class="fa fa-photo" aria-hidden="true">
									</a>
						<?php
									echo "</td>";
									
									echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>
				<?php } ?>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->
		
<!--INICIO Modal -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal  -->
		
<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		"pageLength": 50
	});
});
</script>