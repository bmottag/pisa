$( document ).ready( function () {
	
	$("#nombreSitio").convertirMayuscula();
	$("#celular").bloquearTexto().maxlength(12);
	$("#ext_telefono").bloquearTexto().maxlength(10);
	$("#ext_fax").bloquearTexto().maxlength(10);
	$("#capacidad").bloquearTexto().maxlength(10);
	$("#calificacion").bloquearTexto().maxlength(3);
	$("#barrioSitio").convertirMayuscula();
	$("#direccion").convertirMayuscula();
	$("#observacion").convertirMayuscula();
	
	$( "#form" ).validate( {
		rules: {
			nombreSitio:		{ required: true, minlength: 3, maxlength:120 },
			barrioSitio:		{ required: true, minlength: 3, maxlength:50 },
			direccion:			{ required: true, minlength: 3, maxlength:80 },
			codigoPostal:		{ minlength: 3, maxlength:10 },
			telefono:			{ required: true, minlength: 3, maxlength:15 },
			ext_telefono:		{ number: true, maxlength:10 },
			fax:				{ minlength: 3, maxlength:10 },
			ext_fax:			{ number: true, maxlength:10 },
			celular:			{ required: true, number: true, minlength: 3, maxlength:10 },
			email: 				{ required: true, email: true },
			region:				{ required: true },
			pais:				{ required: true },
			depto:				{ required: true },
			mcpio:				{ required: true },
			codigoDane:			{ required: true, minlength: 2, maxlength:20 },
			discapacitados:		{ required: true },
			capacidad:			{ required: true, number: true, minlength: 1, maxlength:10 },
			calificacion:		{ required: true, maxlength:3 },
			etiqueta:			{ required: true }
			
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			// Add the `help-block` class to the error element
			error.addClass( "help-block" );
			error.insertAfter( element );

		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-sm-6" ).addClass( "has-error" ).removeClass( "has-success" );
		},
		unhighlight: function (element, errorClass, validClass) {
			$( element ).parents( ".col-sm-6" ).addClass( "has-success" ).removeClass( "has-error" );
		},
		submitHandler: function (form) {
			return true;
		}
	});
	
	$("#btnSubmit").click(function(){		
	
		if ($("#form").valid() == true){
		
				//Activa icono guardando
				$('#btnSubmit').attr('disabled','-1');
				$("#div_error").css("display", "none");
				$("#div_load").css("display", "inline");
			
				$.ajax({
					type: "POST",	
					url: base_url + "sitios/save_sitio",	
					data: $("#form").serialize(),
					dataType: "json",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
                                            
						if( data.result == "error" )
						{						
								$("#div_load").css("display", "none");
								$("#div_error").css("display", "inline");
								$("#span_msj").html(data.mensaje);
								$('#btnSubmit').removeAttr('disabled');
								alert(data.mensaje);
								return false;							
						} 

						if( data.result )//true
						{	                                                        
							$("#div_load").css("display", "none");
							$('#btnSubmit').removeAttr('disabled');

							var url = base_url + "sitios/sitio/" + data.idRecord;
							$(location).attr("href", url);
						}
						else
						{
							alert('Error. Reload the web page.');
							$("#div_load").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnSubmit').removeAttr('disabled');
						}	
					},
					error: function(result) {
						alert('Error. Reload the web page.');
						$("#div_load").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnSubmit').removeAttr('disabled');
					}
					
		
				});	
		
		}//if			
	});
});