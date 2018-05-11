<?php

class Main_secretary_coord extends CI_Controller{

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
            redirect('/main_supervisor/show_main'); 
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
    if($this->basic_level() != 1) {
      $this->load->view('restricted',$this->data);
      return ;
    }
    //$id_sector = $this->details->id_sector;
    $id_sector = $this->session->id_sector;
    $new_data['reclamos_list'] = '';
    $new_data['user_enable'] = 'officer';
    $new_data['list_reclaim_type'] = array();
    $new_data['list_responsables_posibles'] = array();
    $new_data['list_oficinas_posibles'] = array();
    $new_data['array_id_tipo_reclamo'] = array();


    $this->load->model('reclamo_tipo_m');

     //si se post algo como filtro lo uso, sino no muestro ninguno
    $info = $this->input->post(null,true);  
    $sectores_multiples = $this->session->sectores_multiples;  

    //si se post algo como filtro lo uso, sino no muestro ninguno
    $info = $this->input->post(null,true);
    if( count($info) ){
      if (!isset($info['status_filter_selector']))        $info['status_filter_selector'] = '';
      if( !isset($info['reclamoType_filter_selector']))   $info['reclamoType_filter_selector'] = '';
      if( !isset($info['desde']))                         $info['desde'] = '';
      if( !isset($info['hasta']))                         $info['hasta'] = '';
      if( !isset($info['sector_filter_selector']))        $info['sector_filter_selector'] = '';
      if( !isset($info['responsable_filter_selector']))   $info['responsable_filter_selector'] = '';
      if( !isset($info['nro_rec']))                       $info['nro_rec'] = '';
      if( !isset($info['apellido']))                      $info['apellido'] = '';
      if( !isset($info['dni']))                           $info['dni'] = '';      
    } else {
      $info['status_filter_selector'] = '';
      $info['reclamoType_filter_selector'] = '';
      $info['desde'] = '';
      $info['hasta'] = '';
      $info['sector_filter_selector'] = '';
      $info['responsable_filter_selector'] = '';
      $info['nro_rec'] = '';
      $info['apellido'] = '';
      $info['dni'] = '';      
    }
    if ($sectores_multiples){
      $array_sectores = $this->session->array_sectores;
      foreach ($array_sectores as $row => $value) {
        $sectorArray = $this->reclamo_tipo_m->get_all_tipo_reclamos_by_sector($array_sectores[$row]->id_sector) ;
        array_push( $new_data['list_reclaim_type'], $sectorArray );
      }
    }else{
      $id_secretaria = $this->session->id_sector;
      $sectorArray2 = $this->reclamo_tipo_m->get_all_tipo_reclamos_by_secretary($id_secretaria) ;
      array_push( $new_data['list_reclaim_type'], $sectorArray2 );
    }

    foreach ($new_data['list_reclaim_type'] as $row => $value) {
      foreach ($value as $row => $v2) {
        array_push($new_data['array_id_tipo_reclamo'], $v2->id_tipo_reclamo);
      }
    }

    $this->load->model('reclamo_m');

    if(!$sectores_multiples){
      $new_data['reclamos_list'] = $this->reclamo_m->get_all_reclamos_for_secretary_by('estado',$info['status_filter_selector'], $id_sector, $info['desde'], $info['hasta'], $info['reclamoType_filter_selector'], $info['sector_filter_selector'], $info['responsable_filter_selector'], $info['nro_rec'], $info['apellido'], $info['dni'] ); 
    }else{
      $new_data['reclamos_list'] = $this->reclamo_m->get_all_reclamos_for_secretary_by_mutiples_sectores('estado',$info['status_filter_selector'], $array_sectores, $info['desde'], $info['hasta'], $info['reclamoType_filter_selector'], $info['sector_filter_selector'], $info['responsable_filter_selector'], $info['nro_rec'], $info['apellido'], $info['dni'] );
    } 

    $new_data['info'] = $info;
    $new_data['query_tipo_reclamo'] = $this->reclamo_m->get_responsables_y_oficinas_by_id_tipo_reclamo($new_data['array_id_tipo_reclamo']);
    //$info['responsable_filter_selector'] = '';

    $this->load->view('main_secretary_coord',$this->data);
    $this->load->view('reclamos_secretary_coord',$new_data);
    $this->load->view('footer_base',$this->data);
	}


  public function editar_observacion(){
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $id_officer = $this->session->userdata('id');
      $this->load->model('reclamo_m');
      $obs_str =  $this->input->post('observacion_input');
      $id_reclamo =  $this->input->post('id_reclamo');

      $saved = $this->reclamo_m->concat_observacion($obs_str, $id_reclamo, $id_officer);
      echo json_encode ($saved);
      //print_r($saved);
    }
    if ( isset($saved) && $saved ) {
      echo 'Editado Correctamente';
    }
  }

  public function ver_observaciones(){
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $this->load->model('reclamo_m');
      $id_reclamo =  $this->input->post('id_reclamo');

      $saved = $this->reclamo_m->show_observaciones($id_reclamo);
      echo json_encode ($saved);
      //print_r($saved);
    }
    if ( isset($saved) && $saved ) {
      //echo 'Editado Correctamente';
    }
  }

  public function actualizar_estado(){
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $this->load->model('reclamo_m');
      $str_state =  $this->input->post('state');
      $id_reclamo =  $this->input->post('id_reclamo');
      $saved = $this->reclamo_m->update_state_reclamo($str_state, $id_reclamo);
    }
    if ( isset($saved) && $saved ) {
      echo 'Estado del Reclamo actualizado Correctamente';
    }
  }

}