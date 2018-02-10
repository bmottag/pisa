<script type="text/javascript" src="<?php echo base_url("assets/js/validate/sitios/sitio.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/ajaxMcpio.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<a class="btn btn-info btn-xs" href=" <?php echo base_url().'sitios'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-truck"></i> <strong>Sitio</strong>
				</div>
				<div class="panel-body">

<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-success ">
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

<form  name="form" id="form" class="form-horizontal" method="post" >
	<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_sitio"]:""; ?>"/>
										
	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="nombreSitio">Nombre Sitio : *</label>
				<div class="col-sm-7">
					<input type="text" id="nombreSitio" name="nombreSitio" class="form-control" value="<?php echo $information?$information[0]["nombre_sitio"]:""; ?>" placeholder="Nombre Sitio" required >
				</div>
			</div>
		</div>
			
		<div class="col-lg-6">	
			<div class="form-group">
				<label class="col-sm-4 control-label" for="barrioSitio">Barrio : *</label>
				<div class="col-sm-7">
					<input type="text" id="barrioSitio" name="barrioSitio" class="form-control" value="<?php echo $information?$information[0]["barrio_sitio"]:""; ?>" placeholder="Barrio" required >
				</div>
			</div>
		</div>

	</div>
	
	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="nombreSitio">Dirección : *</label>
				<div class="col-sm-7">
					<input type="text" id="direccion" name="direccion" class="form-control" value="<?php echo $information?$information[0]["direccion_sitio"]:""; ?>" placeholder="Dirección" required >
				</div>
			</div>
		</div>
	
	
		<div class="col-lg-6">	
			<div class="form-group">
				<label class="col-sm-4 control-label" for="barrioSitio">Código Postal :</label>
				<div class="col-sm-7">
					<input type="text" id="codigoPostal" name="codigoPostal" class="form-control" value="<?php echo $information?$information[0]["codigo_postal_sitio"]:""; ?>" placeholder="Código Postal" >
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="telefono">Teléfono : *</label>
				<div class="col-sm-7">
					<input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo $information?$information[0]["telefono_sitio"]:""; ?>" placeholder="Teléfono Sitio" required >
				</div>
			</div>
		</div>
		
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="ext_telefono">Extensión : </label>
				<div class="col-sm-7">
					<input type="text" id="ext_telefono" name="ext_telefono" class="form-control" value="<?php echo $information?$information[0]["ext_telefono"]:""; ?>" placeholder="Extensión" >
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-6">	
			<div class="form-group">
				<label class="col-sm-4 control-label" for="fax">Fax : </label>
				<div class="col-sm-7">
					<input type="text" id="fax" name="fax" class="form-control" value="<?php echo $information?$information[0]["fax_sitio"]:""; ?>" placeholder="Fax Sitio" >
				</div>
			</div>
		</div>
		
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="ext_fax">Extensión  : </label>
				<div class="col-sm-7">
					<input type="text" id="ext_fax" name="ext_fax" class="form-control" value="<?php echo $information?$information[0]["ext_fax"]:""; ?>" placeholder="Extensión" >
				</div>
			</div>
		</div>

	</div>
	
	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="celular">Celular : *</label>
				<div class="col-sm-7">
					<input type="text" id="celular" name="celular" class="form-control" value="<?php echo $information?$information[0]["celular_sitio"]:""; ?>" placeholder="Celular Sitio" required >
				</div>
			</div>
		</div>
		
		<div class="col-lg-6">	
			<div class="form-group">
				<label class="col-sm-4 control-label" for="email">Email : *</label>
				<div class="col-sm-7">
					<input type="text" id="email" name="email" class="form-control" value="<?php echo $information?$information[0]["email_sitio"]:""; ?>" placeholder="Email" required >
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="organizacion">Organización : </label>
				<div class="col-sm-7">
					<select name="organizacion" id="organizacion" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($organizaciones); $i++) { ?>
							<option value="<?php echo $organizaciones[$i]["id_organizacion"]; ?>" <?php if($information[0]["fk_id_organizacion"] == $organizaciones[$i]["id_organizacion"]) { echo "selected"; }  ?>><?php echo strtoupper($organizaciones[$i]["nombre_organizacion"]); ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
			
		<div class="col-lg-6">	
			<div class="form-group">
				<label class="col-sm-4 control-label" for="region">Nodo o Región : *</label>
				<div class="col-sm-7">
					<select name="region" id="region" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($regiones); $i++) { ?>
							<option value="<?php echo $regiones[$i]["id_region"]; ?>" <?php if($information[0]["fk_id_region"] == $regiones[$i]["id_region"]) { echo "selected"; }  ?>><?php echo strtoupper($regiones[$i]["nombre_region"]); ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-3">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="pais">País : *</label>
				<div class="col-sm-8">
					<select name="pais" id="pais" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($departamentos); $i++) { ?>
							<option value="<?php echo $departamentos[$i]["dpto_divipola"]; ?>" <?php if($information[0]["fk_dpto_divipola"] == $departamentos[$i]["dpto_divipola"]) { echo "selected"; }  ?>><?php echo $departamentos[$i]["dpto_divipola_nombre"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
	
		<div class="col-lg-5">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="depto">Departamento : *</label>
				<div class="col-sm-7">
					<select name="depto" id="depto" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($departamentos); $i++) { ?>
							<option value="<?php echo $departamentos[$i]["dpto_divipola"]; ?>" <?php if($information[0]["fk_dpto_divipola"] == $departamentos[$i]["dpto_divipola"]) { echo "selected"; }  ?>><?php echo strtoupper($departamentos[$i]["dpto_divipola_nombre"]); ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
			
		<div class="col-lg-4">	
			<div class="form-group">
				<label class="col-sm-4 control-label" for="mcpio">Municipio : *</label>
				<div class="col-sm-8">
					<select name="mcpio" id="mcpio" class="form-control" required>					
						<?php if($information){ ?>
						<option value=''>Select...</option>
							<option value="<?php echo $information[0]["fk_mpio_divipola"]; ?>" selected><?php echo $information[0]["mpio_divipola_nombre"]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="zona">Zona :</label>
				<div class="col-sm-7">
					<select name="zona" id="zona" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($zonas); $i++) { ?>
							<option value="<?php echo $zonas[$i]["id_zona"]; ?>" <?php if($information[0]["fk_id_zona"] == $zonas[$i]["id_zona"]) { echo "selected"; }  ?>><?php echo strtoupper($zonas[$i]["nombre_zona"]); ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="codigoDane">Código DANE : *</label>
				<div class="col-sm-7">
					<input type="text" id="codigoDane" name="codigoDane" class="form-control" value="<?php echo $information?$information[0]["codigo_dane"]:""; ?>" placeholder="Código DANE" required >
				</div>
			</div>
		</div>

	</div>
	
	<div class="row">
		<div class="col-lg-4">	
			<div class="form-group">
				<label class="col-sm-5 control-label" for="discapacitados">Acceso para discapacitados : *</label>
				<div class="col-sm-7">
					<select name="discapacitados" id="discapacitados" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["discapacitados"] == 1) { echo "selected"; }  ?>>Si</option>
						<option value=2 <?php if($information[0]["discapacitados"] == 2) { echo "selected"; }  ?>>No</option>
					</select>
				</div>
			</div>
		</div>
			
		<div class="col-lg-4">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="capacidad">Capacidad : *</label>
				<div class="col-sm-7">
					<input type="text" id="capacidad" name="capacidad" class="form-control" value="<?php echo $information?$information[0]["capacidad"]:""; ?>" placeholder="Capacidad" required >
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="calificacion">Calificación : *</label>
				<div class="col-sm-7">
					<input type="text" id="calificacion" name="calificacion" class="form-control" value="<?php echo $information?$information[0]["calificacion"]:""; ?>" placeholder="Calificación" required >
				</div>
			</div>
		</div>
		
	</div>
	
	<div class="row">
		<div class="col-lg-6">	
			<div class="form-group">
				<label class="col-sm-4 control-label" for="etiqueta">Etiqueta : *</label>
				<div class="col-sm-7">
					<select name="etiqueta" id="etiqueta" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["etiqueta"] == 1) { echo "selected"; }  ?>>Penitenciaria</option>
						<option value=2 <?php if($information[0]["etiqueta"] == 2) { echo "selected"; }  ?>>Discapacidad</option>
						<option value=3 <?php if($information[0]["etiqueta"] == 3) { echo "selected"; }  ?>>Exclusivo</option>
					</select>
				</div>
			</div>
		</div>
			
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-sm-4 control-label" for="observacion">Observación : *</label>
				<div class="col-sm-7">
					<textarea id="observacion" name="observacion" placeholder="Observación"  class="form-control" rows="3"><?php echo $information?$information[0]["observacion"]:""; ?></textarea>
				</div>
			</div>
		</div>
		
	</div>

						
	<div class="form-group">
		<div class="row" align="center">
			<div style="width:100%;" align="center">
				<button type="button" id="btnSubmit" name="btnSubmit" class='btn btn-primary'>
						Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
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

					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->