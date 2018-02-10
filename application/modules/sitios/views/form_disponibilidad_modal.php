<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/disponibilidad.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Disponibilidad
	<br><small>Adicionar/Editar Disponibilidad</small>
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdSitio" name="hddIdSitio" value="<?php echo $idSitio; ?>"/>
		
		<div class="row">

			<div class="col-sm-5">
				<div class="form-group text-left">
					<label class="control-label" for="disponibilidad">Disponibilidad : *</label>
					<select name="disponibilidad" id="disponibilidad" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["disponibilidad"] == 1) { echo "selected"; }  ?>>Si</option>
						<option value=2 <?php if($information[0]["disponibilidad"] == 2) { echo "selected"; }  ?>>No</option>
					</select>
				</div>
			</div>

			<div class="col-sm-7">
				<div class="form-group text-left">
					<label class="control-label" for="observacion">Motivo : </label>
					<textarea id="motivo_disponibilidad" name="motivo_disponibilidad" class="form-control" rows="1"><?php echo $information?$information[0]["motivo_disponibilidad"]:""; ?></textarea>
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