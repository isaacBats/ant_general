$(function() {
	var _alto = $(window).width();
	$("#contMapa").css('height',_alto * 0.44);
	$("#contMapa2").css('height',_alto * 0.44);
	$("#cambiaMap1").click(function() {
		$("#contMapa").fadeIn();
		$("#contMapa2").fadeOut();
	});
	$("#cambiaMap2").click(function() {
		$("#contMapa").fadeOut();
		$("#contMapa2").fadeIn();
	});
});