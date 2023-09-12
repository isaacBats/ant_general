
function sendAtencion1(){
    console.log('1');
	var response = grecaptcha.getResponse(0);

    if(response.length == 0){
    	swal({
				title: 	"Alerta!", 
				text: 	"Verifica el captcha", 
				type: 	"warning"
			});
    } else {
    	$("#frmAtencion1").submit();
    }

   	
}

function sendAtencion2(){
    console.log('2');
	var response2 = grecaptcha.getResponse(1);

    if(response2.length == 0){
    	swal({
				title: 	"Alerta!", 
				text: 	"Verifica el captcha", 
				type: 	"warning"
			});
    } else {
    	$("#frmAtencion2").submit();
    }

   	
}

var CaptchaCallback = function() {
        grecaptcha.render('frmTel', {'sitekey' : '6LcHrpUUAAAAAFvFNanBTdCWRyCbTkXx4JAN1Qvu'});
        grecaptcha.render('frmMail', {'sitekey' : '6LcHrpUUAAAAAFvFNanBTdCWRyCbTkXx4JAN1Qvu'});
};