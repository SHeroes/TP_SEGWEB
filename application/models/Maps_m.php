<?php


class Maps_m extends CI_Model {

    function update_domicilio($id_dom, $id_loc, $lat, $lng){
      $this->db->set('id_loc', $id_loc);
      $this->db->set('lat', $lat);
      $this->db->set('lng', $lng);
      $this->db->where('id_domicilio', $id_dom);
      $this->db->update('domicilio');
    }

    function getUnDomicilioSinLocalidad(){
      $str_query = "  
        SELECT id_domicilio, calle, altura   FROM domicilio, calles
        WHERE calles.id_calle = domicilio.id_calle
        AND ( domicilio.id_loc IS NULL OR lat = 99 OR lng = 99 OR lng  IS NULL OR lat  IS NULL )
        LIMIT 1;
      ";
      $query = $this->db->query($str_query);
      return $query->result_array();
    }

    function getUnDomicilio(){
      $str_query = "  
      SELECT id_domicilio, calle, altura, localidades.localidades as loc_name   FROM domicilio, calles, localidades, localidadxcalle
      WHERE calles.id_calle = domicilio.id_calle        
      AND calles.id_calle = localidadxcalle.id_calle
      AND localidadxcalle.id_loc = localidades.id_localidad
      AND ( domicilio.id_loc IS NULL OR lat = 99 OR lng = 99 OR lng  IS NULL OR lat  IS NULL )
      order by id_domicilio
      LIMIT 1 ;
      ";
      $query = $this->db->query($str_query);
      return $query->result_array();
    }

}