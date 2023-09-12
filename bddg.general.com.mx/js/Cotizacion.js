validar();
var cotizacion =[];
var cotizacion = [];
var historial = [];

function validar(){
    console.log("Entro");
    if(localStorage.getItem("tipo")!== null ) {
        console.log("No pasa nada");
    }else{
        console.log("Invalido");
   window.location.href = "index.html";
    }
    
}
function guardarPagina() {
    var idPW= $("#txtIdPW").val();
    var canal= $("#txtCanal").val();
    var idCliente= $("#txtIdCliente").val();
    var idEmpleado=localStorage.getItem("id");
    var abreviatura= $("#txtAbreviatura").val();    
    var via= $("#txtVia").val();
    var transporte=$("#txtTransporte").val();
    var origen= $("#txtOrigen").val();
    var destino= $("#txtDestino").val();
    var mercancia= $("#txtMercancia").val();
    var pesoBruto= $("#txtPesoBruto").val();
    var noPaquetes= $("#txtNoPaquetes").val();
    var volumenP= $("#txtVolumenP").val();
    var comentarios= $("#txtComentarios").val();
    var nombreCliente= $("#txtNombreCliente").val();
    var correoCliente= $("#txtCorreoCliente").val();
    var paginaCliente= $("#txtPaginaCliente").val();
    var telefonoCliente= $("#txtTelefonoCliente").val();
    var ubicacionCliente= $("#txtUbicacionCliente").val();
    var empresaCliente= $("#txtEmpresaCliente").val();
    var fechaContacto= $("#txtFechaContacto").val();
    
     if ($("#txtIdPW").val().length > 0)
    {
        idPW = $("#txtIdPW").val();
    }
       $.ajax({
        async: true,
        type: "POST",
        url: "rest/cotizacion/save", 
        data: {
            idPW:idPW,
            abreviatura:abreviatura,
            canal:canal,
            via:via,
            transporte:transporte,
            origen:origen,
            destino:destino,
            mercancia:mercancia,
            pesoBruto:pesoBruto,
            noPaquetes:noPaquetes,
            volumenP:volumenP,
            comentarios:comentarios,
            fechaContacto:fechaContacto,
            idEmpleado:idEmpleado,
            idCliente:idCliente,
            nombreCliente:nombreCliente,
            correoCliente:correoCliente,
            paginaCliente:paginaCliente,
            telefonoCliente:telefonoCliente,
            ubicacionCliente:ubicacionCliente,
            empresaCliente:empresaCliente

        }
    }).done(function (data) {
        if (data.exception != null)
        {
            Swal.fire("La operacion no pudo ser completada",
                    data.exception,
                    "error");
       } else
        {

            $("#txtIdPW").val(data.id);
            Swal.fire("Operacion realizada con exito",
                    "Los datos de la cotizacion fueron guardados correctamente",
                    "success");

            refrescarTablaInicio();
            limpiarCotizacion();
        }
    });
}


function refrescarTablaCliente() {

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
                                '<td>' + cotizacion[i].cliente.idCliente + '</td>' +
                                '<td>' + cotizacion[i].cliente.nombreCliente + '</td>' +
                                '<td>' + cotizacion[i].cliente.correoCliente+ '</td>' +
                                '<td>' + cotizacion[i].cliente.empresaCliente+ '</td>' +
                              
                                '<td style="text-align: right">' + '<div class="btn-group" role="group"><button data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Modificar Cotización" type="button" class="btn btn-primary btn-lg" onclick="Detalle( ' + i + ');"><i class="icon ion-md-create mr-4"></i></button>\n\
\n\                                  </button></div>'
                        + '</td>' +
                        '<tr>';
                    }
            $("#tableMain").html(contenido);
        }
    });
    
    
}

function seleccionarCliente(i)
{
//Se asigna el objeto empleado seleccionado a la estructura de venta que se va a generar
    var c = cotizacion[i];
//Se obtiene el valor del empleado y se asigna al elemento visual
    $("#txtIdPW").val(c.idPW);
    $("#txtIdEmpleado").val(c.cliente.idEmpleado);
    $("#txtIdCliente").val(c.cliente.idCliente);
    $("#txtNombreCliente").val(c.cliente.nombreCliente);
    $("#txtCorreoCliente").val(c.cliente.correoCliente);
    $("#txtPaginaCliente").val(c.cliente.paginaCliente);
    $("#txtTelefonoCliente").val(c.cliente.telefonoCliente);
    $("#txtUbicacionCliente").val(c.cliente.ubicacionCliente);
    $("#txtEmpresaCliente").val(c.cliente.empresaCliente);

}


