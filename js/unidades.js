$(function() {

    $("a.gal").fancybox({showNavArrows:true});
    
	$('.pagerSlide').each(function () {
		$(this).click(function () {
			var _slide =  $(this).data('slide');
			if(_slide==$('#gal1').data("cycle.opts").slideCount) _slide=0;
			$('#gal2').cycle('goto',_slide);
		});
	});
});