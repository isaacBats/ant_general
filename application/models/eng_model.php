
<?php 

class eng_model extends Ci_Model {

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
            if($l->url_page!='contact'){
                $ligas1.='
                    <li>
                        <a href="'.base_url().'general_is/'.$l->url_page.'">'.$l->page.'</a>
                    </li>';
            }
            
        }
        //$ligas1.='<li><a href="'.base_url().'general_is/contact">Contact</a></li>';
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
                        <a href="'.base_url().'general_is/'.$l->url_page.'">'.$l->page.'</a>
                    </li>';
            }
        }
        return $ligas2;
    }

    function resaltar($cad){
        $cad = str_replace('(','<span>',$cad);
        $cad = str_replace(')','</span>',$cad);
        $cad = str_replace('[General]','<img src="'.base_url().'img/logo_generalCH.png" alt="General" height="16px" style="margin-top:-3px"/>',$cad);
        $cad = str_replace('[general]','<img src="'.base_url().'img/logo_generalCH.png" alt="General" height="16px" style="margin-top:-3px"/>',$cad);
        $cad = str_replace('[','<span style="color:#00628b">',$cad);
        $cad = str_replace(']','</span>',$cad);
        return $cad;
    }

    function resaltar2($cad){
        $cad = str_replace('(','<span>',$cad);
        $cad = str_replace(')','</span>',$cad);
        $cad = str_replace('[General]','<img src="'.base_url().'img/logo_generalCH.png" alt="General" height="23px" style="margin-top:-3px"/>',$cad);
        $cad = str_replace('[general]','<img src="'.base_url().'img/logo_generalCH.png" alt="General" height="235px" style="margin-top:-3px"/>',$cad);
        $cad = str_replace('[','<span style="color:#00628b">',$cad);
        $cad = str_replace(']','</span>',$cad);
        return $cad;
    }

    function mod_error404(){
        $cont= array(
            'DIR'=>base_url(),
            'BACK'=>'Go to previos page',
            'HOME'=>'Go to home page',
        );
        return $this->parser->parse('modulos/error404.html',$cont,true);
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
        if($mod[0]->link!=''){
            $btn='<br><br><a href="'.$mod[0]->link.'" target="'.$mod[0]->open_in.'" class="btnVerMas">View More</a>';
        }
        $cont= array(
            'DIR'=>base_url(),
            'ICONO_TEXTO'=>$mod[0]->icono_texto,
            'TITULO'=>$this->resaltar($mod[0]->title),
            'DESCRIPCION'=>$this->resaltar($mod[0]->description).$btn,
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
        if($mod[0]->link!=''){
            $btn='<br><br><a href="'.$mod[0]->link.'" target="'.$mod[0]->open_in.'" class="btnVerMas">View More</a>';
        }
        $cont= array(
            'DIR'=>base_url(),
            'ICONO_TEXTO'=>$mod[0]->icono_texto,
            'TITULO'=>$this->resaltar($mod[0]->title),
            'DESCRIPCION'=>$this->resaltar($mod[0]->description).$btn,
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
            'HOVER1'=>$mod[0]->text_hover1,
            'HOVER2'=>$mod[0]->text_hover2,
            'IMAGEN1'=>$mod[0]->imagen1,
            'NOMBRE_IMAGEN1'=>$mod[0]->image_name1,
            'IMAGEN2'=>$mod[0]->imagen2,
            'NOMBRE_IMAGEN2'=>$mod[0]->image_name2,
            'TITULO1'=>$this->resaltar($mod[0]->title1),
            'TITULO2'=>$this->resaltar($mod[0]->title2),
            'TEXTO1'=>$this->resaltar($mod[0]->text1),
            'TEXTO2'=>$this->resaltar($mod[0]->text2),
            'SCRIPTMAP'=>$sm,
        );
        return $this->parser->parse('modulos/mapa2ubicaciones.html',$cont,true);
    }


    function mod_instrucciones($id){
        $mod=$this->web_model->getId('mod_instrucciones','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'IMG'=>$mod[0]->icono,
            'TITULO'=>$mod[0]->document_name,
            'PARENTESIS'=>$mod[0]->subtitle,
            'DOC'=>$mod[0]->document,
            'TEXTO'=>$mod[0]->text,
            'DESCARGAR'=>'Download',
        );
        return $this->parser->parse('modulos/instrucciones.html',$cont,true);
    }

    function mod_documentos($id){
        $mod=$this->web_model->getId('mod_documentos','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'IMG1'=>$mod[0]->imagen_documento_1,
            'TITULO1'=>$mod[0]->document_name_1,
            'PARENTESIS1'=>$mod[0]->subtitle_1,
            'DOC1'=>$mod[0]->documento_1,
            'DESCARGAR'=>'Download',
            'IMG2'=>$mod[0]->imagen_documento_2,
            'TITULO2'=>$mod[0]->document_name_2,
            'PARENTESIS2'=>$mod[0]->subtitle_2,
            'DOC2'=>$mod[0]->documento_2,
        );
        return $this->parser->parse('modulos/documentos.html',$cont,true);
    }

    function mod_footer(){
        $mod=$this->web_model->getId('mod_footer','id_mod',1);
        $ligas1='<li>
                    <a href="'.base_url().'home">Home</a>
                </li>';
        $lig1=$this->web_model->ligas1();
        foreach ($lig1 as $l) {
            $ligas1.='
                <li>
                    <a href="'.base_url().'general_is/'.$l->url_page.'">'.$l->page.'</a>
                </li>';
        }
        $ligas2='';
        $lig2=$this->web_model->ligas2();
        foreach ($lig2 as $l) {
            //previos JJ
            if($l->id_pag!= 11 and $l->id_pag!= 12 and $l->id_pag!= 13 and $l->id_pag!= 14 and $l->id_pag!= 15 and $l->id_pag!= 17){
                $ligas2.='
                    <li>
                        <a href="'.base_url().'general_is/'.$l->url_page.'">'.$l->page.'</a>
                    </li>';
            }
        }
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN'=>$mod[0]->imagen,
            'NOMBRE_IMAGEN'=>$mod[0]->image_name,
            'TITULO1'=>$this->resaltar($mod[0]->title1),
            'TITULO2'=>$mod[0]->title2,
            'TITULO3'=>$mod[0]->title3,
            'LIGAS1'=>$ligas1,
            'LIGAS2'=>$ligas2,
            'DIRECCION'=>$mod[0]->address,
        );
        return $this->parser->parse('modulos/footer.html',$cont,true);
    }


    function mod_descargas($id){
        //Descargas
        $downs=$this->web_model->getIdOrder('mod_descargas_files','idioma','I'); 
        $files='';
        $c=0;
        foreach ($downs as $d) {
            $c++;
            $cont2= array(
                'DIR'=>base_url(),
                'ICONO'=>$d->imagen,
                'NOMBRE'=>$d->nombre,
                'TIPO'=>$d->tipo,
                'ARCHIVO'=>$d->archivo,
                'BTN'=>'Download',
                'ANCHO'=>(($c>4)?'4':'3'),
            );
            $files .= $this->parser->parse('modulos/descargas_item.html',$cont2,true);
        }

        $mod=$this->web_model->getId('mod_atencion','id_mod',3);
        $cont= array(
            'DIR'=>base_url(),
            'DOWNS'=>$files,
            'ICONO_TEXTO'=>$mod[0]->icono_texto,
            'CAJA'=>$this->resaltar($mod[0]->email_box),
            'SEND'=>$mod[0]->send_button,
            'LEYENDA'=>$mod[0]->legend,
            'URLSEND'=>'general_is/contact',
            'PHTEL'=>'Phone number',
            'PHEMAIL'=>'E-mail',
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
                <a href="'.base_url().'general_is/'.$equipos[0]->url_page.'/'.$t->slug.'">
                    <img src="'.base_url().'img/contenidos/'.$t->icono.'" alt="General">
                    <p>'.$t->nombre_icono.'</p>
                </a>
            </div>';
        }
        if($id=='')$id='tractor';
        $unidad=$this->web_model->getId('mod_unidades','slug',$id);
        $galeria='';
        $galeria.=(($unidad[0]->vista_frontal!='')?'<img src="'.base_url().'img/contenidos/'.$unidad[0]->vista_frontal.'" alt="General - '.$unidad[0]->title.'" width="100%" />':'');
        $galeria.=(($unidad[0]->vista_lateral!='')?'<img src="'.base_url().'img/contenidos/'.$unidad[0]->vista_lateral.'"  alt="General - '.$unidad[0]->title.'"width="100%" />':'');
        $galeria.=(($unidad[0]->vista_posterior!='')?'<img src="'.base_url().'img/contenidos/'.$unidad[0]->vista_posterior.'" alt="General - '.$unidad[0]->title.'" width="100%" />':'');
        $galeria.=(($unidad[0]->vista_trasera!='')?'<img src="'.base_url().'img/contenidos/'.$unidad[0]->vista_trasera.'" alt="General - '.$unidad[0]->title.'" width="100%" />':'');

        $capacidades='';
        $capacidades.=(($unidad[0]->vista_capacities!='')?'<a href="'.base_url().'img/contenidos/'.$unidad[0]->vista_capacities.'" alt="General - '.$t->nombre_icono.'" rel="group1" class="gal"><div class="btnCotizar">View Capacities</div></a>':'');
        $capacidades.=(($unidad[0]->vista_capacities_2!='')?'<a href="'.base_url().'img/contenidos/'.$unidad[0]->vista_capacities_2.'" alt="General - '.$t->nombre_icono.'" rel="group1" class="gal"></a>':'');
        
        //Mobil
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
                                <div id="textAtras" data-wow-duration="1s" class="wow fadeInUp" style="font-size:100px">'.$t->title.'&nbsp;&nbsp;</div>
                                <div id="desc1" data-wow-duration="1s" class="wow fadeInUp" style="top:100px">'.$t->subtitle.' </div>
                                <div id="imgTextSobre" data-wow-duration="2s" class="wow fadeIn" style="top:160px"><img src="'.base_url().'img/contenidos/'.$t->imagen_principal.'" alt="'.$t->title.'" width="100%"></div>
                            </div>
                        </div>                                                       
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2" data-wow-duration="2s">
                            '.(($t->vista_frontal)?'<div style="background:url('.base_url().'img/bgThumb.jpg) bottom repeat-x; "><img src="'.base_url().'img/contenidos/'.$t->vista_frontal.'" alt="'.$t->title.'" width="100%" class="wow fadeIn"></div>':'').'
                            '.(($t->vista_lateral)?'<div style="background:url('.base_url().'img/bgThumb.jpg) bottom repeat-x; "><img src="'.base_url().'img/contenidos/'.$t->vista_lateral.'" alt="'.$t->title.'" width="100%" class="wow fadeIn"></div>':'').'
                            '.(($t->vista_posterior)?'<div style="background:url('.base_url().'img/bgThumb.jpg) bottom repeat-x; "><img src="'.base_url().'img/contenidos/'.$t->vista_posterior.'" alt="'.$t->title.'" width="100%" class="wow fadeIn"></div>':'').'
                            '.(($t->vista_trasera)?'<div style="background:url('.base_url().'img/bgThumb.jpg) bottom repeat-x; "><img src="'.base_url().'img/contenidos/'.$t->vista_trasera.'" alt="'.$t->title.'" width="100%" class="wow fadeIn"></div>':'').'
                            '.(($t->vista_capacities)?'<div style="background:url('.base_url().'img/bgThumb.jpg) bottom repeat-x; "><img src="'.base_url().'img/contenidos/'.$t->vista_capacities.'" alt="'.$t->title.'" width="100%" class="wow fadeIn"></div>':'').'
                            '.(($t->vista_capacities_2)?'<div style="background:url('.base_url().'img/bgThumb.jpg) bottom repeat-x; "><img src="'.base_url().'img/contenidos/'.$t->vista_capacities_2.'" alt="'.$t->title.'" width="100%" class="wow fadeIn"></div>':'').'
                        </div>
                    </div>     
                </div>      
            </div>';
        };

        $cont= array(
            'DIR'=>base_url(),
            'UNIDADESTOP'=>$menuTop,
            'UNIDADESTOPM'=>$menuTopM,
            'TITULO'=>$unidad[0]->title,
            'SUBTITULO'=>$unidad[0]->subtitle,
            'PRINCIPAL'=>$unidad[0]->imagen_principal,
            'GALERIA'=>$galeria,
            'GALERIAT'=>(str_replace('width="100%" ','width="30px" ',$galeria)),
            'TITULO_CAJA'=>$this->resaltar($unidad[0]->title_box),
            'DESCRIPCION'=>$this->resaltar($unidad[0]->description),
            'CAPACIDADES'=>$capacidades,
        );
        return $this->parser->parse('modulos/unidades.html',$cont,true);
    }

    function mod_atencion($id){
        $mod=$this->web_model->getId('mod_atencion','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN'=>$mod[0]->imagen,
            'NOMBRE_IMAGEN'=>$mod[0]->image_name,
            'ICONO_TEXTO'=>$mod[0]->icono_texto,
            'TEXTO'=>$mod[0]->text,
            'TITULO'=>$this->resaltar($mod[0]->title),
            'ICONO1'=>$mod[0]->icono1,
            'ICONO2'=>$mod[0]->icono2,
            'ICONO3'=>$mod[0]->icono3,
            'ICONO4'=>$mod[0]->icono4,
            'ICONO5'=>$mod[0]->icono5,
            'ICONO6'=>$mod[0]->icono6,
            'ICONO7'=>$mod[0]->icono7,
            'LOC1'=>$mod[0]->location1,
            'TEL1'=>'<a href="tel:'.$mod[0]->phone1.'" style="color:#FFF">'.$mod[0]->phone1.'</a>',
            'CORR1'=>'<a href="mailto:'.$mod[0]->email1.'" style="color:#FFF">'.$mod[0]->email1.'</a>',
            'LOC2'=>$mod[0]->location2,
            'TEL2'=>'<a href="tel:'.$mod[0]->phone2.'" style="color:#FFF">'.$mod[0]->phone2.'</a>',
            'CORR2'=>'<a href="mailto:'.$mod[0]->email2.'" style="color:#FFF">'.$mod[0]->email2.'</a>',
            'LOC3'=>$mod[0]->location3,
            'TEL3'=>'<a href="tel:'.$mod[0]->phone3.'" style="color:#FFF">'.$mod[0]->phone3.'</a>',
            'CORR3'=>'<a href="mailto:'.$mod[0]->email3.'" style="color:#FFF">'.$mod[0]->email3.'</a>',
            'LOC4'=>$mod[0]->location4,
            'TEL4'=>'<a href="tel:'.$mod[0]->phone4.'" style="color:#FFF">'.$mod[0]->phone4.'</a>',
            'CORR4'=>'<a href="mailto:'.$mod[0]->email4.'" style="color:#FFF">'.$mod[0]->email4.'</a>',
            'LOC5'=>$mod[0]->location5,
            'TEL5'=>'<a href="tel:'.$mod[0]->phone5.'" style="color:#FFF">'.$mod[0]->phone5.'</a>',
            'CORR5'=>'<a href="mailto:'.$mod[0]->email5.'" style="color:#FFF">'.$mod[0]->email5.'</a>',
            'LOC6'=>$mod[0]->location6,
            'TEL6'=>'<a href="tel:'.$mod[0]->phone6.'" style="color:#FFF">'.$mod[0]->phone6.'</a>',
            'CORR6'=>'<a href="mailto:'.$mod[0]->email6.'" style="color:#FFF">'.$mod[0]->email6.'</a>',
            'LOC7'=>$mod[0]->location7,
            'TEL7'=>'<a href="tel:'.$mod[0]->phone7.'" style="color:#FFF">'.$mod[0]->phone7.'</a>',
            'CORR7'=>'<a href="mailto:'.$mod[0]->email7.'" style="color:#FFF">'.$mod[0]->email7.'</a>',
            'CAJA'=>$this->resaltar2($mod[0]->email_box),
            'SEND'=>$mod[0]->send_button,
            'LEYENDA'=>$mod[0]->legend,
            'URLSEND'=>'general_is/contact',
            'PHTEL'=>'Phone number',
            'PHEMAIL'=>'E-mail',

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
                <a href="'.base_url().'general_is/'.$equipos[0]->url_page.'/'.$t->slug.'">
                    <img src="'.base_url().'img/contenidos/'.$t->icono.'">
                    <p>'.$t->nombre_icono.'</p>
                </a>
            </div>';
        }
        //
        $menuTopM='';
        foreach ($top as $t) {
            $menuTopM .= '
            <a href="'.base_url().'general_is/units">
                <div class="galUnid">
                    <p><img src="'.base_url().'img/contenidos/'.$t->icono.'" width="auto" style="margin: 0 auto"></p>
                    <p class="tac fcGris">'.$t->nombre_icono.'</p>
                </div>
            </a>';
        }
        $mod=$this->web_model->getId('mod_camiones','id_mod',$id);
        
        $cont= array(
            'DIR'=>base_url(),
            'TITULO'=>$this->resaltar($mod[0]->title),
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
            'NUM1'=>$this->resaltar($mod[0]->number1),
            'IND1'=>$this->resaltar($mod[0]->text1),
            'IMAGEN2'=>$this->resaltar($mod[0]->imagen2),
            'NUM2'=>$this->resaltar($mod[0]->number2),
            'IND2'=>$this->resaltar($mod[0]->text2),
            'IMAGEN3'=>$this->resaltar($mod[0]->imagen3),
            'NUM3'=>$this->resaltar($mod[0]->number3),
            'IND3'=>$this->resaltar($mod[0]->text3),
            'IMAGEN4'=>$this->resaltar($mod[0]->imagen4),
            'NUM4'=>$this->resaltar($mod[0]->number4),
            'IND4'=>$this->resaltar($mod[0]->text4),
        );
        return $this->parser->parse('modulos/indicadores.html',$cont,true);
    }

    function mod_texto1columna($id){
        $mod=$this->web_model->getId('mod_texto1columna','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'TEXTO1'=>$this->resaltar($mod[0]->text1),
        );
        return $this->parser->parse('modulos/texto1columna.html',$cont,true);
    }

    function mod_texto2columnas($id){
        $mod=$this->web_model->getId('mod_texto2columnas','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'TEXTO1'=>$this->resaltar($mod[0]->text1),
            'TEXTO2'=>$this->resaltar($mod[0]->text2),
        );
        return $this->parser->parse('modulos/texto2columnas.html',$cont,true);
    }

    function mod_imagenfull($id){
        $mod=$this->web_model->getId('mod_imagenfull','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN'=>$mod[0]->imagen,
            'NOMBRE_IMAGEN'=>$mod[0]->image_name,
            'TEXTO'=>($mod[0]->text!='')?$this->resaltar($mod[0]->text):'',
        );
        return $this->parser->parse('modulos/imagenfull.html',$cont,true);
    }

    function mod_imagenfull_cintillo($id){
        $mod=$this->web_model->getId('mod_imagenfull_cintillo','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN'=>$mod[0]->imagen,
            'NOMBRE_IMAGEN'=>$mod[0]->image_name,
            'ICONO'=>$mod[0]->icono,
            'TEXTO'=>($mod[0]->text!='')?$this->resaltar($mod[0]->text):'',
            'CINTILLO'=>($mod[0]->cintillo_eng!='')?$this->resaltar($mod[0]->cintillo_eng):'',
            'TEXTOBTN'=>$mod[0]->text_button,
            'LIGABTN'=>$mod[0]->link_button,
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
                'TEXTO'=>$m->text,
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
            'TITULO'=>$this->resaltar($mod[0]->title),
            'TEXTO'=>($pag[0]->text_footer!='')?$this->resaltar($pag[0]->text_footer):$this->resaltar($mod[0]->description),
            'BULLET1'=>$this->resaltar($mod[0]->bullet1),
            'TITULO1'=>$this->resaltar($mod[0]->title1),
            'BULLET2'=>$this->resaltar($mod[0]->bullet2),
            'TITULO2'=>$this->resaltar($mod[0]->title2),
            'BULLET3'=>$this->resaltar($mod[0]->bullet3),
            'TITULO3'=>$this->resaltar($mod[0]->title3),
            'LANG'=>'general_is',
            'SEC_AT'=>$contacto[0]->url_page,
        );
        return $this->parser->parse('modulos/atencionclientes.html',$cont,true);
    }

    function mod_bulletsblanco($id){
        $mod=$this->web_model->getId('mod_bulletsblanco','id_mod',$id);

        $bullets='';
        $cant=0;

        if($mod[0]->bullet1!='' && $mod[0]->title1!=''){
            $cant++;
            $bullets.='
            <div class="anchoCol">
                <div id="bullet">
                    <img src="'.base_url().'img/contenidos/'.$mod[0]->bullet1.'" alt="'.$mod[0]->title1.'"/>
                    <div class="titleGris">'.$this->resaltar($mod[0]->title1).'</div>
                    <div class="textGris visible-md visible-lg">'.$this->resaltar($mod[0]->text1).'</div>
                </div>
            </div>';
        }

        if($mod[0]->bullet2!='' && $mod[0]->title2!=''){
            $cant++;
            $bullets.='
            <div class="anchoCol">
                <div id="bullet">
                    <img src="'.base_url().'img/contenidos/'.$mod[0]->bullet2.'" alt="'.$mod[0]->title2.'"/>
                    <div class="titleGris">'.$this->resaltar($mod[0]->title2).'</div>
                    <div class="textGris visible-md visible-lg">'.$this->resaltar($mod[0]->text2).'</div>
                </div>
            </div>';
        }

        if($mod[0]->bullet3!='' && $mod[0]->title3!=''){
            $cant++;
            $bullets.='
            <div class="anchoCol">
                <div id="bullet">
                    <img src="'.base_url().'img/contenidos/'.$mod[0]->bullet3.'" alt="'.$mod[0]->title3.'"/>
                    <div class="titleGris">'.$this->resaltar($mod[0]->title3).'</div>
                    <div class="textGris visible-md visible-lg">'.$this->resaltar($mod[0]->text3).'</div>
                </div>
            </div>';
        }
        switch ($cant) {
            case 1: $ancho ='col-md-12'; break;
            case 2: $ancho ='col-md-6'; break;
            case 3: $ancho ='col-md-4'; break;
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

        if($mod[0]->bullet1!='' && $mod[0]->title1!=''){
            $cant++;
            $bullets.='
            <div class="anchoCol">
                <div id="bullet">
                    <img src="'.base_url().'img/contenidos/'.$mod[0]->bullet1.'" alt="'.$mod[0]->title1.'"/>
                    <div class="title">'.$this->resaltar($mod[0]->title1).'</div>
                    <div class="text visible-md visible-lg">'.$this->resaltar($mod[0]->text1).'</div>
                </div>
            </div>';
        }

        if($mod[0]->bullet2!='' && $mod[0]->title2!=''){
            $cant++;
            $bullets.='
            <div class="anchoCol">
                <div id="bullet">
                    <img src="'.base_url().'img/contenidos/'.$mod[0]->bullet2.'" alt="'.$mod[0]->title2.'"/>
                    <div class="title">'.$this->resaltar($mod[0]->title2).'</div>
                    <div class="text visible-md visible-lg">'.$this->resaltar($mod[0]->text2).'</div>
                </div>
            </div>';
        }

        if($mod[0]->bullet3!='' && $mod[0]->title3!=''){
            $cant++;
            $bullets.='
            <div class="anchoCol">
                <div id="bullet">
                    <img src="'.base_url().'img/contenidos/'.$mod[0]->bullet3.'" alt="'.$mod[0]->title3.'"/>
                    <div class="title">'.$this->resaltar($mod[0]->title3).'</div>
                    <div class="text visible-md visible-lg">'.$this->resaltar($mod[0]->text3).'</div>
                </div>
            </div>';
        }
        switch ($cant) {
            case 1: $ancho ='col-md-12'; break;
            case 2: $ancho ='col-md-6'; break;
            case 3: $ancho ='col-md-4'; break;
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
            'NOMBRE_IMAGEN'=>$mod[0]->image_name,
            'TITULO1'=>$this->resaltar($mod[0]->title1),
            'TEXTO1'=>$this->resaltar($mod[0]->text1),
            'TITULO2'=>$this->resaltar($mod[0]->title2),
            'TEXTO2'=>$this->resaltar($mod[0]->text2),
        );
        return $this->parser->parse('modulos/textoimagentexto.html',$cont,true);
    }

    function mod_imagentextoimagen($id){
        $mod=$this->web_model->getId('mod_imagentextoimagen','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN1'=>$mod[0]->imagen1,
            'NOMBRE_IMAGEN1'=>$mod[0]->image_name1,
            'IMAGEN2'=>$mod[0]->imagen2,
            'NOMBRE_IMAGEN2'=>$mod[0]->image_name2,
            'TITULO'=>$this->resaltar($mod[0]->title),
            'TEXTO'=>$this->resaltar($mod[0]->text),
        );
        return $this->parser->parse('modulos/imagentextoimagen.html',$cont,true);
    }

    function mod_imagen2texto1($id){
        $mod=$this->web_model->getId('mod_imagen2texto1','id_mod',$id);
        $btn='';
        if($mod[0]->link!=''){
            $btn='<br><br><a href="'.$mod[0]->link.'" target="'.$mod[0]->open_in.'" class="btnVerMas">View More</a>';
        }
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN'=>$mod[0]->imagen,
            'NOMBRE_IMAGEN'=>$mod[0]->image_name,
            'ICONO_TEXTO'=>$mod[0]->icono_texto,
            'TEXTO'=>$this->resaltar(($mod[0]->text!='')?$mod[0]->text:''),
            'TITULO'=>$this->resaltar($mod[0]->title),
            'DESCRIPCION'=>$this->resaltar($mod[0]->description).$btn,
        );
        return $this->parser->parse('modulos/imagen2texto1.html',$cont,true);
    }

    function mod_texto1imagen2($id){
        $mod=$this->web_model->getId('mod_texto1imagen2','id_mod',$id);
        $btn='';
        if($mod[0]->link!=''){
            $btn='<br><br><a href="'.$mod[0]->link.'" target="'.$mod[0]->open_in.'" class="btnVerMas">View More</a>';
        }
        $cont= array(
            'DIR'=>base_url(),
            'IMAGEN'=>$mod[0]->imagen,
            'NOMBRE_IMAGEN'=>$mod[0]->image_name,
            'ICONO_TEXTO'=>$mod[0]->icono_texto,
            'TEXTO'=>$this->resaltar(($mod[0]->text!='')?$mod[0]->text:''),
            'TITULO'=>$this->resaltar($mod[0]->title),
            'DESCRIPCION'=>$this->resaltar($mod[0]->description).$btn,
        );
        return $this->parser->parse('modulos/texto1imagen2.html',$cont,true);
    }

    function mod_titulo($id){
        $mod=$this->web_model->getId('mod_titulo','id_mod',$id);
        $cont= array(
            'DIR'=>base_url(),
            'TITULO'=>$this->resaltar($mod[0]->title),
            'SUBTITULO'=>$this->resaltar($mod[0]->subtitle),
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
                        title:  "Your comment has been submitted.", 
                        text:   "Thanks for your comments, we will contact you as soon as possible.", 
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
            'TITULO'=>'Contact GENERAL specialist',
            'LABEL1'=>'Full name',
            'LABEL2'=>'E-mail',
            'LABEL3'=>'(Area code) Phone',
            'LABEL4'=>'Company name',
            'PAISES'=>$txtP,
            'PH1'=>$mod[0]->placeholder_1,
            'PH2'=>$mod[0]->placeholder_2,
            'PH3'=>$mod[0]->placeholder_3,
            'PH4'=>$mod[0]->placeholder_4,
            'AVISO'=>'Accept privacy policy and terms',
            'BTN'=>'Send',
            'LEYENDA'=>$mod[0]->leyend,
            'SC'=>$sc,
        );
        return $this->parser->parse('modulos/formularioContEng.html',$cont,true);
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
                        title:  "Your comment has been submitted.", 
                        text:   "Thanks for your comments, we will contact you as soon as possible.", 
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
            'TITULO'=>$mod[0]->title,
            'LABEL1'=>'Full name',
            'LABEL2'=>'Email',
            'LABEL3'=>'(Area code) Phone',
            'LABEL4'=>'Company name',
            'PH1'=>$mod[0]->placeholder_1,
            'PH2'=>$mod[0]->placeholder_2,
            'PH3'=>$mod[0]->placeholder_3,
            'PH4'=>$mod[0]->placeholder_4,
            'AVISO'=>'Accept privacy policy and terms',
            'BTN'=>'Send',
            'LEYENDA'=>'We use cookies to ensure that we give you the best experience on our website. If
you continue, we’ll assume that you are happy to receive all the cookies on the GENERAL website.',
            'PAISES'=>$txtP,
            'SC'=>$sc,
            'SCMAP'=>$scMap,
        );
        return $this->parser->parse('modulos/formularioCotizaEng.html',$cont,true);
    }

    function cleanTxt($cad=''){
        $cadena = str_replace('<p>','',$cad);
        $cadena = str_replace('</p>','',$cadena);
        $cadena = trim($cadena);

        return $cadena;
    }
    
}