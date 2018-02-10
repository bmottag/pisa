<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/salones.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Salones
	<br><small>Adicionar/Editar Salones</small>
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdSitio" name="hddIdSitio" value="<?php echo $idSitio; ?>"/>
		<input type="hidden" id="hddIdSalon" name="hddIdSalon" value="<?php echo $information?$information[0]["id_sitio_salon"]:""; ?>"/>	
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="bloque">Bloque : *</label>
					<select name="bloque" id="bloque" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($infoBloques); $i++) { ?>
							<option value="<?php echo $infoBloques[$i]["id_sitio_bloque"]; ?>" <?php if($infoBloques[$i]["id_sitio_bloque"] == $information[0]["fk_id_sitio_bloque"]) { echo "selected"; }  ?>><?php echo $infoBloques[$i]["nombre_bloque"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="salon">Nombre : *</label>
					<input type="text" id="salon" name="salon" class="form-control" value="<?php echo $information?$information[0]["nombre_salon"]:""; ?>" placeholder="Nombre" required >
				</div>
			</div>

		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="capacidad">Capacidad : *</label>
					<select name="capacidad" id="capacidad" class="form-control" required>
						<option value='' >Select...</option>
						<?php
						for ($i = 1; $i < 50; $i++) {
							?>
							<option value='<?php echo $i; ?>' <?php
							if ($information && $i == $information[0]["capacidad_salon"]) {
								echo 'selected="selected"';
							}
							?>><?php echo $i; ?></option>
						<?php } ?>									
					</select>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="computadores">No. computadores : *</label>
					<select name="computadores" id="computadores" class="form-control" required>
						<option value='' >Select...</option>
						<?php
						for ($i = 0; $i < 20; $i++) {
							?>
							<option value='<?php echo $i; ?>' <?php
							if ($information && $i == $information[0]["computadores"]) {
								echo 'selected="selected"';
							}
							?>><?php echo $i; ?></option>
						<?php } ?>									
					</select>
				</div>
			</div>


		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="piso">Número piso : *</label>
					<select name="piso" id="piso" class="form-control" required>
						<option value='' >Select...</option>
						<?php
						for ($i = 1; $i < 20; $i++) {
							?>
							<option value='<?php echo $i; ?>' <?php
							if ($information && $i == $information[0]["numero_piso"]) {
								echo 'selected="selected"';
							}
							?>><?php echo $i; ?></option>
						<?php } ?>									
					</select>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="discapacitados">Accesibilidad discapacitados : *</label>
					<select name="discapacitados" id="discapacitados" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["discapacitados"] == 1) { echo "selected"; }  ?>>Si</option>
						<option value=2 <?php if($information[0]["discapacitados"] == 2) { echo "selected"; }  ?>>No</option>
					</select>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="tipo_salon">Tipo de salón : *</label>
					<select name="tipo_salon" id="tipo_salon" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["tipo_salon"] == 1) { echo "selected"; }  ?>>Arquitectura</option>
						<option value=2 <?php if($information[0]["tipo_salon"] == 2) { echo "selected"; }  ?>>Computo</option>
						<option value=3 <?php if($information[0]["tipo_salon"] == 3) { echo "selected"; }  ?>>Electrónico</option>
						<option value=4 <?php if($information[0]["tipo_salon"] == 4) { echo "selected"; }  ?>>Papel</option>
					</select>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="estado">Estado : *</label>
					<select name="estado" id="estado" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["estado_salon"] == 1) { echo "selected"; }  ?>>Activo</option>
						<option value=2 <?php if($information[0]["estado_salon"] == 2) { echo "selected"; }  ?>>Inactivo</option>
					</select>
				</div>
			</div>
		</div>	

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="observacion">Observación :</label>
					<textarea id="observacion" name="observacion" class="form-control" rows="2"><?php echo $information?$information[0]["observacion_salon"]:""; ?></textarea>
				</div>
			</div>
		</div>		
			

		<div class="form-group">
			<div class="row" align="center">
				<div style="width:50%;" align="center">
					<input type="button" id="btnSubmit" name="btnSubmit" value="Guardar" class="btn btn-primary"/>
				</div>
			</div>
		</div>
		
		<div class="form-group">
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
			
	</form>
</div>