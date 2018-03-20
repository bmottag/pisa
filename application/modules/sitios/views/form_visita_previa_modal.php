<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/ajaxVisitaPrevia.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/visita_previa_v2.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Visita previa
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdSitio" name="hddIdSitio" value="<?php echo $idSitio; ?>"/>
		
		<div class="row">
		
			<div class="col-sm-5">
				<div class="form-group text-left">
					<label class="control-label" for="visita">Se realizó visita previa : *</label>
					<select name="visita" id="visita" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information["visita_previa"] == 1) { echo "selected"; }  ?>>Si</option>
						<option value=2 <?php if($information["visita_previa"] == 2) { echo "selected"; }  ?>>No</option>
					</select>
				</div>
			</div>

		</div>

<?php 
	$mostrar = "none";
	if($information && $information["visita_previa"]==1){
		$mostrar = "inline";
	}
?>
		
<div id="div_vista_previa" style="display:<?php echo $mostrar; ?>">
		
		<div class="row">

			<div class="col-sm-6">		
				<div class="form-group text-left">
<script>
	$( function() {
		$( "#fecha" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
	});
</script>
					<label class="control-label" for="fecha">Fecha : *</label>
					<input type="text" class="form-control" id="fecha" name="fecha" value="<?php echo $information?$information["fecha_visita_previa"]:""; ?>" placeholder="Fecha" />
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="hora">Hora (hh:mm): *</label>
					<input type="text" id="hora" name="hora" class="form-control" value="<?php echo $information?$information["hora_visita_previa"]:""; ?>" placeholder="hh:mm" >
				</div>
			</div>
			
		</div>


		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="nombre">Nombre : *</label>
					<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $information?$information["nombre"]:""; ?>" placeholder="Nombre" >
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="cargo">Cargo : *</label>
					<input type="text" id="cargo" name="cargo" class="form-control" value="<?php echo $information?$information["cargo"]:""; ?>" placeholder="Cargo" >
				</div>
			</div>
		</div>
		
</div>
			
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="observacion">Observación : *</label>
					<textarea id="observacion" name="observacion" class="form-control" rows="1"><?php echo $information?$information["observacion"]:""; ?></textarea>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row" align="center">
				<div style="width:50%;" align="center">
					<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
						Guardar <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
					</button> 
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