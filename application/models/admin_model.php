<?php 

class Admin_model extends Ci_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_test = $this->load->database('default', TRUE);
    }

    public function getSecciones(){
        $query = $this->db->order_by('seccion','ASC');
        $query = $this->db->get('obs_sec_centrodoc');
        return $query->result();
    }

    public function getPaises(){
        $query = $this->db->order_by('nombre','ASC');
        $query = $this->db->get('obs_pais');
        return $query->result();
    }

    public function getDimension($id){
        $query = $this->db->where('id_dimension',$id);
        $query = $this->db->get('obs_dimensiones');
        return $query->result();
    }

    public function getColaborador($id){
        $query = $this->db->where('id_colaborador',$id);
        $query = $this->db->get('obs_colaboradores');
        return $query->result();
    }

    public function consultaAdm($sql){
        $query=$this->db->query($sql);
        return $query->result();
    }
    

}