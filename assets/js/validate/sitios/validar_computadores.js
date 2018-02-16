function habilitar(){

	var form = document.getElementById('formMateria');

	if(form.tipoMovimiento.value ==  1){
		document.formMateria.valorUnitario.disabled = false;
		document.formMateria.proveedor.disabled = false;
		document.formMateria.fechaCaducidad.disabled = false;
	}else{
		document.formMateria.valorUnitario.disabled = true;
		document.formMateria.valorUnitario.value = "";
		document.formMateria.proveedor.disabled = true;
		document.formMateria.proveedor.value = "";			
		document.formMateria.fechaCaducidad.disabled = true;
		document.formMateria.fechaCaducidad.value = "";	
	}
}


function validarFrmComputador(){
	var form = document.getElementById('formDiagnostico');
	var ok = 1;

	if(form.identificacion.value == '' && ok == 1){
		alert('Seleccione producto');
		form.identificacion.focus();
		ok = 0;
	}
	
	if(form.adecuado.value == 1 && (form.cpu.value == 2 || form.os.value == 2 || form.memoria.value == 3 || form.resolucion.value == 2 || form.skype.value == 2 || form.transferencia_usb.value == 2 || form. virus_scan.value == 2 || form.unidad_usb.value == 3) && ok == 1){
		alert('Revise las respuestas. El computador NO cumple los requisitos para aplicar PISA');
		form.adecuado.focus();
		ok = 0;
	}
	
	if(form.adecuado.value == 2 && form.cpu.value == 1 && form.os.value == 1 && (form.memoria.value == 1 || form.memoria.value == 2) && form.resolucion.value == 1 && form.skype.value == 1 && form.transferencia_usb.value == 1 && form. virus_scan.value == 1 && (form.unidad_usb.value == 1 || form.unidad_usb.value == 2) && ok == 1){
		alert('Revise las respuestas. El computador cumple los requisitos para aplicar PISA');
		form.adecuado.focus();
		ok = 0;
	}
	
	if(ok == 1){
			//alert(formato)
			form.submit();
	}
}