function limpiarCotizacion()
{
    $("#txtCanal").val("");
    $("#txtAbreviatura").val("");
    $("#txtVia").val("");    
    $("#txtTransporte").val("");
    $("#txtDestino").val("");
    $("#txtDestino").val("");
    $("#txtMercancia").val("");
    $("#txtPesoBruto").val("");
    $("#txtNoPaquetes").val("");
    $("#txtVolumenP").val("");
    $("#txtIdEmpleado").val("");
    $("#txtIdCliente").val("");
    $("#txtNombreCliente").val("");
    $("#txtCorreoCliente").val("");
    $("#txtPaginaCliente").val("");
    $("#txtTelefonoCliente").val("");
    $("#txtUbicacionCliente").val("");
    $("#txtEmpresaCliente").val("");
    $("#txtFechaContacto").val("");

}





function Detalle(i)
{
//Se asigna el objeto empleado seleccionado a la estructura de venta que se va a generar
    var e = cotizacion[i];
//Se obtiene el valor del empleado y se asigna al elemento visual
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







function search()
{
    var contenido = '';
    var busqueda1 = document.getElementById("txtPalabra").value;
    var data = {filtro : busqueda1};
 
    $.ajax({
        type: "GET",
        url: "rest/cotizacion/search",
        data: data,
        async: true
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
           cotizacion = data;

                    //Recorremos el arreglo JSON para ir generando el
                    //contenido de la tabla:
                    for (var i = 0; i < cotizacion.length; i++)
                    {
                        contenido = contenido + '<tr>' +
                                '<td>' + (i + 1) + '</td>'+
                                '<td>' + cotizacion[i].canal + '</td>' +
                                '<td>' + cotizacion[i].cliente.nombreCliente + '</td>' +
                                '<td>' + cotizacion[i].cliente.correoCliente+ '</td>' +
                                '<td>' + cotizacion[i].cliente.empresaCliente+ '</td>' +                              
                                '<td style="text-align: right">' + '<div class="btn-group" role="group"><button data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Detalle de cotización" type="button" class="btn btn-primary btn-lg" onclick="Lista( ' + i + ');"><i class="icon ion-md-eye mr-4"></i></button>\n\
\n\                                  </button></div>'
                        + '</td>' +
                        '<tr>';
                    }
            $("#tableMain").html(contenido);
        }
    });
    
    
}



function search1()
{
    var contenido = '';
    var busqueda1 = document.getElementById("txtPalabra1").value;
    var data = {filtro : busqueda1};
 
    $.ajax({
        type: "GET",
        url: "rest/cotizacion/search",
        data: data,
        async: true
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
           cotizacion = data;

                    //Recorremos el arreglo JSON para ir generando el
                    //contenido de la tabla:
                    for (var i = 0; i < cotizacion.length; i++)
                    {
                        contenido = contenido + '<tr>' +
                                '<td>' + (i + 1) + '</td>'+
                                '<td>' + cotizacion[i].canal + '</td>' +
                                '<td>' + cotizacion[i].cliente.nombreCliente + '</td>' +
                                '<td>' + cotizacion[i].cliente.correoCliente+ '</td>' +
                                '<td>' + cotizacion[i].cliente.empresaCliente+ '</td>' +                              
                                '<td style="text-align: right">' + '<div class="btn-group" role="group"><button data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Detalle de cotización" type="button" class="btn btn-primary btn-lg" onclick="Lista1( ' + i + ');"><i class="icon ion-md-eye mr-4"></i></button>\n\
\n\                                  </button></div>'
                        + '</td>' +
                        '<tr>';
                    }
            $("#tableMain").html(contenido);
        }
    });
    
    
}

