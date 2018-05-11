<?php

class Main_admin extends CI_Controller{
  var $data = array(
    'perfil' => '' ,
    'perfil_lvl' => 9 ,
    'is_admin' => false,
    'name' => ''
   );

  public function __construct()
  {
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
            break;
        case 13:
            $this->data['perfil'] = 'Operador Tramites';
            redirect('/tramites/main_tr_operator');
            break; 
      }
      return $this->data['perfil_lvl'];
  }

  /* SECCION TRAMITES */
  function pasos_admin_tramites(){
    if($this->basic_level() != 0) {
      $this->load->view('restricted',$this->data);
      return ;
    }
    $this->load->model('tramites_m');
    $this->data['array_pasos']= '';
    $this->data['array_pasos']= $this->tramites_m->get_all_pasos_by_id_order();
    $this->load->model('sector_m');
    $this->data['array_sectores_uso']= $this->sector_m->get_sectors_in_use();

    $this->load->view('tramites/tr_admin_main',$this->data);
    $this->load->view('tramites/tr_admin_pasos',$this->data);
    $this->load->view('footer',$this->data);
  }

  function formularios_admin_tramites(){
    if($this->basic_level() != 0) {
      $this->load->view('restricted',$this->data);
      return ;
    }
    $this->load->model('tramites_m');
    $this->data['array_pasos']= '';
    $this->data['array_pasos']= $this->tramites_m->get_all_pasos_by_id_order();

    $this->load->view('tramites/tr_admin_main',$this->data);
    $this->load->view('tramites/tr_admin_formularios',$this->data);
    $this->load->view('footer',$this->data);
  }

  function tipo_tramite_admin_tramites(){
    if($this->basic_level() != 0) {
      $this->load->view('restricted',$this->data);
      return ;
    }
    $this->load->model('tramites_m');
    $this->data['array_pasos']= '';
    $this->data['array_pasos']= $this->tramites_m->get_all_pasos_by_id_order();
    $this->data['grupos'] = '';
    $this->data['grupos'] = $this->tramites_m->get_all_grupos();

    $this->load->view('tramites/tr_admin_main',$this->data);
    $this->load->view('tramites/tr_admin_armar_ttr',$this->data);
    $this->load->view('footer',$this->data);
  }

  function insertar_tipo_tramite(){
    if($this->basic_level() != 0) {
      $this->load->view('restricted',$this->data);
      return ;
    }
    $this->load->model('tramites_m');
    $data = $this->input->post(null,true);
    $array_id_ubicacion = array();
    $array_id_tiempo = array();    
    $array_info = array();
    foreach ($data as $key => $value) {
        $substr = substr($key, 0, 15);
        if ($key!='titulo' and $key != 'descripcion' and $key != 'grupo' and $substr != 'tiempo_estimado' and $value != ''){
            //array_push($array_ids, $key);
            $obj_dupla = new stdClass();
            $obj_dupla->id = $key; 
            $obj_dupla->ubicacion = $value;
            array_push($array_id_ubicacion, $obj_dupla);
        } else if ($substr == 'tiempo_estimado' and $value != ''){
            $obj = new stdClass();
            $obj->id = substr($key, 15); 
            $obj->tiempo = $value;
            array_push($array_id_tiempo, $obj);
        } else if($key == 'titulo' or $key == 'descripcion' or $key == 'grupo'){
            $array_info[$key]=$value;
        }
    }
    /*
    ?><pre><?php     print_r($array_id_ubicacion);    ?></pre><pre><?php    print_r($array_id_tiempo);
    ?></pre><pre><?php  print_r($array_info);    ?></pre><?php    
    */

    if( count($data) ) { 
      $saved = $this->tramites_m->insertar_tipo_tramite($array_id_ubicacion,$array_id_tiempo,$array_info);
    }
    if ( isset($saved) && $saved ) {
      //echo "success";
      redirect('/main_admin/tipo_tramite_admin_tramites');
    }
  }



  function insertar_paso_tramite(){
    $data = $this->input->post(null,true);
    if( count($data) ) {
      $this->load->model('tramites_m');
      $saved = $this->tramites_m->insertar_paso_tramite($data);
    }
    if ( isset($saved) && $saved ) {
       //echo "success";
       redirect('/main_admin/pasos_admin_tramites');
    }    
  }
  /*
      FIN DE LA SECCION DE TRAMITES
  */

  function show_main() {    
    if($this->basic_level() != 0) {
      $this->load->view('restricted',$this->data);
      return ;
    }
    $this->load->model('sector_m');
    $sectores = $this->sector_m->get_all_sectores();
    $this->data['array_sectores'] = $sectores;

    $this->load->model('user_m');
    $all_users = $this->user_m->get_all__users();
    $this->data['all_users'] = $all_users;

    $this->load->view('main_admin',$this->data);
    $this->load->view('usuarios',$this->data);
    $this->load->view('footer',$this->data);
  }

  function show_sector() {
    if($this->basic_level() != 0) {
      $this->load->view('restricted',$this->data);
      return ;
    }
    $this->load->model('sector_m');
    $sectores = $this->sector_m->get_all_sectores();
    $this->data['array_sectores'] = $sectores;
    $this->load->view('main_admin',$this->data);
    $this->load->view('sectores',$this->data);
    $this->load->view('footer',$this->data);
  }

  function create_new_sector() {
    $userInfo = $this->input->post(null,true);
    if( count($userInfo) ) {
      $this->load->model('sector_m');
      $saved = $this->sector_m->create_new_sector($userInfo);
    }
    if ( isset($saved) && $saved ) {
       echo "success";
    }
  }

  function update_sector() {
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $this->load->model('sector_m');
      $saved = $this->sector_m->update_sector_id($info['id_sector'],$info);
    }
    if ( isset($saved) && $saved ) {
       echo "success";
    }
  }


  function create_new_user() {
    $userInfo = $this->input->post(null,true);

    if( count($userInfo) ) {
      $this->load->model('user_m');
      $saved = $this->user_m->create_new_user($userInfo);
    }

    if ( isset($saved) && $saved ) {
       echo "success creating user with id:".$saved;
    }
  }

  function update_user() {
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $this->load->model('user_m');
      $saved = $this->user_m->update_user_id($info['id'],$info);
    }
    if ( isset($saved) && $saved ) {
       echo "success";
    }
  }

  // cuando lo actualizo yo
  function update_pass() {
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $this->load->model('user_m');
      $saved = $this->user_m->change_password_user($info['id'],$info['pass']);
    }
    if ( isset($saved) && $saved ) {
       echo "success";
    }
  }

  //cuando lo resetea al administrador
  function reset_password() {
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $this->load->model('user_m');
      $saved = $this->user_m->change_password_user($info['id'],$info['password']);
    }
    if ( isset($saved) && $saved ) {
       echo "success";
    }
  }



  function show_calendar() {
    if($this->basic_level() != 0) {
      $this->load->view('restricted',$this->data);
      return ;
    }
    $this->load->model('calendar_m');
    $fechas = $this->calendar_m->get_holy_dates();
    $this->data['array_fechas'] = $fechas;

    $this->load->view('main_admin',$this->data);
    $this->load->view('calendar',$this->data);     
    $this->load->view('footer',$this->data);
  }

  function insert_date() {
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $this->load->model('calendar_m');
      $saved = $this->calendar_m->insert_date($info['datepicker']);
    }
    if ( isset($saved) && $saved ) {
       echo "feriado agregado exitosamente";
       redirect('main_admin/show_calendar');
    }
  }

  function delete_date() {
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $this->load->model('calendar_m');
      $saved = $this->calendar_m->delete_date($info['datepicker2']);
    }
    if ( isset($saved) && $saved ) {
       echo "feriado eliminado exitosamente";
        redirect('main_admin/show_calendar');
    }
  }

  function show_reclamo_tipo() {
    if($this->basic_level() != 0) {
      $this->load->view('restricted',$this->data);
      return ;
    }
    $this->load->model('reclamo_tipo_m');
    $tipos_reclamos = $this->reclamo_tipo_m->get_all_tipo_reclamos();
    $this->data['tipos_reclamos'] = $tipos_reclamos;
    $responsables = $this->reclamo_tipo_m->get_responsables();
    $this->data['array_responsables'] = $responsables;      

    $this->load->view('main_admin',$this->data);
    $this->load->view('reclamos_catalogo',$this->data);     
    $this->load->view('footer',$this->data);
  }

  function insertar_tipo_reclamo() {
      $info = $this->input->post(null,true);
      if( count($info) ) {
        $this->load->model('reclamo_tipo_m');
        $saved = $this->reclamo_tipo_m->insert_tipo_reclamo($info);
      }
      if ( isset($saved) && $saved ) {
         echo "reclamo agregado exitosamente";
         redirect('main_admin/show_reclamo_tipo');
      }
  }

  function modificar_tipo_reclamo() {
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $this->load->model('reclamo_tipo_m');
      $saved = $this->reclamo_tipo_m->update_tipo_reclamo($info);
    }
    if ( isset($saved) && $saved ) {
       echo "reclamo modificado exitosamente";
       redirect('main_admin/show_reclamo_tipo');
    }
  }
  
  function desactivar_tipo_reclamo() {
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $this->load->model('reclamo_tipo_m');
      $saved = $this->reclamo_tipo_m->disable_tipo_reclamo($info);
    }
    if ( isset($saved) && $saved ) {
       echo "reclamo deshabilitado exitosamente";
        redirect('main_admin/show_reclamo_tipo');
    }
  }

}
