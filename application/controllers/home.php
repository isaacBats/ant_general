<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	/** Desarrollado por: Juan José Villanueva	 */

	public function __construct()
	{
		parent:: __construct ();
		$this->load->model('web_model');
		$this->load->model('eng_model');
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
						<div class="cambiante">is</div>
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
			$cont['BANNER_HOME'].='<img src="'.base_url().'img/banners_inicio/'.$b->imagen_home.'" alt="'.$b->image_name.'" width="100%" class="img-responsive" />';
			$cont['BANNER_HOMEM'].='<img src="'.base_url().'img/banners_inicio/'.$b->imagen_home_mobil.'"  alt="'.$b->image_name_mobil.'"width="100%" class="img-responsive" />';
		}
		//Frases HOME
		$fra=$this->web_model->getTable('gen_frases_home');
		$frases='';
		foreach ($fra as $f) {
			$frases.='"'.$f->general_is.'",';
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
				'.(($v->link!='')?'<a href="'.$v->link.'" target="'.$v->open_in.'">':'').'
					<div class="itemHome">
						<img src="'.base_url().'img/banners_footer/'.$v->imagen.'" alt="'.$v->image_name.'">
						<div class="hover">
							<div class="titulo">'.$v->title.'</div>
							<div class="subtitulo">'.$v->subtitle.'</div>
						</div>
					</div>
				'.(($v->link!='')?'</a>':'').'
			</div>';
		}
		$data = array(
			'DIR'=>base_url(),
			'CONTENT'=>$this->parser->parse('home2019.html',$cont,true),
		);
		$data['MAIN_MENU']=$this->eng_model->mainMenu();
		$data['SEC_MENU']=$this->eng_model->secondMenu();
		$info=$this->web_model->getGeneral();
		$data= array_merge($data,$info);
		$this->parser->parse('template.html',$data);
	}

	public function page($slug)
	{
		$cont['DIR'] = base_url();
		$cont['PAGINA'] = '';

		//Contenido
		$pagina=$this->web_model->getId('gen_paginas','url_page',$slug);
		if(count($pagina)==0){
			redirect(base_url().'general_is/error404');
		}

		$modulos=$this->web_model->getModPag($pagina[0]->id_pag);

		foreach ($modulos as $mod) {
			switch ($mod->tipo_mod) {
				case 1:
					$cont['PAGINA'].=$this->eng_model->mod_imagen2texto1($mod->id_mod);
					break;
				case 2:
					$cont['PAGINA'].=$this->eng_model->mod_titulo($mod->id_mod);
					break;
				case 3:
					$cont['PAGINA'].=$this->eng_model->mod_imagentextoimagen($mod->id_mod);
					break;
				case 4:
					$cont['PAGINA'].=$this->eng_model->mod_textoimagentexto($mod->id_mod);
					break;
				case 5:
					$cont['PAGINA'].=$this->eng_model->mod_bulletsfondo($mod->id_mod);
					break;
				case 6:
					$cont['PAGINA'].=$this->eng_model->mod_bulletsblanco($mod->id_mod);
					break;
				case 7:
					$cont['PAGINA'].=$this->eng_model->mod_atencionclientes($mod->id_mod);
					break;
				case 8:
					$cont['PAGINA'].=$this->eng_model->mod_texto1imagen2($mod->id_mod);
					break;
				case 9:
					$cont['PAGINA'].=$this->eng_model->mod_lista2columnas($mod->id_pag);
					break;
				case 11:
					$cont['PAGINA'].=$this->eng_model->mod_imagenfull($mod->id_mod);
					break;
				case 12:
					$cont['PAGINA'].=$this->eng_model->mod_texto2columnas($mod->id_mod);
					break;
				case 13:
					$cont['PAGINA'].=$this->eng_model->mod_texto1columna($mod->id_mod);
					break;
				case 14:
					$cont['PAGINA'].=$this->eng_model->mod_indicadores($mod->id_mod);
					break;
				case 15:
					$cont['PAGINA'].=$this->eng_model->mod_camiones($mod->id_mod);
					break;
				case 16:
					$cont['PAGINA'].=$this->eng_model->mod_atencion($mod->id_mod);
					break;
				case 17:
					$cont['PAGINA'].=$this->eng_model->mod_mapa2ubicaciones($mod->id_mod);
					break;
				case 18:
					$cont['PAGINA'].=$this->eng_model->mod_mapa2texto1($mod->id_mod);
					break;
				case 19:
					$cont['PAGINA'].=$this->eng_model->mod_texto1mapa2($mod->id_mod);
					break;
				case 20:
					$cont['PAGINA'].=$this->eng_model->mod_descargas($mod->id_mod);
					break;
				case 21:
					$cont['PAGINA'].=$this->eng_model->mod_imagenfull_cintillo($mod->id_mod);
					break;
				case 22:
					$cont['PAGINA'].=$this->eng_model->mod_unidades($this->uri->segment(3));
					break;
				case 23:
					$cont['PAGINA'].=$this->eng_model->mod_error404();
					break;
				case 24:
					$cont['PAGINA'].=$this->eng_model->mod_documentos($mod->id_mod);
					break;
				case 25:
					$cont['PAGINA'].=$this->eng_model->mod_instrucciones($mod->id_mod);
					break;
				case 26:
					$cont['PAGINA'].=$this->eng_model->mod_titulo_geo($mod->id_mod);
					break;
				case 27:
					$cont['PAGINA'].=$this->eng_model->mod_formulario($mod->id_mod);
					break;
				case 28:
					$cont['PAGINA'].=$this->eng_model->mod_formularioCotiza($mod->id_mod);
					break;
			}

			
		}

		$cont['PAGINA'].=$this->eng_model->mod_atencionclientes($pagina[0]->id_pag);
		$cont['PAGINA'].=$this->eng_model->mod_footer();
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
						title: 	"Success!", 
						text: 	"We received your phone, we will contact you!", 
						type: 	"success"
					},
						function(isConfirm){   
							if (isConfirm) {  
								location.href="'.base_url().'general_is/contact" ;
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
						title: 	"Success!", 
						text: 	"We received your email, we will contact you!", 
						type: 	"success"
					},
						function(isConfirm){   
							if (isConfirm) {  
								location.href="'.base_url().'general_is/contact" ;
							} 
						}
					);
			});';

			$ins = array('email'=>$_POST['email'],'fecha'=>date('Y-m-d h:i:s'));
			$this->web_model->insertar('gen_correos',$ins);
		}

		$data = array(
			'DIR'=>base_url(),
			'CONTENT'=>$this->parser->parse('page.html',$cont,true),
		);
		$data['MAIN_MENU']=$this->eng_model->mainMenu();
		$data['SEC_MENU']=$this->eng_model->secondMenu();
		$info=$this->web_model->getGeneral();
		$data= array_merge($data,$info);
		$data['TITLE']=$pagina[0]->metatitle;
		$data['DESCRIPTION']=$this->web_model->quitarEtiquetas($pagina[0]->description);
		$data['KEYWORDS']=$this->web_model->quitarEtiquetas(@$pagina[0]->keywords);
		$this->parser->parse('template.html',$data);
	}

	

}