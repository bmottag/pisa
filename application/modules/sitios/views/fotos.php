<script type="text/javascript" src="<?php echo base_url("assets/js/general/say-cheese.js"); ?>"></script>

<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<a class="btn btn-info btn-xs" href=" <?php echo base_url().'sitios'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-photo"></i> <strong>Fotos</strong>
				</div>
				<div class="panel-body">
					
					<div class="col-lg-6">	
						<div class="alert alert-info">
							<strong>Sitio: </strong><?php echo $infoSitio[0]['nombre_sitio']; ?><br>
							<strong>Código DANE: </strong><?php echo $infoSitio[0]['codigo_dane']; ?>
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
	
	<div class="row">
		<div class="col-lg-12">				
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Tomar foto</strong>
				</div>
				<div class="panel-body">
				
				<div class="row">
					<div class="col-lg-4">	
						<div id="webcam">
						</div>
					</div>
					
					<div class="col-lg-4">	
						<div id="say-cheese-snapshot">
						</div>					
					</div>
					
					<div class="col-lg-4">	
						<img id="fotoGuardada" src="" style="display:none" />					
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group text-left">
							<label class="control-label" for="descripcion1">Descripción</label>
							<select name="descripcion1" id="descripcion1" class="form-control" required>
								<option value=''>Seleccione...</option>
								<option value=4>Baños</option>
								<option value=1>Fachada</option>
								<option value=2>Salones</option>
								<option value=3>Techo</option>
							</select>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-4">	
						<button type="button" class="btn btn-success btn-block" id="obturador">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tomar foto
						</button>
					</div>
					
					<div class="col-lg-4">	
						<button type="button" class="btn btn-success btn-block" id="guardarFoto">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Guardar foto
						</button>					
					</div>
				</div>

				</div>
			</div>
		</div>
	</div>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong>Subir foto</strong>
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

		<form  name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url("sitios/do_upload_fotos"); ?>">
		<input type="hidden" id="hddIdSitio" name="hddIdSitio" value="<?php echo $idSitio; ?>"/>
		
		<div class="col-lg-6">	
				<div class="form-group">
					<label class="col-sm-4 control-label" for="descripcion">Descripción: *</label>
					<div class="col-sm-5">
						<select name="descripcion" id="descripcion" class="form-control" required>
							<option value=''>Seleccione...</option>
								<option value=4>Baños</option>
								<option value=1>Fachada</option>
								<option value=2>Salones</option>
								<option value=3>Techo</option>
						</select>
					</div>
				</div>
				
				<div class="col-lg-12">				
					<div class="form-group">					
						<label class="col-sm-4 control-label" for="hddTask">Adjuntar imagen</label>
						<div class="col-sm-5">
							 <input type="file" name="userfile" />
						</div>
					</div>
				</div>
					
				<div class="col-lg-12">				
					<div class="form-group">
						<div class="row" align="center">
							<div style="width:50%;" align="center">
								<button type="submit" id="btnSubmit" name="btnSubmit" class='btn btn-primary'>
										Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
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
	
<?php if($fotos){ ?>	
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>Fotos cargadas</strong>
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<div class="table-responsive">
						
							<table width="100%" class="table table-striped table-hover">

							

						<tr class="dafault">
							<td><p class="text-center"><strong>Descripción</strong></p></td>
							<td><p class="text-center"><strong>Fecha</strong></p></td>
							<td><p class="text-center"><strong>Foto</strong></p></td>
							<td><p class="text-center"><strong>Eliminar</strong></p></td>
						</tr>						
						<?php
							foreach ($fotos as $data):
								echo "<tr>";					
								echo "<td>";
								switch ($data['descripcion_foto']) {
									case 1:
											echo "Fachada";
											break;
									case 2:
											echo "Salones";
											break;
									case 3:
											echo "Techo";
											break;
									case 4:
											echo "Baños";
											break;
								}								
								echo "</td>";
								echo "<td>" . $data['fecha_foto'] . "</td>";
								echo "<td class='text-center'><center>";
								
						//si hay una foto la muestro
						if($data["foto_dispositivo"]){
						?>
<img src="<?php echo $data["foto_dispositivo"]; ?>" class="img-rounded" width="42" height="42" />
						
						<?php }elseif($data["foto_sitio"]){ ?>
<img src="<?php echo base_url($data["foto_sitio"]); ?>" class="img-rounded" width="42" height="42" />
						<?php }


								echo "</center></td>";
								echo "<td class='text-center'><small>";
						?>
							<center>
							<a class='btn btn-danger btn-xs' href='<?php echo base_url('sitios/deleteFoto/' . $data['id_sitio_foto'] . '/' . $data['fk_id_sitio']) ?>' id="btn-delete">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>  Delete
							</a>
							</center>
						<?php
								echo "</small></td>";                     
								echo "</tr>";
							endforeach;
						?>
					</table>
							
						</div>
					</div>
				</div>
			</div>

		</div>	
<?php } ?>
	
	
</div>
<!-- /#page-wrapper -->

<script>
	var img=null;
					
	var sayCheese = new SayCheese('#webcam', { 
					snapshots: true,
					width: 220,
					height: 140
	});
	
	sayCheese.start();
	
	$('#obturador').bind('click', function(e){
		sayCheese.takeSnapshot(220,140);
		return false;
	})
	
	sayCheese.on('snapshot', function(snapshot) {
		// do something with the snapshot
		img = document.createElement('img');
		
		$(img).on('load', function(){
			$('#say-cheese-snapshot').html(img);
		});
		img.src = snapshot.toDataURL('images/png');
	});
	
	$('#guardarFoto').bind('click', function(){
		var src = img.src;
		
		data = {
			src: src,
			hddIdSitio: "<?php echo $idSitio; ?>",
			descripcion: $('#descripcion1').val()
		}

		$.ajax({
			url: '<?php echo base_url() ?>sitios/ajax',
			data: data,
			type: 'post',
			success: function(respuesta){
					$('#fotoGuardada').attr('src', respuesta).show(300);
			}
		});
	});
</script>