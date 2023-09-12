wow = new WOW({
    animateClass: 'wow',
    offset:       200,
	duration:"2s"
  }
);
wow.init();

$(function() {
    //Despliega menu mobil
    $('#menDesp').click(function() {
        if($('#menDesp1').css('display')=='none'){
            $('#menDesp1').css('display','block');
            $("#menDesp1").animate({top: '0px'}, 200);
        }else{
            $("#menDesp1").animate({top: '1000px'}, 200, function() {
                $('#menDesp1').css('display','none');
            });
        }
    });
    $('#menDespC').click(function() {
        if($('#menDesp1').css('display')=='none'){
            $('#menDesp1').css('display','block');
            $("#menDesp1").animate({top: '0px'}, 200);
        }else{
            $("#menDesp1").animate({top: '1000px'}, 200, function() {
                $('#menDesp1').css('display','none');
            });
        }
    });
    Rez();

    jQuery('img.svg').each(function(){
        var $img = jQuery(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');
    
        jQuery.get(imgURL, function(data) {
            // Get the SVG tag, ignore the rest
            var $svg = jQuery(data).find('svg');
    
            // Add replaced image's ID to the new SVG
            if(typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if(typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass+' replaced-svg');
            }
    
            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a');
            
            // Check if the viewport is set, else we gonna set it if we can.
            if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
            }
    
            // Replace image with new SVG
            $img.replaceWith($svg);
    
        }, 'xml');
    
    });

});

$( window ).resize(function() {
    Rez();
});

//Resize
function Rez(){
    bodywidth = $(window).width();
    if(bodywidth<=600){
        $('.cuadro20').css('width','50%');
        $('.cuadro20').last().css('margin-left','25%');
    }else{
        $('.cuadro20').css('width','20%');
        $('.cuadro20').last().css('margin-left','0%');
    }
    
}

$(window).scroll(function() {    
    menuMob();
});

//Menu en mobil
function menuMob() {
    //var altura_del_header = 60 + $('#menDesp1').outerHeight(true);
    var altura_del_header = 400;
    if ($(window).scrollTop() >= altura_del_header){
        $('#menDesp1').addClass('abajoM');
        $('#menDesp1').removeClass('arribaM');
    } else {
        $('#menDesp1').addClass('arribaM');
        $('#menDesp1').removeClass('abajoM');
    }
}