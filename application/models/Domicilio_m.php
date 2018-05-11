<?php


class Domicilio_m extends CI_Model {

	function get_all_localidades(){
	  $this->db->from('localidades');
	  $localidades = $this->db->get()->result();
	  return $localidades;  
	}

	function get_all_calles(){
	  $this->db->from('calles');
	  $calles = $this->db->get()->result();
	  return $calles;  
	}

	function get_calle($search){
		$this->db->select("id_calle,calle");
		$this->db->like('calle', $search);
		$this->db->from('calles');
		$query = $this->db->get();
		return $query->result();
	}

	function get_calle_by_id($id){
		$this->db->select("calle");
		$this->db->where('id_calle',$id);
		$this->db->from('calles');
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_domicilios(){
		$this->db->select('id_domicilio, calle, altura' )
							->from('domicilio, calles')
							->where('domicilio.id_calle = calles.id_calle');
	  $domicilios = $this->db->get()->result();
	  return $domicilios; 
	}

	function get_all_domicilios_reclamo(){
		$this->db->select('id_domicilio, calle, altura, altura_fin' )
							->from('domicilio, calles')
							->where('domicilio.id_calle = calles.id_calle');
	  $domicilios_reclamo = $this->db->get()->result();
	  return $domicilios_reclamo; 
	}

	public function get_domicilio_by_id($id){
		$where_str = 'domicilio.id_calle = calles.id_calle and id_domicilio='.$id ;
		$this->db->select('id_domicilio, calle, altura' )
					->from('domicilio, calles')
					->where($where_str);
	  $domicilio = $this->db->get()->result();
	  return $domicilio; 
	}

	public function get_all_info_domicilio_by_id($id){
		$where_str = 'domicilio.id_calle = calles.id_calle and id_domicilio='.$id ;
		$this->db->select('*')->from('domicilio, calles')->where($where_str);
	  $result = $this->db->get()->result();
	  $domicilio = (array)$result[0];

		if((int)$domicilio['entrecalle1_id'] > 0){			
			$calle1 = $this->get_calle_by_id($domicilio['entrecalle1_id']);
			$domicilio['entrecalle1'] = $calle1[0]->calle;
		}
		if((int)$domicilio['entrecalle2_id'] > 0){
			$calle2 = $this->get_calle_by_id($domicilio['entrecalle2_id']);
			$domicilio['entrecalle2'] = $calle2[0]->calle;
		}
	  return $domicilio; 
	}

	function get_all_barrios(){
	  $this->db->from('barrios');
	  $barrios = $this->db->get()->result();
	  return $barrios;  
	}


	function buscar_info_domicilio_by_id_vecino($id_vecino){

		$idDomicilio = $this->search_Dom_by_Vecino($id_vecino);
		$array_result = $this->get_all_info_domicilio_by_id($idDomicilio);
		return $array_result;
	}

	public function search_Dom_by_Vecino($id_vecino){
    $str_query = 'SELECT domicilio.id_domicilio
    FROM domiciliosxvecinos, domicilio
    where domiciliosxvecinos.id_vecino = '.$id_vecino.' and domiciliosxvecinos.id_domicilio = domicilio.id_domicilio
    order by fecha_alta DESC
    LIMIT 1;';
    $query = $this->db->query($str_query);
    $array = $query->result_array();
    $idDomicilio = (int) $array[0]['id_domicilio'];
    return $idDomicilio;
	}



}