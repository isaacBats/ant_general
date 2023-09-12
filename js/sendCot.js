$(".btnVerMas2019").prop('disabled', true);
$(".btnVerMas2019").addClass('disa');

required = function(fields) {
    var valid = true;
    fields.each(function () { // iterate all
        var $this = $(this);
        console.log(grecaptcha.getResponse());
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
    var fields = $("#via, #transporte, #origen, #destino, #fecha, #mercancia"); // select required
    fields.on('keyup change keypress blur', function () {
        if (required(fields)) {
            //{subnewtopic.disabled = false}  action if all valid
            $("#btn1").prop('disabled', false);
        	$("#btn1").removeClass('disa');
        } else {
            //{subnewtopic.disabled = true}  action if not valid
            $("#btn1").prop('disabled', true);
        	$("#btn1").addClass('disa');
        }
    });
}

validateRealTime();

validateRealTime2 = function () {
    var fields = $("#nombre, #telefono, #correo, #empresa, #sitioweb, #pais"); // select required
    fields.on('keyup change keypress blur', function () {
        if (required(fields)) {
            //{subnewtopic.disabled = false}  action if all valid
            $("#btn2").prop('disabled', false);
        	$("#btn2").removeClass('disa');
        } else {
            //{subnewtopic.disabled = true}  action if not valid
            $("#btn2").prop('disabled', true);
        	$("#btn2").addClass('disa');
        }
    });
}

validateRealTime3 = function () {
    var fields = $("#caja1, #caja2, #caja3, #caja4"); // select required
    fields.on('keyup change keypress blur', function () {
        if (required(fields)) {
            //{subnewtopic.disabled = false}  action if all valid
            $("#btn3").prop('disabled', false);
        	$("#btn3").removeClass('disa');
        } else {
            //{subnewtopic.disabled = true}  action if not valid
            $("#btn3").prop('disabled', true);
        	$("#btn3").addClass('disa');
        }
    });
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

function setTransEng(){
	console.log($("#via").val());
	if($("#via").val()=='Air')
		_opc='<option value="">Type</option><option value="Air Freight">Air Freight</option>';
	if($("#via").val()=='Water')
		_opc='<option value="">Type</option><option value="LCL (less than a container load)">LCL (less than a container load)</option><option value="FCL (full container load) ">FCL (full container load) </option>';
	if($("#via").val()=='Land')
		_opc='<option value="">Type</option><option value="LTL (less than truckload)">LTL (less than truckload)</option><option value="FTL (full truck load)">FTL (full truck load)</option>';
	$("#transporte").html(_opc);
}

function paso1(){

	if($("#via").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo vía es obligatorio", 
			type: 	"warning"
		});
        return false;
    }
	if($("#transporte").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo transporte es obligatorio", 
			type: 	"warning"
		});
        return false;
    }
	if($("#origen").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo origen es obligatorio", 
			type: 	"warning"
		});
        return false;
    }
	if($("#destino").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo destino es obligatorio", 
			type: 	"warning"
		});
        return false;
    }
	if($("#fecha").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo fecha es obligatorio", 
			type: 	"warning"
		});
        return false;
    }
	if($("#mercancia").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo mercancia es obligatorio", 
			type: 	"warning"
		});
        return false;
    }

	/*$("#paso1").slideUp();
	$().slideDown();*/
	//$("#paso2").show();
	$("#paso1").toggle("slide", {direction: "left" }, 500);
	validateRealTime2();
	
}

function paso2(){

	if($("#nombre").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo "+$("#nombre").data("ph")+" es obligatorio", 
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
	if($("#correo").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo "+$("#correo").data("ph")+" es obligatorio", 
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
	if($("#pais").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo "+$("#pais").data("ph")+" es obligatorio", 
			type: 	"warning"
		});
        return false;
    }
	/*$("#paso2").slideUp();
	$("#paso3").slideDown();*/
	$("#paso2").toggle("slide", {direction: "left" }, 500);
	validateRealTime3();
}

function sendForm(){
	
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
	if($("#caja4").val()=='') {
        swal({
			title: 	"Error!", 
			text: 	"El campo "+$("#caja4").data("ph")+" es obligatorio", 
			type: 	"warning"
		});
        return false;
    }
	if(!$('#checkAcom').is(':checked')) {
        swal({
			title: 	"Error!", 
			text: 	"Selecciona "+$("#checkAcom").data("ph"), 
			type: 	"warning"
		});
        return false;
    }

   	$("#frmCont").submit();
}