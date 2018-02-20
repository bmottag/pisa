<script type="text/javascript" src="<?php echo base_url("assets/js/general/say-cheese.js"); ?>"></script>

<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<a class="btn btn-info btn-xs" href=" <?php echo base_url().'sitios/computadores_salon/' . $idSalon; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-photo"></i> <strong>Fotos computador</strong>
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
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Foto computador</strong>
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

		<form  name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url("sitios/do_upload_fotos_computador"); ?>">
		<input type="hidden" id="hddIdComputador" name="hddIdComputador" value="<?php echo $idComputador; ?>"/>
		<input type="hidden" id="hddIdSalon" name="hddIdSalon" value="<?php echo $idSalon; ?>"/>
		
		<div class="col-lg-6">					
				<div class="col-lg-12">				
					<div class="form-group">					
						<label class="col-sm-4 control-label" for="hddTask">Foto</label>
						<div class="col-sm-5">
							 <input type="file" name="userfile" capture="camera" accept="image/*">
						</div>
					</div>
				</div>
					
				<div class="col-lg-12">				
					<div class="form-group">
						<div class="row" align="center">
							<div style="width:50%;" align="center">
								<button type="submit" id="btnSubmit" name="btnSubmit" class='btn btn-primary'>
									Guardar <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
								</button>
							</div>
						</div>
					</div>
				</div>
		</div>
		</form>
		
		<div class="col-lg-6">	

					<?php if($error){ ?>
					<div class="col-lg-12">
						<div class="alert alert-danger">
						<?php 
							echo "<strong>Error :</strong>";
							pr($error); 
						?><!--$ERROR MUESTRA LOS ERRORES QUE PUEDAN HABER AL SUBIR LA IMAGEN-->
						</div>
					</div>
					<?php } ?>
					
				<div class="col-lg-12">
					<div class="alert alert-danger">
							<strong>Nota :</strong><br>
							Formato permitido: gif - jpg - png<br>
							Tamaño máximo: 3000 KB<br>
							Tamaño mínimo: 2024 pixels<br>
							Peso máximo: 2008 pixels<br>
							
					</div>
				</div>
		</div>

					
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