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
								<th class="text-center">Departamento</th>
								<th class="text-center">Municipio</th>
								<th class="text-center">Sitio</th>
								<th class="text-center">Código DANE</th>
								<th class="text-center">Gestión salas de cómputo</th>
								<th class="text-center">No. salas de cómputo</th>
								<th class="text-center">No. computadores</th>
								<th class="text-center">Usuario PISA</th>
							</tr>
						</thead>
						<tbody id="sitios">							
						<?php
							$ci = &get_instance();
							$ci->load->model("general_model");
						
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td >" . strtoupper($lista['departamento']) . "</td>";
									echo "<td >" . strtoupper($lista['municipio']) . "</td>";	
									echo "<td >" . $lista['nombre_sitio'] . "</td>";
									echo "<td class='text-center'>" . $lista['national_school_id'] . "</td>";
									
									echo "<td class='text-center'>";
						?>
									<a class='btn btn-default btn-xs' href='<?php echo base_url('sitios/salones/' . $lista['id_sitio']) ?>'>
										Salas de cómputo <span class="fa fa-cube" aria-hidden="true">
									</a>
						
									</td>
									
						<?php
									//cuenta registros de salones
									$arrParam = array("idSitio" => $lista['id_sitio']);
									$noSalones = $ci->general_model->countSalones($arrParam);
									if($noSalones){
										$noComputadores = $ci->general_model->countComputadores($arrParam);
									}else{
										$noComputadores = 0;
									}
									
									echo "<td class='text-center'>" . $noSalones . "</td>";
									echo "<td class='text-center'>" . $noComputadores . "</td>";
						?>		
									<td class='text-center'>
									<a href="<?php echo base_url("admin/asignar_pisa/" . $lista['id_sitio']); ?>" class="btn btn-info btn-xs">Usuario PISA <span class="fa fa-gears fa-fw" aria-hidden="true"></a>
						<?php 
if($lista['id_school_pisa']){
	echo "<p class='text-primary text-center'>";
	echo "No. " . $lista['cedula_pisa'] . "</br>";
	echo "<a href='" . base_url("admin/updatePisa/" . $lista['id_sitio']) . "' class='text-primary text-center'>Eliminar</p>";
}else{
	echo "<p class='text-danger text-center'><strong>Falta</strong></p>";
}

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
		"pageLength": 100
	});
});
</script>