<?php

class Upload_m extends CI_Model {

  function insert($id_reclamo,$file_name){
    $data['id_reclamo'] = $id_reclamo;
    $data['file_name'] = $file_name;    
   

    $this->insert_flag($id_reclamo);

    return $this->db->insert('upload_x_reclamo',$data);
  }

  function insert_flag($id_reclamo){
    $this->db->set('flag_imagenes', true); //value that used to update column  
    $this->db->where('id_reclamo', $id_reclamo); //which row want to upgrade  
    $this->db->update('reclamos');  //table name
  }
}
?>