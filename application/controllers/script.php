<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Script extends CI_Controller {

	/** Desarrollado por: Juan José Villanueva */

	public function __construct()
	{
		parent:: __construct ();
		$this->load->model('web_model');
	}

	public function index()
	{
		// $this->web_model->execQuery("INSERT INTO `gen_user_perm` VALUES ('1', '11', '1');");
	}
	

}