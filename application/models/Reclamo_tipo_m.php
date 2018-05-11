<?php


class Reclamo_tipo_m extends CI_Model {

    function get_all_tipo_reclamos(){
      $this->db->from('tiporeclamo');
      $tiporeclamo = $this->db->get()->result();
      return $tiporeclamo;
    }

    function get_all_tipo_reclamos_by_sector($sectorId){
      $sectorId == '' ? $where_cond = '' : $where_cond = " and usuariosxsector.id_sector ='". $sectorId . "'";
      $this->db->select('id_tipo_reclamo, tiempo_respuesta_hs, titulo, descripcion, sectores.denominacion')
              ->from('tiporeclamo, user, usuariosxsector, sectores')
              ->where("tiporeclamo.id_responsable = usuariosxsector.id_usuario  and estado_activo = true and
 user.id = usuariosxsector.id_usuario and sectores.id_sector = usuariosxsector.id_sector" . $where_cond);

      $tiposreclamo_filtrados = $this->db->get()->result();
      return $tiposreclamo_filtrados;
    }

    function get_all_tipo_reclamos_by_secretary($sectorId){
      $sectorId == '' ? $where_cond = '' : $where_cond = " and sectores.id_padre ='". $sectorId . "'";
      $this->db->select('id_tipo_reclamo, tiempo_respuesta_hs, titulo, descripcion, sectores.denominacion')
              ->from('tiporeclamo, user, usuariosxsector, sectores')
              ->where("tiporeclamo.id_responsable = usuariosxsector.id_usuario  and estado_activo = true and
 user.id = usuariosxsector.id_usuario and sectores.id_sector = usuariosxsector.id_sector" . $where_cond);
              
      $tiposreclamo_filtrados = $this->db->get()->result();
      return $tiposreclamo_filtrados;
    }

    function get_responsables(){
      $str_query = "
      SELECT user.id as id_responsable , nombre , apellido, denominacion as sec_nombre , sectores.id_sector as sec_id
      FROM user , usuariosxsector , sectores
      WHERE perfil_level = '2' and user.id = usuariosxsector.id_usuario and usuariosxsector.id_sector = sectores.id_sector
      ";
      $query = $this->db->query($str_query);

      return $query->result_array();
    }

    function insert_tipo_reclamo($tipo_reclamo){
      //$data['id_tipo_reclamo'] = $tipo_reclamo[''];
      $data['tiempo_respuesta_hs'] = $tipo_reclamo['tiempo_respuesta'];
      $data['id_responsable'] = $tipo_reclamo['id_responsable'];
      $data['descripcion'] = $tipo_reclamo['descripcion'];
      $data['titulo'] = $tipo_reclamo['titulo'];

      return $this->db->insert('tiporeclamo',$data);
    }

    function update_tipo_reclamo($tipo_reclamo){
      $data['tiempo_respuesta_hs'] = $tipo_reclamo['tiempo_respuesta'];
      $data['id_responsable'] = $tipo_reclamo['id_responsable'];
      $data['descripcion'] = $tipo_reclamo['descripcion'];
      $data['titulo'] = $tipo_reclamo['titulo'];
      $data['estado_activo'] = true;

      $this->db->where('id_tipo_reclamo',  $tipo_reclamo['id_tipo_reclamo']);
      return $this->db->update('tiporeclamo', $data);
    }

    function disable_tipo_reclamo($tipo_reclamo){
      $data['estado_activo'] = false;

      $this->db->where('id_tipo_reclamo',  $tipo_reclamo['id_tipo_reclamo']);
      return $this->db->update('tiporeclamo', $data);
    }
}