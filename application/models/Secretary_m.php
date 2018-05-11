<?php


class Secretary_m extends CI_Model {

    function  create_new_secretary( $secretaryData ) {
      $data['nombre'] = $secretaryData['secretaria'];
      $data['id_secretario'] = $secretaryData['id_secretario'];
      //TODO si lo hago tomando el nombre del secretario.. que lo busque en la base primero y aho saco el id
      return $this->db->insert('secretarias',$data);
    }

    function get_all_secretaries(){
		$this->db->from('secretarias');
        $secretarias = $this->db->get()->result();
        return $secretarias;
    }
    

}