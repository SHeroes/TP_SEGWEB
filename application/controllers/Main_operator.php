<?php

class Main_operator extends CI_Controller{

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
    if($this->basic_level() != 3) {
      $this->load->view('restricted',$this->data);
      return ;
    }
    $this->load->model('sector_m');
    $this->load->model('domicilio_m');
    $this->load->model('vecino_m');
    //$new_data['last_10_days_reclamos'] = '';

    $new_data['secretarias'] = $this->sector_m->get_all_sector_by_type('Secretaria');
    $new_data['oficinas'] = $this->sector_m->get_all_sector_by_type('Oficina');
    $new_data['vecinos_filtrados'] = '';
    $new_data['id_vecino'] = '';
    $new_data['name_vecino'] = '';


    $new_data['all_domicilios_reclamo'] = $this->domicilio_m->get_all_domicilios_reclamo();
    $new_data['all_barrios'] = $this->domicilio_m->get_all_barrios();

    //si se post algo como filtro lo uso, sino no muestro ninguno
    $post = $this->input->post(null,true);
    if( count($post) ) {

      if (isset($post['id_vecino'])){
          $new_data['id_vecino'] = $post['id_vecino'];
          $new_data['name_vecino'] = $post['name_vecino'];
          if (isset($post['secretaria_filter'])){
            $new_data['secretaria_selected'] = $post['secretaria_filter'];
            $new_data['oficinas_filtradas'] = $this->sector_m->get_all_sector_by_father_id($new_data['secretaria_selected']);
            //print_r($new_data['oficinas_filtradas']);
          }
          if (isset($post['oficina_filter'])){
            $this->load->model('reclamo_tipo_m');
            $new_data['tipo_reclamos_filtrados'] = $this->reclamo_tipo_m->get_all_tipo_reclamos_by_sector($post['oficina_filter']);
            
            $new_data['id_actual_user'] = $this->session->userdata('id');
            $new_data['vecinos'] = $this->vecino_m->get_all_vecinos();

          }
      } else {
          if (isset($post['DNI_filter'])){
            $new_data['vecinos_filtrados'] = $this->vecino_m->get_vecinos_by_DNI($post['DNI_filter']);
          }
          if (isset($post['Apellido_filter'])){
            $new_data['vecinos_filtrados'] = $this->vecino_m->get_vecinos_by_Apellido($post['Apellido_filter']);
          }

          if( count($new_data['vecinos_filtrados']) == 0){
            //$new_data['all_domicilios'] = $this->domicilio_m->get_all_domicilios();
            $new_data['all_localidades'] = $this->domicilio_m->get_all_localidades();
            
          }
      }

    } else { //NO HAY FILTRADOS TODAVIA

    }

    

