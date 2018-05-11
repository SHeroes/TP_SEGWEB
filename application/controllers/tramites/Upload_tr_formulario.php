<?php
  
   class Upload_tr_formulario extends CI_Controller {
	
      public function __construct() { 
        parent::__construct(); 
        $this->load->helper(array('form', 'url')); 

      }
		
      public function index() {
        $this->load->view('tramites/upload_form', array('error' => ' ' ));
        //$this->session->set_userdata('id-reclamo-aux', $this->input->get('id-rec'));
        $this->session->set_userdata('id-paso-aux', $this->input->get('id-paso'));
        //print_r($this->session->userdata('id-paso-aux'));
      } 
		
      public function do_upload() {
          $config['upload_path']   = './uploads/tr_formularios/'; 
          $config['allowed_types'] = '*';
          $config['max_size']      = 10000; //10 Mb
          $config['max_width']     = 4096; 
          $config['max_height']    = 3072;
          $config['file_temp']    = $this->input->get('id-paso');

          $info_form['id_paso']  = $this->input->get('id-paso');
          $info_form['descripcion']  = $this->input->post('descripcion');
          $info_form['titulo']  = $this->input->post('titulo');
          $info_form['cod_int']  = $this->input->post('cod_int');
		 
          $this->load->library('upload', $config);
          $this->upload->initialize($config);

          if ( ! $this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors()); 
            $this->load->view('tramites/upload_form', $error); 
          }		
          else {
            $data = array('upload_data' => $this->upload->data()); 
            $info_form['file_name'] = $data['upload_data']['file_name'];
            $this->load->model('tramites_m');
            //$id_paso = $this->session->userdata('id-paso-aux');
            $info_form['id_paso']  = $this->session->userdata('id-paso-aux');
            $this->tramites_m->insert_formulario($info_form);
            $this->load->view('tramites/upload_success', $data);
          }
      }
   }
?>