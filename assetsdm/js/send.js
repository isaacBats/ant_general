

$(document).ready(function(){
 $("#frmPM").submit(function(e){
    e.preventDefault();
    $.ajax({
      url: $(this).attr("action"),//action del formulario, ej:
      type: $(this).attr("method"),//el método post o get del formulario
      data: $(this).serialize(),//obtenemos todos los datos del formulario
      success:function(data){
        location.reload();
      }
   });
  });
});

function delPM(_pag){
  return confirm("Deseas eliminar el modulo?");
 /* if(confirm("Deseas eliminar el modulo?")){
    $.ajax({
      url: $(this).attr("action"),//action del formulario, ej:
      type: $(this).attr("method"),//el método post o get del formulario
      data: $(this).serialize(),//obtenemos todos los datos del formulario
      success:function(data){
        location.reload();
      }
    }); 
  }*/
}



/*function sendPM(){
  var base_url = $('body').attr('rel');
  $.ajax({
    type: 'POST',
    data: $('#frmPM').serialize(),
    url: base_url+'GeneralAdm/crud/savePM/',
    success:function(data){
      alert('mando');
    }
 });
};
*/