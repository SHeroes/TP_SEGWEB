<?php


class Tramites_m extends CI_Model {

    function get_all_tramite_for_op($id_sector, $fecha_desde, $fecha_hasta, $typePaso, $nro_tr, $apellido, $dni){
      $cond_str = '';
      $cond_str = $cond_str .$this->armar_filtro_vecino($cond_str, $nro_tr, $apellido, $dni);
      $cond_str = $cond_str .$this->armar_Str_Cond_Fechas_Tipo_Reclamo($cond_str, $fecha_desde, $fecha_hasta, $typePaso);

      $str_query = "
      SELECT *, paso.id pasoId , tr.id tramiteId
      FROM tr_tramite tr, tr_tipo_tramite ttr, tr_pasos_x_tipo_tramite pttr, tr_paso paso, vecino
      WHERE 
        paso.id_sector = '".$id_sector."' AND
        pttr.tr_tipo_tramite_id = tr.tr_tipo_tramite_id AND
        paso.id = pttr.tr_paso_id AND
        tr.pasos_completados + 1 = pttr.orden AND 
        tr.id_vecino = vecino.id_vecino AND 
        ttr.id = pttr.tr_tipo_tramite_id ".$cond_str."
        ORDER BY tr.tr_fecha_tramite asc ; ";
      $all_tramites = $this->db->query($str_query);

      return $all_tramites->result();
    }

    function get_pasos_by_sector($id_sector){
      $this->db->from('tr_paso');
      $this->db->where('id_sector',$id_sector);
      $info = $this->db->get()->result();
      return $info;
    }

    function get_pasos_by_ttr_id($ttr_id){
      $str_query = "
      SELECT * 
      FROM tr_tipo_tramite ttr, tr_pasos_x_tipo_tramite pxt, tr_paso, sectores
      WHERE ttr.id = pxt.tr_tipo_tramite_id AND
          tr_paso.id = pxt.tr_paso_id AND
          sectores.id_sector = tr_paso.id_sector AND
              ttr.id = '".$ttr_id."'
      ORDER BY orden asc";
      $query = $this->db->query($str_query);

      return $query->result_array();
    }

    function get_formularios_by_tr_paso_id($id_paso){
      $this->db->from('tr_formularios');
      $this->db->where('tr_paso_id',$id_paso);
      $info = $this->db->get()->result();
      return $info;
    }

    function get_formularios_by_ttrId($ttr_id){
      $str_query = "
      SELECT tr_formularios.*
      FROM tr_pasos_x_tipo_tramite pxt, tr_paso, tr_formularios
      WHERE  pxt.tr_tipo_tramite_id = '".$ttr_id."' AND
          tr_paso.id = pxt.tr_paso_id AND
      tr_formularios.tr_paso_id = tr_paso.id
      ";
      $query = $this->db->query($str_query);

      return $query->result_array();     
    }

    function get_ttr_by_id($ttr_id){
      $this->db->from('tr_tipo_tramite');
      $this->db->where('id',$ttr_id);
      $info = $this->db->get()->result();
      return $info;
    }

    function get_all_grupos(){
      $this->db->from('tr_grupos');
      $grupos = $this->db->get()->result();
      return $grupos;
    }

    function get_all_tipo_tramites(){
      $this->db->from('tr_tipo_tramite');
      $tipo_tramites = $this->db->get()->result();
      return $tipo_tramites;
    }

    function get_all_tipo_tramites_order_by_grupo(){
      $this->db->from('tr_tipo_tramite');
      $this->db->order_by('tr_grupo_id', 'asc');
      $tipo_tramites = $this->db->get()->result();
      return $tipo_tramites;
    }

    function get_all_pasos(){
      $this->db->from('tr_paso');
      $pasos = $this->db->get()->result();
      return $pasos;
    }

    function get_all_pasos_by_id_order(){
      $this->db->from('tr_paso');
      $this->db->order_by('id', 'desc');
      $pasos = $this->db->get()->result();
      return $pasos;
    }

