<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/usuario.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Formulario de Usuario
	<br><small>Adicionar/Editar Usuario</small>
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_usuario"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="firstName">Nombres : *</label>
					<input type="text" id="firstName" name="firstName" class="form-control" value="<?php echo $information?$information[0]["nombres_usuario"]:""; ?>" placeholder="Nombres" required >
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="lastName">Apellidos : *</label>
					<input type="text" id="lastName" name="lastName" class="form-control" value="<?php echo $information?$information[0]["apellidos_usuario"]:""; ?>" placeholder="Apellidos" required >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="tipoDocumento">Tipo de documento : *</label>
					<select name="tipoDocumento" id="tipoDocumento" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["tipo_documento"] == 1) { echo "selected"; }  ?>>Cédula de Ciudadanía</option>
						<option value=2 <?php if($information[0]["tipo_documento"] == 2) { echo "selected"; }  ?>>Cédula de Extranjería</option>
						<option value=3 <?php if($information[0]["tipo_documento"] == 3) { echo "selected"; }  ?>>Otros</option>
					</select>
				</div>
			</div>
		
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="documento">Número de documento : *</label>
					<input type="text" id="documento" name="documento" class="form-control" value="<?php echo $information?$information[0]["numero_documento"]:""; ?>" placeholder="Número de documento" required >
				</div>
			</div>
			
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="telefono">Teléfono fijo</label>
					<input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo $information?$information[0]["telefono_fijo"]:""; ?>" placeholder="Teléfono fijo" >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="movilNumber">Celular : *</label>
					<input type="text" id="movilNumber" name="movilNumber" class="form-control" value="<?php echo $information?$information[0]["celular"]:""; ?>" placeholder="Celular" required >
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="email">Email : *</label>
					<input type="text" class="form-control" id="email" name="email" value="<?php echo $information?$information[0]["email"]:""; ?>" placeholder="Email" />
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="perfil">Rol : *</label>
					<select name="rol" id="rol" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($roles); $i++) { ?>
							<option value="<?php echo $roles[$i]["id_rol"]; ?>" <?php if($information[0]["fk_id_rol"] == $roles[$i]["id_rol"]) { echo "selected"; }  ?>><?php echo $roles[$i]["nombre_rol"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-8">
				<div class="form-group text-left">
					<label class="control-label" for="address">Dirección :</label>
					<input type="text" id="address" name="address" class="form-control" value="<?php echo $information?$information[0]["direccion_usuario"]:""; ?>" placeholder="Dirección" >
				</div>
			</div>
			
			
<?php if($information){ ?>
			<div class="col-sm-4">
				<div class="form-group text-left">
					<label class="control-label" for="estado">Estado : *</label>
					<select name="estado" id="estado" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["estado"] == 1) { echo "selected"; }  ?>>Activo</option>
						<option value=2 <?php if($information[0]["estado"] == 2) { echo "selected"; }  ?>>Inactivo</option>
					</select>
				</div>
			</div>
<?php } ?>
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
				<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">Este número de documetno ya existe en la base de datos.</span></div>
			</div>	
		</div>
			
	</form>
</div>