<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/computadores.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Formulario de resultado de pruebas de verificación y diagnóstico de computadores	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdSalon" name="hddIdSalon" value="<?php echo $idSalon; ?>"/>
		<input type="hidden" id="hddIdComputador" name="hddIdComputador" value="<?php echo $information?$information[0]["id_sitio_computador"]:""; ?>"/>	
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="windows_defender"> ¿Para equipos con Windows 8.1 y Windows 10, se actualizó  Windows Defender  a la versión 1.261.610.0 o posterior? : *</label>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					
					<label class="radio-inline">
						<input type="radio" name="windows_defender" id="windows_defender1" value=1 <?php if($information && $information[0]["windows_defender"] == 1) { echo "checked"; }  ?>>Si
					</label>
					<label class="radio-inline">
						<input type="radio" name="windows_defender" id="windows_defender2" value=2 <?php if($information && $information[0]["windows_defender"] == 2) { echo "checked"; }  ?>>No
					</label>
				</div>
			</div>
		</div>
		
		<hr>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="cpu">CPU : *</label>
					
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					
					<label class="radio-inline">
						<input type="radio" name="cpu" id="cpu1" value=1 <?php if($information && $information[0]["cpu"] == 1) { echo "checked"; }  ?>>Ok
					</label>
					<label class="radio-inline">
						<input type="radio" name="cpu" id="cpu2" value=2 <?php if($information && $information[0]["cpu"] == 2) { echo "checked"; }  ?>>Falló
					</label>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="os">OS : *</label>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">

					<label class="radio-inline">
						<input type="radio" name="os" id="os1" value=1 <?php if($information && $information[0]["os"] == 1) { echo "checked"; }  ?>>Ok
					</label>
					<label class="radio-inline">
						<input type="radio" name="os" id="os2" value=2 <?php if($information && $information[0]["os"] == 2) { echo "checked"; }  ?>>Falló
					</label>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="memoria">Memoria del sistema : *</label>				
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">				
					<label class="radio-inline">
						<input type="radio" name="memoria" id="memoria1" value=1 <?php if($information && $information[0]["memoria"] == 1) { echo "checked"; }  ?>>Ok
					</label>
					<label class="radio-inline">
						<input type="radio" name="memoria" id="memoria2" value=2 <?php if($information && $information[0]["memoria"] == 2) { echo "checked"; }  ?>>Al límite
					</label>
					<label class="radio-inline">
						<input type="radio" name="memoria" id="memoria3" value=3 <?php if($information && $information[0]["memoria"] == 3) { echo "checked"; }  ?>>Falló
					</label>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="resolucion">Resolución de la pantalla : *</label>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">					
					<label class="radio-inline">
						<input type="radio" name="resolucion" id="resolucion1" value=1 <?php if($information && $information[0]["resolucion"] == 1) { echo "checked"; }  ?>>Ok
					</label>
					<label class="radio-inline">
						<input type="radio" name="resolucion" id="resolucion2" value=2 <?php if($information && $information[0]["resolucion"] == 2) { echo "checked"; }  ?>>Falló
					</label>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="skype">¿Skype NO se está ejecutando en el computador? : *</label>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">					
					<label class="radio-inline">
						<input type="radio" name="skype" id="skype1" value=1 <?php if($information && $information[0]["skype"] == 1) { echo "checked"; }  ?>>Ok
					</label>
					<label class="radio-inline">
						<input type="radio" name="skype" id="skype2" value=2 <?php if($information && $information[0]["skype"] == 2) { echo "checked"; }  ?>>Falló
					</label>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="transferencia_usb">Velocidad de transferecia de datos a la USB : *</label>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">					
					<label class="radio-inline">
						<input type="radio" name="transferencia_usb" id="transferencia_usb1" value=1 <?php if($information && $information[0]["transferencia_usb"] == 1) { echo "checked"; }  ?>>Ok
					</label>
					<label class="radio-inline">
						<input type="radio" name="transferencia_usb" id="transferencia_usb2" value=2 <?php if($information && $information[0]["transferencia_usb"] == 2) { echo "checked"; }  ?>>Falló
					</label>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="virus_scan">Virus SCAN : *</label>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">					
					<label class="radio-inline">
						<input type="radio" name="virus_scan" id="virus_scan1" value=1 <?php if($information && $information[0]["virus_scan"] == 1) { echo "checked"; }  ?>>Ok
					</label>
					<label class="radio-inline">
						<input type="radio" name="virus_scan" id="virus_scan2" value=2 <?php if($information && $information[0]["virus_scan"] == 2) { echo "checked"; }  ?>>Falló
					</label>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="unidad_usb">Unidad USB : *</label>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">					
					<label class="radio-inline">
						<input type="radio" name="unidad_usb" id="unidad_usb1" value=1 <?php if($information && $information[0]["unidad_usb"] == 1) { echo "checked"; }  ?>>Ok
					</label>
					<label class="radio-inline">
						<input type="radio" name="unidad_usb" id="unidad_usb2" value=2 <?php if($information && $information[0]["unidad_usb"] == 2) { echo "checked"; }  ?>>Falló, pero se corrigió
					</label>
					<label class="radio-inline">
						<input type="radio" name="unidad_usb" id="unidad_usb3" value=3 <?php if($information && $information[0]["unidad_usb"] == 3) { echo "checked"; }  ?>>Falló
					</label>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="comentarios">Comentarios : </label>
					<textarea id="comentarios" name="comentarios" class="form-control" rows="2"><?php echo $information?$information[0]["comentarios"]:""; ?></textarea>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="adecuado">¿El computador cumple los requisitos para aplicar PISA? : *</label>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="radio-inline">
						<input type="radio" name="adecuado" id="adecuado1" value=1 <?php if($information && $information[0]["adecuado"] == 1) { echo "checked"; }  ?>>Si
					</label>
					<label class="radio-inline">
						<input type="radio" name="adecuado" id="adecuado2" value=2 <?php if($information && $information[0]["adecuado"] == 2) { echo "checked"; }  ?>>No
					</label>
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