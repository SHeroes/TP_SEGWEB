<?php


class Vecino_m extends CI_Model {

  function get_vecinos_by_DNI($DNI){
    $DNI_ = "'" . $DNI . "'";
    $where_str = 'domicilio.id_calle = calles.id_calle and  domiciliosxvecinos.id_domicilio = domicilio.id_domicilio and domiciliosxvecinos.id_vecino = vecino.id_vecino and DNI ='.$DNI_;
    $this->db->select('domiciliosxvecinos.id_vecino, Nombre, Apellido, DNI, mail, tel_fijo, tel_movil, domiciliosxvecinos.id_domicilio, calle ,altura')
              ->from('vecino, domicilio, calles, domiciliosxvecinos')
              ->where($where_str);
    $vecino = $this->db->get()->result();
    return $vecino;
  }

  function get_vecino_info($id_vecino){
    $this->db->select('Nombre, Apellido, DNI, mail, tel_fijo, tel_movil, calle, altura, dpto, piso');
    $this->db->from('vecino');
    $this->db->join('domiciliosxvecinos', 'domiciliosxvecinos.id_vecino = vecino.id_vecino');
    $this->db->join('domicilio', 'domiciliosxvecinos.id_domicilio = domicilio.id_domicilio');
    $this->db->join('calles', 'calles.id_calle = domicilio.id_calle');
    $this->db->where('vecino.id_vecino', $id_vecino);

    $query = $this->db->get();
    if ( $query->num_rows() > 0 ){
        $row = $query->row_array();
        //print_r($row);
        return $row;
    }else {
      return $query;
    }

  }

  function get_all_vecinos(){
    $this->db->from('vecino');
    $vecinos = $this->db->get()->result();
    return $vecinos;
  }

  function get_vecinos_by_Apellido($Apellido){
    $Apellido_ = "'%" . $Apellido . "%'";
    $where_str = 'domicilio.id_calle = calles.id_calle and  domiciliosxvecinos.id_domicilio = domicilio.id_domicilio and domiciliosxvecinos.id_vecino = vecino.id_vecino and vecino.Apellido LIKE'.$Apellido_;
    $this->db->select('domiciliosxvecinos.id_vecino, Nombre, Apellido, DNI, mail, tel_fijo, tel_movil, domiciliosxvecinos.id_domicilio, calle ,altura')
              ->from('vecino, domicilio, calles, domiciliosxvecinos')
              ->where($where_str);
              //->limit(1);
    $vecino = $this->db->get()->result();
    return $vecino;
  }

  function create_vecino($userData){
    // create_domicilio //
    $data2['id_loc'] = (int) $userData['localidad_id_google'];
    $data2['lat'] = (float) $userData['lat'];
    $data2['lng'] = (float) $userData['lng'];
    $data2['id_loc_vec'] =    (int) $userData['id_loc'];
    $data2['id_calle'] =    (int) $userData['calle_id'];
    $data2['altura'] =      (int) $userData['altura'];
    $data2['entrecalle1_id'] = (int) $userData['entrecalle1_id'];
    $data2['entrecalle2_id'] = (int) $userData['entrecalle2_id'];
    $data2['id_barrio'] =   (int) $userData['id_barrio'];
    $data2['dpto'] = (int) $userData['departamento'];
    $data2['piso'] =        (int) $userData['piso']; 
    $this->db->insert('domicilio',$data2);
    $idDomicilioAgregado = $this->db->insert_id();


    if($idDomicilioAgregado){
      $data['nombre'] = $userData['nombre'];
      $data['apellido'] = $userData['apellido'];
      $data['DNI'] = $userData['dni'];
      $data['mail'] = $userData['mail'];
      $data['tel_fijo'] = $userData['tel_fijo'];
      $data['tel_movil'] = $userData['tel_movil'];
      $this->db->insert('vecino',$data);
      $idVecinoAgregado = $this->db->insert_id();
      if ($idVecinoAgregado){
        // create domicilioxvecino //
        $data3['id_vecino'] = $idVecinoAgregado;
        $data3['id_domicilio'] = $idDomicilioAgregado;
        $data3['fecha_alta'] = date('Y-m-d H:i:s',time());

        $this->db->insert('domiciliosxvecinos',$data3);

        return $idVecinoAgregado;
      } else {
        return "fallo al agregar el vecino";
      } 
    } else{
        return "fallo al agregar el Domicilio";
    }
  }
}
