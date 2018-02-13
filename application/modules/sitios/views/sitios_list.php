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
								<th class="text-center">Gestión de salas de computo</th>
								<th class="text-center">Usuario PISA</th>
							</tr>
						</thead>
						<tbody id="sitios">							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td >" . strtoupper($lista['departamento']) . "</td>";
									echo "<td >" . strtoupper($lista['municipio']) . "</td>";	
									echo "<td >" . $lista['nombre_sitio'] . "</td>";
									echo "<td class='text-center'>" . $lista['national_school_id'] . "</td>";
									
									echo "<td class='text-center'>";
						?>
									<a class='btn btn-default btn-xs' href='<?php echo base_url('sitios/salones/' . $lista['id_sitio']) ?>'>
										Sala de computo <span class="fa fa-cube" aria-hidden="true">
									</a>
						
									</td>
									
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
		"pageLength": 50
	});
});
</script>