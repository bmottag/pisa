<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/contacto.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Contacto
	<br><small>Adicionar/Editar Contacto</small>
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdSitio" name="hddIdSitio" value="<?php echo $idSitio; ?>"/>
		<input type="hidden" id="hddIdContacto" name="hddIdContacto" value="<?php echo $information?$information[0]["id_sitio_contacto"]:""; ?>"/>	
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="nombres">Nombres : *</label>
					<input type="text" id="nombres" name="nombres" class="form-control" value="<?php echo $information?$information[0]["nombre_contacto"]:""; ?>" placeholder="Nombres" required >
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="apellidos">Apellidos : *</label>
					<input type="text" id="apellidos" name="apellidos" class="form-control" value="<?php echo $information?$information[0]["apellido_contacto"]:""; ?>" placeholder="Apellidos" required >
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="cargo">Cargo : *</label>
					<input type="text" id="cargo" name="cargo" class="form-control" value="<?php echo $information?$information[0]["cargo_contacto"]:""; ?>" placeholder="Cargo" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="documento">Documento : *</label>
					<input type="text" id="documento" name="documento" class="form-control" value="<?php echo $information?$information[0]["documento"]:""; ?>" placeholder="Documento" required >
				</div>
			</div>
		</div>		
			
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="telefono">Teléfono : *</label>
					<input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo $information?$information[0]["telefono_contacto"]:""; ?>" placeholder="Teléfono" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="email">Email : *</label>
					<input type="text" id="email" name="email" class="form-control" value="<?php echo $information?$information[0]["email_contacto"]:""; ?>" placeholder="Email" required >
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