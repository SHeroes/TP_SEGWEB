<?php

class Main_tr_operator extends CI_Controller{

  var $data = array(
    'perfil' => '' ,
    'perfil_lvl' => 9 ,    // TODO poner usuarios para hacer le correcto login
    'is_admin' => false,
    'name' => ''
   );

	public function __construct(){
		parent::__construct();
    
		if( !$this->session->userdata('isLoggedIn') ) {
	    redirect('/login/show_login');   
      //print_r("hola");
		}
    
	}

  public function index()
  {
    if($this->basic_level() != 13) {
      $this->load->view('restricted',$this->data);
      return ;
    }
    $this->load->model('tramites_m');
    $info = $this->input->post(null,true);
    if( count($info) ){
      if( !isset($info['typePaso']))                    $info['typePaso'] = '';
      if( !isset($info['desde']))                       $info['desde'] = '';
      if( !isset($info['hasta']))                       $info['hasta'] = '';
      if( !isset($info['nro_tr']))                      $info['nro_tr'] = '';
      if( !isset($info['apellido']))                    $info['apellido'] = '';
      if( !isset($info['dni']))                         $info['dni'] = '';
    } else {
      $info['typePaso'] = '';
      $info['desde'] = '';
      $info['hasta'] = '';
      $info['nro_tr'] = '';
      $info['apellido'] = '';
      $info['dni'] = '';
    }

    $new_data['pasos_list'] = $this->tramites_m->get_pasos_by_sector($this->session->id_sector);
    $new_data['tramites_list'] = $this->tramites_m->get_all_tramite_for_op($this->session->id_sector,$info['desde'], $info['hasta'], $info['typePaso'], $info['nro_tr'], $info['apellido'], $info['dni'] );
  
    $this->load->view('tramites/tr_office_main',$this->data);
    $this->load->view('tramites/tr_office_show',$new_data);
    $this->load->view('footer_base',$this->data);

  }


  public function tratar_paso(){
    if($this->basic_level() != 13) {
      $this->load->view('restricted',$this->data);
      return ;
    }
    $this->load->model('tramites_m');
    $info = $this->input->get(null,true);

    $new_data['formularios'] = $this->tramites_m->get_formularios_by_ttrId($info['id_ttr']);
    $new_data['ttr_pasos'] = $this->tramites_m->get_pasos_by_ttr_id($info['id_ttr']);
    $new_data['ttr_data'] = $this->tramites_m->get_ttr_by_id($info['id_ttr']);
    $new_data['paso_array'] = array();
    foreach ($new_data['ttr_pasos'] as $key => $value) {
      if ($value['tr_paso_id'] = $info['id_paso']){
        $new_data['paso_array'] = $value;
      }
    }


    $this->load->view('tramites/tr_office_main',$this->data);
    $this->load->view('tramites/tr_office_edit_paso',$new_data);
    $this->load->view('footer_base',$this->data);
  }


  public function basic_level(){
      $this->data['name'] = $this->session->name;
      $this->data['my_id_user'] = $this->session->userdata('id');
      $this->data['my_sha1_pass'] = $this->session->userdata('password');      
      $this->data['perfil_lvl'] = $this->session->userdata('perfil_level');
      switch ($this->data['perfil_lvl']){
        case 0:
            $this->data['perfil'] = 'Administrador';
            $this->data['is_admin'] = true;
            redirect('/main_admin/show_main');
            break;
        case 1: 
            $this->data['perfil'] = 'Secretario';
            redirect('/main_secretary_coord/show_main');
            break;
        case 2:
            $this->data['perfil'] = 'Oficina';
            redirect('/main_office/show_main');
            break;
        case 3: 
            $this->data['perfil'] = 'Operador';
            redirect('/main_operator/show_main');
            break;
        case 4: 
            $this->data['perfil'] = 'Supervisor';
            redirect('/main_supervisor/show_main'); 
            break;            
        case 5: 
            $this->data['perfil'] = 'Intendente';
            //no esta hecho el perfil de intendente todavia
            break;
        case 13: // OPARADOR TRAMITES
            $this->data['perfil'] = 'Operador Tramites';
            break;
      }
      return $this->data['perfil_lvl'];
  }

}