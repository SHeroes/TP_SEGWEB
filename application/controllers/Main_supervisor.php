<?php

class Main_supervisor extends CI_Controller{

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
            break;            
        case 5: 
            $this->data['perfil'] = 'Intendente';  
            break;
        case 13:
            $this->data['perfil'] = 'Operador Tramites';
            redirect('/tramites/main_tr_operator');
            break;               
      }
      return $this->data['perfil_lvl'];
  }

	function show_main() {
    if($this->basic_level() != 4) {
      $this->load->view('restricted',$this->data);
      return ;
    }

    $new_data['reclamos_list_no_vistos'] = '';

    $this->load->model('reclamo_m');

    $new_data['reclamos_list_no_vistos'] = $this->reclamo_m->get_reclamos_no_vistos_creados_hace_mas_un_dia();

    $this->load->view('main_supervisor',$this->data);
    $this->load->view('sup_rec_list_no_vistos',$new_data);
    $this->load->view('footer_base',$this->data);
	}

  function show_no_contact() {
    if($this->basic_level() != 4) {
      $this->load->view('restricted',$this->data);
      return ;
    }

    $new_data['reclamos_list_no_contactados'] = '';

    $this->load->model('reclamo_m');

    $new_data['reclamos_list_no_contactados'] = 
    $this->reclamo_m->get_reclamos_vistos_no_contactados_hace_mas_dos_dias();

    $this->load->view('main_supervisor',$this->data);
    $this->load->view('sup_rec_list_no_contact',$new_data);
    $this->load->view('footer_base',$this->data);
  }

  function show_contactados() {
    if($this->basic_level() != 4) {
      $this->load->view('restricted',$this->data);
      return ;
    }

    $new_data['reclamos_list_contactados'] = '';

    $this->load->model('reclamo_m');

    $new_data['reclamos_list_contactados'] = $this->reclamo_m->get_all_reclamos_contactados_no_verificados();

    $this->load->view('main_supervisor',$this->data);
    $this->load->view('sup_rec_list_contactados',$new_data);
    $this->load->view('footer_base',$this->data);
  }

  public function correctitud(){
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $id_supervisor = $this->session->userdata('id');
      $this->load->model('reclamo_m');
      $obs_str =  $this->input->post('observacion_input');
      $id_reclamo =  $this->input->post('id_reclamo');

      $saved = $this->reclamo_m->concat_observacion_esp($obs_str, $id_reclamo, $id_supervisor);
      echo json_encode ($saved);
      //print_r($saved);
    }
    if ( isset($saved) && $saved ) {
      echo 'Editado Correctamente';
    }
  }
  
  function show_verificados() {
    if($this->basic_level() != 4) {
      $this->load->view('restricted',$this->data);
      return ;
    }
    $new_data['reclamos_list_verificados'] = '';
    $this->load->model('reclamo_m');
    $new_data['reclamos_list_verificados'] = $this->reclamo_m->get_all_reclamos_verificados();

    $this->load->view('main_supervisor',$this->data);
    $this->load->view('sup_rec_list_verificados',$new_data);
    $this->load->view('footer_base',$this->data);
  }

  public function verificacion_reclamo(){
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $this->load->model('reclamo_m');

      $correctitud =  $this->input->post('correctitud');
      $id_reclamo =  $this->input->post('id_reclamo_asociado');

      $saved = $this->reclamo_m->verificacion_reclamo( $id_reclamo, $correctitud);
    }

    if ( isset($saved) && $saved ) {
      echo 'Verificado Correctamente';
    }
    //$this->load->view('test_query',$saved);
    //$this->load->view('footer_base',$this->data);  
  }

  function show_reclamos(){
    if($this->basic_level() != 4) {
      $this->load->view('restricted',$this->data);
      return ;
    }

    $this->load->model('reclamo_m');
    $this->load->model('user_m');
    $this->load->model('reclamo_tipo_m');
    $this->load->model('sector_m');

    $new_data['reclamos_list'] = '';
    $new_data['query_responsable'] = '';
    $new_data['query_tipos_reclamo'] = '';
    $new_data['query_sectores'] = '';


    $info = $this->input->post(null,true);

    if( count($info) ){
      if( !isset($info['status_filter_selector']))        $info['status_filter_selector'] = '';
      if( !isset($info['reclamoType_filter_selector']))   $info['reclamoType_filter_selector'] = '';
      if( !isset($info['desde']))                         $info['desde'] = '';
      if( !isset($info['hasta']))                         $info['hasta'] = '';
      if( !isset($info['sector_filter_selector_of']))     $info['sector_filter_selector_of'] = '';
      if( !isset($info['sector_filter_selector_sec']))    $info['sector_filter_selector_sec'] = '';
      if( !isset($info['responsable_filter_selector']))   $info['responsable_filter_selector'] = '';
      if( !isset($info['nro_rec']))                       $info['nro_rec'] = '';
      if( !isset($info['apellido']))                      $info['apellido'] = '';
      if( !isset($info['dni']))                           $info['dni'] = '';      
    } else {
      $info['status_filter_selector'] = '';
      $info['reclamoType_filter_selector'] = '';
      $info['desde'] = '';
      $info['hasta'] = '';
      $info['sector_filter_selector_of'] = '';
      $info['sector_filter_selector_sec'] = '';
      $info['responsable_filter_selector'] = '';
      $info['nro_rec'] = '';
      $info['apellido'] = '';
      $info['dni'] = '';      
    }

    $new_data['info'] = $info;
    $new_data['query_responsable'] = $this->user_m->get_all_users_responsables();
    $new_data['query_tipos_reclamo'] = $this->reclamo_tipo_m->get_all_tipo_reclamos();
    $new_data['query_secretarias'] = $this->sector_m->get_all_sector_by_type('Secretaria');
    $new_data['query_oficinas'] = $this->sector_m->get_all_sector_by_type('Oficina');

    $new_data['reclamos_list'] = $this->reclamo_m->get_all_reclamos_for_supervisor('estado',$info['status_filter_selector'], $info['sector_filter_selector_of'],$info['sector_filter_selector_sec'], $info['desde'], $info['hasta'], $info['reclamoType_filter_selector'], $info['responsable_filter_selector'], $info['nro_rec'], $info['apellido'], $info['dni'] );

    $this->load->view('main_supervisor',$this->data);
    $this->load->view('reclamos_supervisor',$new_data);
    $this->load->view('footer_base',$this->data);   
  }

  public function editar_observacion_esp(){
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $id_officer = $this->session->userdata('id');
      $this->load->model('reclamo_m');
      $obs_str =  $this->input->post('observacion_input');
      $id_reclamo =  $this->input->post('id_reclamo');

      $saved = $this->reclamo_m->concat_observacion_esp($obs_str, $id_reclamo, $id_officer);
      echo json_encode ($saved);
      //print_r($saved);
    }
    if ( isset($saved) && $saved ) {
      echo 'Editado Correctamente';
    }
  }


  public function reasignacion_reclamo(){
    $info = $this->input->post(null,true);
          print_r($info);
    if( count($info) ) {
      $this->load->model('reclamo_m');
      $id_new_tipo_reclamo =  $this->input->post('id_new_tipo_reclamo');
      $id_reclamo =  $this->input->post('id_reclamo');

      
      $returnOK = false;
      $returnOK = $this->reclamo_m->reasignar_reclamo($id_reclamo, $id_new_tipo_reclamo);
      
    }
    if ( $returnOK ) {
      echo 'Reasignado Correctamente';
    }
  }

}