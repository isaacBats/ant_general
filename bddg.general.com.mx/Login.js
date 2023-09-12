/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function login()
{
    var correo = $("#txtCorreo").val();
    var contrasenia = $("#txtContrasenia").val();
    var data = {correo: correo, contrasenia: contrasenia};
    $.ajax({
        type: "POST",
        url: "rest/log/in",
        data: data,
        async: true
    }).done(
            function (data)
            {
                if (data.idEmpleado != null) {                  
                        var empleado = data;
                        var nombre = empleado.persona.nombre+" "+
                                     empleado.persona.apellidoPaterno+" "+
                                     empleado.persona.apellidoMaterno+" "
                        
                        var tipo = "General"+Math.floor(Math.random() * 100) + 1;


                        Swal.fire({
                            icon: 'success',
                            title: 'Yes!',
                            text: nombre + "--- General",
                            showConfirmButton: false

                        });
                        setTimeout(function(){location.href="inicio.html";},1000)


                        //Nombre de la varialbe de almacenamiento, valor o contenido de la variable
                        //localStorage.getItem("nombre");  //Nombre de la variable que quiero obtener

                        localStorage.setItem("tipo", tipo);
                        localStorage.setItem("id", empleado.idEmpleado);
                        localStorage.setItem("nombre", nombre);
                        


                    
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El usuario o la contraseña son incorrectas, intenta nuevamenta',
                        showConfirmButton: false
                       

                    });


                }
            }
    );

}
