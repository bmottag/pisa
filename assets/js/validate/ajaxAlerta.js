/**
 * Muchipio por Departamento
 * @since  12/5/2017
 */

$(document).ready(function () {
	    
    $('#sesion').change(function () {
        $('#sesion option:selected').each(function () {
            var sesion = $('#sesion').val();
            if (sesion > 0 || sesion != '-') {
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'report/alertaList',
                    data: {'identificador': sesion},
                    cache: false,
                    success: function (data)
                    {
                        $('#alerta').html(data);
                    }
                });
            } else {
                var data = '';
                $('#alerta').html(data);
            }
        });
    });
    
});