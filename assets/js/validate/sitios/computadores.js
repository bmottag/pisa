$( document ).ready( function () {
	
	$("#comentarios").convertirMayuscula();
		
	$( "#form" ).validate( {
		rules: {
			identificacion:		{ required: true, maxlength:200 },
			windows_defender:	{ required: true },
			cpu:				{ required: true },
			os:					{ required: true },
			memoria:			{ required: true },
			resolucion:			{ required: true },
			skype:				{ required: true },
			transferencia_usb:	{ required: true },
			virus_scan:			{ required: true },
			unidad_usb:			{ required: true },
			adecuado:			{ required: true }
			
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
					url: base_url + "sitios/save_computadores",	
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
							alert("Por favor subir la foto del computador.");

							var url = base_url + "sitios/computadores_salon" + "/" + data.idRecord;
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