<?php
  
   class Upload extends CI_Controller {
	
      public function __construct() { 
        parent::__construct(); 
      }

      public function custom_view(){
        $this->load->view('custom_view', array('error' => ' ' ));
      }
		
      public function index() { 
                $this->load->helper(array('form', 'url')); 

        $this->load->view('upload_form', array('error' => ' ' ));
        $this->session->set_userdata('id-reclamo-aux', $this->input->get('id-rec'));
        //print_r($this->session->userdata('id-reclamo-aux'));
      } 
		
      public function do_upload() {
         $config['upload_path']   = './uploads/'; 
         //$config['allowed_types'] = '*';
         $config['allowed_types'] = 'jpeg|jpg|gif|bmp|png';

         $config['max_size']      = 10000; 
         $config['max_width']     = 40968888; 
         $config['max_height']    = 30729999;
         $config['file_temp']    = $this->input->get('id-rec');
		 
         $this->load->library('upload', $config);
         $this->upload->initialize($config);
		 
         if ( ! $this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors()); 
            print_r($error);die();
            //$this->load->view('custom_view', $error);
            //$this->load->view('upload_form', $error); 
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