    $this->load->view('main_operator',$this->data);
    $this->load->view('reclamos',$new_data);
    $this->load->view('footer_base',$this->data);
	}

	function show_vecinos() {
    if($this->basic_level() != 3) {
      $this->load->view('restricted',$this->data);
      return ;
    }
    $this->load->model('domicilio_m');
    $this->load->model('vecino_m');
    
    $new_data['vecinos_filtrados'] = '';
    //si se post algo como filtro lo uso, sino no muestro ninguno
    $vecino_filter = $this->input->post(null,true);
    if( count($vecino_filter) ) {
      if (isset($vecino_filter['DNI_filter'])){
        $new_data['vecinos_filtrados'] = $this->vecino_m->get_vecinos_by_DNI($vecino_filter['DNI_filter']);
      }
      if (isset($vecino_filter['Apellido_filter'])){
        $new_data['vecinos_filtrados'] = $this->vecino_m->get_vecinos_by_Apellido($vecino_filter['Apellido_filter']);
      }
    }

    // $new_data['all_domicilios'] = $this->domicilio_m->get_all_domicilios();
    $new_data['all_localidades'] = $this->domicilio_m->get_all_localidades();
    $new_data['all_barrios'] = $this->domicilio_m->get_all_barrios();

    $this->load->view('main_operator',$this->data);
    $this->load->view('vecinos',$new_data);
    $this->load->view('footer_base',$this->data);
	}

  function show_reclamos(){
    if($this->basic_level() != 3) {
      $this->load->view('restricted',$this->data);
      return ;
    }

    $this->load->model('reclamo_m');

    $new_data['reclamos_list'] = '';

    $post = $this->input->post(null,true);
    if( count($post)){
      if(isset($post['status_filter_selector'])){
        $new_data['reclamos_list'] = $this->reclamo_m->get_all_reclamos_con_vecino_by('estado',$post['status_filter_selector']);
      } 
      if (isset($post['DNI_filter_sel'])){
        $new_data['reclamos_list'] = $this->reclamo_m->get_all_reclamos_con_vecino_by('DNI',$post['DNI_filter_sel']);
      }
      if (isset($post['Apellido_filter_sel'])){
        $new_data['reclamos_list'] = $this->reclamo_m->get_all_reclamos_con_vecino_by('Apellido',$post['Apellido_filter_sel']);
      }
      if (isset($post['num_reclamo_sel'])){
        $new_data['reclamos_list'] = $this->reclamo_m->get_all_reclamos_con_vecino_by('codigo_reclamo',$post['num_reclamo_sel']);
      }
    }else{
      $new_data['reclamos_list'] = $this->reclamo_m->get_all_reclamos_con_vecino_by('estado','');
    }
    $this->load->view('main_operator',$this->data);
    $this->load->view('show_reclamos',$new_data);
    $this->load->view('footer_base',$this->data);   
  }

  function update_reitero_reclamo(){
    $info = $this->input->post(null,true);
    
    print_r($info);

    if( count($info) ) {
      $this->load->model('reclamo_m');
      $saved = $this->reclamo_m->update_reitero_reclamo($info['num_reitero'],$info['id_reclamo'],$info['str_comentario']);
    }
    
  }

  function insert_reclamo(){
    $info = $this->input->post(null,true);
    if ( !isset($info['usar_domicilio_vecino'])){
      $info['usar_domicilio_vecino'] = false;
    }
    if( count($info) ) {
      $this->load->model('reclamo_m');

      if ($info['usar_domicilio_vecino']){
        $this->load->model('domicilio_m');
        $info['idDomicilioParaReclamo'] = $this->domicilio_m->search_Dom_by_Vecino($info['id_vecino']);
      }
      $saved = $this->reclamo_m->create_reclamo($info,$info['usar_domicilio_vecino']);
    }
    if ( isset($saved) && $saved ) {
      echo '<script> alert( "Numero de Reclamo:  '.$saved.'");
          window.location.replace("/index.php/main_operator/show_main");   
      </script>';
       //echo "reclamo agregado exitosamente";      
       //redirect('main_operator/show_main');
    }
  }

  function insert_varios_reclamos(){
    $info = $this->input->post(null,true);
    if ( !isset($info['usar_domicilio_vecino'])){
      $info['usar_domicilio_vecino'] = false;
    }
    if( count($info) ) {
      $this->load->model('reclamo_m');
      if ($info['usar_domicilio_vecino']){
        $this->load->model('domicilio_m');
        $info['idDomicilioParaReclamo'] = $this->domicilio_m->search_Dom_by_Vecino($info['id_vecino']);
      }      
      $saved = $this->reclamo_m->create_reclamo($info,$info['usar_domicilio_vecino']);
    }
    if ( isset($saved) && $saved ) {
      //echo '<script> alert( "Numero de Reclamo:  '.$saved.'");</script>';
      echo "Reclamo agregado exitosamente. Numero de Reclamo:  " .$saved;      
    }
  }

  function insert_vecino() {
    echo '<script src="'. base_url() .'assets/js/vendor/jquery-1.9.0.min.js"></script>';
    $info = $this->input->post(null,true);
    //print_r($info);

    if( count($info) ) {
      $this->load->model('vecino_m');
      $saved = $this->vecino_m->create_vecino($info);
    }
    if ( isset($saved) && $saved ) {
       echo "Vecino agregado exitosamente";
       $vecino_info = $this->vecino_m->get_vecino_info($saved);
       //print_r($vecino_info);
       
       $name_vecino = 'name_vecino';
       $name_vecino = $vecino_info['Apellido'] . ", " . $vecino_info['Nombre'];

        echo '<form id="form-id-vecino-creado" action="/index.php/main_operator/show_main" method="POST" >
        <p><input hidden  type="text" class="span4 id_vecino" name="id_vecino" value="'. $saved .'" id=""></p>
    <p><input hidden  type="text" class="span4 name_vecino" name="name_vecino" value="'. $name_vecino .'" id=""></p>
        </form>
        <script>
        $(document).ready(function(){
          $("form#form-id-vecino-creado").submit(function(){
              alert("Se ha Registrado al Vecino: '. $name_vecino .' correctamente, Se procede a la toma del reclamo");
          });
          $("form#form-id-vecino-creado").submit();
        });
        </script>';

       //redirect('main_operator/show_main');
    }

  }

  function search_calle(){
    $this->load->model('domicilio_m');
    $search =  $this->input->post('searchCalle');    
    $query = $this->domicilio_m->get_calle($search);
    echo json_encode ($query);
  }


  function show_observaciones(){
    $this->load->model('reclamo_m');
    $id_reclamo =  $this->input->post('id_reclamo');    
    $result = $this->reclamo_m->show_observaciones($id_reclamo);
    echo json_encode ($result);
  }

  function search_domicilio_by_id_vecino(){
    
    $this->load->model('domicilio_m');
    $id_vecino =  $this->input->post('id_vecino');
    $info = $this->domicilio_m->buscar_info_domicilio_by_id_vecino($id_vecino);
    echo json_encode ($info);
    
  }


}