function search2()
{
    var contenido = '';
    var busqueda2 = document.getElementById("txtPalabra2").value;
    var data = {filtro : busqueda2};
 
    $.ajax({
        type: "GET",
        url: "rest/cotizacion/search",
        data: data,
        async: true
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
           cotizacion = data;

                    //Recorremos el arreglo JSON para ir generando el
                    //contenido de la tabla:
                    for (var i = 0; i < cotizacion.length; i++)
                    {
                        contenido = contenido + '<tr>' +
                                '<td>' + (i + 1) + '</td>'+
                                '<td>' + cotizacion[i].canal + '</td>' +
                                '<td>' + cotizacion[i].cliente.nombreCliente + '</td>' +
                                '<td>' + cotizacion[i].cliente.correoCliente+ '</td>' +
                                '<td>' + cotizacion[i].cliente.empresaCliente+ '</td>' +                              
                                '<td style="text-align: right">' + '<div class="btn-group" role="group"><button data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Detalle de cotización" type="button" class="btn btn-primary btn-lg" onclick="Lista2( ' + i + ');"><i class="icon ion-md-eye mr-4"></i></button>\n\
\n\                                  </button></div>'
                        + '</td>' +
                        '<tr>';
                    }
            $("#tableMain").html(contenido);
        }
    });
    
    
}


function search3()
{
    var contenido = '';
    var busqueda3 = document.getElementById("txtPalabra3").value;
    var data = {filtro : busqueda3};
 
    $.ajax({
        type: "GET",
        url: "rest/cotizacion/search",
        data: data,
        async: true
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
           cotizacion = data;

                    //Recorremos el arreglo JSON para ir generando el
                    //contenido de la tabla:
                    for (var i = 0; i < cotizacion.length; i++)
                    {
                        contenido = contenido + '<tr>' +
                                '<td>' + (i + 1) + '</td>'+
                                '<td>' + cotizacion[i].canal + '</td>' +
                                '<td>' + cotizacion[i].cliente.nombreCliente + '</td>' +
                                '<td>' + cotizacion[i].cliente.correoCliente+ '</td>' +
                                '<td>' + cotizacion[i].cliente.empresaCliente+ '</td>' +                              
                                '<td style="text-align: right">' + '<div class="btn-group" role="group"><button data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Detalle de cotización" type="button" class="btn btn-primary btn-lg" onclick="Lista3( ' + i + ');"><i class="icon ion-md-eye mr-4"></i></button>\n\
\n\                                  </button></div>'
                        + '</td>' +
                        '<tr>';
                    }
            $("#tableMain").html(contenido);
        }
    });
    
    
}




function search4()
{
    var contenido = '';
    var busqueda4 = document.getElementById("txtPalabra4").value;
    var data = {filtro : busqueda4};
 
    $.ajax({
        type: "GET",
        url: "rest/cotizacion/search",
        data: data,
        async: true
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
           cotizacion = data;

                    //Recorremos el arreglo JSON para ir generando el
                    //contenido de la tabla:
                    for (var i = 0; i < cotizacion.length; i++)
                    {
                        contenido = contenido + '<tr>' +
                                '<td>' + (i + 1) + '</td>'+
                                '<td>' + cotizacion[i].canal + '</td>' +
                                '<td>' + cotizacion[i].cliente.nombreCliente + '</td>' +
                                 '<td>' + cotizacion[i].cliente.correoCliente+ '</td>' +
                                '<td>' + cotizacion[i].cliente.empresaCliente+ '</td>' +                              
                                '<td style="text-align: right">' + '<div class="btn-group" role="group"><button data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Detalle de cotización" type="button" class="btn btn-primary btn-lg" onclick="Lista4( ' + i + ');"><i class="icon ion-md-eye mr-4"></i></button>\n\
\n\                                  </button></div>'
                        + '</td>' +
                        '<tr>';
                    }
            $("#tableMain").html(contenido);
        }
    });
    
    
}


