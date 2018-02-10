		$( document ).ready( function () {

			$( "#form" ).validate( {
				rules: {
					inputPassword: 		{ required: true, minlength: 6, maxlength:12 },
					inputConfirm: 		{ required: true, minlength: 6, maxlength:12, equalTo: "#inputPassword" }
				},
				messages: {
					inputPassword: {
						required: "Ingresar contraseña.",
						minlength: "La contrasela debe tener mínimo 6 caracteres de largo.",
						maxlength: "Ingresar como máximo 12 caracteres."
					},
					inputConfirm: {
						required: "Ingresar contraseña.",
						minlength: "La contrasela debe tener mínimo 6 caracteres de largo.",
						maxlength: "Ingresar como máximo 12 caracteres.",
						equalTo: "Las contraseñas no coinciden."
					}
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );
					error.insertAfter( element );

				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
				},
				unhighlight: function (element, errorClass, validClass) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
				},
				submitHandler: function (form) {
					return true;
				}
			});
			
			$("#btnSubmit").click(function(){		
				if ($("#form").valid() == true){
					var form = document.getElementById('form');
					form.submit();	
				}else
				{
					//alert('Error.');
				}
			});

		});