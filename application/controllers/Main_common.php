<?php

class Main_common extends CI_Controller{

	var $data = array(
		'perfil' => '' ,
		'perfil_lvl' => 9 ,
		'is_admin' => false,
		'name' => ''
	);

	public function __construct(){
		parent::__construct();
		if( !$this->session->userdata('isLoggedIn') ) {
		redirect('/login/show_login');   
		}
	}
	function search_imagenes_por_reclamo(){
		$this->load->model('reclamo_m');
		$id_reclamo =  $this->input->post('id_reclamo');    
		$query = $this->reclamo_m->get_images($id_reclamo);
		echo json_encode ($query);    
	}
	
	public function get_vecino_info(){
		$this->load->model('vecino_m');
		$id_vecino =  $this->input->post('id_vecino');
		$query = $this->vecino_m->get_vecino_info($id_vecino);
		echo json_encode ($query);
	}

}