function search5()
{
    var contenido = '';
    var busqueda5 = document.getElementById("txtPalabra5").value;
    var data = {filtro : busqueda5};
 
    $.ajax({
        type: "GET",
        url: "rest/cotizacion/search",
        data: data,
        async: true
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
           cotizacion = data;

                    //Recorremos el arreglo JSON para ir generando el
                    //contenido de la tabla:
                    for (var i = 0; i < cotizacion.length; i++)
                    {
                        contenido = contenido + '<tr>' +
                                '<td>' + (i + 1) + '</td>'+
                                '<td>' + cotizacion[i].canal + '</td>' +
                                '<td>' + cotizacion[i].cliente.nombreCliente + '</td>' +
                                '<td>' + cotizacion[i].cliente.correoCliente+ '</td>' +
                                '<td>' + cotizacion[i].cliente.empresaCliente+ '</td>' +                              
                                '<td style="text-align: right">' + '<div class="btn-group" role="group"><button data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Detalle de cotización" type="button" class="btn btn-primary btn-lg" onclick="Lista5( ' + i + ');"><i class="icon ion-md-eye mr-4"></i></button>\n\
\n\                                  </button></div>'
                        + '</td>' +
                        '<tr>';
                    }
            $("#tableMain").html(contenido);
        }
    });
    
    
}


