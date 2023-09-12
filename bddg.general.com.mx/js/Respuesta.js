var cotizaciones =new Object();
var respuesta = [];
validar();

function validar(){
    console.log("Entro");
    if(localStorage.getItem("tipo")!== "" ) {
        console.log("No pasa nada");
    }else{
        console.log("Invalido");
   window.location.href = "index.html";
    }
    
}
function guardarRespuesta() {
    var idPW= $("#txtIdPW").val(); 
    var idRespuesta= $("#txtIdRespuesta").val();
    var atencion= $("#txtAtencion").val();
    var estatus= $("#txtEstatus").val();
    var observaciones= $("#txtObservaciones").val();
    var fechaAtencion= $("#txtFechaAtencion").val();
    
    
       $.ajax({
        async: true,
        type: "POST",
        url: "rest/respuesta/save", 
        data: {
            idPW:idPW,
            idRespuesta:idRespuesta,
            atencion:atencion,
            estatus:estatus,
            observaciones:observaciones,
            fechaAtencion:fechaAtencion

        }
    }).done(function (data) {
        if (data.exception != null)
        {
            Swal.fire("La operacion no pudo ser completada",
                    data.exception,
                    "error");
       } else
        {

            $("#txtIdRespuesta").val(data.idRespuesta);
            Swal.fire("Operacion realizada con exito",
                    "Los datos de la respuesta fueron guardados correctamente",
                    "success");

            refrescarTablaInicio();
            limpiarCotizacion();
        }
    });
}

function refrescarTablaClienteR() {

    var contenido = "";
   
    $.ajax({
        type: "GET",
        url: "rest/cotizacion/getAll",
        
    }).done(function (data)
    {
        if (data.exception != null)
        {
            Swal.fire({
                icon: 'error',
                text: 'Error al cargar el contenido',
                timer: 6000
            });
        } else if (data.length < 1)
        {
           contenido = '<tr class="text-center">' +
                    '<td>' +
                    '<span class="text-danger font-weight-bold">' +
                    'Ocurrió un error, comunicarse con el área de desarrollo para resolver el problema' +
                    '</span>' +
                    '</td>' +
                    '</td>';
            $("#tableMain").html(contenido);
        } else
        {
           cotizacion = data;

                    //Recorremos el arreglo JSON para ir generando el
                    //contenido de la tabla:
                    for (var i = 0; i < cotizacion.length; i++)
                    {
                        contenido = contenido + '<tr>' +
                                '<td>' + cotizacion[i].cliente.nombreCliente +'</td>' +
                                '<td>' + cotizacion[i].cliente.correoCliente+ '</td>' +
                                '<td>' + cotizacion[i].cliente.empresaCliente+ '</td>' +
                                '<td>' + cotizacion[i].fechaContacto+ '</td>' +
                              
                                '<td style="text-align: right">' + '<div class="btn-group" role="group"><button data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Modificar respuesta" type="button" class="btn btn-primary btn-lg" onclick="modificarCotizacion( ' + i + ');"><i class="icon ion-md-create mr-4"></i></button>\n\
\n\                                  </button></div>'
                        + '</td>' +
                        '<tr>';
                    }
            $("#tableMain").html(contenido);
        }
    });
    
    
}


function modificarCotizacion(pos)
{
    var e = cotizacion [pos];
    
    $("#txtIdPW").val(e.idPW);
    $("#txtCanal").val(e.canal);
    $("#txtAbreviatura").val(e.abreviatura);    
    $("#txtVia").val(e.via);
    $("#txtTrasporte").val(e.transporte);
    $("#txtOrigen").val(e.origen);
    $("#txtDestino").val(e.destino);
    $("#txtMercancia").val(e.mercancia);
    $("#txtPesoBruto").val(e.pesoBruto);
    $("#txtNoPaquetes").val(e.noPaquetes);
    $("#txtVolumenP").val(e.volumenP);
    $("#txtComentarios").val(e.comentarios);
    $("#txtFechaContacto").val(e.fechaContacto);
    $("#txtNombreCliente").val(e.cliente.nombreCliente);
    $("#txtCorreoCliente").val(e.cliente.correoCliente);
    $("#txtPaginaCliente").val(e.cliente.paginaCliente);
    $("#txtTelefonoCliente").val(e.cliente.telefonoCliente);
    $("#txtUbicacionCliente").val(e.cliente.ubicacionCliente);
    $("#txtEmpresaCliente").val(e.cliente.empresaCliente);
}

