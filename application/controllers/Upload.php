<?php
  
   class Upload extends CI_Controller {
	
      public function __construct() { 
        parent::__construct(); 
        $this->load->helper(array('form', 'url')); 

      }
		
      public function index() { 
        $this->load->view('upload_form', array('error' => ' ' ));
        $this->session->set_userdata('id-reclamo-aux', $this->input->get('id-rec'));
        //print_r($this->session->userdata('id-reclamo-aux'));
      } 
		
      public function do_upload() {
         $config['upload_path']   = './uploads/'; 
         //$config['allowed_types'] = '*';
         $config['allowed_types'] = 'gif|jpg|png|jpeg';

         $config['max_size']      = 10000; 
         $config['max_width']     = 4096; 
         $config['max_height']    = 3072;
         $config['file_temp']    = $this->input->get('id-rec');
		 
         $this->load->library('upload', $config);
         $this->upload->initialize($config);
		 
         if ( ! $this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors()); 
            $this->load->view('upload_form', $error); 
         }		
         else {
            $data = array('upload_data' => $this->upload->data()); 
            //TODO cargar en la base de datos el la url de la imagen con el id del reclamo relacionado

            $this->load->model('upload_m');
			$id_rec = $this->session->userdata('id-reclamo-aux');
			$this->upload_m->insert($id_rec,$data['upload_data']['file_name']);
            //$data['secretarias'] = $this->sector_m->get_all_sector_by_type('Secretaria');
            $this->load->view('upload_success', $data);
         } 
		 
      }
   } 
?>