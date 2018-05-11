<?php

class Coord_gen extends CI_Controller{

  // ESTE ARCHIVO ES PARA CREAR LAS COORDENADAS DE LAS DIRECCIONES YA EXISTENTES, NO DEBERIA VOLVER A USARSE
  var $data = array(
    'perfil' => '' ,
    'perfil_lvl' => 9 ,    // TODO poner usuarios para hacer le correcto login
    'is_admin' => false,
    'name' => ''
   );


	public function __construct(){
		parent::__construct();
    
    /*   TODO UNA vez utilizado, volver a descomentar esto para que nadie acceda por error

		if( !$this->session->userdata('isLoggedIn') ) {
	    redirect('/login/show_login');   
      //print_r("hola");
		}
    */
    
	}

  public function actualizar_domicilio(){

    $this->load->model('maps_m');
    $info = $this->input->post(null,true);

    if( count($info) ){
      if( !isset($info['loc']))                    $info['loc'] = '';
      if( !isset($info['dom']))                       $info['dom'] = '';
      if( !isset($info['lat']))                       $info['lat'] = '';
      if( !isset($info['lng']))                      $info['lng'] = '';
    } else {
      $info['loc'] = '';
      $info['dom'] = '';
      $info['lat'] = '';
      $info['lng'] = '';
    }
    
    $this->maps_m->update_domicilio($info['dom'],$info['loc'],$info['lat'],$info['lng']);
    redirect('/edesur/maps/Coord_gen/');  
  }

  public function index(){
    /*   TODO UNA vez utilizado, volver a descomentar esto para que nadie acceda por error
    if($this->session->userdata('perfil_level') != 0) {
      $this->load->view('restricted',$this->data);
      return ;
    }
  */
    $this->load->model('maps_m');
    $array = $this->maps_m->getUnDomicilio();
    if (!empty($array) ){
      $new_data['unDomicilio'] = $array[0]; 
      $this->load->view('maps/main_blank',$new_data);
      $this->load->view('maps/footer',$this->data);       
    } else {
      echo 'Se han actualizado todas las coordenadas de los domicilios disponibles';      
    }

  }






}