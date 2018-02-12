<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/asignar_pisa.js"); ?>"></script>

<div id="page-wrapper">

	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						<i class="fa fa-gear fa-fw"></i> CONFIGURACIONES - SITIO
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->				
	</div>
	
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-success">
				<div class="panel-heading">
					<strong>Nombre Sitio: </strong><br><?php echo $infoSitio[0]['nombre_sitio']; ?>
					<br><strong>Dirección: </strong><?php echo $infoSitio[0]['direccion_sitio']; ?>
					<br><strong>Código DANE: </strong><?php echo $infoSitio[0]['codigo_dane']; ?>
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-success">
				<div class="panel-heading">
					<strong>Nodo o Región: </strong><?php echo $infoSitio[0]['nombre_region']; ?>
					<br><strong>Departamento: </strong><?php echo $infoSitio[0]['dpto_divipola_nombre']; ?>
					<br><strong>Municipio: </strong><?php echo $infoSitio[0]['mpio_divipola_nombre']; ?>
					<br><strong>Zona: </strong><?php echo $infoSitio[0]['nombre_zona']; ?>
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-success">
				<div class="panel-heading">
					<strong>Usuario PISA: </strong><br>
					<?php 
					if($infoSitio[0]['fk_id_user_pisa']){
						echo "C.C. " . $infoSitio[0]['cedula_pisa'] . " " . $infoSitio[0]['nom_pisa'] . " "  . $infoSitio[0]['ape_pisa'];
					} else { echo "Falta asignar usuario PISA.";}
					?>
				</div>
			</div>
		</div>
	</div>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="btn btn-success" href=" <?php echo base_url(). 'sitios'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-gears"></i> Asignar usuario PISA
				</div>
				<div class="panel-body">
				
					<p class="text-danger text-left">Los campos con * son obligatorios.</p>
					
					<form  name="form" id="form" class="form-horizontal" method="post" action="<?php echo base_url("admin/guardar_pisa"); ?>" >
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $infoSitio[0]["id_sitio"]; ?>"/>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="usuario">Usuario PISA: *</label>
							<div class="col-sm-5">

							<?php if($usuarios){ ?>
							<select name="usuario" id="usuario" class="form-control" required>
								<option value=''>Select...</option>
								<?php for ($i = 0; $i < count($usuarios); $i++) { ?>
									<option value="<?php echo $usuarios[$i]["id_usuario"]; ?>" <?php if($infoSitio[0]["fk_id_user_pisa"] == $usuarios[$i]["id_usuario"]) { echo "selected"; }  ?>><?php echo  "C.C. " . $usuarios[$i]["numero_documento"] . " - " . $usuarios[$i]["nombres_usuario"] . " " . $usuarios[$i]["apellidos_usuario"]; ?></option>
								<?php } ?>
							</select>
							
							<?php }else{ 
									echo "No hay Usuario PISA disponible."; 
							} ?>
							
							
							</div>
						</div>
<?php if($usuarios){ ?>												
						<div class="row" align="center">
							<div style="width:50%;" align="center">
								 <button type="submit" class="btn btn-primary" id='btnSubmit' name='btnSubmit'>Guardar </button>
							</div>
						</div>
<?php } ?>
					</form>

				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->