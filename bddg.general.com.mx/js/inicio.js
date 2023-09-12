var paginas = [];
function regresarMain()
{
    window.location.href = "inicio.html";
}

function cargarAccesos() {
    $.ajax({
        url: "cotizacion.html",
        context: document.body
    }
    )
            .done(function (data) {
                $("#contenedorMain").html(data);
            });
}

function cargarFacebook() {
    $.ajax({
        url: "listaCotizacion.html",
        context: document.body
    }
    )
            .done(function (data) {
                $("#contenedorMain").html(data);
            });
}






function cargarPagos() {
    $.ajax({
        url: "respuesta.html",
        context: document.body
    }
    )
            .done(function (data) {
                $("#contenedorMain").html(data);
            });
}

function logout() {
    localStorage.setItem("nombre", "");
    localStorage.setItem("tipo","" );
    localStorage.setItem("id", "");
    window.location.href = "index.html";
    
}


