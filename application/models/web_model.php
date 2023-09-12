<?php 

class Web_model extends Ci_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_test = $this->load->database('default', TRUE);
    }

    public function execQuery($query){
        $this->db->query($query);
        return $query->result();
    }

    public function UpdateRow($table,$id,$data){
        $this->db->where('id',$id);
        $this->db->update($table,$data);
    }

    public function getTable($table){
        $query = $this->db->get($table);
        return $query->result();
    } 

    public function getTableOrder($table){
        $this->db->order_by('id','ASC');
        $query = $this->db->get($table);
        return $query->result();
    } 

    public function getId($table,$campo,$id){
        $this->db->where($campo, $id);
        $query = $this->db->get($table);
        return $query->result();
    } 
    public function getIdOrder($table,$campo,$id){
        $this->db->order_by('id','ASC');
        $this->db->where($campo, $id);
        $query = $this->db->get($table);
        return $query->result();
    } 

    public function insertar($table,$datos){
        $this->db->insert($table, $datos);
    } 
    public function ultimoInsert(){
        return $this->db->insert_id();
    } 
    public function actualizar($table,$campo,$id,$datos){
        $this->db->where($campo, $id);
        $this->db->update($table, $datos); 
    } 
    public function getModPag($id){
        $this->db->where('id_pag', $id);
        $this->db->order_by('priority', 'ASC');
        $query = $this->db->get('gen_pagina_modulo');
        return $query->result();
    }
    public function getModLPag($id){
        $this->db->where('id_pag', $id);
        $this->db->order_by('priority', 'ASC');
        $query = $this->db->get('gen_landing_modulo');
        return $query->result();
    } 

    public function deletePM($table,$mod,$pag){
        $this->db->where('id_mod', $mod);
        $this->db->where('id_pag', $pag);
        $this->db->delete($table);
    } 

    public function ligas1(){
        $this->db->where('mostrar_en_menu',1);
        $this->db->order_by('orden','asc');
        $query = $this->db->get('gen_paginas');
        return $query->result();
    } 

    public function ligas2(){
        $this->db->where('mostrar_en_menu',NULL);
        $this->db->or_where('mostrar_en_menu',0);
        $query = $this->db->get('gen_paginas');
        return $query->result();
    } 

    public function getUbica($pag,$map){
        $this->db->where('id_pag',$pag);
        $this->db->where('id_map',$map);
        $query = $this->db->get('mod_ubicaciones');
        return $query->result();
    } 

    public function getUni(){
        $this->db->select('id,icono,nombre_icono,slug');
        $this->db->order_by('id','ASC');
        $query = $this->db->get('mod_unidades');
        return $query->result();
    } 
    public function getUniFull(){
        $this->db->order_by('id','ASC');
        $query = $this->db->get('mod_unidades');
        return $query->result();
    } 

    public function getGeneral(){
        $sitio = $this->getId('gen_datos_generales','id',1);
        $contacto = $this->getId('gen_paginas','id_pag',9);
        $desc = $this->getId('gen_paginas','id_pag',13);
        $priva = $this->getId('gen_paginas','id_pag',14);
        $term = $this->getId('gen_paginas','id_pag',15);
        $info =array(
            'TITULO'=>@$sitio[0]->titulo_principal,
            'DESCRIPCION'=>str_replace('</p>','',(str_replace('<p>','',@$sitio[0]->descripcion))),
            'PALABRAS_CLAVE'=>str_replace('</p>','',(str_replace('<p>','',@$sitio[0]->palabras_claves))),
            'ANALYTICS'=>@$sitio[0]->analytics,
            'FAVICON'=>@$sitio[0]->favicon,
            'TITLE'=>@$sitio[0]->main_title,
            'DESCRIPTION'=>str_replace('</p>','',(str_replace('<p>','',@$sitio[0]->description))),
            'KEYWORDS'=>str_replace('</p>','',(str_replace('<p>','',@$sitio[0]->keywords))),
            'URL_DESCARGAS'=>$desc[0]->url_pagina,
            'URL_DOWNLOADS'=>$desc[0]->url_page,
            'URL_CONTACTO'=>$contacto[0]->url_pagina,
            'URL_CONTACT'=>$contacto[0]->url_page,
            'URL_PRIVA'=>$priva[0]->url_pagina,
            'URL_PRIVA_ENG'=>$priva[0]->url_page,
            'URL_TERMINOS'=>$term[0]->url_pagina,
            'URL_TERMINOS_ENG'=>$term[0]->url_page,
        );
        return $info;

    }

    public function quitarEtiquetas($cad){
        $cad = str_replace('<p>','',$cad);
        $cad = str_replace('</p>','',$cad);
        $cad = str_replace('<span>','',$cad);
        $cad = str_replace('</span>','',$cad);
        return $cad;
    }
}