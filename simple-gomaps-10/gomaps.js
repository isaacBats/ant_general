var map;
var marker;
var html;

window.onload = function initialize() {
	
	/**/

	 if (GBrowserIsCompatible()) {
		var pmaps = document.getElementById("pmaps");
		var ptos;	
		map = new GMap2(document.getElementById("map_admin"));

		if(pmaps.value != '') {
			/*	Usamos el split para cortar las cordenadas por la coma	*/
			ptos = pmaps.value.split(',');
			
			/*	Mensaje de edición	*/
			msg = ptos[0]+","+ptos[1]+","+ptos[2];
			
			/*	Instanciamos	*/
			var point = new GLatLng(parseFloat(ptos[0]),parseFloat(ptos[1]));
			
			map.setCenter(point,parseInt(ptos[2]));
			
			/*	Creamos la marca	con draggable: false que indica que la marca NO se puede mover*/
			marker = new GMarker(point, {draggable: true});
			//marker.disableDragging();

			marker.openInfoWindow(msg);
			
			
			/*	Cuando empieza el movimiento, lo unico que hace este es cerrar la ventanita de informacion	*/
			GEvent.addListener(marker, "dragstart", function() { map.closeInfoWindow();});
			/*	Un a vez que acaba el arrastre, este llena las coordenas,	*/

			GEvent.addListener(marker, "dragend", function() {
			/*	Llenamos las coordenadas	*/
				pmaps.value = marker.getLatLng().toUrlValue()+','+map.getZoom();
				marker.openInfoWindow(pmaps.value);
			});
			
			map.addOverlay(marker);
		}
		else {
			/*	Mensjae cuando el punto es nuevo	*/
			/*	Isntanciamos	*/
			var point = new GLatLng(-12.038313,-77.062225);
			
			map.setCenter(point, 10);
			
			/*	Creamos la marca	con draggable: true que indica que la marca se puede mover*/
			marker = new GMarker(point, {draggable: true});
			//marker.openInfoWindow(html);
		}
		
		// insertar los controles
		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());
		map.addControl(new GOverviewMapControl());
		map.enableScrollWheelZoom();
		
		GEvent.addListener(map, "click", function(overlay,point) {
			marker = createMarker(point.lat(),point.lng());
			pmaps.value = marker.getLatLng().toUrlValue()+','+map.getZoom();
			map.addOverlay(marker);
			
			marker.openInfoWindow(pmaps.value);
		});
		

		
		//map.addOverlay(marker);
	}
}

function createMarker(latpoint,lngpoint) {
	var pmaps = document.getElementById("pmaps");
	
	if(marker) map.removeOverlay(marker);
	
	var ppoint = new GLatLng(latpoint,lngpoint);
	var pmarker = new GMarker(ppoint, {draggable: true});

	/*	Cuando empieza el movimiento, lo unico que hace este es cerrar la ventanita de informacion	*/
	GEvent.addListener(pmarker, "dragstart", function() { map.closeInfoWindow();});
	/*	Un a vez que acaba el arrastre, este llena las coordenas,	*/

	GEvent.addListener(pmarker, "dragend", function() {
		/*	Llenamos las coordenadas	*/
		pmaps.value = pmarker.getLatLng().toUrlValue()+','+map.getZoom();
		pmarker.openInfoWindow(pmaps.value);
	});
			
	return pmarker;
}
    