<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/salones_total.js"); ?>"></script>

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
					
					<div class="col-lg-6">	
						<div class="alert alert-info">
							<strong>Sitio: </strong><?php echo $infoSitio[0]['nombre_sitio']; ?><br>
							<strong>Código DANE: </strong><?php echo $infoSitio[0]['codigo_dane']; ?><br>
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

<form  name="form" id="form" class="form-horizontal" method="post"  >
	<input type="hidden" id="hddIdSalon" name="hddIdSalon" value="<?php echo $information?$information[0]["id_sitio_salon"]:""; ?>"/>
	<input type="hidden" id="hddId" name="hddId" value="<?php echo $idSitio; ?>"/>

	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Infraestructura</strong>
				</div>
				<div class="panel-body">
									
					<div class="form-group">
						<label class="col-sm-3 control-label" for="aire_acondicionado">Aire acondicionado </label>
						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="aire_acondicionado" id="aire_acondicionado1" value=1 <?php if($information && $information[0]["aire_acondicionado"] == 1) { echo "checked"; }  ?>>Si
							</label>
							<label class="radio-inline">
								<input type="radio" name="aire_acondicionado" id="aire_acondicionado2" value=2 <?php if($information && $information[0]["aire_acondicionado"] == 2) { echo "checked"; }  ?>>No
							</label>
						</div>

						<label class="col-sm-3 control-label" for="ventilacion_natural">Ventilación natural </label>
						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="ventilacion_natural" id="ventilacion_natural1" value=1 <?php if($information && $information[0]["ventilacion_natural"] == 1) { echo "checked"; }  ?>>Si
							</label>
							<label class="radio-inline">
								<input type="radio" name="ventilacion_natural" id="ventilacion_natural2" value=2 <?php if($information && $information[0]["ventilacion_natural"] == 2) { echo "checked"; }  ?>>No
							</label>
						</div>						
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label" for="iluminacion">Iluminación </label>
						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="iluminacion" id="iluminacion1" value=1 <?php if($information && $information[0]["iluminacion"] == 1) { echo "checked"; }  ?>>Si
							</label>
							<label class="radio-inline">
								<input type="radio" name="iluminacion" id="iluminacion2" value=2 <?php if($information && $information[0]["iluminacion"] == 2) { echo "checked"; }  ?>>No
							</label>
						</div>
						
						<label class="col-sm-3 control-label" for="separador_piso_techo">Separador de piso a techo </label>
						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="separador_piso_techo" id="separador_piso_techo1" value=1 <?php if($information && $information[0]["separador_piso_techo"] == 1) { echo "checked"; }  ?>>Si
							</label>
							<label class="radio-inline">
								<input type="radio" name="separador_piso_techo" id="separador_piso_techo2" value=2 <?php if($information && $information[0]["separador_piso_techo"] == 2) { echo "checked"; }  ?>>No
							</label>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label" for="puerta">Puerta </label>
						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="puerta" id="puerta1" value=1 <?php if($information && $information[0]["puerta"] == 1) { echo "checked"; }  ?>>Si
							</label>
							<label class="radio-inline">
								<input type="radio" name="puerta" id="puerta2" value=2 <?php if($information && $information[0]["puerta"] == 2) { echo "checked"; }  ?>>No
							</label>
						</div>
						
						<label class="col-sm-3 control-label" for="forma_mobiliario">Forma de mobiliario </label>
						<div class="col-sm-3">
							<select name="forma_mobiliario" id="forma_mobiliario" class="form-control" required>
								<option value="">Select...</option>
								<option value=1 <?php if($information[0]["forma_mobiliario"] == 1) { echo "selected"; }  ?>>Mesas hexagonales</option>
								<option value=2 <?php if($information[0]["forma_mobiliario"] == 2) { echo "selected"; }  ?>>Mesas individuales</option>
								<option value=3 <?php if($information[0]["forma_mobiliario"] == 3) { echo "selected"; }  ?>>Pupitres unipersonales</option>
								<option value=4 <?php if($information[0]["forma_mobiliario"] == 4) { echo "selected"; }  ?>>Pupitres bipersonales</option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label" for="tamaño">Tamaño </label>
						<div class="col-sm-3">
							<select name="tamaño" id="tamaño" class="form-control" required>
								<option value="">Select...</option>
								<option value=1 <?php if($information[0]["tamaño"] == 1) { echo "selected"; }  ?>>Preescolar</option>
								<option value=2 <?php if($information[0]["tamaño"] == 2) { echo "selected"; }  ?>>Primaria</option>
								<option value=3 <?php if($information[0]["tamaño"] == 3) { echo "selected"; }  ?>>Secundaria</option>
								<option value=4 <?php if($information[0]["tamaño"] == 4) { echo "selected"; }  ?>>Universitarios</option>
							</select>
						</div>

						<label class="col-sm-3 control-label" for="tipo_piso">Pisos</label>
						<div class="col-sm-3">
							<select name="tipo_piso" id="tipo_piso" class="form-control" required>
								<option value="">Select...</option>
								<option value=1 <?php if($information[0]["tipo_piso"] == 1) { echo "selected"; }  ?>>Baldosa</option>
								<option value=2 <?php if($information[0]["tipo_piso"] == 2) { echo "selected"; }  ?>>Destapado</option>
								<option value=3 <?php if($information[0]["tipo_piso"] == 3) { echo "selected"; }  ?>>Madera</option>
								<option value=4 <?php if($information[0]["tipo_piso"] == 4) { echo "selected"; }  ?>>Vinilo</option>
							</select>
						</div>
					</div>
					
					
				</div>
			</div>
		</div>
	</div>

				

						<div class="form-group">
							<div class="row" align="center">
								<div style="width:100%;" align="center">							
<button type="button" id="btnSubmit" name="btnSubmit" class='btn btn-primary'>
		Guardar <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
</button>
									

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

	
</form>

</div>
<!-- /#page-wrapper -->

<!--INICIO Modal para NEW HAZARD -->
<div class="modal fade text-center" id="modalNewHazard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatosNewHazard">

		</div>
	</div>
</div>                       
<!--FIN Modal para NEW HAZARD -->