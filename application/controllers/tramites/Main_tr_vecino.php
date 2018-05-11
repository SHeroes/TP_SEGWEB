<?php

class Main_tr_vecino extends CI_Controller{

  var $data = array(
    'perfil' => '' ,
    'perfil_lvl' => 9 ,    // TODO poner usuarios para hacer le correcto login
    'is_admin' => false,
    'name' => ''
   );

	public function __construct(){
		parent::__construct();        
	}

  public function index()
  {
    redirect('/tramites/Main_tr_vecino/select_Vecino');
  }





  function show_ttr(){
    $get = $this->input->get(null,true);
    if(!isset($get['id_vecino']) OR !isset($get['ttr'])){
      redirect('/tramites/Main_tr_vecino/select_Vecino');
    }

    $ttr_id = $get['ttr'];
    $this->load->model('tramites_m');
    $new_data['id_vecino'] = $get['id_vecino'];
    $new_data['ttr'] = $get['ttr'];
    $new_data['ttr_data'] = $this->tramites_m->get_ttr_by_id($ttr_id);
    
    //pasos que corresponden al tramite elegido  
    $new_data['pasos'] = $this->tramites_m->get_pasos_by_ttr_id($ttr_id);

    //formularios que corresponden al tramite elegido
    $new_data['formularios'] = $this->tramites_m->get_formularios_by_ttrId($ttr_id);


    $this->load->view('tramites/tr_vecino_main',$this->data);
    $this->load->view('tramites/tr_show_ttr',$new_data);
    $this->load->view('tramites/tr_footer',$this->data);
  }













  function show_group(){
    $get = $this->input->get(null,true);
    if(!isset($get['id_vecino']) OR !isset($get['grupo'])){
      redirect('/tramites/Main_tr_vecino/select_Vecino');
    }
    print_r("show_group");   
  }

  function show_organismos(){
    $get = $this->input->get(null,true);
    if(!isset($get['id_vecino'])){
      redirect('/tramites/Main_tr_vecino/select_Vecino');
    }
        print_r("show_organismos");   
  }

  function show_temas(){
    $get = $this->input->get(null,true);
    if(!isset($get['id_vecino'])){
      redirect('/tramites/Main_tr_vecino/select_Vecino');
    }
            print_r("show_temas");
  }


  function select_Vecino(){
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

    $this->load->view('tramites/tr_vecino_main',$this->data);
    $this->load->view('tramites/vecinos',$new_data);
    $this->load->view('tramites/tr_footer_base',$this->data);
  }

  function show_main() {

    $new_data['vecinos_filtrados'] = '';
  
    $new_data['id_vecino'] = '';
    $new_data['name_vecino'] = '';

    //si se post algo como filtro lo uso, sino no muestro ninguno
    $post = $this->input->post(null,true);
    $get = $this->input->get(null,true);
    if( count($post) or count($get) ) {

      if (isset($post['id_vecino']) or isset($get['id_vecino'])){
          if (isset($post['id_vecino'])){
                  $new_data['id_vecino'] = $post['id_vecino'];
                  $new_data['name_vecino'] = $post['name_vecino'];
          } else{
                  $new_data['id_vecino'] = $get['id_vecino'];
                  $new_data['name_vecino'] = $get['name_vecino'];
          }

      } else { //NO HAY FILTRADOS TODAVIA, posiblemente un acceso mal por url
          redirect('tramites/Main_tr_vecino/select_Vecino');
      }
    } else { //NO HAY FILTRADOS TODAVIA
      redirect('tramites/Main_tr_vecino/select_Vecino');
    }
    //  $new_data tiene la info del vecino seleccionado
    $this->load->model('tramites_m');
    $ttr = $new_data['tipoTramites'] = $this->tramites_m->get_all_tipo_tramites_order_by_grupo();
    
    $new_data['grupos'] = $this->tramites_m->get_all_grupos();
  //  print_r($new_data['grupos']);



    $this->load->view('tramites/tr_vecino_main',$this->data);
    $this->load->view('tramites/tr_vecino_chose_tramite',$new_data);
    $this->load->view('tramites/tr_footer',$this->data);
  }

  function search_calle(){
    $this->load->model('domicilio_m');
    $search =  $this->input->post('searchCalle');    
    $query = $this->domicilio_m->get_calle($search);
    echo json_encode ($query);
  }

  function search_domicilio_by_id_vecino(){
    $this->load->model('domicilio_m');
    $id_vecino =  $this->input->post('id_vecino');
    $info = $this->domicilio_m->buscar_info_domicilio_by_id_vecino($id_vecino);
    echo json_encode ($info);   
  }

  function inciar_tramite(){
    $id_vecino =  $this->input->post('id_vecino');
    $ttr =  $this->input->post('ttr');
    $this->load->model('tramites_m');
    $info = $this->tramites_m->insertar_tramite($id_vecino,$ttr);
    echo ' <script>
          alert("tramite inciado - Nro: ' .$info .'.           Ahora dirijase a la oficina correspondiente");
          window.location.replace("select_Vecino"); 
        </script>';
  }

  function insert_vecino() {
    echo '<script src="'. base_url() .'assets/js/vendor/jquery-1.9.0.min.js"></script>';
    $info = $this->input->post(null,true);
    if( count($info) ) {
      $this->load->model('vecino_m');
      $saved = $this->vecino_m->create_vecino($info);
    }
    if ( isset($saved) && $saved ) {
       echo "vecino agregado exitosamente";
       $vecino_info = $this->vecino_m->get_vecino_info($saved);
       //print_r($vecino_info);
       
       $name_vecino = 'name_vecino';
       $name_vecino = $vecino_info['Apellido'] . ", " . $vecino_info['Nombre'];

        echo '<form id="form-id-vecino-creado" action="/index.php/tramites/Main_tr_vecino/show_main" method="POST" >
        <p><input hidden  type="text" class="span4 id_vecino" name="id_vecino" value="'. $saved .'" id=""></p>
    <p><input hidden  type="text" class="span4 name_vecino" name="name_vecino" value="'. $name_vecino .'" id=""></p>
        </form>
        <script>
        $(document).ready(function(){
          $("form#form-id-vecino-creado").submit(function(){
                  
          });
          $("form#form-id-vecino-creado").submit();
        });
        </script>';
//alert("'. $name_vecino . 'Se ha registrado correctamente");

       //redirect('main_operator/show_main');
        //http://cav.gob/index.php/Main_tr_vecino/show_main
    }
  }

}