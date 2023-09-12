<?php

$codigohtml =  '<b>nombre=</b>'.$_POST[nombre].'<br>'.
 '<b>Empresa=</b>'.$_POST[empresa].'<br>'.
 '<b>E-mail=</b>'.$_POST[mail].'<br>'.
 '<b>Eel=</b>'.$_POST[tel].'<br>'.
 '<b>Calle=</b>'.$_POST[calle].'<br>'.
 '<b>Ciudad=</b>'.$_POST[ciudad].'<br>'.
 '<b>Estado=</b>'.$_POST[estado].'<br>'.
 '<b>Provincia=</b>'.$_POST[provincia].'<br>'.
 '<b>Industria=</b>'.$_POST[industria].'<br>'.
 '<b>Producto=</b>'.$_POST[producto].'<br>'.
 '<b>Transporte terrestre=</b>'.$_POST[tran_terrestre].'<br>'.
 '<b>Transporte marino=</b>'.$_POST[tran_marino].'<br>'.
 '<b>Transporte aereo=</b>'.$_POST[tran_aereo].'<br>'.
 '<b>Servicio especial=</b>'.$_POST[serv_especial].'<br>'.
 '<b>Recolección=</b>'.$_POST[recoleccion].'<br>'.
 '<b>Proyecto de negocios=</b>'.$_POST[proyecto].'<br>'.
 '<b>Servicio inmediato=</b>'.$_POST[serv_inmediato].'<br>'.
 '<b>Comentarios=</b>'.$_POST[msg].'<br>'.
 '<b>Como se enteró= </b>'.$_POST[txt_9].'<br>'.
 '<b>País= </b>'.$_POST[txt_7].'<br>';

$email = 'jgaytan@generalforwarding.com.mx';
$asunto = 'Mensaje desde la pagina de generalforwarding.com.mx';
$cabeceras = "Content-type: text/html\r\n";
if(isset($_POST[nombre]) and isset($_POST[mail]) and isset($_POST[ciudad])){
mail($email,$asunto,$codigohtml,$cabeceras);

echo "&estatus=ok&";
}

?>