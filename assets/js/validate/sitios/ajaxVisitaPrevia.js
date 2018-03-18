/**
 * Visita previa
 * @since  18/3/2018
 */

$(document).ready(function () {
	
    $('#visita').change(function () {
        $('#visita option:selected').each(function () {
            var visita = $('#visita').val();
			
			if(visita==1){
				$("#div_vista_previa").css("display", "inline");
			}else{
				$("#div_vista_previa").css("display", "none");
				
				document.getElementById("fecha").value = "";
				document.getElementById("hora").value = "";
				document.getElementById("nombre").value = "";
				document.getElementById("cargo").value = "";
			}

        });
    });
    
});