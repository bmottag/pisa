<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/bloques.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Bloques
	<br><small>Adicionar/Editar Bloques</small>
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdSitio" name="hddIdSitio" value="<?php echo $idSitio; ?>"/>
		<input type="hidden" id="hddIdBloque" name="hddIdBloque" value="<?php echo $information?$information[0]["id_sitio_bloque"]:""; ?>"/>	
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="bloque">Nombre : *</label>
					<input type="text" id="bloque" name="bloque" class="form-control" value="<?php echo $information?$information[0]["nombre_bloque"]:""; ?>" placeholder="Nombre" required >
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="estado">Estado : *</label>
					<select name="estado" id="estado" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["estado_bloque"] == 1) { echo "selected"; }  ?>>Activo</option>
						<option value=2 <?php if($information[0]["estado_bloque"] == 2) { echo "selected"; }  ?>>Inactivo</option>
					</select>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="observacion">Observación : </label>
					<textarea id="observacion" name="observacion" class="form-control" rows="1"><?php echo $information?$information[0]["observacion_bloque"]:""; ?></textarea>
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