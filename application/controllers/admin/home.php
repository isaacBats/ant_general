<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->post=$this->input->post();
        $this->adm=$this->config->item('admin');
        $this->load->library('session');
	}
    function index(){
    	$data=array('DIR'	=>site_url('assetsdm'),
    				'BASE'	=>site_url(),
                    'FORM'  =>site_url($this->adm.'/home/login')
    				);
        $this->parser->parse('adm/home.html',$data);
    }
    function login(){
    	$msg='';
    	if(!$this->post)
    		redirect($this->adm);

    	$this->load->library('form_validation');
    	$this->form_validation->set_rules('txt_usr', 'Usuario', 'required');
    	$this->form_validation->set_rules('txt_pass', 'Password', 'required');

    	if($this->form_validation->run() && $this->post){

	        $data=array('user'	=>$this->post['txt_usr'],
	                    'pass'	=>md5($this->post['txt_pass']),
	                    'active'=>1
	                    );

	        $sq=$this->db->get_where(DB.'user',$data,1);

	        if($sq->num_rows()){
                foreach($sq->result() as $ud);
	            $this->session->set_userdata('loguear',$ud->id);
	            echo '<script>top.location.href="'.site_url($this->adm.'/menu').'"</script>';
	        }
	        else{
	            $msg='El usuario no existe';
	        }
    	}else
    		$msg=validation_errors();

    		echo '<div id="error">'.$msg.'<div>';
    }
    function cerrar(){
    	$this->session->unset_userdata('loguear');
        redirect($this->adm);
    }
}