function Lista()
{
    var contenido = '';
    var busqueda = document.getElementById("txtPalabra").value;
    var data = {filtro : busqueda};
 
    $.ajax({
        type: "GET",
        url: "rest/cotizacion/historial",
        data: data,
        async: true
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
            $("#listaC").html(contenido);
            return;
        } else
        {
           historial = data;

                    //Recorremos el arreglo JSON para ir generando el
                    //contenido de la tabla:
                    for (var i = 0; i < historial.length; i++)
                    {
                        contenido = contenido + '<tr>' +
                                '<td>' + (i + 1) + '</td>'+
                                '<td>' + historial[i].cliente.nombreCliente + '</td>' +
                                '<td>' + historial[i].cliente.correoCliente+ '</td>' +
                                
                                '<td>' + historial[i].fechaContacto + '</td>' +
                                '<td>' + historial[i].respuesta.estatus+ '</td>' +
                                '<td>' + historial[i].respuesta.observaciones+ '</td>' +   
                                '<td>' + historial[i].respuesta.fechaAtencion+ '</td>' +  
                               
                        + '</td>' +
                        '<tr>';
                    }
            $("#listaC").html(contenido);
        }
    });
    
    
}
function Lista1()
{
    var contenido = '';
    var busqueda1 = document.getElementById("txtPalabra1").value;
    var data = {filtro : busqueda1};
 
    $.ajax({
        type: "GET",
        url: "rest/cotizacion/historial",
        data: data,
        async: true
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
            $("#listaC").html(contenido);
            return;
        } else
        {
           historial = data;

                    //Recorremos el arreglo JSON para ir generando el
                    //contenido de la tabla:
                    for (var i = 0; i < historial.length; i++)
                    {
                        contenido = contenido + '<tr>' +
                                '<td>' + (i + 1) + '</td>'+
                                '<td>' + historial[i].cliente.nombreCliente + '</td>' +
                                '<td>' + historial[i].cliente.correoCliente+ '</td>' +
                                
                                '<td>' + historial[i].fechaContacto + '</td>' +
                                '<td>' + historial[i].respuesta.estatus+ '</td>' +
                                '<td>' + historial[i].respuesta.observaciones+ '</td>' +   
                                '<td>' + historial[i].respuesta.fechaAtencion+ '</td>' +  
                               
                        + '</td>' +
                        '<tr>';
                    }
            $("#listaC").html(contenido);
        }
    });
    
    
}
function Lista2()
{
    var contenido = '';
    var busqueda2 = document.getElementById("txtPalabra2").value;
    var data = {filtro : busqueda2};
 
    $.ajax({
        type: "GET",
        url: "rest/cotizacion/historial",
        data: data,
        async: true
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
            $("#listaC").html(contenido);
            return;
        } else
        {
           historial = data;

                    //Recorremos el arreglo JSON para ir generando el
                    //contenido de la tabla:
                    for (var i = 0; i < historial.length; i++)
                    {
                        contenido = contenido + '<tr>' +
                                '<td>' + (i + 1) + '</td>'+
                                '<td>' + historial[i].cliente.nombreCliente + '</td>' +
                                '<td>' + historial[i].cliente.correoCliente+ '</td>' +
                                
                                '<td>' + historial[i].fechaContacto + '</td>' +
                                '<td>' + historial[i].respuesta.estatus+ '</td>' +
                                '<td>' + historial[i].respuesta.observaciones+ '</td>' +   
                                '<td>' + historial[i].respuesta.fechaAtencion+ '</td>' +  
                               
                        + '</td>' +
                        '<tr>';
                    }
            $("#listaC").html(contenido);
        }
    });
    
    
}
function Lista3()
{
    var contenido = '';
    var busqueda3 = document.getElementById("txtPalabra3").value;
    var data = {filtro : busqueda3};
 
    $.ajax({
        type: "GET",
        url: "rest/cotizacion/historial",
        data: data,
        async: true
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
            $("#listaC").html(contenido);
            return;
        } else
        {
           historial = data;

                    //Recorremos el arreglo JSON para ir generando el
                    //contenido de la tabla:
                    for (var i = 0; i < historial.length; i++)
                    {
                        contenido = contenido + '<tr>' +
                                '<td>' + (i + 1) + '</td>'+
                                '<td>' + historial[i].cliente.nombreCliente + '</td>' +
                                '<td>' + historial[i].cliente.correoCliente+ '</td>' +
                                
                                '<td>' + historial[i].fechaContacto + '</td>' +
                                '<td>' + historial[i].respuesta.estatus+ '</td>' +
                                '<td>' + historial[i].respuesta.observaciones+ '</td>' +   
                                '<td>' + historial[i].respuesta.fechaAtencion+ '</td>' +  
                               
                        + '</td>' +
                        '<tr>';
                    }
            $("#listaC").html(contenido);
        }
    });
    
    
}
function Lista4()
{
    var contenido = '';
    var busqueda4 = document.getElementById("txtPalabra4").value;
    var data = {filtro : busqueda4};
 
    $.ajax({
        type: "GET",
        url: "rest/cotizacion/historial",
        data: data,
        async: true
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
            $("#listaC").html(contenido);
            return;
        } else
        {
           historial = data;

                    //Recorremos el arreglo JSON para ir generando el
                    //contenido de la tabla:
                    for (var i = 0; i < historial.length; i++)
                    {
                        contenido = contenido + '<tr>' +
                                '<td>' + (i + 1) + '</td>'+
                                '<td>' + historial[i].cliente.nombreCliente + '</td>' +
                                '<td>' + historial[i].cliente.correoCliente+ '</td>' +
                                
                                '<td>' + historial[i].fechaContacto + '</td>' +
                                '<td>' + historial[i].respuesta.estatus+ '</td>' +
                                '<td>' + historial[i].respuesta.observaciones+ '</td>' +   
                                '<td>' + historial[i].respuesta.fechaAtencion+ '</td>' +  
                               
                        + '</td>' +
                        '<tr>';
                    }
            $("#listaC").html(contenido);
        }
    });
    
    
}
function Lista5()
{
    var contenido = '';
    var busqueda5 = document.getElementById("txtPalabra5").value;
    var data = {filtro : busqueda5};
 
    $.ajax({
        type: "GET",
        url: "rest/cotizacion/historial",
        data: data,
        async: true
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
            $("#listaC").html(contenido);
            return;
        } else
        {
           historial = data;

                    //Recorremos el arreglo JSON para ir generando el
                    //contenido de la tabla:
                    for (var i = 0; i < historial.length; i++)
                    {
                        contenido = contenido + '<tr>' +
                                '<td>' + (i + 1) + '</td>'+
                                '<td>' + historial[i].cliente.nombreCliente + '</td>' +
                                '<td>' + historial[i].cliente.correoCliente+ '</td>' +
                                
                                '<td>' + historial[i].fechaContacto + '</td>' +
                                '<td>' + historial[i].respuesta.estatus+ '</td>' +
                                '<td>' + historial[i].respuesta.observaciones+ '</td>' +   
                                '<td>' + historial[i].respuesta.fechaAtencion+ '</td>' +  
                               
                        + '</td>' +
                        '<tr>';
                    }
            $("#listaC").html(contenido);
        }
    });
    
    
}




$.validator.setDefaults({
    submitHandler: function () {

        guardarPagina();
      
    }
});


$(document).ready(function () {
    $('#formCoti').validate({
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
            txtUbicacionCliente:{required:true,number:true},
            txtEmpresaCliente:{required: true},
            txtFechaContacto:{required:true},
          
            
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
    txtUbicacionCliente:"Por favor ingresa su número de WA",
    txtEmpresaCliente: "Por favor ingrese la empresa",
    txtFechaContacto: "Por favor ingrese la fecha de contacto",
  
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


