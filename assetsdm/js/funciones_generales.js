// JavaScript Document
function objeto(id_objeto)
{
	return document.getElementById(id_objeto);
}

function objxmlhttp()
{
	var xmlhttp;
	if(window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	return xmlhttp;
}

function ajax(method,url,async,vars,activarPrecargador,idPrecargador)
{
	var xmlhttp=new objxmlhttp();
	
	
	var date = new Date();
    var timestamp = date.getTime();
	var timestamp = Math.random()
	
	if(activarPrecargador==true)
	{
		var precargador=objeto(idPrecargador);
		$("#"+idPrecargador).fadeIn();
	}
	
	var respuesta;
	
	xmlhttp.onreadystatechange=function()
	{
		if(xmlhttp.readyState>=1 && xmlhttp.readyState<4)
		{
			//precargador.innerHTML='<div class="precargador"><div class="content_precargador"><img src="'+base_url+'img/admin/administrador/imagenPrecargador.gif" /><p style="color:#999;">Cargando...</p></div></div>';
			if(activarPrecargador==true)
			{
				$("#"+idPrecargador).fadeIn('fast');
			}
			
		}
		else
		{
			if(xmlhttp.readyState==4)
            {
				if(xmlhttp.status==200)
				{
					//precargador.innerHTML='';
					if(activarPrecargador==true)
					{
						$("#"+idPrecargador).fadeOut();
					}
				    respuesta=xmlhttp.responseText;
				}
			}
		}
		
	  if(xmlhttp.readyState==4 && xmlhttp.status==200)
	  {
		 respuesta=xmlhttp.responseText; 
	  }
	} 
	xmlhttp.open(method,url+'?time='+timestamp,async);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(vars);
	return String(respuesta);
}




function validar_form_login()
{
	if(objeto('txt_usr').value=='' || objeto('txt_pass').value=='')
	{
		objeto('login_message').innerHTML='Hay campos vacios';
		objeto('login_message').style.color="red";
	}
	else
	{
		var method='POST';
		var url=base_url+NOM_CARPETA_ADMIN+'/inicio/validarUsuario/';
		var async=false;
		var vars='';
		var activarPrecargador=false;
		var idPrecargador='';
		
		var resultados_ajax='';
		
		
		vars='txt_usr='+objeto('txt_usr').value;
		vars+='&txt_pass='+objeto('txt_pass').value;
		
		resultados_ajax=String(ajax(method,url,async,vars,activarPrecargador,idPrecargador));

		
		//alert(resultados_ajax);
		
		switch(resultados_ajax)
		{
			case "valido":
			objeto('form_login').submit();
			break;
			case "no_valido":
			objeto('login_message').innerHTML='Usuario o contraseña no validos';
		    objeto('login_message').style.color="red";
			break;
		}
		
	}
}












<!--
var nav4 = window.Event ? true : false;
function soloNumeros(evt)
{
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57, '.' = 46
var key = nav4 ? evt.which : evt.keyCode;
return (key <= 13 || (key >= 48 && key <= 57) || key == 46);
}
//-->



function select_todos_checkbox(id_form)
{
	for (i=0;i<objeto(id_form).elements.length;i++)
	{ 
      if(objeto(id_form).elements[i].type == "checkbox")
	  {	
         objeto(id_form).elements[i].checked=true; 
	  }
	}
}
function select_ninguno_checkbox(id_form)
{
	for (i=0;i<objeto(id_form).elements.length;i++)
	{ 
      if(objeto(id_form).elements[i].type == "checkbox")
	  {	
         objeto(id_form).elements[i].checked=false; 
	  }
	}
}

/*function eliminarElemento(url)
{
	var confirmar=confirm('Desea eliminar el elemento?');
	
	if(confirmar==true)
	{
		window.location.href=url;
	}
}

function eliminarElementosSeleccionados(id_form,url)
{
	var xmlhttp;
	var array_elements="";
	
	var elements=0;
	
	
	for (i=0;i<objeto(id_form).elements.length;i++)
	{ 
      if(objeto(id_form).elements[i].type == "checkbox")
	  {	
         if(objeto(id_form).elements[i].checked==true)
		 {
			 elements+=1;
		 }
	  }
	}
	
	
	if(elements==0)
	{
		alert('Debe seleccionar al menos un elemento de la lista');
	}
	else
	{
	
	
	if(confirm('Desea eliminar los elementos seleccionados?')==true)
	{
	for (i=0;i<objeto(id_form).elements.length;i++)
	{ 
      if(objeto(id_form).elements[i].type == "checkbox")
	  {	
         if(objeto(id_form).elements[i].checked==true)
		 {
			 array_elements+=objeto(id_form).elements[i].value+".";
		 }
	  }
	}

	
	   window.location.href=url+array_elements;
	   
	}
	
	}
}*/


function confirmEliminarElementosSeleccionadosList(urlEliminar, idForm, classVal,urlActualizarLista,id_pag,id_paginacion,id_content)
{
	var array_elements="";
	var elements=0;
	var accionBtnAceptar='';
	
	
	for (i=0;i<objeto(idForm).elements.length;i++)
	{ 
      if(objeto(idForm).elements[i].type == "checkbox")
	  {	
         if(objeto(idForm).elements[i].checked==true)
		 {
			 if(objeto(idForm).elements[i].className && objeto(idForm).elements[i].className==classVal)
			 {
			    elements+=1;
				array_elements+=objeto(idForm).elements[i].value+".";
			 }
		 }
	  }
	}
	
	if(elements==0)
	{
		abrirAlertBox('Debe seleccionar al menos un elemento de la lista')
	}
	else
	{
		accionBtnAceptar='javascript:cerrarConfirmBox(); eliminarElementosList(\''+urlEliminar+array_elements+'\',\''+urlActualizarLista+'\',\''+id_pag+'\',\''+id_paginacion+'\',\''+id_content+'\')';
	    abrirConfirmBox(accionBtnAceptar, '¿Desea eliminar los elementos seleccionados?');
	}
	
}



function confirmEliminarElementoList(urlEliminar, idForm, classVal,urlActualizarLista,id_pag,id_paginacion,id_content)
{
	var accionBtnAceptar='';
	accionBtnAceptar='javascript:cerrarConfirmBox(); eliminarElementosList(\''+urlEliminar+'\',\''+urlActualizarLista+'\',\''+id_pag+'\',\''+id_paginacion+'\',\''+id_content+'\')';
	abrirConfirmBox(accionBtnAceptar, '¿Desea eliminar este elemento?');
}




function eliminarElementosList(urlEliminarElementos,urlActualizarLista,id_pag,id_paginacion,id_content)
{
	var method='POST';
	var url=urlEliminarElementos;
	var async=false;
	var vars='';
	var activarPrecargador=true;
	var idPrecargador='precargador1';
	var resultados_ajax='';
	
	vars='';
	resultados_ajax=ajax(method,url,async,vars,activarPrecargador,idPrecargador);
	
	
	actualizarLista(urlActualizarLista,id_pag,id_paginacion,id_content);
	
	objeto('alertList').className='styleAlert4';
	objeto('alertList').innerHTML=resultados_ajax;
	$('#alertList').fadeIn();
	
	
}



function abrirAlertBox(msgAlert)
{
	var method='POST';
	var url=base_url+NOM_CARPETA_ADMIN+'/'+nom_controlador_inicio+'/imprimirAlertBox';
	var async=false;
	var vars='';
	var activarPrecargador=true;
	var idPrecargador='precargador1';
	var resultados_ajax='';
	
	vars='msgAlert='+msgAlert;
	resultados_ajax=ajax(method,url,async,vars,activarPrecargador,idPrecargador);
	
	objeto('terceraPantalla').innerHTML=resultados_ajax;
	$('#terceraPantalla').fadeIn('fast',
	   function()
	   {
		   $('#alertBox').animate(
			{height:'30%',width:'30%'},
			'fast',
			'linear',
			   function()
				{
					$('#msgAlert').fadeIn('fast');
					$('#btnsAlert').fadeIn('fast');
				}
			);
	   }
	);
}


function cerrarAlertBox()
{
	$('#alertBox').animate(
	{height:'0px',width:'0px'},
	'fast',
	'linear',
	function()
	    {
		    $('#terceraPantalla').fadeOut('fast',
			   function()
			   {
				   objeto('terceraPantalla').innerHTML='';
			   }
			);
		}
	);
	$('#msgAlert').hide();
	$('#btnsAlert').hide();
}



function abrirConfirmBox(accionBtnAceptar, msgConfirm)
{
	var method='POST';
	var url=base_url+NOM_CARPETA_ADMIN+'/'+nom_controlador_inicio+'/imprimirConfirmBox';
	var async=false;
	var vars='';
	var activarPrecargador=true;
	var idPrecargador='precargador1';
	var resultados_ajax='';
	
	vars='accionBtnAceptar='+accionBtnAceptar;
	vars+='&msgConfirm='+msgConfirm;
	resultados_ajax=ajax(method,url,async,vars,activarPrecargador,idPrecargador);
	
	objeto('terceraPantalla').innerHTML=resultados_ajax;
	$('#terceraPantalla').fadeIn('fast',
	   function()
	   {
		   $('#confirmBox').animate(
			{height:'30%',width:'30%'},
			'fast',
			'linear',
			   function()
				{
					$('#msgConfirm').fadeIn('fast');
					$('#btnsConfirm').fadeIn('fast');
				}
			);
	   }
	);
}



function cerrarConfirmBox()
{
	$('#confirmBox').animate(
	{height:'0px',width:'0px'},
	'fast',
	'linear',
	function()
	    {
		    $('#terceraPantalla').fadeOut('fast',
			   function()
			   {
				   objeto('terceraPantalla').innerHTML='';
			   }
			);
		}
	);
	$('#msgConfirm').hide();
	$('#btnsConfirm').hide();
}





function eliminarMensajeForm(idMsg)
{
	if(objeto(idMsg))
	{
		msg=objeto(idMsg);
		msg.parentNode.removeChild(msg);
	}
}



function tooltip1Effect(idTooltip,action)
{
	switch(action)
	{
		case 1:
		//objeto(idTooltip).style.display='table';
		$("#"+idTooltip).stop(true, true).fadeIn();
		break;
		case 0:
		//objeto(idTooltip).style.display='none';
		$("#"+idTooltip).stop(true, true).fadeOut();
		break;
	}
}



function inicializarPaginacion(urlActualizarLista,id_paginacion,id_content)
{
	var arrayAnchor=objeto(id_paginacion).getElementsByTagName('a');
	var href="";
	for(var i=0;i<arrayAnchor.length;i++)
	{
		href=arrayAnchor[i].href;
		arrayAnchor[i].href='javascript:actualizarLista("'+urlActualizarLista+'","'+href.replace(/\D/g,'')+'","'+id_paginacion+'","'+id_content+'");';
	}
}

function actualizarLista(urlActualizarLista,id_pag,id_paginacion,id_content)
{
	var method='POST';
	var url=urlActualizarLista+id_pag;
	var async=false;
	var vars='';
	var activarPrecargador=true;
	var idPrecargador='precargador1';
	
	var resultados_ajax='';
	vars='';
	resultados_ajax=ajax(method,url,async,vars,activarPrecargador,idPrecargador);
	
	
	$("#"+id_content).hide();
	objeto(id_content).innerHTML=resultados_ajax;
	$("#"+id_content).fadeIn('slow');
	inicializarPaginacion(urlActualizarLista,id_paginacion,id_content);
}



function abrirWindowForm1(urlFrm)
{
	var method='POST';
	var url=urlFrm;
	var async=false;
	var vars='';
	var activarPrecargador=true;
	var idPrecargador='precargador1';
	
	var resultados_ajax='';
	vars='';
	resultados_ajax=ajax(method,url,async,vars,activarPrecargador,idPrecargador);
	objeto('segundaPantalla').innerHTML=resultados_ajax;
	$('#segundaPantalla').fadeIn('fast',
	   function()
	   {
		   $('#windowForm1').animate(
			{height:'90%',width:'90%'},
			'fast',
			'linear',
				function()
				{
					$('.menuFrmDatos').fadeIn('fast');
				}
			);
	   }
	);
	
	ejectScriptsForms();
	
}



function cerrarWindowForm1()
{
	objeto('contentWindowForm1').style.overflow='hidden';
	$('.msg_val').hide();
	$('#windowForm1').animate(
	{height:'0px',width:'0px'},
	'fast',
	'linear',
	function()
	    {
		    $('#segundaPantalla').fadeOut('fast',
			   function()
			   {
				   objeto('segundaPantalla').innerHTML='';
			   }
			);
		}
	);
	$('.menuFrmDatos').hide();
	
}
















//MOVER VENTANAS
// JavaScript Document
function moveWindows()
{
posicion=0;
// IE
if(navigator.userAgent.indexOf("MSIE")>=0) navegador=0;
// Otros
else navegador=1;
}
function evitaEventos(event)
{
// Funcion que evita que se ejecuten eventos adicionales
if(navegador==0)
{
window.event.cancelBubble=true;
window.event.returnValue=false;
}
if(navegador==1) event.preventDefault();
}
function comienzoMovimiento(event, id)
{
elMovimiento=document.getElementById(id);
// Obtengo la posicion del cursor
if(navegador==0)
{
cursorComienzoX=window.event.clientX+document.documentElement.scrollLeft+document.body.scrollLeft;

cursorComienzoY=window.event.clientY+document.documentElement.scrollTop+document.body.scrollTop;
document.attachEvent("onmousemove", enMovimiento);
document.attachEvent("onmouseup", finMovimiento);
}
if(navegador==1)
{ 
cursorComienzoX=event.clientX+window.scrollX;
cursorComienzoY=event.clientY+window.scrollY;
document.addEventListener("mousemove", enMovimiento, true);
document.addEventListener("mouseup", finMovimiento, true);
}
elComienzoX=parseInt(elMovimiento.style.left);
elComienzoY=parseInt(elMovimiento.style.top);
// Actualizo el posicion del elemento
elMovimiento.style.zIndex=++posicion;
evitaEventos(event);
}
function enMovimiento(event)
{
var xActual, yActual;
if(navegador==0)
{
xActual=window.event.clientX+document.documentElement.scrollLeft+document.body.scrollLeft;
yActual=window.event.clientY+document.documentElement.scrollTop+document.body.scrollTop;
} 
if(navegador==1)
{
xActual=event.clientX+window.scrollX;
yActual=event.clientY+window.scrollY;
}
elMovimiento.style.left=(elComienzoX+xActual-cursorComienzoX)+"px";
elMovimiento.style.top=(elComienzoY+yActual-cursorComienzoY)+"px";
evitaEventos(event);
}
function finMovimiento(event)
{
if(navegador==0)
{
document.detachEvent("onmousemove", enMovimiento);
document.detachEvent("onmouseup", finMovimiento);
}
if(navegador==1)
{
document.removeEventListener("mousemove", enMovimiento, true);
document.removeEventListener("mouseup", finMovimiento, true);
}
}

//window.onload=moveWindows();


$(document).ready(function(){
	moveWindows();
	$('#menu1Admin li a').stop(true).hover(function(){
		$(this).parent().find('ul').slideDown().hover(function(){},
			function(){
				$(this).slideUp()
			})
	})
});


//FIN MOVER VENTANAS


