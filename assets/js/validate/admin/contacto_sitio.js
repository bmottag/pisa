		$( document ).ready( function () {
			
			$("#nombres").bloquearNumeros().convertirMayuscula().maxlength(50);
			$("#apellidos").bloquearNumeros().convertirMayuscula().maxlength(50);		
			$("#movilNumber").bloquearTexto().maxlength(15);
			$("#cargo").convertirMayuscula();

			$( "#form" ).validate( {
				rules: {
					nombres: 			{ required: true, minlength: 3, maxlength:50 },
					apellidos: 			{ required: true, minlength: 3, maxlength:50 },
					cargo: 				{ required: true, minlength: 3, maxlength:50 },
					telefono:	 		{ minlength: 4, maxlength:15  },
					movilNumber: 		{ required: true, minlength: 4, maxlength:15 },
					email: 				{ required: true, email: true }
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