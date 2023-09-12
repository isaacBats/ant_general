$(".btnVerMas2019").prop('disabled', true);
$(".btnVerMas2019").addClass('disa');

required = function(fields) {
    var valid = true;
    fields.each(function () { // iterate all
        var $this = $(this);
        //console.log(grecaptcha.getResponse());
        //console.log($this.prop("id"));
        if (($this.is(':checkbox') && !$this.is(":checked")) || // checkbox
            (($this.is(':text') || $this.is('textarea')) && !$this.val()) || // text and textarea
            ($this.is(':radio') && !$('input[name='+ $this.attr("name") +']:checked').length)) { // radio
            valid = false;
        }
    });
    return valid;
}

validateRealTime = function () {
    var fields = $("#nombre, #telefono, #correo, #empresa, #pais, #caja1, #caja2, #caja3, #checkAcom"); // select required
    fields.on('keyup change keypress blur', function () {
        if (required(fields)) {
            //{subnewtopic.disabled = false}  action if all valid
            $(".btnVerMas2019").prop('disabled', false);
        	$(".btnVerMas2019").removeClass('disa');
        } else {
            //{subnewtopic.disabled = true}  action if not valid
            $(".btnVerMas2019").prop('disabled', true);
        	$(".btnVerMas2019").addClass('disa');
        }
    });
}

validateRealTime();


function sendForm(){
	if($("#nombre").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo "+$("#nombre").data("ph")+" es obligatorio", 
			type: 	"warning"
		});
        return false;
    }
	if($("#correo").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo "+$("#correo").data("ph")+" es obligatorio", 
			type: 	"warning"
		});
        return false;
    }
	if($("#telefono").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo "+$("#telefono").data("ph")+" es obligatorio", 
			type: 	"warning"
		});
        return false;
    }
	if($("#empresa").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo "+$("#empresa").data("ph")+" es obligatorio", 
			type: 	"warning"
		});
        return false;
    }
	if($("#caja1").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo "+$("#caja1").data("ph")+" es obligatorio", 
			type: 	"warning"
		});
        return false;
    }
	if($("#caja2").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo "+$("#caja2").data("ph")+" es obligatorio", 
			type: 	"warning"
		});
        return false;
    }
	if($("#caja3").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo "+$("#caja3").data("ph")+" es obligatorio", 
			type: 	"warning"
		});
        return false;
    }
	/*if($("#caja4").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo "+$("#caja4").data("ph")+" es obligatorio", 
			type: 	"warning"
		});
        return false;
    }*/
	if(!$('#checkAcom').is(':checked')) {
        swal({
			title: 	"Error!", 
			text: 	"Selecciona "+$("#checkAcom").data("ph"), 
			type: 	"warning"
		});
        return false;
    }

   	$("#frmGen").submit();

}

function setTrans(){
	console.log($("#via").val());
	if($("#via").val()=='Aéreo')
		_opc='<option value="">Tipo de transporte</option><option value="Aéreo">Aéreo</option>';
	if($("#via").val()=='Marítimo')
		_opc='<option value="">Tipo de transporte</option><option value="Carga Consolidada (LCL)">Carga Consolidada (LCL)</option><option value="Contenedor Completo (FCL)">Contenedor Completo (FCL)</option>';
	if($("#via").val()=='Terrestre')
		_opc='<option value="">Tipo de transporte</option><option value="Carga Consolidada (LTL)">Carga Consolidada (LTL)</option><option value="Camión Completo (FTL)">Camión Completo (FTL)</option>';
	$("#transporte").html(_opc);
}
