/**
 * Muchipio por Departamento
 * @since  12/5/2017
 */

$(document).ready(function () {
	    
    $('#consecutivo').blur(function () {

            var consecutivo = $('#consecutivo').val();
			var idMunicipio = $('#hddIdMunicipio').val();
			var codigoDane = $('#hddCodigoDane').val();
			
            if (consecutivo > 0 || consecutivo != '') {
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'novedades/busquedaList/1',
                    data: {'consecutivo': consecutivo, 'idMunicipio': idMunicipio, 'codigoDane': codigoDane},
                    cache: false,
                    success: function (data)
                    {
                        $('#busqueda_1').html(data);
                    }
                });
				
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'novedades/busquedaList/2',
                    data: {'consecutivo': consecutivo, 'idMunicipio': idMunicipio, 'codigoDane': codigoDane},
                    cache: false,
                    success: function (data)
                    {
                        $('#busqueda_2').html(data);
                    }
                });
            } else {
                var data = '';
                $('#busqueda_1').html(data);
				$('#busqueda_2').html(data);
            }

    });
	
    
});