<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/validar_computadores.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<a class="btn btn-info btn-xs" href=" <?php echo base_url().'sitios/computadores_salon/' . $idSala; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="glyphicon glyphicon-screenshot"></i> <strong>Formulario de resultado de pruebas de verificación y diagnóstico de computadores</strong>
				</div>
				<div class="panel-body">
					
					<div class="col-lg-6">	
						<div class="alert alert-info">
							<strong>Sitio: </strong><?php echo $infoSitio[0]['nombre_sitio']; ?><br>
							<strong>ID: </strong><?php echo $infoSitio[0]['national_school_id']; ?>
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

<form  name="formDiagnostico" id="formDiagnostico" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url("sitios/guardar_info_computador"); ?>">
	<input type="hidden" id="hddIdSala" name="hddIdSala" value="<?php echo $idSala; ?>"/>
	<input type="hidden" id="hddIdComputador" name="hddIdComputador" value="<?php echo $idComputador; ?>"/>

	<!-- esto es para saber si es desde el boton adicionar, si es asi se adiciona el computador y se suma uno al conteo de computadores -->
	<input type="hidden" id="hddAdd" name="hddAdd" value=<?php echo $add; ?> />

<?php 
if(validation_errors()){
?>
	<div class="col-lg-12">	
		<div class="alert alert-danger ">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<strong>Error:</strong> Los campos con * son obligatorios.
		</div>
	</div>
<?php
}else{
	echo '<p class="text-danger text-left">Los campos con * son obligatorios.</p>';
} 
?>
	
