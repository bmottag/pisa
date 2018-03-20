$( document ).ready( function () {

jQuery.validator.addMethod("verificar", function(value, element, param) {
	var campo = $(param).val();
	
	if(campo == 1 && value == ""){
		return false;
	}else{
		return true;
	}
}, "Campo requerido.");

jQuery.validator.addMethod("horahhmm", function(value, element) {
	var res = false;

	// Formato hh:mm
	res = this.optional(element) || /^\d{2}[:]\d{2}$/.test(value);

	var hora = value.split(':');
	var hh = parseInt(hora[0],10);
	var mm = parseInt(hora[1],10);
	if (hh < 0 || hh > 23) res = false;
	if (mm < 0 || mm > 59) res = false;

	return res;
}, "La hora indicada no es válida"
);

	
	$("#nombre").convertirMayuscula();
	$("#cargo").convertirMayuscula();
	$("#observacion").convertirMayuscula();
		
	$( "#form" ).validate( {
		rules: {
			visita:			{ required: true},
			fecha:			{ verificar: "#visita" },
			hora: 			{ maxlength:5, verificar: "#visita", horahhmm: true },
			nombre:			{ verificar: "#visita" },
			cargo:			{ verificar: "#visita" },
			observacion:	{ required: true}
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
					url: base_url + "sitios/save_visita_previa",	
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

							var url = base_url + "sitios";
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