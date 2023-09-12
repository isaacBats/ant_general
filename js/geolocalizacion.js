function obtener(){navigator.geolocation.getCurrentPosition(mostrar, gestionarErrores);}

function mostrar(posicion){
	/*var ubicacion=document.getElementById('localizacion');
	var datos='';
	datos+='Latitud: '+posicion.coords.latitude+'<br>';
	datos+='Longitud: '+posicion.coords.longitude+'<br>';
	datos+='Exactitud: '+posicion.coords.accuracy+' metros.<br>';*/
	//ubicacion.innerHTML=datos;

	var geocoder = new google.maps.Geocoder;
	var latlng = {lat: posicion.coords.latitude, lng: posicion.coords.longitude};
	geocoder.geocode({'location': latlng}, function(results, status) {
		var cad = results[1].formatted_address.split(',');
		cad=cad.reverse();
		cad=cad[2]||cad[1]||cad[0];
		//var destinos = ['guadalajara'];
		//var titulo = "De "+ cad;
		//if(destinos.indexOf(cad)!=-1)
		$('#destino').html(cad);
		//console.log(cad);
	});
}
 
function gestionarErrores(error){
	alert('Error: '+error.code+' '+error.message+ '\n\nPor favor compruebe que está conectado '+
'a internet y habilite la opción permitir compartir ubicación física');
}

window.addEventListener('load', obtener, false);