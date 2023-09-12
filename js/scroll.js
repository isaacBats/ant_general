$(function() {
    Rez2();
	posicionarMenu();
});

$(window).scroll(function() {    
    posicionarMenu();
});

function posicionarMenu() {
    //var altura_del_header = $('.header').outerHeight(true);
    var altura_del_header = 130 + $('#imgText').outerHeight(true);
    //var altura_del_menu = $('.cotizar').outerHeight(true);

    if ($(window).scrollTop() >= altura_del_header){
        $('#cambiante').addClass('fijoTop');
        $('#cambiante').removeClass('cotizar2');
        //$('.wrapper').css('margin-top', (altura_del_menu) + 'px');
    } else {
        $('#cambiante').addClass('cotizar2');
        $('#cambiante').removeClass('fijoTop');
        //$('.wrapper').css('margin-top', '0');
    }
}

$( window ).resize(function() {
    Rez2();
});

//Resize
function Rez2(){
    bodywidth = $(window).width();
    if(bodywidth<=600){
        $('#cambiante').height('110px');
    }else{
        $('#cambiante').height('80px');
    }
}