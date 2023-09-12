<?php 

class esp_model extends Ci_Model {
    
    /** Desarrollado por: Juan José Villanueva   */

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_test = $this->load->database('default', TRUE);
        $this->load->model('web_model');
    }

   
    function mainMenu(){
        //Menu Principal
        $ligas1='';
        $lig1=$this->web_model->ligas1();
        foreach ($lig1 as $l) {
            if($l->url_pagina!='contacto'){
                $ligas1.='
                    <li>
                        <a href="'.base_url().'general_es/'.$l->url_pagina.'">'.$l->pagina.'</a>
                    </li>';
            }
            
        }
        //$ligas1.='<li><a href="'.base_url().'general_es/contacto">Contacto</a></li>';
        return $ligas1;
    }

    function secondMenu(){
        //Menu Secuntario
        $ligas2='';
        $lig2=$this->web_model->ligas2();
        foreach ($lig2 as $l) {
            //previos JJ
            if($l->id_pag!= 11 and $l->id_pag!= 12 and $l->id_pag!= 13 and $l->id_pag!= 14 and $l->id_pag!= 15 and $l->id_pag!= 17){
                $ligas2.='
                    <li>
                        <a href="'.base_url().'general_es/'.$l->url_pagina.'">'.$l->pagina.'</a>
                    </li>';
            }
        }
        return $ligas2;
    }

    function resaltar($cad){
        $cad = str_replace('(','<span>',$cad);
        $cad = str_replace(')','</span>',$cad);
        $cad = str_replace('[destino]','<span id="destino"></span>',$cad);
        $cad = str_replace('[General]','<img src="'.base_url().'img/logo_generalCH.png" alt="General" height="16px" style="margin-top:-3px"/>',$cad);
        $cad = str_replace('[general]','<img src="'.base_url().'img/logo_generalCH.png" alt="General" height="16px" style="margin-top:-3px"/>',$cad);
        $cad = str_replace('[','<span style="color:#00628b">',$cad);
        $cad = str_replace(']','</span>',$cad);
        return $cad;
    }
    function resaltar2($cad){
        $cad = str_replace('(','<span>',$cad);
        $cad = str_replace(')','</span>',$cad);
        $cad = str_replace('[destino]','<span id="destino"></span>',$cad);
        $cad = str_replace('[General]','<img src="'.base_url().'img/logo_generalCH.png" alt="General" height="23px" style="margin-top:-3px"/>',$cad);
        $cad = str_replace('[general]','<img src="'.base_url().'img/logo_generalCH.png" alt="General" height="23px" style="margin-top:-3px"/>',$cad);
        $cad = str_replace('[','<span style="color:#00628b">',$cad);
        $cad = str_replace(']','</span>',$cad);
        return $cad;
    }

    function mod_error404(){
        $cont= array(
            'DIR'=>base_url(),
            'BACK'=>'Ir a la pagina anterior',
            'HOME'=>'Ir a la pagina de inicio',
        );
        return $this->parser->parse('modulos/error404.html',$cont,true);
    }

    function mod_instrucciones($id){
        $mod=$this->web_model->getId('mod_instrucciones','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'IMG'=>$mod[0]->icono,
            'TITULO'=>$mod[0]->nombre_documento,
            'PARENTESIS'=>$mod[0]->subtitulo,
            'DOC'=>$mod[0]->documento,
            'TEXTO'=>$mod[0]->texto,
            'DESCARGAR'=>'Descargar',
        );
        return $this->parser->parse('modulos/instrucciones.html',$cont,true);
    }

    function mod_documentos($id){
        $mod=$this->web_model->getId('mod_documentos','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'IMG1'=>$mod[0]->imagen_documento_1,
            'TITULO1'=>$mod[0]->nombre_documento_1,
            'PARENTESIS1'=>$mod[0]->subtitulo_1,
            'DOC1'=>$mod[0]->documento_1,
            'DESCARGAR'=>'Descargar',
            'IMG2'=>$mod[0]->imagen_documento_2,
            'TITULO2'=>$mod[0]->nombre_documento_2,
            'PARENTESIS2'=>$mod[0]->subtitulo_2,
            'DOC2'=>$mod[0]->documento_2,
        );
        return $this->parser->parse('modulos/documentos.html',$cont,true);
    }

    function mod_footer(){
        $mod=$this->web_model->getId('mod_footer','id_mod',1);
        $ligas1='<li>
                    <a href="'.base_url().'inicio">Inicio</a>
                </li>';
        $lig1=$this->web_model->ligas1();
        foreach ($lig1 as $l) {
            $ligas1.='
                <li>
                    <a href="'.base_url().'general_es/'.$l->url_pagina.'">'.$l->pagina.'</a>
                </li>';
        }
        $ligas2='';
        $lig2=$this->web_model->ligas2();
        foreach ($lig2 as $l) {
            //previos JJ
            if($l->id_pag!= 11 and $l->id_pag!= 12 and $l->id_pag!= 13 and $l->id_pag!= 14 and $l->id_pag!= 15 and $l->id_pag!= 17){
                $ligas2.='
                    <li>
                        <a href="'.base_url().'general_es/'.$l->url_pagina.'">'.$l->pagina.'</a>
                    </li>';
            }
            
        }
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN'=>$mod[0]->imagen,
            'NOMBRE_IMAGEN'=>$mod[0]->nombre_imagen,
            'TITULO1'=>$this->resaltar($mod[0]->titulo1),
            'TITULO2'=>$mod[0]->titulo2,
            'TITULO3'=>$mod[0]->titulo3,
            'LIGAS1'=>$ligas1,
            'LIGAS2'=>$ligas2,
            'DIRECCION'=>$mod[0]->direccion,
        );
        return $this->parser->parse('modulos/footer.html',$cont,true);
    }

    function mod_texto1mapa2($id){
        $mod=$this->web_model->getId('mod_texto1mapa2','id_mod',$id);
        $map1=$this->web_model->getUbica($mod[0]->id_pag,1);
        $sm='
        var stylesArray = [
                              {
                                "featureType": "poi",
                                "elementType": "geometry.fill",
                                "stylers": [
                                  { "color": "#e0e0e0" }
                                ]
                              },{
                                "featureType": "landscape.man_made",
                                "elementType": "geometry.fill",
                                "stylers": [
                                  { "color": "#e0e0e0" }
                                ]
                              },{
                                "featureType": "road.highway",
                                "stylers": [
                                  { "saturation": -71 }
                                ]
                              },{
                              }
                            ];

        var map;
        function initialize() {
            var mapOptions = {
                zoom: '.$mod[0]->zoom.',
                center: new google.maps.LatLng('.$mod[0]->coordenadas.'),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                streetViewControl: false,
                styles:  stylesArray
            };
            map = new google.maps.Map(document.getElementById("contMapa"),mapOptions);';
            $c=1;
            foreach ($map1 as $m1) {
                $sm.='
                var Marker'.$c.' = new google.maps.Marker({
                    position: new google.maps.LatLng('.$m1->coordenadas.'),
                    map: map,
                    icon: "'.base_url().'img/markerMap.png",
                    title: "'.$m1->etiqueta.'"
                });';
                $c++;
            }
            
            $sm.='
        }

        google.maps.event.addDomListener(window, "load", initialize);

        ';

        $btn='';
        if($mod[0]->liga!=''){
            $btn='<br><br><a href="'.$mod[0]->liga.'" target="'.$mod[0]->abrir_en.'" class="btnVerMas">Ver Más</a>';
        }

        $cont= array(
            'DIR'=>base_url(),
            'ICONO_TEXTO'=>$mod[0]->icono_texto,
            'TITULO'=>$this->resaltar($mod[0]->titulo),
            'DESCRIPCION'=>$this->resaltar($mod[0]->descripcion).$btn,
            'SCRIPTMAP'=>$sm,
        );
        return $this->parser->parse('modulos/texto1mapa2.html',$cont,true);
    }

    function mod_mapa2texto1($id){
        $mod=$this->web_model->getId('mod_mapa2texto1','id_mod',$id);
        $map1=$this->web_model->getUbica($mod[0]->id_pag,1);
        $sm='
        var stylesArray = [
                              {
                                "featureType": "poi",
                                "elementType": "geometry.fill",
                                "stylers": [
                                  { "color": "#e0e0e0" }
                                ]
                              },{
                                "featureType": "landscape.man_made",
                                "elementType": "geometry.fill",
                                "stylers": [
                                  { "color": "#e0e0e0" }
                                ]
                              },{
                                "featureType": "road.highway",
                                "stylers": [
                                  { "saturation": -71 }
                                ]
                              },{
                              }
                            ];

        var map;
        function initialize() {
            var mapOptions = {
                zoom: '.$mod[0]->zoom.',
                center: new google.maps.LatLng('.$mod[0]->coordenadas.'),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                streetViewControl: false,
                styles:  stylesArray
            };
            map = new google.maps.Map(document.getElementById("contMapa"),mapOptions);';
            $c=1;
            foreach ($map1 as $m1) {
                $sm.='
                var Marker'.$c.' = new google.maps.Marker({
                    position: new google.maps.LatLng('.$m1->coordenadas.'),
                    map: map,
                    icon: "'.base_url().'img/markerMap.png",
                    title: "'.$m1->etiqueta.'"
                });';
                $c++;
            }
            
            $sm.='
        }

        google.maps.event.addDomListener(window, "load", initialize);

        ';

        $btn='';
        if($mod[0]->liga!=''){
            $btn='<br><br><a href="'.$mod[0]->liga.'" target="'.$mod[0]->abrir_en.'" class="btnVerMas">Ver Más</a>';
        }

        $cont= array(
            'DIR'=>base_url(),
            'ICONO_TEXTO'=>$mod[0]->icono_texto,
            'TITULO'=>$this->resaltar($mod[0]->titulo),
            'DESCRIPCION'=>$this->resaltar($mod[0]->descripcion).$btn,
            'SCRIPTMAP'=>$sm,
        );
        return $this->parser->parse('modulos/mapa2texto1.html',$cont,true);
    }

    function mod_mapa2ubicaciones($id){
        $mod=$this->web_model->getId('mod_mapa2ubicaciones','id_mod',$id);
        $map1=$this->web_model->getUbica($mod[0]->id_pag,1);
        $map2=$this->web_model->getUbica($mod[0]->id_pag,2);
        $sm='
        var stylesArray = [
                              {
                                "featureType": "poi",
                                "elementType": "geometry.fill",
                                "stylers": [
                                  { "color": "#e0e0e0" }
                                ]
                              },{
                                "featureType": "landscape.man_made",
                                "elementType": "geometry.fill",
                                "stylers": [
                                  { "color": "#e0e0e0" }
                                ]
                              },{
                                "featureType": "road.highway",
                                "stylers": [
                                  { "saturation": -71 }
                                ]
                              },{
                              }
                            ];

        var map;
        var map2;
        function initialize() {
            var mapOptions = {
                zoom: '.$mod[0]->zoom1.',
                center: new google.maps.LatLng('.$mod[0]->coordenadas1.'),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                streetViewControl: false,
                styles:  stylesArray
            };
            map = new google.maps.Map(document.getElementById("contMapa"),mapOptions);';
            $c=1;
            foreach ($map1 as $m1) {
                $sm.='
                var Marker'.$c.' = new google.maps.Marker({
                    position: new google.maps.LatLng('.$m1->coordenadas.'),
                    map: map,
                    icon: "'.base_url().'img/markerMap.png",
                    title: "'.$m1->etiqueta.'"
                });';
                $c++;
            }
            
            $sm.='

            var mapOptions2 = {
                zoom: '.$mod[0]->zoom2.',
                center: new google.maps.LatLng('.$mod[0]->coordenadas2.'),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                streetViewControl: false,
                styles:  stylesArray
            };
            map2 = new google.maps.Map(document.getElementById("contMapa2"),mapOptions2);';
            $c2=1;
            foreach ($map2 as $m2) {
                $sm.='
                var Marker2'.$c2.' = new google.maps.Marker({
                    position: new google.maps.LatLng('.$m2->coordenadas.'),
                    map: map2,
                    icon: "'.base_url().'img/markerMap.png",
                    title: "'.$m1->etiqueta.'"
                });';
                $c2++;
            }
            
            $sm.='
        }

        google.maps.event.addDomListener(window, "load", initialize);

        ';
        $cont= array(
            'DIR'=>base_url(),
            'HOVER1'=>$mod[0]->texto_hover1,
            'HOVER2'=>$mod[0]->texto_hover2,
            'IMAGEN1'=>$mod[0]->imagen1,
            'NOMBRE_IMAGEN1'=>$mod[0]->nombre_imagen1,
            'IMAGEN2'=>$mod[0]->imagen2,
            'NOMBRE_IMAGEN2'=>$mod[0]->nombre_imagen2,
            'TITULO1'=>$this->resaltar($mod[0]->titulo1),
            'TITULO2'=>$this->resaltar($mod[0]->titulo2),
            'TEXTO1'=>$this->resaltar($mod[0]->texto1),
            'TEXTO2'=>$this->resaltar($mod[0]->texto2),
            'SCRIPTMAP'=>$sm,
        );
        return $this->parser->parse('modulos/mapa2ubicaciones.html',$cont,true);
    }

    function mod_descargas($id){
        //Descargas
        $downs=$this->web_model->getIdOrder('mod_descargas_files','idioma','E'); 
        $files='';
        foreach ($downs as $d) {
            $cont2= array(
                'DIR'=>base_url(),
                'ICONO'=>$d->imagen,
                'NOMBRE'=>$d->nombre,
                'TIPO'=>$d->tipo,
                'ARCHIVO'=>$d->archivo,
                'BTN'=>'Descargar',
                'ANCHO'=>(($d->id>4)?'4':'3'),
            );
            $files .= $this->parser->parse('modulos/descargas_item.html',$cont2,true);
        }

        $mod=$this->web_model->getId('mod_atencion','id_mod',3);
        $cont= array(
            'DIR'=>base_url(),
            'DOWNS'=>$files,
            'ICONO_TEXTO'=>$mod[0]->icono_texto,
            'CAJA'=>$this->resaltar($mod[0]->caja_correo),
            'SEND'=>$mod[0]->boton_enviar,
            'LEYENDA'=>$mod[0]->leyenda,
            'URLSEND'=>'general_es/contacto-transporte-de-carga-centroamerica.html',
            'PHTEL'=>'Teléfono',
            'PHEMAIL'=>'Correo Electrónico',
        );
        return $this->parser->parse('modulos/descargas.html',$cont,true);
    }

    function mod_unidades($id=''){
        $equipos = $this->web_model->getId('gen_paginas','id_pag',16);
        //Unidades
        $top=$this->web_model->getUni(); 
        $menuTop='';
        $ancho = 100/count($top);
        foreach ($top as $t) {
            $menuTop .= '
            <div class="icoGal tac" style="width:'.$ancho.'%">
                <a href="'.base_url().'general_es/'.$equipos[0]->url_pagina.'/'.$t->slug.'">
                    <img src="'.base_url().'img/contenidos/'.$t->icono.'" alt="General">
                    <p>'.$t->nombre_icono.'</p>
                </a>
            </div>';
        }
        
        if($id=='')$id='tractor';
        $unidad=$this->web_model->getId('mod_unidades','slug',$id);
        $galeria='';
        $galeria.=(($unidad[0]->vista_frontal!='')?'<img src="'.base_url().'img/contenidos/'.$unidad[0]->vista_frontal.'" alt="General - '.$unidad[0]->titulo.'" width="100%" />':'');
        $galeria.=(($unidad[0]->vista_lateral!='')?'<img src="'.base_url().'img/contenidos/'.$unidad[0]->vista_lateral.'" alt="General - '.$unidad[0]->titulo.'" width="100%" />':'');
        $galeria.=(($unidad[0]->vista_posterior!='')?'<img src="'.base_url().'img/contenidos/'.$unidad[0]->vista_posterior.'" alt="General - '.$unidad[0]->titulo.'" width="100%" />':'');
        $galeria.=(($unidad[0]->vista_trasera!='')?'<img src="'.base_url().'img/contenidos/'.$unidad[0]->vista_trasera.'" alt="General - '.$unidad[0]->titulo.'" width="100%" />':'');

        $capacidades='';
        $capacidades.=(($unidad[0]->vista_medidas!='')?'<a href="'.base_url().'img/contenidos/'.$unidad[0]->vista_medidas.'" alt="General - '.$t->nombre_icono.'" rel="group1" class="gal"><div class="btnCotizar">Ver Capacidades</div></a>':'');
        $capacidades.=(($unidad[0]->vista_medidas_2!='')?'<a href="'.base_url().'img/contenidos/'.$unidad[0]->vista_medidas_2.'" alt="General - '.$t->nombre_icono.'" rel="group1" class="gal"></a>':'');

        $topMob=$this->web_model->getUniFull(); 
        $menuTopM='';
        foreach ($topMob as $t) {
            $menuTopM .= '
            <div class="tac">
                <div class="galUnid">
                    <p><img src="'.base_url().'img/contenidos/'.$t->icono.'" alt="'.$t->nombre_icono.'" width="auto" style="margin: 0 auto"></p>
                    <p>'.$t->nombre_icono.'</p>
                </div>
                <div style="background:url('.base_url().'img/bgGris.jpg) repeat-x; height:400px" class="container-fluid">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="textAtras" data-wow-duration="1s" class="wow fadeInUp" style="font-size:100px">'.$t->titulo.'&nbsp;&nbsp;</div>
                                <div id="desc1" data-wow-duration="1s" class="wow fadeInUp" style="top:100px">'.$t->subtitulo.' </div>
                                <div id="imgTextSobre" data-wow-duration="2s" class="wow fadeIn" style="top:160px"><img src="'.base_url().'img/contenidos/'.$t->imagen_principal.'" alt="'.$t->titulo.'" width="100%"></div>
                            </div>
                        </div>                                                       
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2" data-wow-duration="2s">
                            '.(($t->vista_frontal)?'<div style="background:url('.base_url().'img/bgThumb.jpg) bottom repeat-x; "><img src="'.base_url().'img/contenidos/'.$t->vista_frontal.'"  alt="'.$t->titulo.'" width="100%" class="wow fadeIn"></div>':'').'
                            '.(($t->vista_lateral)?'<div style="background:url('.base_url().'img/bgThumb.jpg) bottom repeat-x; "><img src="'.base_url().'img/contenidos/'.$t->vista_lateral.'"  alt="'.$t->titulo.'" width="100%" class="wow fadeIn"></div>':'').'
                            '.(($t->vista_posterior)?'<div style="background:url('.base_url().'img/bgThumb.jpg) bottom repeat-x; "><img src="'.base_url().'img/contenidos/'.$t->vista_posterior.'"   alt="'.$t->titulo.'"width="100%" class="wow fadeIn"></div>':'').'
                            '.(($t->vista_trasera)?'<div style="background:url('.base_url().'img/bgThumb.jpg) bottom repeat-x; "><img src="'.base_url().'img/contenidos/'.$t->vista_trasera.'"  alt="'.$t->titulo.'" width="100%" class="wow fadeIn"></div>':'').'
                            '.(($t->vista_medidas)?'<div style="background:url('.base_url().'img/bgThumb.jpg) bottom repeat-x; "><img src="'.base_url().'img/contenidos/'.$t->vista_medidas.'"  alt="'.$t->titulo.'" width="100%" class="wow fadeIn"></div>':'').'
                            '.(($t->vista_medidas_2)?'<div style="background:url('.base_url().'img/bgThumb.jpg) bottom repeat-x; "><img src="'.base_url().'img/contenidos/'.$t->vista_medidas_2.'"  alt="'.$t->titulo.'" width="100%" class="wow fadeIn"></div>':'').'
                        </div>
                    </div>     
                </div>      
            </div>';
        };

        $cont= array(
            'DIR'=>base_url(),
            'UNIDADESTOP'=>$menuTop,
            'UNIDADESTOPM'=>$menuTopM,
            'TITULO'=>$unidad[0]->titulo,
            'SUBTITULO'=>$unidad[0]->subtitulo,
            'PRINCIPAL'=>$unidad[0]->imagen_principal,
            'GALERIA'=>$galeria,
            'GALERIAT'=>(str_replace('width="100%" ','width="30px" ',$galeria)),
            'TITULO_CAJA'=>$this->resaltar($unidad[0]->titulo_caja),
            'DESCRIPCION'=>$this->resaltar($unidad[0]->descripcion),
            'CAPACIDADES'=>$capacidades,
        );
        return $this->parser->parse('modulos/unidades.html',$cont,true);
    }

    function mod_atencion($id){
        $mod=$this->web_model->getId('mod_atencion','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN'=>$mod[0]->imagen,
            'NOMBRE_IMAGEN'=>$mod[0]->nombre_imagen,
            'ICONO_TEXTO'=>$mod[0]->icono_texto,
            'TEXTO'=>$mod[0]->texto,
            'TITULO'=>$mod[0]->titulo,
            'ICONO1'=>$mod[0]->icono1,
            'ICONO2'=>$mod[0]->icono2,
            'ICONO3'=>$mod[0]->icono3,
            'ICONO4'=>$mod[0]->icono4,
            'ICONO5'=>$mod[0]->icono5,
            'ICONO6'=>$mod[0]->icono6,
            'ICONO7'=>$mod[0]->icono7,
            'LOC1'=>$mod[0]->ubicacion1,
            'TEL1'=>'<a href="tel:'.$mod[0]->telefono1.'" style="color:#FFF">'.$mod[0]->telefono1.'</a>',
            'CORR1'=>'<a href="mailto:'.$mod[0]->correo1.'" style="color:#FFF">'.$mod[0]->correo1.'</a>',
            'LOC2'=>$mod[0]->ubicacion2,
            'TEL2'=>'<a href="tel:'.$mod[0]->telefono2.'" style="color:#FFF">'.$mod[0]->telefono2.'</a>',
            'CORR2'=>'<a href="mailto:'.$mod[0]->correo2.'" style="color:#FFF">'.$mod[0]->correo2.'</a>',
            'LOC3'=>$mod[0]->ubicacion3,
            'TEL3'=>'<a href="tel:'.$mod[0]->telefono3.'" style="color:#FFF">'.$mod[0]->telefono3.'</a>',
            'CORR3'=>'<a href="mailto'.$mod[0]->correo3.'" style="color:#FFF">'.$mod[0]->correo3.'</a>',
            'LOC4'=>$mod[0]->ubicacion4,
            'TEL4'=>'<a href="tel:'.$mod[0]->telefono4.'" style="color:#FFF">'.$mod[0]->telefono4.'</a>',
            'CORR4'=>'<a href="mailto:'.$mod[0]->correo4.'" style="color:#FFF">'.$mod[0]->correo4.'</a>',
            'LOC5'=>$mod[0]->ubicacion5,
            'TEL5'=>'<a href="tel:'.$mod[0]->telefono5.'" style="color:#FFF">'.$mod[0]->telefono5.'</a>',
            'CORR5'=>'<a href="mailto:'.$mod[0]->correo5.'" style="color:#FFF">'.$mod[0]->correo5.'</a>',
            'LOC6'=>$mod[0]->ubicacion6,
            'TEL6'=>'<a href="tel:'.$mod[0]->telefono6.'" style="color:#FFF">'.$mod[0]->telefono6.'</a>',
            'CORR6'=>'<a href="mailto:'.$mod[0]->correo6.'" style="color:#FFF">'.$mod[0]->correo6.'</a>',
            'LOC7'=>$mod[0]->ubicacion7,
            'TEL7'=>'<a href="tel:'.$mod[0]->telefono7.'" style="color:#FFF">'.$mod[0]->telefono7.'</a>',
            'CORR7'=>'<a href="mailto:'.$mod[0]->correo7.'" style="color:#FFF">'.$mod[0]->correo7.'</a>',
            'CAJA'=>$this->resaltar2($mod[0]->caja_correo),
            'SEND'=>$mod[0]->boton_enviar,
            'LEYENDA'=>$mod[0]->leyenda,
            'URLSEND'=>'general_es/contacto-transporte-de-carga-centroamerica.html',
            'PHTEL'=>'Teléfono',
            'PHEMAIL'=>'Correo Electrónico',

        );
        return $this->parser->parse('modulos/atencion.html',$cont,true);
    }

    function mod_camiones($id){
        $equipos = $this->web_model->getId('gen_paginas','id_pag',16);
        //Unidades
        $top=$this->web_model->getUni(); 
        $menuTop='';
        $ancho = 100/count($top);
        foreach ($top as $t) {
            $menuTop .= '
            <div class="icoGal tac" style="width:'.$ancho.'%">
                <a href="'.base_url().'general_es/'.$equipos[0]->url_pagina.'/'.$t->slug.'">
                    <img src="'.base_url().'img/contenidos/'.$t->icono.'">
                    <p>'.$t->nombre_icono.'</p>
                </a>
            </div>';
        }
        //
        $menuTopM='';
        foreach ($top as $t) {
            $menuTopM .= '
            <a href="'.base_url().'general_es/unidades">
                <div class="galUnid">
                    <p><img src="'.base_url().'img/contenidos/'.$t->icono.'" width="auto" style="margin: 0 auto"></p>
                    <p class="tac fcGris">'.$t->nombre_icono.'</p>
                </div>
            </a>';
        }

        $mod=$this->web_model->getId('mod_camiones','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'TITULO'=>$this->resaltar($mod[0]->titulo),
            'UNIDADESTOP'=>$menuTop,
            'UNIDADESTOPM'=>$menuTopM,
        );
        return $this->parser->parse('modulos/camiones.html',$cont,true);
    }

    function mod_indicadores($id){
        $mod=$this->web_model->getId('mod_indicadores','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN1'=>$this->resaltar($mod[0]->imagen1),
            'NUM1'=>$this->resaltar($mod[0]->numero1),
            'IND1'=>$this->resaltar($mod[0]->texto1),
            'IMAGEN2'=>$this->resaltar($mod[0]->imagen2),
            'NUM2'=>$this->resaltar($mod[0]->numero2),
            'IND2'=>$this->resaltar($mod[0]->texto2),
            'IMAGEN3'=>$this->resaltar($mod[0]->imagen3),
            'NUM3'=>$this->resaltar($mod[0]->numero3),
            'IND3'=>$this->resaltar($mod[0]->texto3),
            'IMAGEN4'=>$this->resaltar($mod[0]->imagen4),
            'NUM4'=>$this->resaltar($mod[0]->numero4),
            'IND4'=>$this->resaltar($mod[0]->texto4),
        );
        return $this->parser->parse('modulos/indicadores.html',$cont,true);
    }

    function mod_texto1columna($id){
        $mod=$this->web_model->getId('mod_texto1columna','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'TEXTO1'=>$this->resaltar($mod[0]->texto1),
        );
        return $this->parser->parse('modulos/texto1columna.html',$cont,true);
    }

    function mod_texto2columnas($id){
        $mod=$this->web_model->getId('mod_texto2columnas','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'TEXTO1'=>$this->resaltar($mod[0]->texto1),
            'TEXTO2'=>$this->resaltar($mod[0]->texto2),
        );
        return $this->parser->parse('modulos/texto2columnas.html',$cont,true);
    }

    function mod_imagenfull($id){
        $mod=$this->web_model->getId('mod_imagenfull','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN'=>$mod[0]->imagen,
            'NOMBRE_IMAGEN'=>$mod[0]->nombre_imagen,
            'TEXTO'=>($mod[0]->texto!='')?$this->resaltar($mod[0]->texto):'',
        );
        return $this->parser->parse('modulos/imagenfull.html',$cont,true);
    }

    function mod_imagenfull_cintillo($id){
        $mod=$this->web_model->getId('mod_imagenfull_cintillo','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN'=>$mod[0]->imagen,
            'NOMBRE_IMAGEN'=>$mod[0]->nombre_imagen,
            'ICONO'=>$mod[0]->icono,
            'TEXTO'=>($mod[0]->texto!='')?$this->resaltar($mod[0]->texto):'',
            'CINTILLO'=>($mod[0]->cintillo!='')?$this->resaltar($mod[0]->cintillo):'',
            'TEXTOBTN'=>$mod[0]->texto_boton,
            'LIGABTN'=>$mod[0]->liga_boton,
        );
        return $this->parser->parse('modulos/imagenfull_cintillo.html',$cont,true);
    }

    function mod_lista2columnas($id){
        $mod=$this->web_model->getId('mod_lista2columnas','id_pag',$id);
        $items='';
        foreach ($mod as $m) {
            $contIt= array(
                'DIR'=>base_url(),
                'IMAGEN'=>$m->bullet,
                'TEXTO'=>$m->texto,
            );
            $items.=$this->parser->parse('modulos/itemlista2columnas.html',$contIt,true);
        }
        $cont= array(
            'DIR'=>base_url(),
            'ITEMS'=>$items,
        );
        return $this->parser->parse('modulos/lista2columnas.html',$cont,true);
    }

    function mod_atencionclientes($id){
        $mod=$this->web_model->getId('mod_atencionclientes','id_mod',1);
        $pag=$this->web_model->getId('gen_paginas','id_pag',$id);

        $contacto = $this->web_model->getId('gen_paginas','id_pag',9);

        $cont= array(
            'DIR'=>base_url(),
            'FONDO'=>$mod[0]->fondo,
            'TITULO'=>$this->resaltar($mod[0]->titulo),
            'TEXTO'=>($pag[0]->texto_footer!='')?$this->resaltar($pag[0]->texto_footer):$this->resaltar($mod[0]->descripcion),
            'BULLET1'=>$this->resaltar($mod[0]->bullet1),
            'TITULO1'=>$this->resaltar($mod[0]->titulo1),
            'BULLET2'=>$this->resaltar($mod[0]->bullet2),
            'TITULO2'=>$this->resaltar($mod[0]->titulo2),
            'BULLET3'=>$this->resaltar($mod[0]->bullet3),
            'TITULO3'=>$this->resaltar($mod[0]->titulo3),
            'LANG'=>'general_es',
            'SEC_AT'=>$contacto[0]->url_pagina,
        );
        return $this->parser->parse('modulos/atencionclientes.html',$cont,true);
    }

    function mod_bulletsblanco($id){
        $mod=$this->web_model->getId('mod_bulletsblanco','id_mod',$id);

        $bullets='';
        $cant=0;

        if($mod[0]->bullet1!='' && $mod[0]->titulo1!=''){
            $cant++;
            $bullets.='
            <div class="anchoCol wow fadeInUp" data-wow-duration="1s">
                <div id="bullet">
                    <img src="'.base_url().'img/contenidos/'.$mod[0]->bullet1.'" alt="'.$mod[0]->titulo1.'"/>
                    <div class="titleGris">'.$this->resaltar($mod[0]->titulo1).'</div>
                    <div class="textGris visible-md visible-lg">'.$this->resaltar($mod[0]->texto1).'</div>
                </div>
            </div>';
        }

        if($mod[0]->bullet2!='' && $mod[0]->titulo2!=''){
            $cant++;
            $bullets.='
            <div class="anchoCol wow fadeInUp" data-wow-duration="1s">
                <div id="bullet">
                    <img src="'.base_url().'img/contenidos/'.$mod[0]->bullet2.'" alt="'.$mod[0]->titulo2.'"/>
                    <div class="titleGris">'.$this->resaltar($mod[0]->titulo2).'</div>
                    <div class="textGris visible-md visible-lg">'.$this->resaltar($mod[0]->texto2).'</div>
                </div>
            </div>';
        }

        if($mod[0]->bullet3!='' && $mod[0]->titulo3!=''){
            $cant++;
            $bullets.='
            <div class="anchoCol wow fadeInUp" data-wow-duration="1s">
                <div id="bullet">
                    <img src="'.base_url().'img/contenidos/'.$mod[0]->bullet3.'" alt="'.$mod[0]->titulo3.'"/>
                    <div class="titleGris">'.$this->resaltar($mod[0]->titulo3).'</div>
                    <div class="textGris visible-md visible-lg">'.$this->resaltar($mod[0]->texto3).'</div>
                </div>
            </div>';
        }
        switch ($cant) {
            case 1: $ancho ='col-md-12'; break;
            case 2: $ancho ='col-md-6'; break;
            case 3: $ancho ='col-md-4 col-xs-4'; break;
        }
        $bullets =str_replace('anchoCol', $ancho, $bullets);    

        $cont= array(
            'DIR'=>base_url(),
            'BULLETS'=>$bullets,
        );
        return $this->parser->parse('modulos/bulletsblanco.html',$cont,true);
    }

    function mod_bulletsfondo($id){
        $mod=$this->web_model->getId('mod_bulletsfondo','id_mod',$id);

        $bullets='';
        $cant=0;

        if($mod[0]->bullet1!='' && $mod[0]->titulo1!=''){
            $cant++;
            $bullets.='
            <div class="anchoCol wow fadeInUp" data-wow-duration="1s">
                <div id="bullet">
                    <img src="'.base_url().'img/contenidos/'.$mod[0]->bullet1.'" alt="'.$mod[0]->titulo1.'"/>
                    <div class="title">'.$this->resaltar($mod[0]->titulo1).'</div>
                    <div class="text visible-md visible-lg">'.$this->resaltar($mod[0]->texto1).'</div>
                </div>
            </div>';
        }

        if($mod[0]->bullet2!='' && $mod[0]->titulo2!=''){
            $cant++;
            $bullets.='
            <div class="anchoCol wow fadeInUp" data-wow-duration="1s">
                <div id="bullet">
                    <img src="'.base_url().'img/contenidos/'.$mod[0]->bullet2.'" alt="'.$mod[0]->titulo2.'"/>
                    <div class="title">'.$this->resaltar($mod[0]->titulo2).'</div>
                    <div class="text visible-md visible-lg">'.$this->resaltar($mod[0]->texto2).'</div>
                </div>
            </div>';
        }

        if($mod[0]->bullet3!='' && $mod[0]->titulo3!=''){
            $cant++;
            $bullets.='
            <div class="anchoCol wow fadeInUp" data-wow-duration="1s">
                <div id="bullet">
                    <img src="'.base_url().'img/contenidos/'.$mod[0]->bullet3.'" alt="'.$mod[0]->titulo3.'"/>
                    <div class="title">'.$this->resaltar($mod[0]->titulo3).'</div>
                    <div class="text visible-md visible-lg">'.$this->resaltar($mod[0]->texto3).'</div>
                </div>
            </div>';
        }
        switch ($cant) {
            case 1: $ancho ='col-md-12'; break;
            case 2: $ancho ='col-md-6'; break;
            case 3: $ancho ='col-md-4 col-xs-4'; break;
        }
        $bullets =str_replace('anchoCol', $ancho, $bullets);    

        $cont= array(
            'DIR'=>base_url(),
            'FONDO'=>$mod[0]->fondo,
            'BULLETS'=>$bullets,
        );
        return $this->parser->parse('modulos/bulletsfondo.html',$cont,true);
    }

    function mod_textoimagentexto($id){
        $mod=$this->web_model->getId('mod_textoimagentexto','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN'=>$mod[0]->imagen,
            'NOMBRE_IMAGEN'=>$mod[0]->nombre_imagen,
            'TITULO1'=>$this->resaltar($mod[0]->titulo1),
            'TEXTO1'=>$this->resaltar($mod[0]->texto1),
            'TITULO2'=>$this->resaltar($mod[0]->titulo2),
            'TEXTO2'=>$this->resaltar($mod[0]->texto2),
        );
        return $this->parser->parse('modulos/textoimagentexto.html',$cont,true);
    }

    function mod_imagentextoimagen($id){
        $mod=$this->web_model->getId('mod_imagentextoimagen','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN1'=>$mod[0]->imagen1,
            'NOMBRE_IMAGEN1'=>$mod[0]->nombre_imagen1,
            'IMAGEN2'=>$mod[0]->imagen2,
            'NOMBRE_IMAGEN2'=>$mod[0]->nombre_imagen2,
            'TITULO'=>$this->resaltar($mod[0]->titulo),
            'TEXTO'=>$this->resaltar($mod[0]->texto),
        );
        return $this->parser->parse('modulos/imagentextoimagen.html',$cont,true);
    }

    function mod_imagen2texto1($id){
        $mod=$this->web_model->getId('mod_imagen2texto1','id_mod',$id);
        $btn='';
        if($mod[0]->liga!=''){
            $btn='<br><br><a href="'.$mod[0]->liga.'" target="'.$mod[0]->abrir_en.'" class="btnVerMas">Ver Más</a>';
        }
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN'=>$mod[0]->imagen,
            'NOMBRE_IMAGEN'=>$mod[0]->nombre_imagen,
            'ICONO_TEXTO'=>$mod[0]->icono_texto,
            'TEXTO'=>$this->resaltar(($mod[0]->texto!='')?$mod[0]->texto:''),
            'TITULO'=>$this->resaltar($mod[0]->titulo),
            'DESCRIPCION'=>$this->resaltar($mod[0]->descripcion).$btn,
        );
        return $this->parser->parse('modulos/imagen2texto1.html',$cont,true);
    }

    function mod_texto1imagen2($id){
        $mod=$this->web_model->getId('mod_texto1imagen2','id_mod',$id);
        $btn='';
        if($mod[0]->liga!=''){
            $btn='<br><br><a href="'.$mod[0]->liga.'" target="'.$mod[0]->abrir_en.'" class="btnVerMas">Ver Más</a>';
        }
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN'=>$mod[0]->imagen,
            'NOMBRE_IMAGEN'=>$mod[0]->nombre_imagen,
            'ICONO_TEXTO'=>$mod[0]->icono_texto,
            'TEXTO'=>$this->resaltar(($mod[0]->texto!='')?$mod[0]->texto:''),
            'TITULO'=>$this->resaltar($mod[0]->titulo),
            'DESCRIPCION'=>$this->resaltar($mod[0]->descripcion).$btn,
        );
        return $this->parser->parse('modulos/texto1imagen2.html',$cont,true);
    }

    function mod_titulo($id){
        $mod=$this->web_model->getId('mod_titulo','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'TITULO'=>$this->resaltar($mod[0]->titulo),
            'SUBTITULO'=>$this->resaltar($mod[0]->subtitulo),
        );
        return $this->parser->parse('modulos/titulo.html',$cont,true);
    }

    function mod_titulo_geo($id){
        $mod=$this->web_model->getId('mod_titulo_geo','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'TITULO'=>$this->resaltar($mod[0]->titulo),
            'SUBTITULO'=>$this->resaltar($mod[0]->subtitulo),
        );
        return $this->parser->parse('modulos/tituloGeolocalizacion.html',$cont,true);
    }

    function mod_formulario($id){
        $mod=$this->web_model->getId('mod_formulario','id_mod',$id);
        $pag=$this->web_model->getId('gen_paginas','id_pag',$mod[0]->id_pag);

        $sc='';
        if($this->session->flashdata('error')!=''){
            $err = $this->cleanTxt($this->session->flashdata('error'));
            $sc='
            $(document).ready(function () {
                setTimeout(function () {
                    swal({
                        title:  "Error!", 
                        text:   "'.$err.'", 
                        type:   "warning"
                    });
                }, 500);
            });';
        }
        if($this->session->flashdata('msg')=='yes'){
            $sc='
            $(document).ready(function () {
                setTimeout(function () {
                    swal({
                        title:  "Tu comentario se ha enviado correctamente.", 
                        text:   "Gracias por tus comentarios, te contactarémos a la brevedad posible.", 
                        type:   "success"
                    });
                }, 500);
            });
            ';
        }

        $rowP=$this->web_model->getTable('gen_paises');
        $txtP='';
        foreach ($rowP as $r) {
            $txtP.='<option value="'.$r->nombre.'">'.$r->nombre.'</option>';
        }

        $cont= array(
            'DIR'=>base_url(),
            'URL'=>$pag[0]->url_pagina,
            'TIPO'=>$mod[0]->tipo,
            'ICONO'=>$mod[0]->icono,
            'TITULO'=>$mod[0]->titulo,
            'LABEL1'=>'Nombre completo',
            'LABEL2'=>'Correo Electrónico',
            'LABEL3'=>'Teléfono con LADA',
            'LABEL4'=>'Nombre de la compañia',
            'PAISES'=>$txtP,
            'PH1'=>$mod[0]->texto_caja_1,
            'PH2'=>$mod[0]->texto_caja_2,
            'PH3'=>$mod[0]->texto_caja_3,
            'PH4'=>$mod[0]->texto_caja_4,
            'AVISO'=>$mod[0]->aviso,
            'BTN'=>$mod[0]->boton_enviar,
            'LEYENDA'=>$mod[0]->leyenda,
            'SC'=>$sc,
        );
        return $this->parser->parse('modulos/formularioCont.html',$cont,true);
    }

    function mod_formularioCotiza($id){
        $mod=$this->web_model->getId('mod_formulariocotiza','id_mod',$id);
        $pag=$this->web_model->getId('gen_paginas','id_pag',$mod[0]->id_pag);

        $sc='';
        if($this->session->flashdata('error')!=''){
            $err = $this->cleanTxt($this->session->flashdata('error'));
            $sc='
            $(document).ready(function () {
                setTimeout(function () {
                    swal({
                        title:  "Error!", 
                        text:   "'.$err.'", 
                        type:   "warning"
                    });
                }, 500);
            });';
        }
        if($this->session->flashdata('msg')=='yes'){
            $sc='
            $(document).ready(function () {
                setTimeout(function () {
                    swal({
                        title:  "Tu comentario se ha enviado correctamente.", 
                        text:   "Gracias por tus comentarios, te contactarémos a la brevedad posible.", 
                        type:   "success"
                    });
                }, 500);
            });
            ';
        }

        $scMap="
function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 21.117672, lng: -101.659040},
    zoom: 13
  });
  //inputOrigen
  var input = document.getElementById('origen');
  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo('bounds', map);
  autocomplete.setFields(
      ['address_components', 'geometry', 'icon', 'name']);
  autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();
  });
  //inputDestino
  var inputD = document.getElementById('destino');
  var autocompleteD = new google.maps.places.Autocomplete(inputD);
  autocompleteD.bindTo('bounds', map);
  autocompleteD.setFields(
      ['address_components', 'geometry', 'icon', 'name']);
  autocompleteD.addListener('place_changed', function() {
    var place = autocomplete.getPlace();
  });

 
}";
    $rowP=$this->web_model->getTable('gen_paises');
    $txtP='';
    foreach ($rowP as $r) {
        $txtP.='<option value="'.$r->nombre.'">'.$r->nombre.'</option>';
    }

        $cont= array(
            'DIR'=>base_url(),
            'URL'=>$pag[0]->url_pagina,
            'TIPO'=>'cotiza',
            'ICONO'=>$mod[0]->icono,
            'TITULO'=>$mod[0]->titulo,
            'LABEL1'=>'Nombre completo',
            'LABEL2'=>'Correo Electrónico',
            'LABEL3'=>'Teléfono con LADA',
            'LABEL4'=>'Nombre de la compañia',
            'PH1'=>$mod[0]->texto_caja_1,
            'PH2'=>$mod[0]->texto_caja_2,
            'PH3'=>$mod[0]->texto_caja_3,
            'PH4'=>$mod[0]->texto_caja_4,
            'AVISO'=>$mod[0]->aviso,
            'BTN'=>$mod[0]->boton_enviar,
            'LEYENDA'=>$mod[0]->leyenda,
            'PAISES'=>$txtP,
            'SC'=>$sc,
            'SCMAP'=>$scMap,
        );
        return $this->parser->parse('modulos/formularioCotiza.html',$cont,true);
    }

    function cleanTxt($cad=''){
        $cadena = str_replace('<p>','',$cad);
        $cadena = str_replace('</p>','',$cadena);
        $cadena = trim($cadena);

        return $cadena;
    }


}