<?php
if(!$information){
?>
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Foto computador</strong>
				</div>
				<div class="panel-body">
									
					<div class="col-lg-6">					
							<div class="col-lg-12">				
								<div class="form-group">					
									<label class="col-sm-4 control-label" for="hddTask">Adjuntar foto: *</label>
									<div class="col-sm-5">
										 <input type="file" name="userfile" capture="camera" accept="image/*">
									</div>
								</div>
							</div>
					</div>

					
					<div class="col-lg-3">
							<div class="col-lg-12">
								<div class="alert alert-danger">
										<strong>Formato permitido:</strong> gif - jpg - png<br>
										<strong>Peso máximo:</strong> 2008 pixels										
								</div>
							</div>
					</div>
					
					<div class="col-lg-3">
							<div class="col-lg-12">
								<div class="alert alert-danger">
										<strong>Tamaño mínimo:</strong> 2024 pixels<br>
										<strong>Tamaño máximo:</strong> 3000 KB
								</div>
							</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
<?php } ?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Identificación del computador</strong>
				</div>
				<div class="panel-body">

					<div class="form-group">
						<label class="col-sm-5 control-label" for="sites_watered">Identificación del computador: *</label>
						<div class="col-sm-3">
							<input type="text" id="identificacion" name="identificacion" class="form-control" value="<?php echo $information?$information[0]["identificacion"]:set_value('identificacion'); ?>" placeholder="Identificación del computador" onblur="upperCase()">
						</div>
						<div class="col-sm-3">
							<?php echo form_error('identificacion','<p class="text-danger text-left">', '</p>'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Variables básicas</strong>
				</div>
				<div class="panel-body">	
					<div class="form-group">
						<label class="col-sm-5 control-label" for="cement_debagging">	
¿Para equipos con Windows 8.1 y Windows 10, se actualizó Windows Defender a la versión 1.261.610.0 o posterior? : *
</label>

						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="windows_defender" id="windows_defender1" value=1 <?php if(($information && $information[0]["windows_defender"] == 1) || set_value('windows_defender') == 1) { echo "checked"; }  ?>>Si
							</label>
							<label class="radio-inline">
								<input type="radio" name="windows_defender" id="windows_defender2" value=2 <?php if(($information && $information[0]["windows_defender"] == 2) || set_value('windows_defender') == 2) { echo "checked"; }  ?>>No
							</label>
							<label class="radio-inline">
								<input type="radio" name="windows_defender" id="windows_defender3" value=3 <?php if(($information && $information[0]["windows_defender"] == 3) || set_value('windows_defender') == 3) { echo "checked"; }  ?>>No aplica
							</label>
						</div>
						
						<div class="col-sm-3">
							<?php echo form_error('windows_defender','<p class="text-danger text-left">', '</p>'); ?>
						</div>
						
					</div>
					
					<div class="form-group">
						<label class="col-sm-5 control-label" for="dusty_covered">CPU : * </label>
						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="cpu" id="cpu1" value=1 <?php if(($information && $information[0]["cpu"] == 1) || set_value('cpu') == 1) { echo "checked"; }  ?>>Ok
							</label>
							<label class="radio-inline">
								<input type="radio" name="cpu" id="cpu2" value=2 <?php if(($information && $information[0]["cpu"] == 2) || set_value('cpu') == 2) { echo "checked"; }  ?>>Falló
							</label>
						</div>
						
						<div class="col-sm-3">
							<?php echo form_error('cpu','<p class="text-danger text-left">', '</p>'); ?>
						</div>
						
					</div>
					
					<div class="form-group">
						<label class="col-sm-5 control-label" for="speed_control">OS: * </label>
						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="os" id="os1" value=1 <?php if(($information && $information[0]["os"] == 1) || set_value('os') == 1) { echo "checked"; }  ?>>Ok
							</label>
							<label class="radio-inline">
								<input type="radio" name="os" id="os2" value=2 <?php if(($information && $information[0]["os"] == 2) || set_value('os') == 2) { echo "checked"; }  ?>>Falló
							</label>
						</div>
						
						<div class="col-sm-3">
							<?php echo form_error('os','<p class="text-danger text-left">', '</p>'); ?>
						</div>
						
					</div>
					
					<div class="form-group">
						<label class="col-sm-5 control-label" for="speed_control">Memoria del sistema : *</label>
						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="memoria" id="memoria1" value=1 <?php if(($information && $information[0]["memoria"] == 1) || set_value('memoria') == 1) { echo "checked"; }  ?>>Ok
							</label>
							<label class="radio-inline">
								<input type="radio" name="memoria" id="memoria2" value=2 <?php if(($information && $information[0]["memoria"] == 2) || set_value('memoria') == 2) { echo "checked"; }  ?>>Al límite
							</label>
							<label class="radio-inline">
								<input type="radio" name="memoria" id="memoria3" value=3 <?php if(($information && $information[0]["memoria"] == 3) || set_value('memoria') == 3) { echo "checked"; }  ?>>Falló
							</label>
						</div>
						
						<div class="col-sm-3">
							<?php echo form_error('memoria','<p class="text-danger text-left">', '</p>'); ?>
						</div>
						
					</div>
					
					<div class="form-group">
						<label class="col-sm-5 control-label" for="speed_control">Resolución de la pantalla : *</label>
						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="resolucion" id="resolucion1" value=1 <?php if(($information && $information[0]["resolucion"] == 1) || set_value('resolucion') == 1) { echo "checked"; }  ?>>Ok
							</label>
							<label class="radio-inline">
								<input type="radio" name="resolucion" id="resolucion2" value=2 <?php if(($information && $information[0]["resolucion"] == 2) || set_value('resolucion') == 2) { echo "checked"; }  ?>>Falló
							</label>
						</div>
						
						<div class="col-sm-3">
							<?php echo form_error('resolucion','<p class="text-danger text-left">', '</p>'); ?>
						</div>
						
					</div>
					
					<div class="form-group">
						<label class="col-sm-5 control-label" for="speed_control">Skype NO se está ejecutando : *</label>
						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="skype" id="skype1" value=1 <?php if(($information && $information[0]["skype"] == 1) || set_value('skype') == 1) { echo "checked"; }  ?>>Ok
							</label>
							<label class="radio-inline">
								<input type="radio" name="skype" id="skype2" value=2 <?php if(($information && $information[0]["skype"] == 2) || set_value('skype') == 2) { echo "checked"; }  ?>>Falló
							</label>
						</div>
						
						<div class="col-sm-3">
							<?php echo form_error('skype','<p class="text-danger text-left">', '</p>'); ?>
						</div>
						
					</div>
					
					<div class="form-group">
						<label class="col-sm-5 control-label" for="speed_control">Velocidad de transferecia de datos a la USB : *</label>
						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="transferencia_usb" id="transferencia_usb1" value=1 <?php if(($information && $information[0]["transferencia_usb"] == 1) || set_value('transferencia_usb') == 1) { echo "checked"; }  ?>>Ok
							</label>
							<label class="radio-inline">
								<input type="radio" name="transferencia_usb" id="transferencia_usb2" value=2 <?php if(($information && $information[0]["transferencia_usb"] == 2) || set_value('transferencia_usb') == 2) { echo "checked"; }  ?>>Falló
							</label>
						</div>
						
						<div class="col-sm-3">
							<?php echo form_error('transferencia_usb','<p class="text-danger text-left">', '</p>'); ?>
						</div>
						
					</div>
					
					<div class="form-group">
						<label class="col-sm-5 control-label" for="speed_control">Virus SCAN : *</label>
						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="virus_scan" id="virus_scan1" value=1 <?php if(($information && $information[0]["virus_scan"] == 1) || set_value('virus_scan') == 1) { echo "checked"; }  ?>>Ok
							</label>
							<label class="radio-inline">
								<input type="radio" name="virus_scan" id="virus_scan2" value=2 <?php if(($information && $information[0]["virus_scan"] == 2) || set_value('virus_scan') == 2) { echo "checked"; }  ?>>Falló
							</label>
						</div>
						
						<div class="col-sm-3">
							<?php echo form_error('virus_scan','<p class="text-danger text-left">', '</p>'); ?>
						</div>
						
					</div>
					
					<div class="form-group">
						<label class="col-sm-5 control-label" for="speed_control">Unidad USB : *</label>
						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="unidad_usb" id="unidad_usb1" value=1 <?php if(($information && $information[0]["unidad_usb"] == 1) || set_value('unidad_usb') == 1) { echo "checked"; }  ?>>Ok
							</label>
							<label class="radio-inline">
								<input type="radio" name="unidad_usb" id="unidad_usb2" value=2 <?php if(($information && $information[0]["unidad_usb"] == 2) || set_value('unidad_usb') == 2) { echo "checked"; }  ?>>Falló, pero se corrigió
							</label>
							<label class="radio-inline">
								<input type="radio" name="unidad_usb" id="unidad_usb3" value=3 <?php if(($information && $information[0]["unidad_usb"] == 3) || set_value('unidad_usb') == 3) { echo "checked"; }  ?>>Falló
							</label>
						</div>

						<div class="col-sm-3">
							<?php echo form_error('unidad_usb','<p class="text-danger text-left">', '</p>'); ?>
						</div>
						
					</div>
			<hr>		
					<div class="form-group">
						<label class="col-sm-5 control-label" for="speed_control">Comentarios:</label>
						<div class="col-sm-3">
							<textarea id="comentarios" name="comentarios" class="form-control" rows="2" onblur="upperCase()"><?php echo $information?$information[0]["comentarios"]:set_value('comentarios'); ?></textarea>
						</div>
					</div>
			<hr>	
					<div class="form-group">
						<label class="col-sm-5 control-label" for="speed_control">¿El computador cumple los requisitos para aplicar PISA? : *</label>
						<div class="col-sm-3">
							<label class="radio-inline">
								<input type="radio" name="adecuado" id="adecuado1" value=1 <?php if(($information && $information[0]["adecuado"] == 1) || set_value('adecuado') == 1) { echo "checked"; }  ?>>Si
							</label>
							<label class="radio-inline">
								<input type="radio" name="adecuado" id="adecuado2" value=2 <?php if(($information && $information[0]["adecuado"] == 2) || set_value('adecuado') == 2) { echo "checked"; }  ?>>No
							</label>
						</div>

						<div class="col-sm-3">
							<?php echo form_error('adecuado','<p class="text-danger text-left">', '</p>'); ?>
						</div>
						
					</div>
					
					
				</div>
			</div>
		</div>
	</div>
	

						<div class="form-group">
							<div class="row" align="center">
								<div style="width:100%;" align="center">							
<button type="button" id="btnSubmit" name="btnSubmit" class='btn btn-primary' onclick="validarFrmComputador()">
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