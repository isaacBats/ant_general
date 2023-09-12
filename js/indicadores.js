$(document).ready(function() {
	/*var wow = new WOW(
		{
			boxClass:     'wowInd',      // animated element css class (default is wow)
			animateClass: 'animated', // animation css class (default is animated)
			offset:       0,          // distance to the element when triggering the animation (default is 0)
			mobile:       true,       // trigger animations on mobile devices (default is true)
			live:         true,       // act on asynchronously loaded content (default is true)
			delay:        '1s',       // act on asynchronously loaded content (default is true)
			callback:     function(box) {
				$('.timer').countTo();
			},
			scrollContainer: null // optional scroll container selector, otherwise use window
		}
	);
	wow.init();
*/
	setInterval('contador()',1000);
});


function contador(){
	var cont = $("#timer1").val();
	cont++;
	$("#timer1").val(cont);
	var cont = $("#timer2").val();
	cont++;
	$("#timer2").val(cont);
	var cont = $("#timer3").val();
	cont++;
	$("#timer3").val(cont);
	var cont = $("#timer4").val();
	cont++;
	$("#timer4").val(cont);
}