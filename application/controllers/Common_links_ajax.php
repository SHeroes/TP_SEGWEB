
<?php

class Common_links_ajax extends CI_Controller{

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

	function oficinas_por_id_secretaria() {
		$info = $this->input->post(null,true);
		if( count($info) ) {
		  $this->load->model('sector_m');
		  $id_secretaria =  $this->input->post('id_secretaria');
		  if ($id_secretaria == ""){
		  	$saved = $this->sector_m->get_all_sector_by_type( "Oficina");
		  }else{
		  	$saved = $this->sector_m->get_all_sector_by_father_id( $id_secretaria);
		  }
		  echo json_encode ($saved);
		}
	}

}