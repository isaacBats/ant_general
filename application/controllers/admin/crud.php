<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'fun.php';
class Crud extends Fun {
	var $i=0;
	function __construct(){
		parent::__construct();
        $this->load->library('session');
		$this->id=$this->session->userdata('loguear');
		$this->adm=$this->config->item('admin');
		if(!$this->id) redirect($this->adm);
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
		$this->load->library('ajax_grocery_CRUD');
		$this->load->library('image_CRUD');
		$this->load->model('admin_model');
		$this->load->model('web_model');
		$this->grocery_crud->set_theme('datatables');
		$this->state = $this->grocery_crud->getState();

	}
	function index(){
		$con=(object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
		echo $this->tpl($con,'es <span>Panel de Administración</span>');
	}
	///////////////// CONTENIDOS


	function landings(){
		$this->load->config('grocery_crud');
		$this->config->set_item('grocery_crud_file_upload_allow_file_types','gif|jpeg|jpg|png|pdf|ico');
		$this->grocery_crud->set_table('gen_landings')
		->set_subject('landing')
		->columns('nombre')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->add_action('Módulos', '', 'GeneralAdm/crud/landings_modulosDrag','ui-icon-plus')
		->change_field_type('idioma','dropdown',array('esp'=>'Español','eng'=>'Inglés'))
		;

		$this->grocery_crud->set_field_upload('favicon','img/');
		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Landing Pages</span>');
	}

	function landings_modulosDrag($id){
		$pag=$this->web_model->getId('gen_landings','id_lan',$id);
		
		$mod=$this->web_model->getTable('gen_modulos');
		$modulos='';
		foreach ($mod as $m) {
			$modulos.='
			<li>
				<img src="'.base_url().'img/modulos/'.$m->imagen.'" width="150px" />
				<br>'.$m->modulo.'
				<br><input type="hidden" name="id_pm[]" value="">
				<br><input type="hidden" name="tipo_mod[]" value="'.$m->id.'">
			</li>';
		}

		$modPag = $this->web_model->getModLPag($id);
		$modAct='';
		foreach ($modPag as $p) {
			$modId=$this->web_model->getId('gen_modulos','id',$p->tipo_mod);
			$action='edit/'.$p->id_mod;
			if($p->tipo_mod==9){
				$action=$p->id_pag;
			}
			if($p->tipo_mod==20){
				$action='../mod_descargas_files';
			}
			if($p->tipo_mod==22){
				$action='../mod_unidades';
			}
			$btnAdd='';
			if($p->tipo_mod==17 || $p->tipo_mod==18 || $p->tipo_mod==19 ){
				$btnAdd='<a href="'.base_url().'GeneralAdm/crud/mod_ubicaciones/'.$p->id_pag.'" class="icoOpc"><img src="'.base_url().'assetsdm/img/maps.png" /></a>';
			}
			$modAct.='
			<li>
				<img src="'.base_url().'img/modulos/'.$modId[0]->imagen.'" width="150px" />
				<br>'.$modId[0]->modulo.'
				<br><input type="hidden" name="id_pm[]" value="'.$p->id.'">
				<br><input type="hidden" name="tipo_mod[]" value="'.$p->tipo_mod.'">
				<a href="'.base_url().'GeneralAdm/crud/deletePML/'.$p->tipo_mod.'/'.$p->id_mod.'/'.$p->id_pag.'" class="icoOpc" onclick="return delPM('.$p->id_pag.');" ><img src="'.base_url().'assetsdm/img/delete.png"/></a>
				<a href="'.base_url().'GeneralAdm/crud/'.($this->getTipoMod($p->tipo_mod)).'/'.$action.'" class="icoOpc"><img src="'.base_url().'assetsdm/img/settings.png" /></a>
				'.$btnAdd.'
				<div class="clear"></div>
			</li>';
		}

		$page = '
<div style="float:left; display:table; width:47%; margin-right:10px">
	<form id="frmPM" method="POST" action="'.base_url().'GeneralAdm/crud/savePML"> 
		<div id="cart">
			<h1 class="ui-widget-header">Página</h1>
			<div class="ui-widget-content">
				<ol class="placeholder">
					<span>Arrastra a esta zona los modulos de la derecha</span>
					'.$modAct.'
				</ol>
			</div>
		</div>
		<input type="hidden" name="id_pag" value="'.$id.'">
		<input type="submit" style="margin-top:20px" class="ui-input-button ui-button ui-widget ui-state-default ui-corner-all" value="Guardar">
	</form>
</div>


<div style="float:left; display:table; width:47%">
	<div id="products">
		<h1 class="ui-widget-header">Módulos disponibles</h1>
		<div id="catalog">
			<ul style="list-style:none">'.$modulos.'</ul>
		</div>
	</div>
</div>

<script>
  $(function() {
    //$( "#catalog" ).accordion();
    $( "#catalog li" ).draggable({
		appendTo: "body",
		helper: "clone",
		option: {"rel":3}
    });
    $( "#cart ol" ).droppable({
      activeClass: "ui-state-default",
      hoverClass: "ui-state-hover",
      accept: ":not(.ui-sortable-helper)",
      drop: function( event, ui ) {
        $( this ).find( ".placeholder" ).remove();
        $( "<li></li>" ).html( ui.draggable.html() ).appendTo( this );
      }
    }).sortable({
      items: "li:not(.placeholder)",
      sort: function() {
        // gets added unintentionally by droppable interacting with sortable
        // using connectWithSortable fixes this, but doesnt allow you to customize active/hoverClass options
        $( this ).removeClass( "ui-state-default" );
      }
    });
  });
  </script>';

		$output=(object)array('output' => $page , 'js_files' => array(base_url().'assetsdm/js/jquery-1.10.2.js',base_url().'assetsdm/js/jquery-ui.js',base_url().'assetsdm/js/send.js') , 'css_files' => array(base_url().'assetsdm/css/jquery-ui.css'));
		$this->tpl($output,'es <span>Módulos del landing page -  '.$pag[0]->nombre.'</span>');
	}

	function savePML(){
		
		for($c=0; $c<count($_POST['tipo_mod']); $c++){
			if($_POST['id_pm'][$c]==''){
				//Inserta en pag mod
				$datos = array(
					'id_pag'=>$_POST['id_pag'],
					'tipo_mod'=>$_POST['tipo_mod'][$c],
					'priority'=>$c
				);
				$this->web_model->insertar('gen_landing_modulo',$datos);
				$lastPM = $this->web_model->ultimoInsert();
				//Inserta en la tabla de modulo
				$table = $this->getTipoMod($_POST['tipo_mod'][$c]);
				$this->web_model->insertar($table,array('id_pag'=>$_POST['id_pag']));
				$last = $this->web_model->ultimoInsert();
				//Atualiza pag mod
				$this->web_model->UpdateRow('gen_landing_modulo',$lastPM,array('id_mod'=>$last));
			}else{
				$this->web_model->UpdateRow('gen_landing_modulo',$_POST['id_pm'][$c],array('priority'=>$c));
			}
			
		}
	}

	function deletePML($tipo_mod,$id_mod,$id_pag){
		if($tipo_mod!=''){
			$table = $this->getTipoMod($tipo_mod);
			$this->web_model->deletePM($table,$id_mod,$id_pag);
			$this->web_model->deletePM('gen_landing_modulo',$id_mod,$id_pag);
			redirect(base_url().'GeneralAdm/crud/landings_modulosDrag/'.$id_pag);
		}
	}

	function datos_generales(){
		$this->load->config('grocery_crud');
		$this->config->set_item('grocery_crud_file_upload_allow_file_types','gif|jpeg|jpg|png|pdf|ico');

		$this->grocery_crud->set_table('gen_datos_generales')
		->set_subject('nombre_sitio')
		->columns('nombre_sitio')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_add()
		->unset_delete()
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('favicon','img/');
		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Datos Generales</span>');
	}

	function posicion_banner(){
		$this->grocery_crud->set_table('gen_posicion_banner')
		->set_subject('posicion')
		->columns('horizontal','vertical')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_add()
		->unset_delete()
		->change_field_type('horizontal','dropdown',array('i'=>'Izquierda','c'=>'Centro','d'=>'Derecha'))
		->change_field_type('vertical','dropdown',array('u'=>'Arriba','m'=>'Centro','d'=>'Abajo'))
		;
		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Posición Banner Home</span>');
	}

	function banner_home(){
		$this->grocery_crud->set_table('gen_banner_home')
		->set_subject('banner')
		->columns('banner_home','imagen_home')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		;
		$this->grocery_crud->set_field_upload('imagen_home','img/banners_inicio/');
		$this->grocery_crud->set_field_upload('imagen_home_mobil','img/banners_inicio/');
		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Banner Home</span>');
	}

	function frases_home(){
		$this->grocery_crud->set_table('gen_frases_home')
		->set_subject('frase')
		->columns('general_es')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Frases Home</span>');
	}

	function botones_home(){
		$this->grocery_crud->set_table('gen_botones_home')
		->set_subject('boton')
		->columns('titulo','imagen')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_add()
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		->field_type('abrir_en','dropdown',array('1' => 'Misma pestaña', '0' => 'Nueva pestaña'))
		->field_type('open_in','dropdown',array('1' => 'Self tab', '0' => 'New tab'))
		;
		$this->grocery_crud->set_field_upload('imagen','img/banners_footer/');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Botones Home</span>');
	}

	function menu_principal(){
		$this->grocery_crud->set_table('gen_menu_principal')
		->set_subject('boton de menu')
		->columns('nombre_menu')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		;

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Menu Principal</span>');
	}

	function modulos(){
		$this->grocery_crud->set_table('gen_modulos')
		->set_subject('modulo')
		->columns('modulo','imagen')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		;
		$this->grocery_crud->set_field_upload('imagen','img/modulos/');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Módulos</span>');
	}

	function paginas(){
		$this->grocery_crud->set_table('gen_paginas')
		->set_subject('pagina')
		->columns('pagina')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->add_action('Módulos', '', 'GeneralAdm/crud/paginas_modulosDrag','ui-icon-plus')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function paginas_modulos($id){
		$pag=$this->web_model->getId('gen_paginas','id_pag',$id);
		$this->grocery_crud->set_table('gen_pagina_modulo')
		->set_subject('modulo')
		->columns('tipo_mod')
		->set_relation('tipo_mod','gen_modulos','modulo')
		->field_type('id_pag','hidden',$id)
		->unset_fields('id_mod','priority')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->callback_after_insert(array($this, 'beforeModulo'))
		->add_action('Configurar', '', 'GeneralAdm/crud/config_modulo/','ui-icon-plus')
		;
		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Módulos de la página '.$pag[0]->pagina.'</span>');
	}

	function beforeModulo($post_array,$primary_key)
	{
		$table = $this->getTipoMod($post_array['tipo_mod']);
	    $datos1 = array(
	        "id_pag" => $primary_key
	    );
	    $this->web_model->insertar($table,$datos1);
	   	$datos2 = array(
	        "id_mod" => $this->web_model->ultimoInsert()
	    );
	    $this->web_model->actualizar('gen_pagina_modulo','id', $primary_key,$datos2);
	    return true;
	}

	function paginas_modulosDrag($id){
		$pag=$this->web_model->getId('gen_paginas','id_pag',$id);
		
		$mod=$this->web_model->getTable('gen_modulos');
		$modulos='';
		foreach ($mod as $m) {
			$modulos.='
			<li>
				<img src="'.base_url().'img/modulos/'.$m->imagen.'" width="150px" />
				<br>'.$m->modulo.'
				<br><input type="hidden" name="id_pm[]" value="">
				<br><input type="hidden" name="tipo_mod[]" value="'.$m->id.'">
			</li>';
		}

		$modPag = $this->web_model->getModPag($id);
		$modAct='';
		foreach ($modPag as $p) {
			$modId=$this->web_model->getId('gen_modulos','id',$p->tipo_mod);
			$action='edit/'.$p->id_mod;
			if($p->tipo_mod==9){
				$action=$p->id_pag;
			}
			if($p->tipo_mod==20){
				$action='../mod_descargas_files';
			}
			if($p->tipo_mod==22){
				$action='../mod_unidades';
			}
			$btnAdd='';
			if($p->tipo_mod==17 || $p->tipo_mod==18 || $p->tipo_mod==19 ){
				$btnAdd='<a href="'.base_url().'GeneralAdm/crud/mod_ubicaciones/'.$p->id_pag.'" class="icoOpc"><img src="'.base_url().'assetsdm/img/maps.png" /></a>';
			}
			$modAct.='
			<li>
				<img src="'.base_url().'img/modulos/'.$modId[0]->imagen.'" width="150px" />
				<br>'.$modId[0]->modulo.'
				<br><input type="hidden" name="id_pm[]" value="'.$p->id.'">
				<br><input type="hidden" name="tipo_mod[]" value="'.$p->tipo_mod.'">
				<a href="'.base_url().'GeneralAdm/crud/deletePM/'.$p->tipo_mod.'/'.$p->id_mod.'/'.$p->id_pag.'" class="icoOpc" onclick="return delPM('.$p->id_pag.');" ><img src="'.base_url().'assetsdm/img/delete.png"/></a>
				<a href="'.base_url().'GeneralAdm/crud/'.($this->getTipoMod($p->tipo_mod)).'/'.$action.'" class="icoOpc"><img src="'.base_url().'assetsdm/img/settings.png" /></a>
				'.$btnAdd.'
				<div class="clear"></div>
			</li>';
		}

		$page = '
<div style="float:left; display:table; width:47%; margin-right:10px">
	<form id="frmPM" method="POST" action="'.base_url().'GeneralAdm/crud/savePM"> 
		<div id="cart">
			<h1 class="ui-widget-header">Página</h1>
			<div class="ui-widget-content">
				<ol class="placeholder">
					<span>Arrastra a esta zona los modulos de la derecha</span>
					'.$modAct.'
				</ol>
			</div>
		</div>
		<input type="hidden" name="id_pag" value="'.$id.'">
		<input type="submit" style="margin-top:20px" class="ui-input-button ui-button ui-widget ui-state-default ui-corner-all" value="Guardar">
	</form>
</div>


<div style="float:left; display:table; width:47%">
	<div id="products">
		<h1 class="ui-widget-header">Módulos disponibles</h1>
		<div id="catalog">
			<ul style="list-style:none">'.$modulos.'</ul>
		</div>
	</div>
</div>

<script>
  $(function() {
    //$( "#catalog" ).accordion();
    $( "#catalog li" ).draggable({
		appendTo: "body",
		helper: "clone",
		option: {"rel":3}
    });
    $( "#cart ol" ).droppable({
      activeClass: "ui-state-default",
      hoverClass: "ui-state-hover",
      accept: ":not(.ui-sortable-helper)",
      drop: function( event, ui ) {
        $( this ).find( ".placeholder" ).remove();
        $( "<li></li>" ).html( ui.draggable.html() ).appendTo( this );
      }
    }).sortable({
      items: "li:not(.placeholder)",
      sort: function() {
        // gets added unintentionally by droppable interacting with sortable
        // using connectWithSortable fixes this, but doesnt allow you to customize active/hoverClass options
        $( this ).removeClass( "ui-state-default" );
      }
    });
  });
  </script>';

		$output=(object)array('output' => $page , 'js_files' => array(base_url().'assetsdm/js/jquery-1.10.2.js',base_url().'assetsdm/js/jquery-ui.js',base_url().'assetsdm/js/send.js') , 'css_files' => array(base_url().'assetsdm/css/jquery-ui.css'));
		$this->tpl($output,'es <span>Módulos de la página '.$pag[0]->pagina.'</span>');
	}

	function savePM(){
		
		for($c=0; $c<count($_POST['tipo_mod']); $c++){
			if($_POST['id_pm'][$c]==''){
				//Inserta en pag mod
				$datos = array(
					'id_pag'=>$_POST['id_pag'],
					'tipo_mod'=>$_POST['tipo_mod'][$c],
					'priority'=>$c
				);
				$this->web_model->insertar('gen_pagina_modulo',$datos);
				$lastPM = $this->web_model->ultimoInsert();
				//Inserta en la tabla de modulo
				$table = $this->getTipoMod($_POST['tipo_mod'][$c]);
				$this->web_model->insertar($table,array('id_pag'=>$_POST['id_pag']));
				$last = $this->web_model->ultimoInsert();
				//Atualiza pag mod
				$this->web_model->UpdateRow('gen_pagina_modulo',$lastPM,array('id_mod'=>$last));
			}else{
				$this->web_model->UpdateRow('gen_pagina_modulo',$_POST['id_pm'][$c],array('priority'=>$c));
			}
			
		}
	}

	function deletePM($tipo_mod,$id_mod,$id_pag){
		if($tipo_mod!=''){
			$table = $this->getTipoMod($tipo_mod);
			$this->web_model->deletePM($table,$id_mod,$id_pag);
			$this->web_model->deletePM('gen_pagina_modulo',$id_mod,$id_pag);
			redirect(base_url().'GeneralAdm/crud/paginas_modulosDrag/'.$id_pag);
		}
	}

	function getTipoMod($tipo){
		switch ($tipo) {
			case 1:
				$table = 'mod_imagen2texto1';
				break;
			case 2:
				$table = 'mod_titulo';
				break;
			case 3:
				$table = 'mod_imagentextoimagen';
				break;
			case 4:
				$table = 'mod_textoimagentexto';
				break;
			case 5:
				$table = 'mod_bulletsfondo';
				break;
			case 6:
				$table = 'mod_bulletsblanco';
				break;
			case 7:
				$table = 'mod_atencionclientes';
				break;
			case 8:
				$table = 'mod_texto1imagen2';
				break;
			case 9:
				$table = 'mod_lista2columnas';
				break;
			case 11:
				$table = 'mod_imagenfull';
				break;
			case 12:
				$table = 'mod_texto2columnas';
				break;
			case 13:
				$table = 'mod_texto1columna';
				break;
			case 14:
				$table = 'mod_indicadores';
				break;
			case 15:
				$table = 'mod_camiones';
				break;
			case 16:
				$table = 'mod_atencion';
				break;
			case 17:
				$table = 'mod_mapa2ubicaciones';
				break;
			case 18:
				$table = 'mod_mapa2texto1';
				break;
			case 19:
				$table = 'mod_texto1mapa2';
				break;
			case 20:
				$table = 'mod_descargas';
				break;
			case 21:
				$table = 'mod_imagenfull_cintillo';
				break;
			case 22:
				$table = 'mod_unidades';
				break;
			case 23:
				$table = 'mod_error404';
				break;
			case 24:
				$table = 'mod_documentos';
				break;
			case 25:
				$table = 'mod_instrucciones';
				break;
			case 26:
				$table = 'mod_titulo_geo';
				break;
			case 27:
				$table = 'mod_formulario';
				break;
			case 28:
				$table = 'mod_formulariocotiza';
				break;
		}
		return $table;
	}

	function getBack($id_pag){
		return '
		<div class="buttons-box">
			<div class="form-button-box">
				<!--<input type="button" value="Volver" class="ui-input-button ui-button ui-widget ui-state-default ui-corner-all" role="button" aria-disabled="false">-->
				<a href="" class="ui-input-button ui-button ui-widget ui-state-default ui-corner-all">Volver</a>
			</div>
			<div class="clear"></div>	
		</div>';
	}

	////// Modulos



	function mod_instrucciones(){
		$this->grocery_crud->set_table('mod_instrucciones')
		->set_subject('documentos')
		->columns('icono','nombre_documento')
		->unset_export()
		->unset_print()
		->unset_fields('id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('icono','img/contenidos');
		$this->grocery_crud->set_field_upload('documento','img/contenidos');
		$this->grocery_crud->set_field_upload('document','img/contenidos');
		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Documentos</span>');
	}

	function mod_documentos(){
		$this->grocery_crud->set_table('mod_documentos')
		->set_subject('documentos')
		->columns('imagen_documento_1','nombre_documento_1','imagen_documento_2','nombre_documento_2')
		->unset_export()
		->unset_print()
		->unset_fields('id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('imagen_documento_1','img/contenidos');
		$this->grocery_crud->set_field_upload('imagen_documento_2','img/contenidos');
		$this->grocery_crud->set_field_upload('documento_1','img/contenidos');
		$this->grocery_crud->set_field_upload('documento_2','img/contenidos');
		$this->grocery_crud->set_field_upload('document_1','img/contenidos');
		$this->grocery_crud->set_field_upload('document_2','img/contenidos');
		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Documentos</span>');
	}
	function mod_unidades(){
		$this->grocery_crud->set_table('mod_unidades')
		->set_subject('unidad')
		->columns('icono','nombre_icono')
		->unset_export()
		->unset_print()
		->display_as('vista_capacities','View Capacities')
		->display_as('vista_capacities_2','View Capacities 2')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('icono','img/contenidos');
		$this->grocery_crud->set_field_upload('imagen_principal','img/contenidos');
		$this->grocery_crud->set_field_upload('vista_frontal','img/contenidos');
		$this->grocery_crud->set_field_upload('vista_lateral','img/contenidos');
		$this->grocery_crud->set_field_upload('vista_posterior','img/contenidos');
		$this->grocery_crud->set_field_upload('vista_trasera','img/contenidos');
		$this->grocery_crud->set_field_upload('vista_medidas','img/contenidos');
		$this->grocery_crud->set_field_upload('vista_capacities','img/contenidos');
		$this->grocery_crud->set_field_upload('vista_medidas_2','img/contenidos');
		$this->grocery_crud->set_field_upload('vista_capacities_2','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Unidades</span>');
	}

	function mod_descargas_files(){
		$this->grocery_crud->set_table('mod_descargas_files')
		->set_subject('descargable')
		->columns('idioma','nombre','imagen')
		->unset_export()
		->unset_print()
		->field_type('idioma','dropdown',array('E' => 'Español', 'I' => 'Inglés'))
		;
		$this->grocery_crud->set_field_upload('imagen','img/contenidos');
		$this->grocery_crud->set_field_upload('archivo','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Descargables</span>');
	}

	function mod_ubicaciones($id){
		$this->grocery_crud->set_table('mod_ubicaciones')
		->set_subject('ubicación')
		->columns('etiqueta')
		->unset_export()
		->unset_print()
		->field_type('id_pag','hidden',$id)
		->display_as('id_map','Mapa')
		->field_type('id_map','dropdown',array('1' => 'Mapa 1', '2' => 'Mapa 2'))
		;
		if($this->state=='list' || $this->state=='success'){
			$this->grocery_crud->where('id_pag',$id);
		}

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Ubicaciones</span>');
	}

	function mod_mapa2texto1(){
		$this->grocery_crud->set_table('mod_mapa2texto1')
		->set_subject('elemento')
		->columns('id_mod')
		->unset_fields('id_mod','id_pag')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		->field_type('abrir_en','dropdown',array('1' => 'Misma pestaña', '0' => 'Nueva pestaña'))
		->field_type('open_in','dropdown',array('1' => 'Self tab', '0' => 'New tab'))
		;
		$this->grocery_crud->set_field_upload('icono_texto','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Mapa 2 Texto 1</span>');
	}

	function mod_texto1mapa2(){
		$this->grocery_crud->set_table('mod_texto1mapa2')
		->set_subject('elemento')
		->columns('id_mod')
		->unset_fields('id_mod','id_pag')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		->field_type('abrir_en','dropdown',array('1' => 'Misma pestaña', '0' => 'Nueva pestaña'))
		->field_type('open_in','dropdown',array('1' => 'Self tab', '0' => 'New tab'))
		;
		$this->grocery_crud->set_field_upload('icono_texto','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Texto 1 Mapa 2</span>');
	}

	function mod_mapa2ubicaciones(){
		$this->grocery_crud->set_table('mod_mapa2ubicaciones')
		->set_subject('elemento')
		->columns('id_mod')
		->unset_fields('id_mod','id_pag')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('imagen1','img/contenidos');
		$this->grocery_crud->set_field_upload('imagen2','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Footer</span>');
	}

	function mod_footer(){
		$this->grocery_crud->set_table('mod_footer')
		->set_subject('elemento')
		->columns('id_mod')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('imagen','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Footer</span>');
	}

	function mod_atencion($id){
		$this->grocery_crud->set_table('mod_atencion')
		->set_subject('elemento')
		->columns('imagen')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_mod','id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('imagen','img/contenidos');
		$this->grocery_crud->set_field_upload('icono_texto','img/contenidos');
		$this->grocery_crud->set_field_upload('icono1','img/contenidos');
		$this->grocery_crud->set_field_upload('icono2','img/contenidos');
		$this->grocery_crud->set_field_upload('icono3','img/contenidos');
		$this->grocery_crud->set_field_upload('icono4','img/contenidos');
		$this->grocery_crud->set_field_upload('icono5','img/contenidos');
		$this->grocery_crud->set_field_upload('icono6','img/contenidos');
		$this->grocery_crud->set_field_upload('icono7','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_camiones($id){
		$this->grocery_crud->set_table('mod_camiones')
		->set_subject('elemento')
		->columns('imagen')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_mod','id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('camion1','img/contenidos');
		$this->grocery_crud->set_field_upload('camion2','img/contenidos');
		$this->grocery_crud->set_field_upload('camion3','img/contenidos');
		$this->grocery_crud->set_field_upload('camion4','img/contenidos');
		$this->grocery_crud->set_field_upload('camion5','img/contenidos');
		$this->grocery_crud->set_field_upload('camion6','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_indicadores($id){
		$this->grocery_crud->set_table('mod_indicadores')
		->set_subject('elemento')
		->columns('imagen')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_mod','id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('imagen1','img/contenidos');
		$this->grocery_crud->set_field_upload('imagen2','img/contenidos');
		$this->grocery_crud->set_field_upload('imagen3','img/contenidos');
		$this->grocery_crud->set_field_upload('imagen4','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_imagenfull($id){
		$this->grocery_crud->set_table('mod_imagenfull')
		->set_subject('elemento')
		->columns('imagen')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_mod','id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('imagen','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_imagenfull_cintillo($id){
		$this->grocery_crud->set_table('mod_imagenfull_cintillo')
		->set_subject('elemento')
		->columns('imagen')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_mod','id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('imagen','img/contenidos');
		$this->grocery_crud->set_field_upload('icono','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_texto2columnas(){
		$this->grocery_crud->set_table('mod_texto2columnas')
		->set_subject('pagina')
		->columns('id_mod')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_texto1columna(){
		$this->grocery_crud->set_table('mod_texto1columna')
		->set_subject('pagina')
		->columns('id_mod')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_lista2columnas($id){
		$this->grocery_crud->set_table('mod_lista2columnas')
		->set_subject('elemento')
		->columns('bullet','texto')
		->unset_export()
		->unset_print()
		->unset_fields('id_mod')
		->field_type('id_pag','hidden',$id)
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		if($this->state=='list' || $this->state=='success'){
			$this->grocery_crud->where('id_pag',$id);
		}
		$this->grocery_crud->set_field_upload('bullet','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_atencionclientes(){
		$this->grocery_crud->set_table('mod_atencionclientes')
		->set_subject('pagina')
		->columns('id_mod')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('fondo','img/contenidos');
		$this->grocery_crud->set_field_upload('bullet1','img/contenidos');
		$this->grocery_crud->set_field_upload('bullet2','img/contenidos');
		$this->grocery_crud->set_field_upload('bullet3','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Atención a Clientes</span>');
	}

	function mod_bulletsblanco(){
		$this->grocery_crud->set_table('mod_bulletsblanco')
		->set_subject('pagina')
		->columns('id_mod')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('bullet1','img/contenidos');
		$this->grocery_crud->set_field_upload('bullet2','img/contenidos');
		$this->grocery_crud->set_field_upload('bullet3','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_bulletsfondo(){
		$this->grocery_crud->set_table('mod_bulletsfondo')
		->set_subject('pagina')
		->columns('id_mod')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_pag')
		->display_as('fondo','Imagen de Fondo')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('fondo','img/contenidos');
		$this->grocery_crud->set_field_upload('bullet1','img/contenidos');
		$this->grocery_crud->set_field_upload('bullet2','img/contenidos');
		$this->grocery_crud->set_field_upload('bullet3','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_textoimagentexto(){
		$this->grocery_crud->set_table('mod_textoimagentexto')
		->set_subject('pagina')
		->columns('id_mod')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_pag')
		->display_as('imagen','Imagen')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('imagen','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_imagentextoimagen(){
		$this->grocery_crud->set_table('mod_imagentextoimagen')
		->set_subject('pagina')
		->columns('id_mod')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_pag')
		->display_as('imagen1','Imagen 1')
		->display_as('imagen2','Imagen 2')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		$this->grocery_crud->set_field_upload('imagen1','img/contenidos');
		$this->grocery_crud->set_field_upload('imagen2','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_imagen2texto1(){
		$this->grocery_crud->set_table('mod_imagen2texto1')
		->set_subject('pagina')
		->columns('id_mod')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		->field_type('abrir_en','dropdown',array('1' => 'Misma pestaña', '0' => 'Nueva pestaña'))
		->field_type('open_in','dropdown',array('1' => 'Self tab', '0' => 'New tab'))
		;
		$this->grocery_crud->set_field_upload('imagen','img/contenidos');
		$this->grocery_crud->set_field_upload('icono_texto','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_texto1imagen2(){
		$this->grocery_crud->set_table('mod_texto1imagen2')
		->set_subject('pagina')
		->columns('id_mod')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		->field_type('abrir_en','dropdown',array('1' => 'Misma pestaña', '0' => 'Nueva pestaña'))
		->field_type('open_in','dropdown',array('1' => 'Self tab', '0' => 'New tab'))
		;
		$this->grocery_crud->set_field_upload('imagen','img/contenidos');
		$this->grocery_crud->set_field_upload('icono_texto','img/contenidos');

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_titulo(){
		$this->grocery_crud->set_table('mod_titulo')
		->set_subject('pagina')
		->columns('id_mod')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		->display_as('subtitulo','Subtitulo (opcional)')
		->display_as('subtile','Subtitle (optional)')
		;
		//$this->grocery_crud->callback_field('back',array($this,'_callback_webpage_url'));

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
		//,$this->getBack($post_array['id_pag'])
	}

	function mod_titulo_geo(){
		$this->grocery_crud->set_table('mod_titulo_geo')
		->set_subject('pagina')
		->columns('id_mod')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		->display_as('subtitulo','Subtitulo (opcional)')
		->display_as('subtile','Subtitle (optional)')
		;
		//$this->grocery_crud->callback_field('back',array($this,'_callback_webpage_url'));

		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
		//,$this->getBack($post_array['id_pag'])
	}

	function mod_formulario(){
		$this->grocery_crud->set_table('mod_formulario')
		->set_subject('pagina')
		->columns('id_mod')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		
		$this->grocery_crud->set_field_upload('icono','img/contenidos');
		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function mod_formulariocotiza(){
		$this->grocery_crud->set_table('mod_formulariocotiza')
		->set_subject('pagina')
		->columns('id_mod')
		->unset_export()
		->unset_print()
		->unset_back_to_list()
		->unset_fields('id_pag')
		->change_field_type('esp','readonly')
		->change_field_type('eng','readonly')
		;
		
		$this->grocery_crud->set_field_upload('icono','img/contenidos');
		$output = $this->grocery_crud->render();
		$this->tpl($output,'es <span>Páginas</span>');
	}

	function _callback_webpage_url($value, $row){
	  return "<a href='".site_url('GeneralAdm/crud/paginas_modulosDrag/'.$row->id_pag)."'>Volver a la página</a>";
	}

    ///////////////////////////////

	function admins(){
		$this->grocery_crud->set_table(DB.'user')
		->set_subject('Administrador')
		->columns('name','user','active')
		->display_as('name','Nombre')
		->display_as('user','Usuario')
		->display_as('pass','Contraseña')
		->change_field_type('pass', 'password')
		->display_as('active','Activo')
		->callback_before_update(array($this,'_adm_pass'))
		->callback_before_insert(array($this,'_adm_pass'))
		->set_relation_n_n('permisos',DB.'user_perm',DB.'menu','id_user','id_menu','name','priority',array('tipo'=>0))
		->unset_print()
		->unset_export()
		;

		$output = $this->grocery_crud->render();
		$this->tpl($output,'Administradores');
	}
	
}