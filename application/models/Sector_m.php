<?php


class Sector_m extends CI_Model {

    function  create_new_sector( $sectorData ) {
      $sectorData['padre'] == '' ? $data['id_padre'] = null : $data['id_padre'] = $sectorData['padre'];
      $data['denominacion'] = $sectorData['denominacion'];
      $data['tipo'] = $sectorData['tipo'];
      $data['fecha_creacion'] =  date('Y-m-d H:i:s',time());
      //$data['cierre'] = $sectorData['fecha_cierre'];

      //TODO si lo hago tomando el nombre del secretario.. que lo busque en la base primero y aho saco el id
      return $this->db->insert('sectores',$data);
    }

    function get_all_sectores(){
		  $this->db->from('sectores');
      $sectores = $this->db->get()->result();
      return $sectores;
    }

    function get_all_sector_by_type($typeSector){
      $this->db->from('sectores')
            ->where("tipo = '". $typeSector ."'");
      $sectores = $this->db->get()->result();
      return $sectores;
    }

    function get_all_sector_by_father_id($idPadre){
      $this->db->from('sectores')
            ->where("id_padre = '". $idPadre ."'");
      $sectores = $this->db->get()->result();
      return $sectores;
    }

    function update_sector_id($id,$sectorData){
      $sectorData['padre'] == '' ? $data['id_padre'] = null : $data['id_padre'] = $sectorData['padre'];
      $data['denominacion'] = $sectorData['denominacion'];
      $data['tipo'] = $sectorData['tipo'];
      $data['fecha_modificacion'] =  date('Y-m-d H:i:s',time());
    $this->db->where('id_sector', $id);
    $this->db->update('sectores', $data);

    }
    
    function get_sectors_in_use(){
      $str_query = "select of.id_sector id, sec.denominacion secretaria, of.denominacion oficina from sectores as of, sectores as sec where sec.id_sector = of.id_padre  and of.tipo = 'Oficina' and sec.denominacion != 'SIN USO' order by secretaria asc, oficina asc ; ";

      $query = $this->db->query($str_query);
      return $query->result_array();
    }

}