    function insertar_tramite($id_vecino, $ttr){
      $data['id_vecino'] =  $id_vecino;
      $data['pasos_completados'] =  0;
      $data['obs'] = '';
      $data['tr_tipo_tramite_id'] =    $ttr;      
      $data['tr_fecha_tramite'] = date('Y-m-d H:i:s',time());
      $data['pasos_totales_al_incio'] = $this->get_cantidad_pasos_totales($ttr);

      $this->db->insert('tr_tramite',$data);
      return $id_tipo_tramite = $this->db->insert_id();
    }

    private function  get_cantidad_pasos_totales($ttr_id){
      $str_query ="SELECT COUNT(*) as cantidad
      FROM tr_pasos_x_tipo_tramite
      WHERE tr_tipo_tramite_id = ".$ttr_id.";";
      $query = $this->db->query($str_query);
      return $query->result_array()[0]['cantidad'];       
    }

    function insertar_tipo_tramite($array_id_ubicacion,$array_id_tiempo,$array_info){
      $max = count($array_id_ubicacion);
      $data['titulo'] =                $array_info['titulo'];
      $data['desc'] =                  $array_info['descripcion'];
      $data['tr_grupo_id'] =           $array_info['grupo']; 
      
      $this->db->insert('tr_tipo_tramite',$data);
      $id_tipo_tramite = $this->db->insert_id();

      for($i = 0; $i<$max; $i++){
        $data2['tr_tipo_tramite_id']= $id_tipo_tramite;
        $data2['tr_paso_id']= $array_id_ubicacion[$i]->id;
        $data2['orden']= $array_id_ubicacion[$i]->ubicacion;
        foreach ($array_id_tiempo as $key => $value) {
          if($value->id == $i){
            $data2['tiempo_estimado']= $value->tiempo;    
          }
        }

        $this->db->insert('tr_pasos_x_tipo_tramite',$data2);
      }
      return $max;
    }

    function insertar_paso_tramite($info){
      $data['id_sector'] =          $info['id_sector'];
      $data['titulo'] =             $info['titulo'];
      $data['desc'] =               $info['descripcion'];
      $data['check_list_json'] =     $info['checklist'];      

      return $this->db->insert('tr_paso',$data);      
    }

    function insert_formulario($info_form){
      $data['tr_paso_id'] =       $info_form['id_paso'];
      $data['file_name'] =        $info_form['file_name'];
      $data['codigo_interno'] =   $info_form['cod_int'] ;
      $data['titulo'] =           $info_form['titulo'];
      $data['desc'] =             $info_form['descripcion'];
      
      return $this->db->insert('tr_formularios',$data);
    }

/* ------------------------*/
/*  FUNCIONES AUXILIARES   */
/* ------------------------*/


  function armar_filtro_vecino($cond_str, $nro_tr, $apellido, $dni){
    $nro_tr != '' ? $cond_str = $cond_str . " AND tr.id LIKE '%" . $nro_tr ."%'" : '' ;
    $apellido != '' ? $cond_str = $cond_str . " AND vecino.apellido LIKE '%" . $apellido ."%'" : '' ;
    $dni != '' ? $cond_str = $cond_str . " AND vecino.dni LIKE '%" . $dni ."%'" : '' ;

    return $cond_str;
  }


  function armar_Str_Cond_Fechas_Tipo_Reclamo($cond_str, $fecha_desde, $fecha_hasta, $typePaso){
  $filtro_fecha = false;
  if ( $fecha_desde != '' OR $fecha_hasta != '') $filtro_fecha = true;
  if ( $fecha_hasta == '') $fecha_hasta = date('Y-m-d'); 
  if ( $fecha_desde == '') $fecha_desde = '2017-01-10';
  if ( $filtro_fecha){
    $cond_str = $cond_str . "AND tr_fecha_tramite between '". $fecha_desde ."' and '".$fecha_hasta."' ";
  }

  if ($typePaso != ''){
    $cond_str = $cond_str . "AND tr_paso_id ='". $typePaso ."' ";
  } 

  return $cond_str;
  }

/*
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
    */
}