
<?php


class Reportes_m extends CI_Model {

	function get_reporte_composicion_secretaria(){
	$str_query = "SELECT sec.id_sector as id_secretaria, sec.denominacion , user.id as id_user, user.nombre, user.apellido, user.email
                  FROM sectores sec, usuariosxsector, user
                  WHERE user.id = usuariosxsector.id_usuario
                  AND sec.id_sector = usuariosxsector.id_sector
                  AND sec.id_padre = '1' ; ";

    $query = $this->db->query($str_query);
    return $query->result_array();	                  
  	}

	function get_reporte_composicion_oficinas(){
	$str_query = "SELECT sec.id_padre as id_padre, sec.id_sector as id_sector, sec.denominacion , user.id as id_user, user.nombre, user.apellido, user.email, tiporeclamo.titulo TipoReclamo , tiporeclamo.descripcion descripcionTipoReclamo
                  FROM sectores sec, usuariosxsector, user, tiporeclamo
                  WHERE user.id = usuariosxsector.id_usuario
                  AND tiporeclamo.id_responsable = user.id
                  AND sec.id_sector = usuariosxsector.id_sector
                  order by id_padre,id_sector, id_user; ";

    $query = $this->db->query($str_query);
    return $query->result_array();	
	}


/*
no lo uso temporalmente
	function show_reportes_union(){
		$q = "
		SELECT sec.id_sector as id_sector, sec.id_padre as id_padre, sec.denominacion , user.id as id_user, user.nombre, user.apellido, user.email , null, null
		                  FROM sectores sec, usuariosxsector, user
		                  WHERE user.id = usuariosxsector.id_usuario
		                  AND sec.id_sector = usuariosxsector.id_sector
		                  AND sec.id_padre = '1'
		UNION                  

		SELECT sec.id_sector as id_sector, sec.id_padre as id_padre, sec.denominacion , user.id as id_user, user.nombre, user.apellido, user.email, tiporeclamo.titulo TipoReclamo , tiporeclamo.descripcion descripcionTipoReclamo
		                  FROM sectores sec, usuariosxsector, user, tiporeclamo
		                  WHERE user.id = usuariosxsector.id_usuario
		                  AND tiporeclamo.id_responsable = user.id
		                  AND sec.id_sector = usuariosxsector.id_sector
		                  order by id_padre, id_sector,id_user ;" ;
    $query = $this->db->query($q);
    return $query->result_array();	        
	}
*/

}