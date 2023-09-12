<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller {

	/** Desarrollado por: Juan José Villanueva	 */

	public function __construct()
	{
		parent:: __construct ();
		$this->load->model('web_model');
		$this->load->model('esp_model');
		$this->load->model('eng_model');
	}

	public function index()
	{
		$this->page();
	}

	public function page($slug='')
	{
		$cont['DIR'] = base_url();
		$cont['PAGINA'] = '';

		//Contenido
		$pagina=$this->web_model->getId('gen_landings','url',$slug);
		if(count($pagina)==0){
			redirect(base_url().'general_es/error404');
		}

		$modulos=$this->web_model->getModLPag($pagina[0]->id_lan);

		$lang=($pagina[0]->idioma=='esp')?1:0;

		foreach ($modulos as $mod) {
			switch ($mod->tipo_mod) {
				case 1:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_imagen2texto1($mod->id_mod):$this->eng_model->mod_imagen2texto1($mod->id_mod);
					break;
				case 2:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_titulo($mod->id_mod):$this->eng_model->mod_titulo($mod->id_mod);
					break;
				case 3:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_imagentextoimagen($mod->id_mod):$this->eng_model->mod_imagentextoimagen($mod->id_mod);
					break;
				case 4:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_textoimagentexto($mod->id_mod):$this->eng_model->mod_textoimagentexto($mod->id_mod);
					break;
				case 5:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_bulletsfondo($mod->id_mod):$this->eng_model->mod_bulletsfondo($mod->id_mod);
					break;
				case 6:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_bulletsblanco($mod->id_mod):$this->eng_model->mod_bulletsblanco($mod->id_mod);
					break;
				case 7:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_atencionclientes($mod->id_mod):$this->eng_model->mod_atencionclientes($mod->id_mod);
					break;
				case 8:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_texto1imagen2($mod->id_mod):$this->eng_model->mod_texto1imagen2($mod->id_mod);
					break;
				case 9:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_lista2columnas($mod->id_mod):$this->eng_model->mod_lista2columnas($mod->id_mod);
					break;
				case 11: 
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_imagenfull($mod->id_mod):$this->eng_model->mod_imagenfull($mod->id_mod);
					break;
				case 12:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_texto2columnas($mod->id_mod):$this->eng_model->mod_texto2columnas($mod->id_mod);
					break;
				case 13:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_texto1columna($mod->id_mod):$this->eng_model->mod_texto1columna($mod->id_mod);
					break;
				case 14:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_indicadores($mod->id_mod):$this->eng_model->mod_indicadores($mod->id_mod);
					break;
				case 15:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_camiones($mod->id_mod):$this->eng_model->mod_camiones($mod->id_mod);
					break;
				case 16:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_atencion($mod->id_mod):$this->eng_model->mod_atencion($mod->id_mod);
					break;
				case 17:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_mapa2ubicaciones($mod->id_mod):$this->eng_model->mod_mapa2ubicaciones($mod->id_mod);
					break;
				case 18:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_mapa2texto1($mod->id_mod):$this->eng_model->mod_mapa2texto1($mod->id_mod);
					break;
				case 19:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_texto1mapa2($mod->id_mod):$this->eng_model->mod_texto1mapa2($mod->id_mod);
					break;
				case 20:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_descargas($mod->id_mod):$this->eng_model->mod_descargas($mod->id_mod);
					break;
				case 21:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_imagenfull_cintillo($mod->id_mod):$this->eng_model->mod_imagenfull_cintillo($mod->id_mod);
					break;
				case 22:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_unidades($this->uri->segment(3)):$this->eng_model->mod_unidades($this->uri->segment(3));
					break;
				case 23:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_error404():$this->eng_model->mod_error404();
					break;
				case 24:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_documentos($mod->id_mod):$this->eng_model->mod_documentos($mod->id_mod);
					break;
				case 25:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_instrucciones($mod->id_mod):$this->eng_model->mod_instrucciones($mod->id_mod);
					break;
				case 26:
					$cont['PAGINA'].=($lang)?$this->esp_model->mod_titulo_geo($mod->id_mod):$this->eng_model->mod_titulo_geo($mod->id_mod);
					break;
			}

			
		}

		if($pagina[0]->footer){
			$cont['PAGINA'].=($lang)?$this->esp_model->mod_atencionclientes():$this->eng_model->mod_atencionclientes();
			$cont['PAGINA'].=($lang)?$this->esp_model->mod_footer():$this->eng_model->mod_footer();
		}
		
		$cont['SCRIPT']='';

		$data = array(
			'DIR'=>base_url(),
			'CONTENT'=>($lang)?$this->parser->parse('pagina.html',$cont,true):$this->parser->parse('page.html',$cont,true),
			'MAIN_MENU'=>($lang)?$this->esp_model->mainMenu():$this->eng_model->mainMenu(),
			'SEC_MENU'=>($lang)?$this->esp_model->secondMenu():$this->eng_model->secondMenu(),
            
            'TITULO'=>@$pagina[0]->titulo,
            'DESCRIPCION'=>str_replace('</p>','',(str_replace('<p>','',@$pagina[0]->descripcion))),
            'PALABRAS_CLAVE'=>str_replace('</p>','',(str_replace('<p>','',@$pagina[0]->palabras_clave))),
            'ANALYTICS'=>@$pagina[0]->analytics,
            'FAVICON'=>@$pagina[0]->favicon,
            'TITLE'=>@$pagina[0]->titulo,
            'DESCRIPTION'=>str_replace('</p>','',(str_replace('<p>','',@$pagina[0]->descripcion))),
            'KEYWORDS'=>str_replace('</p>','',(str_replace('<p>','',@$pagina[0]->palabras_clave))),
		);

		
		if($pagina[0]->plantilla){
			if($lang)
				$this->parser->parse('plantilla.html',$data);
			else
				$this->parser->parse('template.html',$data);
		}else{
			$this->parser->parse('plantillaVacia.html',$data);
		}
	}


}