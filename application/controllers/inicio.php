<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Inicio extends CI_Controller {



	/** Desarrollado por: Juan José Villanueva	 */



	public function __construct()

	{

		parent:: __construct ();

		$this->load->model('web_model');

		$this->load->model('esp_model');



		$this->load->library('form_validation');

	}



	public function index()

	{

		$cont['DIR'] = base_url();

		//Posicion

		$pos=$this->web_model->getTable('gen_posicion_banner');

		switch ($pos[0]->horizontal) {

			case 'i':

				$h1='col-md-2 ';

				$h2='col-md-10';

				break;

			case 'c':

				$h1='col-md-3 col-md-offset-2';

				$h2='col-md-7';

				break;

			case 'd':

				$h1='col-md-2 col-md-offset-5';

				$h2='col-md-5';

				break;

		}

		switch ($pos[0]->vertical) {

			case 'u':

				$top='top:2%;';

				break;

			case 'm':

				$top='top:40%;';

				break;

			case 'd':

				$top='top:76%;';

				break;

		}

		$cont['FRASES']='

		<div class="letras" style="'.$top.'">

			<div class="container">

				<div class="row">

					<div class="'.$h1.' tar visible-md visible-lg">

						<img src="'.base_url().'img/logo_general.png" alt="General logotipo">

					</div>

					<div class="'.$h2.' visible-md visible-lg">

						<div class="cambiante">es</div>

						<div class="ancho typed"></div>

						<span id="typed-cursor"></span>

					</div>

				</div>

			</div>

		</div>';



		//Banners

		$ban=$this->web_model->getTable('gen_banner_home');

		$cont['BANNER_HOME']='';

		$cont['BANNER_HOMEM']='';

		foreach ($ban as $b) {

			$cont['BANNER_HOME'].='<img src="'.base_url().'img/banners_inicio/'.$b->imagen_home.'" alt="'.$b->nombre_imagen.'" width="100%" class="img-responsive" />';

			$cont['BANNER_HOMEM'].='<img src="'.base_url().'img/banners_inicio/'.$b->imagen_home_mobil.'" alt="'.$b->nombre_imagen_mobil.'" width="100%" class="img-responsive" />';

		}

		//Frases HOME

		$fra=$this->web_model->getTable('gen_frases_home');

		$frases='';

		foreach ($fra as $f) {

			$frases.='"'.$f->general_es.'",';

		}

		$cont['SCRIPT']='

		$(function(){



			$(".typed").typed({

			    strings: ['.$frases.'],

			    typeSpeed: 30,

			    backDelay: 2500,

			    loop: true,

			    // defaults to false for infinite loop

			    loopCount: false,

			});



		});';

		//Ventanas

		$ven=$this->web_model->getTable('gen_botones_home');

		$cont['VENTANAS']='';

		foreach ($ven as $v) {

			$cont['VENTANAS'].='

			<div class="cuadro20">

				'.(($v->liga!='')?'<a href="'.$v->liga.'" target="'.$v->abrir_en.'">':'').'

					<div class="itemHome">

						<img src="'.base_url().'img/banners_footer/'.$v->imagen.'" alt="'.$v->nombre_imagen.'">

						<div class="hover">

							<div class="titulo">'.$v->titulo.'</div>

							<div class="subtitulo">'.$v->subtitulo.'</div>

						</div>

					</div>

				'.(($v->liga!='')?'</a>':'').'

			</div>';

		}

		$data = array(

			'DIR'=>base_url(),

			'CONTENT'=>$this->parser->parse('inicio.html',$cont,true),

            

		);

		$data['MAIN_MENU']=$this->esp_model->mainMenu();

		$data['SEC_MENU']=$this->esp_model->secondMenu();

		$info=$this->web_model->getGeneral();

		$data= array_merge($data,$info);

		$this->parser->parse('plantilla.html',$data);

	}



	public function inicio2019()

	{

		$cont['DIR'] = base_url();

		//Posicion

		$pos=$this->web_model->getTable('gen_posicion_banner');

		switch ($pos[0]->horizontal) {

			case 'i':

				$h1='col-md-2 ';

				$h2='col-md-10';

				break;

			case 'c':

				$h1='col-md-3 col-md-offset-2';

				$h2='col-md-7';

				break;

			case 'd':

				$h1='col-md-2 col-md-offset-5';

				$h2='col-md-5';

				break;

		}

		switch ($pos[0]->vertical) {

			case 'u':

				$top='top:2%;';

				break;

			case 'm':

				$top='top:40%;';

				break;

			case 'd':

				$top='top:76%;';

				break;

		}

		$cont['FRASES']='

		<div class="letras" style="'.$top.'">

			<div class="container">

				<div class="row">

					<div class="'.$h1.' tar visible-md visible-lg">

						<img src="'.base_url().'img/logo_general.png" alt="General logotipo">

					</div>

					<div class="'.$h2.' visible-md visible-lg">

						<div class="cambiante">es</div>

						<div class="ancho typed"></div>

						<span id="typed-cursor"></span>

					</div>

				</div>

			</div>

		</div>';



		//Banners

		$ban=$this->web_model->getTable('gen_banner_home');

		$cont['BANNER_HOME']='';

		$cont['BANNER_HOMEM']='';

		foreach ($ban as $b) {

			$cont['BANNER_HOME'].='<img src="'.base_url().'img/banners_inicio/'.$b->imagen_home.'" alt="'.$b->nombre_imagen.'" width="100%" class="img-responsive" />';

			$cont['BANNER_HOMEM'].='<img src="'.base_url().'img/banners_inicio/'.$b->imagen_home_mobil.'" alt="'.$b->nombre_imagen_mobil.'" width="100%" class="img-responsive" />';

		}

		//Frases HOME

		$fra=$this->web_model->getTable('gen_frases_home');

		$frases='';

		foreach ($fra as $f) {

			$frases.='"'.$f->general_es.'",';

		}

		$cont['SCRIPT']='

		$(function(){



			$(".typed").typed({

			    strings: ['.$frases.'],

			    typeSpeed: 30,

			    backDelay: 2500,

			    loop: true,

			    // defaults to false for infinite loop

			    loopCount: false,

			});



		});';

		//Ventanas

		$ven=$this->web_model->getTable('gen_botones_home');

		$cont['VENTANAS']='';

		foreach ($ven as $v) {

			$cont['VENTANAS'].='

			<div class="cuadro20">

				'.(($v->liga!='')?'<a href="'.$v->liga.'" target="'.$v->abrir_en.'">':'').'

					<div class="itemHome">

						<img src="'.base_url().'img/banners_footer/'.$v->imagen.'" alt="'.$v->nombre_imagen.'">

						<div class="hover">

							<div class="titulo">'.$v->titulo.'</div>

							<div class="subtitulo">'.$v->subtitulo.'</div>

						</div>

					</div>

				'.(($v->liga!='')?'</a>':'').'

			</div>';

		}

		$data = array(

			'DIR'=>base_url(),

			'CONTENT'=>$this->parser->parse('inicio2019.html',$cont,true),

            

		);

		$data['MAIN_MENU']=$this->esp_model->mainMenu();

		$data['SEC_MENU']=$this->esp_model->secondMenu();

		$info=$this->web_model->getGeneral();

		$data= array_merge($data,$info);

		$this->parser->parse('plantilla.html',$data);

	}



	function guardaFormCoti($jx=false){



		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');

		$this->form_validation->set_rules('correo', 'Email', 'trim|valid_email|required');

		$this->form_validation->set_rules('g-recaptcha-response', 'Imagen Captcha', 'trim|required|callback__re_captcha');

		$p=$this->input->post();

		unset($p['g-recaptcha-response']);

		unset($p['aviso']);

		$data=array();

		if($this->form_validation->run()){

			$this->db->insert('gen_formularioCoti',$p);



			$mensaje = '<p>Se ha recibido un correo para cotización desde GENERAL.COM.MX</p>

					<p>Vía: '.$_POST['via'].'</p>

					<p>Tipo de transporte: '.$_POST['transporte'].'</p>

					<p>Origen: '.$_POST['origen'].'</p>

					<p>Destino: '.$_POST['destino'].'</p>

					<p>Fecha: '.$_POST['fecha_entrega'].'</p>

					<p>Tipo de mercancía: '.$_POST['mercancia'].'</p>

					<p>Nombre: '.$_POST['nombre'].'</p>

					<p>Correo: '.$_POST['correo'].'</p>

					<p>Teléfono: '.$_POST['telefono'].'</p>

					<p>Empresa: '.$_POST['empresa'].'</p>

					<p>Sitio web: '.$_POST['sitioweb'].'</p>

					<p>País: '.$_POST['pais'].'</p>

					<p>Peso del producto: '.$_POST['caja1'].'</p>

					<p>Cantidad de paquetes: '.$_POST['caja2'].'</p>

					<p>Volúmen (metros cúbicos): '.$_POST['caja3'].'</p>

					<p>Comentarios: '.$_POST['caja4'].'</p>

					';



			$this->load->library('email');

			$config['mailtype'] = 'html';

			$this->email->initialize($config);

			$this->email->from($_POST['correo'],$_POST['nombre']);

			$this->email->from('hola@general.com.mx');

			$this->email->to('jgaytan@general.com.mx');

			//$this->email->bcc('villanuevajuanjo@gmail.com');

			$this->email->subject('Se ha recibido un correo desde GENERAL.COM.MX');

			$this->email->message($mensaje);

			$this->email->send();



			$data['msg']='yes';	

		}else{

			$data['error']=str_replace("\r\n", '', validation_errors());

		}



		if($jx){

			echo json_encode($data);

		}

		else{

			if(count($data))

				$this->session->set_flashdata($data);

			redirect('general_es/'.$_POST['url']);

		}

	}



	function guardaForm($jx=false){



		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');

		$this->form_validation->set_rules('correo', 'Email', 'trim|valid_email|required');

		$this->form_validation->set_rules('g-recaptcha-response', 'Imagen Captcha', 'trim|required|callback__re_captcha');

		$p=$this->input->post();

		unset($p['g-recaptcha-response']);

		unset($p['aviso']);

		unset($p['tipo']);

		$data=array();

		if($this->form_validation->run()){

			$this->db->insert('gen_formulario',$p);



			$mensaje = '<p>Se ha recibido un correo desde GENERAL.COM.MX</p>

					<p>Nombre: '.$_POST['nombre'].'</p>

					<p>Correo: '.$_POST['correo'].'</p>

					<p>Teléfono: '.$_POST['telefono'].'</p>

					<p>Empresa: '.$_POST['empresa'].'</p>

					<p>Sitio web: '.$_POST['sitioweb'].'</p>

					<p>País: '.$_POST['pais'].'</p>

					<p>Comentarios: '.$_POST['caja4'].'</p>

						';



			$this->load->library('email');

			$config['mailtype'] = 'html';

			$this->email->initialize($config);

			$this->email->from($_POST['correo'],$_POST['nombre']);

			$this->email->from('hola@general.com.mx');

			$this->email->to('jgaytan@general.com.mx');

			$this->email->subject('Se ha recibido un correo desde GENERAL.COM.MX');

			$this->email->message($mensaje);

			$this->email->send();



			$data['msg']='yes';	

		}else{

			$data['error']=str_replace("\r\n", '', validation_errors());

		}



		if($jx){

			echo json_encode($data);

		}

		else{

			if(count($data))

				$this->session->set_flashdata($data);

			redirect('general_es/'.$_POST['url']);

		}

	}



	public function pagina($slug)

	{

		$cont['DIR'] = base_url();

		$cont['PAGINA'] = '';



		//Contenido

		$pagina=$this->web_model->getId('gen_paginas','url_pagina',$slug);

		if(count($pagina)==0){

			redirect(base_url().'general_es/error404');

		}



		$modulos=$this->web_model->getModPag($pagina[0]->id_pag);



		foreach ($modulos as $mod) {

			switch ($mod->tipo_mod) {

				case 1:

					$cont['PAGINA'].=$this->esp_model->mod_imagen2texto1($mod->id_mod);

					break;

				case 2:

					$cont['PAGINA'].=$this->esp_model->mod_titulo($mod->id_mod);

					break;

				case 3:

					$cont['PAGINA'].=$this->esp_model->mod_imagentextoimagen($mod->id_mod);

					break;

				case 4:

					$cont['PAGINA'].=$this->esp_model->mod_textoimagentexto($mod->id_mod);

					break;

				case 5:

					$cont['PAGINA'].=$this->esp_model->mod_bulletsfondo($mod->id_mod);

					break;

				case 6:

					$cont['PAGINA'].=$this->esp_model->mod_bulletsblanco($mod->id_mod);

					break;

				case 7:

					$cont['PAGINA'].=$this->esp_model->mod_atencionclientes($mod->id_mod);

					break;

				case 8:

					$cont['PAGINA'].=$this->esp_model->mod_texto1imagen2($mod->id_mod);

					break;

				case 9:

					$cont['PAGINA'].=$this->esp_model->mod_lista2columnas($mod->id_pag);

					break;

				case 11:

					$cont['PAGINA'].=$this->esp_model->mod_imagenfull($mod->id_mod);

					break;

				case 12:

					$cont['PAGINA'].=$this->esp_model->mod_texto2columnas($mod->id_mod);

					break;

				case 13:

					$cont['PAGINA'].=$this->esp_model->mod_texto1columna($mod->id_mod);

					break;

				case 14:

					$cont['PAGINA'].=$this->esp_model->mod_indicadores($mod->id_mod);

					break;

				case 15:

					$cont['PAGINA'].=$this->esp_model->mod_camiones($mod->id_mod);

					break;

				case 16:

					$cont['PAGINA'].=$this->esp_model->mod_atencion($mod->id_mod);

					break;

				case 17:

					$cont['PAGINA'].=$this->esp_model->mod_mapa2ubicaciones($mod->id_mod);

					break;

				case 18:

					$cont['PAGINA'].=$this->esp_model->mod_mapa2texto1($mod->id_mod);

					break;

				case 19:

					$cont['PAGINA'].=$this->esp_model->mod_texto1mapa2($mod->id_mod);

					break;

				case 20:

					$cont['PAGINA'].=$this->esp_model->mod_descargas($mod->id_mod);

					break;

				case 21:

					$cont['PAGINA'].=$this->esp_model->mod_imagenfull_cintillo($mod->id_mod);

					break;

				case 22:

					$cont['PAGINA'].=$this->esp_model->mod_unidades($this->uri->segment(3));

					break;

				case 23:

					$cont['PAGINA'].=$this->esp_model->mod_error404();

					break;

				case 24:

					$cont['PAGINA'].=$this->esp_model->mod_documentos($mod->id_mod);

					break;

				case 25:

					$cont['PAGINA'].=$this->esp_model->mod_instrucciones($mod->id_mod);

					break;

				case 26:

					$cont['PAGINA'].=$this->esp_model->mod_titulo_geo($mod->id_mod);

					break;

				case 27:

					$cont['PAGINA'].=$this->esp_model->mod_formulario($mod->id_mod);

					break;

				case 28:

					$cont['PAGINA'].=$this->esp_model->mod_formularioCotiza($mod->id_mod);

					break;

			}



			

		}



		$cont['PAGINA'].=$this->esp_model->mod_atencionclientes($pagina[0]->id_pag);

		$cont['PAGINA'].=$this->esp_model->mod_footer();

		$cont['SCRIPT']='';

		//Send correo

		if(isset($_POST['telefono'])){

			$mensaje = '<p>Se ha recibido un teléfono desde GENERAL.COM.MX</p>

						<p>Teléfono: '.$_POST['telefono'].'</p>';



			$this->load->library('email');

			$config['mailtype'] = 'html';

			$this->email->initialize($config);

			$this->email->from('hola@general.com.mx');

			$this->email->to('jgaytan@general.com.mx');

			$this->email->subject('Se ha recibido un teléfono desde GENERAL.COM.MX');

			$this->email->message($mensaje);

			$this->email->send();

			$cont['SCRIPT']='

			$(window).load(function() {

				swal({

						title: 	"Recibido!", 

						text: 	"Recibimos tu teléfono, en breve nos pondremos en contacto contigo!", 

						type: 	"success"

					},

						function(isConfirm){   

							if (isConfirm) {  

								location.href="'.base_url().'general_es/contacto-transporte-de-carga-centroamerica.html" ;

							} 

						}

					);

			});';



			$ins = array('telefono'=>$_POST['telefono'],'fecha'=>date('Y-m-d h:i:s'));

			$this->web_model->insertar('gen_telefonos',$ins);

		}

		if(isset($_POST['email'])){

			$mensaje = '<p>Se ha recibido un correo desde GENERAL.COM.MX</p>

						<p>Correo: '.$_POST['email'].'</p>';



			$this->load->library('email');

			$config['mailtype'] = 'html';

			$this->email->initialize($config);

			$this->email->from('hola@general.com.mx');

			$this->email->to('jgaytan@general.com.mx');

			$this->email->subject('Se ha recibido un correo desde GENERAL.COM.MX');

			$this->email->message($mensaje);

			$this->email->send();

			$cont['SCRIPT']='

			$(window).load(function() {

				swal({

						title: 	"Recibido!", 

						text: 	"Recibimos tu correo, en breve nos pondremos en contacto contigo!", 

						type: 	"success"

					},

						function(isConfirm){   

							if (isConfirm) {  

								location.href="'.base_url().'general_es/contacto-transporte-de-carga-centroamerica.html" ;

							} 

						}

					);

			});';



			$ins = array('email'=>$_POST['email'],'fecha'=>date('Y-m-d h:i:s'));

			$this->web_model->insertar('gen_correos',$ins);

		}



		$data = array(

			'DIR'=>base_url(),

			'CONTENT'=>$this->parser->parse('pagina.html',$cont,true),

		);

		$data['MAIN_MENU']=$this->esp_model->mainMenu();

		$data['SEC_MENU']=$this->esp_model->secondMenu();

		$info=$this->web_model->getGeneral();

		$data= array_merge($data,$info);

		$data['TITULO']=$pagina[0]->metatitulo;

		$data['DESCRIPCION']=$this->web_model->quitarEtiquetas($pagina[0]->descripcion);

		$data['PALABRAS_CLAVE']=$this->web_model->quitarEtiquetas($pagina[0]->palabras_clave);

		$this->parser->parse('plantilla.html',$data);

	}









}