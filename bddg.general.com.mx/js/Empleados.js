var empleados =[];
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
function guardarEmpleado() {
   var id= $("#txtIdPersona").val();
    var idEmpleado= $("#txtIdEmpleador").val();
    var nombre= $("#txtNombre").val();
    var apellidoPaterno= $("#txtApellidoP").val();
    var apellidoMaterno= $("#txtApellidoM").val();
    var tel=$("#txtTelefono1").val();

    var correo= $("#txtCorreo").val();
    var contrasenia= $("#txtContrasenia").val();
    
     if ($("#txtIdEmpleador").val().length > 0)
    {
        id = $("#txtIdPersona").val();
        idEmpleado = $("#txtIdEmpleador").val();
    }
       $.ajax({
        async: true,
        type: "POST",
        url: "rest/empleado/save", 
        data: {
            id:id,
            idEmpleado:idEmpleado,
            nombre: nombre,
            apellidoPaterno:apellidoPaterno,
            apellidoMaterno:apellidoMaterno,        
            tel:tel,
            contrasenia:contrasenia,
            correo:correo
            

        }
    }).done(function (data) {
        if (data.exception != null)
        {
            Swal.fire("La operacion no pudo ser completada",
                    data.exception,
                    "error");
       } else
        {

            $("#txtIdPersona").val(data.persona.id);
            $("#txtIdEmpleado").val(data.id);
            Swal.fire("Operacion realizada con exito",
                    "Los datos del Empleado fueron guardados correctamente",
                    "success");

            refrescarTablaInicio();
        }
    });
}

function refrescarTablaInicio()
{
    var contenido = '';
    $.ajax({
        type: "GET",
        url: "rest/empleado/getAll"
    }).done(function (data) {
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
            return;
        } else
        {
                empleados = data;

                    //Recorremos el arreglo JSON para ir generando el
                    //contenido de la tabla:
                    for (var i = 0; i < empleados.length; i++)
                    {
                        contenido = contenido + '<tr>' +
                                
                                '<td>' + empleados[i].persona.nombre + " "+ empleados[i].persona.apellidoPaterno +" " + empleados[i].persona.apellidoMaterno  + '</td>' +
                                '<td>' + empleados[i].persona.tel+ '</td>' +
                                '<td>' + empleados[i].correo+ '</td>' +
                                 '<td>' + empleados[i].contrasenia + '</td>' +
                                '<td style="text-align: right">' + '<div class="btn-group" role="group"><button data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Modificar empleado" type="button" class="btn btn-primary btn-lg" onclick="modificarPagina( ' + i + ');"><i class="icon ion-md-create mr-4"></i></button>\n\
\n\                                  </button></div>'
                        + '</td>' +
                        '<tr>';
                    }
            $("#tableMain").html(contenido);
        }
    });
}
function limpiarEmpleado(){
    
      
    $("#txtIdPersona").val(" ");
    $("#txtIdEmpleador").val(" ");
    $("#txtNombre").val(" ");
    $("#txtApellidoP").val(" ");
    $("#txtApellidoM").val(" ");
    $("#txtTelefono1").val(" ");
    $("#txtCorreo").val(" ");
    $("#txtContrasenia").val(" ");
}

function modificarPagina(pos)
{
    var e = empleados [pos];
  
    $("#txtIdPersona").val(e.persona.id);
    $("#txtIdEmpleador").val(e.idEmpleado);
    $("#txtNombre").val(e.persona.nombre);
    $("#txtApellidoP").val(e.persona.apellidoPaterno);
    $("#txtApellidoM").val(e.persona.apellidoMaterno);
    $("#txtTelefono1").val(e.persona.tel);
    $("#txtCorreo").val(e.correo);
    $("#txtContrasenia").val(e.contrasenia);
    refrescarTablaInicio();

}

$.validator.setDefaults({
    submitHandler: function () {

        guardarEmpleado();
      
    }
});

$(document).ready(function () {
    $('#formEmpleado').validate({
        rules: {
            txtNombre: {
                required: true,
                minlength: 5
            },
            txtApellidoP: {
                required: true
            },
            txtApellidoM: {
                required: true}
            ,txtCorreo:{
                required:true,
                email: true
            },txtTelefono1:{
                
                number:true,
                required:true
            },txtContrasenia:{
                required:true
            }
        },
        messages: {
            txtNombre: {
                required: "Por favor ingresa el nombre",
                minlength: "El nombre debe ser de minimo 5 caracteres"
            },
            txtApellidoP: "Por favor ingresa un Apellido Paterno",
            txtApellidoM: "Por favor ingresa un Apellido Materno",
            txtCorreo:{ required: "Por favor ingresa un Correo",
            email:"Por favor Ingrese un correo valido"},
            txtTelefono1:{ number: "Por favor ingresa solo numeros",
            required:"Por favor ingrese un telefono"},
            txtContrasenia: "Por favor ingresa una Contraseña",
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





function rfc(e) {
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


