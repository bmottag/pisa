/**
 * Salones por bloques
 * @since  14/12/2017
 */

$(document).ready(function () {
	    
    $('#bloques').change(function () {
        $('#bloques option:selected').each(function () {
            var bloques = $('#bloques').val();
            if (bloques > 0 || bloques != '-') {
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'sitios/salonesList',
                    data: {'identificador': bloques},
                    cache: false,
                    success: function (data)
                    {
                        $('#salones').html(data);
                    }
                });
            } else {
                var data = '';
                $('#salones').html(data);
            }
        });
    });
	
	
    $('#depto').change(function () {
        $('#depto option:selected').each(function () {
            var depto = $('#depto').val();
			var mcpio = $('#mcpio').val();
            if (depto > 0 || depto != '-') {
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'admin/mcpioList',
                    data: {'identificador': depto},
                    cache: false,
                    success: function (data)
                    {
                        $('#mcpio').html(data);
                    }
                });
				
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'sitios/sitioList',
                    data: {'depto': depto, 'mcpio': mcpio},
                    cache: false,
                    success: function (data)
                    {
                        $('#sitios').html(data);
                    }
                });
				
            } else {
                var data = '';
                $('#sitios').html(data);
            }
        });
    });
	
    $('#mcpio').change(function () {
        $('#mcpio option:selected').each(function () {
            var depto = $('#depto').val();
			var mcpio = $('#mcpio').val();
            if (depto > 0 || depto != '-') {		
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'sitios/sitioList',
                    data: {'depto': depto, 'mcpio': mcpio},
                    cache: false,
                    success: function (data)
                    {
                        $('#sitios').html(data);
                    }
                });
				
            } else {
                var data = '';
                $('#sitios').html(data);
            }
        });
    });
	
	
    
});