function limpiarCotizacion()
{
    $("#txtIdEmpleado").val("");
    $("#txtIdCliente").val("");
    $("#txtNombreCliente").val("");
    $("#txtApellidoPaternoCliente").val("");
    $("#txtApellidoMaternoCliente").val("");
    $("#txtCorreoCliente").val("");
    $("#txtPaginaCliente").val("");
    $("#txtTelefonoCliente").val("");
    $("#txtUbicacionCliente").val("");
    $("#txtEmpresaCliente").val("");

}

$.validator.setDefaults({
    submitHandler: function () {

        guardarRespuesta();
    }
});


$(document).ready(function () {
    $('#formPago').validate({
        rules: {
            txtOrigen: {
                required: true
            },
            txtDestino: {
                required: true
            },
            txtMercancia: {
                required: true}
            ,txtPesoBruto:{
                required:true,
                number: true
            },txtNoPaquetes:{
                
                number:true,
                required:true
            },txtVolumenP:{
                required:true,
                number:true
            },
            txtNombreCliente:{required:true},
            txtApellidoPaternoCliente:{required: true},
            txtCorreoCliente:{required:true, email:true},
            txtPaginaCliente:{required:true},
            txtTelefonoCliente:{required: true, number:true},
            txtUbicacionCliente:{required:true},
            txtEmpresaCliente:{required: true},
            txtFechaContacto:{required:true},
            txtAtencion:{required: true},
            txtFechaAtencion:{required:true}
            
        },
        messages: {
            txtOrigen: "Por favor ingresa el Origen"
           ,
            txtDestino: "Por favor ingresa el Destino",
            txtMercancia: "Por favor ingresa la Mercancia",
            txtPesoBruto:{ required: "Por favor ingresa el Peso",
            number:"Por favor Ingrese solo Numeros"},
            txtNoPaquetes:{ number: "Por favor ingresa solo numeros",
            required:"Por favor ingrese el numero de paquetes"},
            txtVolumenP:{ required: "Por favor ingresa el volumen del paquete",
            number: "Por favor Ingrese solo numeros"},
        txtNombreCliente: "Por favor Ingrese el Nombre",
        txtApellidoPaternoCliente: "Por Favor Ingrese el Apellido Paterno",
        txtCorreoCliente:{
            required: "Por facor Ingresa el Correo Electronico",
            email: "Por favor Ingresa un correo valido"
        },
        txtPaginaCliente: "Por favor Ingrese la Pagina",
        txtTelefonoCliente:{required:"Por favor Ingresa el telefono",
        number:"Por favor Ingresa solo numeros"},
    txtUbicacionCliente:"Por favor ingresa la ubicacion",
    txtEmpresaCliente: "Por favor ingrese la empresa",
    txtFechaContacto: "Por favor ingrese la fecha de contacto",
    txtAtencion: "Por favor ingrese la atencion",
    txtFechaAtencion:"Por favor ingrese la fecha de atencion"
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-10").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-10").addClass("has-success").removeClass("has-error");
        }
    });
});




function valideKey(evt){
    
    // code is the decimal ASCII representation of the pressed key.
    var code = (evt.which) ? evt.which : evt.keyCode;
    
    if(code==8) { // backspace.
      return true;
    } else if(code>=48 && code<=57) { // is a number.
      return true;
    } else{ // other keys.
      return false;
    }
}




function soloLetras(e) {
    var key = e.keyCode || e.which,
      tecla = String.fromCharCode(key).toLowerCase(),
      letras = " áéíóúabcdefghijklmnñopqrstuvwxyz@",
      especiales = [8, 37, 39, 46],
      tecla_especial = false;

    for (var i in especiales) {
      if (key == especiales[i]) {
        tecla_especial = true;
        break;
      }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      return false;
    }
  }
  
  

function soloContraseña(e) {
    var key = e.keyCode || e.which,
      tecla = String.fromCharCode(key).toLowerCase(),
      letras = " áéíóúabcdefghijklmnñopqrstuvwxyz@1234567890!$%&*",
      especiales = [8, 37, 39, 46],
      tecla_especial = false;

    for (var i in especiales) {
      if (key == especiales[i]) {
        tecla_especial = true;
        break;
      }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      return false;
    }
  }





function r(e) {
    var key = e.keyCode || e.which,
      tecla = String.fromCharCode(key).toLowerCase(),
      letras = " abcdefghijklmnñopqrstuvwxyz1234567890",
      especiales = [8, 37, 39, 46],
      tecla_especial = false;

    for (var i in especiales) {
      if (key == especiales[i]) {
        tecla_especial = true;
        break;
      }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      return false;
    }
  }


