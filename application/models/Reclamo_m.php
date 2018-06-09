<?php


class Reclamo_m extends CI_Model {



  function create_reclamo($userData,$usar_domicilio_vecino){
    // create_domicilio //
    if ($usar_domicilio_vecino){ 
      $idDomicilioReclamoAgregado = $userData['idDomicilioParaReclamo'];
    } else {
      $data2['id_calle'] =    (int) $userData['calle_id'];
      $data2['altura'] =      (int) $userData['altura_inicio'];
      //$data2['altura_fin'] =      (int) $userData['altura_fin'];

      $data2['entrecalle1_id'] = (int) $userData['entrecalle1_id'];
      $data2['entrecalle2_id'] = (int) $userData['entrecalle2_id'];
      $data2['id_barrio'] =   (int) $userData['id_barrio'];
      $data2['columna_luminaria'] = (int) $userData['columna_electrica'];

      $this->db->insert('domicilio',$data2);
      $idDomicilioReclamoAgregado = $this->db->insert_id();
    }
    // create_reclamo //

    $data3['id_vecino'] = $userData['id_vecino'];
    $data3['id_tipo_reclamo'] = $userData['id_tipo_reclamo'];
    $data3['id_operador'] = $userData['id_operador']; 
    $data3['id_dom_reclamo'] = $idDomicilioReclamoAgregado;
    $data3['estado'] = 'Iniciado';    
    $data3['fecha_alta_reclamo'] = date('Y-m-d H:i:s',time());
    $data3['id_lastchanger'] = $userData['id_operador']; 
    $data3['molestar_dia_hs'] = $userData['molestar_dia_hs']; 

    
    isset($userData['molestar_al_tel_fijo']) ?  $data3['molestar_al_tel_fijo'] = true :  $data3['molestar_al_tel_fijo'] = false;
    isset($userData['molestar_al_tel_mov']) ?   $data3['molestar_al_tel_mov'] = true :   $data3['molestar_al_tel_mov'] = false;
    isset($userData['molestar_al_dom']) ?       $data3['molestar_al_domicilio'] = true : $data3['molestar_al_domicilio'] = false;
    isset($userData['redes_sociales']) ?        $data3['redes_sociales'] = true :        $data3['redes_sociales'] = false;

    $data3['comentarios'] = $userData['comentarios'];

     isset($userData['domicilio_restringido']) ? $data3['domicilio_restringido'] = true : $data3['domicilio_restringido'] = false ;
    $currentYear =  date('Y');

    
    $where_cond = "YEAR(fecha_alta_reclamo) =" . $currentYear;
    $this->db->select('COUNT(fecha_alta_reclamo) as cantReclamos')->from('reclamos')->where($where_cond);
    $aux = $this->db->get()->result();
    $cantidad_reclamos_delAnio = (int) $aux[0]->cantReclamos;

    //El número de reclamo debe ser automático comenzando por el 0010000/año, cada año comienza con el mismo número.   
    $int_reclamo = 10001 + $cantidad_reclamos_delAnio;
    $cod_reclamo = '00' . $int_reclamo . '/' . $currentYear;
    $data3['codigo_reclamo'] = $cod_reclamo;

    $idReclamogregado = $this->db->insert('reclamos',$data3);

    return $cod_reclamo;
  }


  function concat_observacion($str_obs,$id_reclamo,$id_user){

    $data['userId'] = $id_user;
    $data['body'] = $str_obs;
    $data['createdDate'] = date('Y-m-d H:i:s',time());

    $this->db->insert('observaciones', $data);
    $id_observacion = $this->db->insert_id();

    $data2['id_obs'] = $id_observacion;
    $data2['id_reclamo'] = $id_reclamo;

    $id_obsXreclamo = $this->db->insert('observacionesxreclamo', $data2);

    return $id_observacion;
  }

  function concat_observacion_esp($str_obs,$id_reclamo,$id_user){

    $data['userId'] = $id_user;
    $data['body'] = $str_obs;
    $data['createdDate'] = date('Y-m-d H:i:s',time());

    $this->db->insert('observaciones', $data);
    $id_observacion = $this->db->insert_id();

    $data2['id_obs'] = $id_observacion;
    $data2['id_reclamo'] = $id_reclamo;

    $id_obsXreclamo = $this->db->insert('obs_esp_sup_x_reclamo', $data2);
    $id_obsXreclamo = $this->db->insert('observacionesxreclamo', $data2);

    return $id_observacion;
  }

  function show_observaciones($id_reclamo){
    $query = 'SELECT id_reclamo, apellido, nombre , body, createdDate FROM dbcav.observacionesxreclamo, user, observaciones
    where id_obs = observaciones.ID    
    and user.id = observaciones.userId
    and id_reclamo = '. $id_reclamo .'
    order by createdDate asc;';
    $query_result = $this->db->query($query);
    return $query_result->result_array();
  }

  function update_state_reclamo($str_state,$id_reclamo){
    if ($str_state == 'Visto'){
      $fecha_visto = date('Y-m-d H:i:s',time());
      $this->db->set('fecha_visto', $fecha_visto );      
    }

    $this->db->set('estado', $str_state);
    $this->db->where('id_reclamo', $id_reclamo);
    $this->db->update('reclamos');
  }

  function update_reitero_reclamo($num_reitero,$id_reclamo, $str_comentario){
    $num_reitero++;
    $fecha_reitero = date('Y-m-d H:i:s',time());
    $str_comentario = $str_comentario . "<br>--- \n Reitero Reclamo: --- <br>" . $fecha_reitero . "<br>\n";

    $this->db->set('reitero', $num_reitero);
    $this->db->set('comentarios', $str_comentario);
    
    $this->db->where('id_reclamo', $id_reclamo);
    $this->db->update('reclamos');
  }

  function get_all_reclamos_con_vecino_by($column,$value){

    $arrayName = array();

    //$value != '' ? $cond_str = " AND ".$column." = '".$value."' " : $cond_str = " AND reclamos.estado != 'Solucionado' AND reclamos.estado != 'Gestionado'  ";

    if ($value != '' ){
      $cond_str = " AND ".$column." = '".$value."' "; }
    else{
          return $arrayName;
     } ;
    if ($column != 'estado'){ $cond_str = " AND ".$column." LIKE '%".$value."%'" ;}

    $str_query = 'SELECT id_reclamo, vecino.id_vecino, codigo_reclamo, fecha_alta_reclamo, tiporeclamo.titulo , tiempo_respuesta_hs , domicilio_restringido,  estado,comentarios, Apellido, DNI, reitero, flag_imagenes, calles.calle , domicilio.altura
    FROM reclamos, tiporeclamo, vecino, calles, domicilio
    WHERE reclamos.id_tipo_reclamo = tiporeclamo.id_tipo_reclamo
    AND domicilio.id_domicilio = reclamos.id_dom_reclamo
    AND calles.id_calle = domicilio.id_calle 
    AND reclamos.id_vecino = vecino.id_vecino '. $cond_str .'
    ORDER BY fecha_alta_reclamo ASC';
    /* los datos del titular se buscar por ajax al darle click */

    $query = $this->db->query($str_query);
    return $query->result_array();
  }

  /* ES PARA LAS OFICINIAS porque solo aparecen los reclamos de la oficina a la que pertenece el usuario */
  function get_all_reclamos_for_office($column,$value, $id_sec, $fecha_desde, $fecha_hasta, $typeReclamo, $nro_rec, $apellido, $dni){
    $cond_str = '';
    if ($value != '' or $fecha_desde != '' or $fecha_hasta != '' or $typeReclamo != '' or $nro_rec != '' or $apellido != '' or $dni != ''){
      if ($value != '' ) $cond_str = " AND reclamos.".$column." = '".$value."' ";
      //print_r($cond_str);
    }else{
      $cond_str = " AND reclamos.estado != 'Solucionado' AND reclamos.estado != 'Gestionado' ";
      //print_r($cond_str);
    }

    /*
    $value != '' ? $cond_str = " AND reclamos.".$column." = '".$value."' " : $cond_str = " AND reclamos.estado != 'Solucionado' AND reclamos.estado != 'Gestionado' ";
    */
    $cond_str = $cond_str .$this->armar_filtro_vecino($cond_str, $nro_rec, $apellido, $dni);
    $cond_str = $cond_str .$this->armar_Str_Cond_Fechas_Tipo_Reclamo($cond_str, $fecha_desde, $fecha_hasta, $typeReclamo);

    /*  yo ya tengo mi id de sector, entonces busco los reclamos de los responsable de mi sector */
    $str_query = 'SELECT id_reclamo, reclamos.id_vecino, codigo_reclamo, fecha_alta_reclamo, barrios.barrio ,calles.calle, domicilio.altura , tiporeclamo.titulo , tiporeclamo.tiempo_respuesta_hs , domicilio_restringido,  estado,comentarios, molestar_dia_hs , reitero, flag_imagenes
    FROM reclamos, domicilio, tiporeclamo, calles, barrios, usuariosxsector, vecino
    WHERE reclamos.id_tipo_reclamo = tiporeclamo.id_tipo_reclamo
    AND reclamos.id_vecino = vecino.id_vecino
    AND tiporeclamo.id_responsable = usuariosxsector.id_usuario';
    if ($id_sec != ''){
      $str_query = $str_query .' AND usuariosxsector.id_sector = '. $id_sec;      
    }
    $str_query = $str_query . ' AND reclamos.id_dom_reclamo = domicilio.id_domicilio
    AND domicilio.id_calle = calles.id_calle
    AND domicilio.id_barrio = barrios.id_barrio '. $cond_str .'
    ORDER BY fecha_alta_reclamo ASC;';
    /* los datos del titular se buscar por ajax al darle click */

    $query = $this->db->query($str_query);
    return $query->result_array();
  }

  function get_responsables_y_oficinas_by_id_tipo_reclamo($array_id_tipo_reclamo){
    $str = "SELECT DISTINCT sectores.id_sector, denominacion as 'nombre_sector', user.id as id_responsable, user.apellido , user.nombre
        FROM sectores, usuariosxsector, tiporeclamo, user
        WHERE sectores.id_sector = usuariosxsector.id_sector
        AND tiporeclamo.id_responsable = usuariosxsector.id_usuario
        AND user.id = usuariosxsector.id_usuario ";
    foreach ($array_id_tipo_reclamo as $row => $v2) {
      if ($row == 0) {
        $str = $str . " AND ( tiporeclamo.id_tipo_reclamo = '" . $v2 . "'";
      } else {
        $str = $str . " OR tiporeclamo.id_tipo_reclamo = '" . $v2 . "' ";
      }
    }
    if (!empty($array_id_tipo_reclamo)){
      $str = $str . " ) ";     
    }
    $str = $str . " GROUP BY sectores.id_sector; "  ;

    $query = $this->db->query($str);   
    return $query->result_array();
  }


  function get_all_reclamos_for_secretary_by_mutiples_sectores($column,$value, $array_sectores,$fecha_desde, $fecha_hasta, $typeReclamo, $sector_filter, $responsable_id, $nro_rec, $apellido, $dni){
    $cond_str = '';
    if ($value != '' or $fecha_desde != '' or $fecha_hasta != '' or $typeReclamo != '' or $nro_rec != '' or $apellido != '' or $dni != '' or $sector_filter != '' or $responsable_id != '' or $nro_rec != ''){
      if ($value != '' ) $cond_str = " AND reclamos.".$column." = '".$value."' ";
      //print_r($cond_str);
    }else{
      $cond_str = " AND reclamos.estado != 'Solucionado' AND reclamos.estado != 'Gestionado' ";
      //print_r($cond_str);
    }

    /*
    $value != '' ? $cond_str = " AND reclamos.".$column." = '".$value."' " : $cond_str = "  AND reclamos.estado != 'Solucionado' AND reclamos.estado != 'Gestionado' ";
    */

    $cond_str = $cond_str .$this->armar_filtro_vecino($cond_str, $nro_rec, $apellido, $dni);    
    $cond_str = $cond_str . $this->armar_Str_Cond_Fechas_Tipo_Reclamo($cond_str, $fecha_desde, $fecha_hasta, $typeReclamo);

    if ($responsable_id != ''){
      $cond_str = $cond_str . " AND tiporeclamo.id_responsable = '" . $responsable_id ."' ";
    }
//print_r($cond_str);
    if ($sector_filter != ''){
      $string_sectores = " AND sectores.id_sector = '".$sector_filter."' ";
    } else {
      $string_sectores = " AND ( ";
      foreach ($array_sectores as $row => $value) {
        $string_sectores = $string_sectores. " sectores.id_sector = '" .$array_sectores[$row]->id_sector ."' OR ";
      }
      $string_sectores = $string_sectores .' false ) ';
    }

    $str_query = 'SELECT id_reclamo, reclamos.id_vecino, codigo_reclamo, fecha_alta_reclamo, barrios.barrio ,calles.calle, domicilio.altura , tiporeclamo.titulo , tiporeclamo.tiempo_respuesta_hs , domicilio_restringido,  estado, comentarios, molestar_dia_hs, flag_imagenes
    FROM reclamos, domicilio, tiporeclamo, calles, barrios, usuariosxsector, sectores , vecino
    WHERE reclamos.id_tipo_reclamo = tiporeclamo.id_tipo_reclamo
    AND reclamos.id_vecino = vecino.id_vecino
    AND tiporeclamo.id_responsable = usuariosxsector.id_usuario'.
    $string_sectores . '
    AND usuariosxsector.id_sector = sectores.id_sector
    AND reclamos.id_dom_reclamo = domicilio.id_domicilio
    AND domicilio.id_calle = calles.id_calle
    AND domicilio.id_barrio = barrios.id_barrio '. $cond_str .'
    ORDER BY fecha_alta_reclamo ASC;';

    $query = $this->db->query($str_query);
    
    return $query->result_array();

  }

  function get_all_reclamos_for_supervisor($column,$value,$of_filter, $sec_filter,$fecha_desde, $fecha_hasta, $typeReclamo, $responsable_id, $nro_rec, $apellido, $dni){
    $cond_str = '';
    if ($value != '' or $fecha_desde != '' or $fecha_hasta != '' or $typeReclamo != '' or $nro_rec != '' or $apellido != '' or $dni != '' or $sec_filter != '' or $of_filter != ''){
      if ($value != '' ) $cond_str = " AND reclamos.".$column." = '".$value."' ";
      //print_r($cond_str);
    }else{

      // $cond_str = " AND reclamos.estado != 'Solucionado' AND reclamos.estado != 'Gestionado' ";
       $cond_str = " AND reclamos.estado = 'no quiero ninguno'";

    }


    /*
    $value != '' ? $cond_str = " AND reclamos.".$column." = '".$value."' " : $cond_str = "  AND reclamos.estado != 'Solucionado' AND reclamos.estado != 'Gestionado' ";
    */
    $cond_str = $cond_str .$this->armar_filtro_vecino($cond_str, $nro_rec, $apellido, $dni);    
    $cond_str = $cond_str . $this->armar_Str_Cond_Fechas_Tipo_Reclamo($cond_str, $fecha_desde, $fecha_hasta, $typeReclamo);


    if ($responsable_id != ''){
      $cond_str = $cond_str . " AND tiporeclamo.id_responsable = '" . $responsable_id ."' ";
    }

    $string_sectores = " ";
    if ($of_filter != ''){
      $string_sectores = " AND sectores.id_sector = '" .$of_filter ."' ";
    } else if ($sec_filter!=""){    
      $this->load->model('sector_m');
      $sector_response = $this->sector_m->get_all_sector_by_father_id($sec_filter);
      //print_r($sector_response);
      if (!empty($sector_response)) {
     // list is empty.
        //$array_sectores = $sector_response[0];
        $string_sectores = " AND ( ";
        foreach ($sector_response as $row => $value) {
          $string_sectores = $string_sectores. " sectores.id_sector = '" .$sector_response[$row]->id_sector ."' OR ";
        }
        $string_sectores = $string_sectores .' sectores.id_sector = '. $sec_filter .' ) ';
      } else {
        //Si eligiera solo la secretaria y no tiene ninguna oficina dependiente entonces pone los que corresponde a la secretaria
        $string_sectores = ' AND sectores.id_sector = '. $sec_filter .' ';
      }
    }

    //print_r($string_sectores);

    $str_query = 'SELECT id_reclamo, reclamos.id_vecino, codigo_reclamo, fecha_alta_reclamo,barrios.barrio ,localidades.localidades ,calles.calle, domicilio.altura , tiporeclamo.titulo , tiporeclamo.tiempo_respuesta_hs , domicilio_restringido,  estado, comentarios, molestar_dia_hs
    FROM reclamos, domicilio, tiporeclamo, calles, localidades, usuariosxsector, sectores , vecino , localidadxcalle, barrios
    WHERE reclamos.id_tipo_reclamo = tiporeclamo.id_tipo_reclamo
    AND reclamos.id_vecino = vecino.id_vecino
    AND tiporeclamo.id_responsable = usuariosxsector.id_usuario'.
    $string_sectores . '
    AND usuariosxsector.id_sector = sectores.id_sector
    AND reclamos.id_dom_reclamo = domicilio.id_domicilio
    AND domicilio.id_calle = calles.id_calle
    AND domicilio.id_barrio = barrios.id_barrio
    AND domicilio.id_calle = localidadxcalle.id_calle
    AND localidadxcalle.id_loc = localidades.id_localidad
    '. $cond_str .'
    ORDER BY fecha_alta_reclamo ASC;';

    $query = $this->db->query($str_query);
    
    return $query->result_array();

  }

  /* ES PARA LAS SECRETARIAS porque solo aparecen los reclamos de la oficina a la que pertenece el usuario */
  function get_all_reclamos_for_secretary_by($column,$value, $id_sec,$fecha_desde, $fecha_hasta, $typeReclamo, $sector_filter, $responsable_id, $nro_rec, $apellido, $dni){
    $cond_str = '';
    if ($value != '' or $fecha_desde != '' or $fecha_hasta != '' or $typeReclamo != '' or $nro_rec != '' or $apellido != '' or $dni != '' or $sector_filter != '' or $responsable_id !='' or $nro_rec != ''){
      if ($value != '' ) $cond_str = " AND reclamos.".$column." = '".$value."' ";
      //print_r($cond_str);
    }else{
      $cond_str = " AND reclamos.estado != 'Solucionado' AND reclamos.estado != 'Gestionado' ";
      //print_r($cond_str);
    }

    /*
    $value != '' ? $cond_str = " AND reclamos.".$column." = '".$value."' " : $cond_str = "  AND reclamos.estado != 'Solucionado' AND reclamos.estado != 'Gestionado'  
 ";*/
    $cond_str = $cond_str .$this->armar_filtro_vecino($cond_str, $nro_rec, $apellido, $dni);  
    /*  yo ya tengo mi id de sector, entonces busco los reclamos de los responsable de mi sector */

    $cond_str = $cond_str . $this->armar_Str_Cond_Fechas_Tipo_Reclamo($cond_str, $fecha_desde, $fecha_hasta, $typeReclamo);

    if ($responsable_id != ''){
      $cond_str = $cond_str . " AND tiporeclamo.id_responsable = '" . $responsable_id ."' ";
    }

    if ($sector_filter != ''){
      $cond_str = $cond_str . " AND sectores.id_sector = '". $sector_filter ."' ";
    }

    $str_query = 'SELECT id_reclamo, reclamos.id_vecino, codigo_reclamo, fecha_alta_reclamo, barrios.barrio ,calles.calle, domicilio.altura , tiporeclamo.titulo , tiporeclamo.tiempo_respuesta_hs , domicilio_restringido,  estado, comentarios, molestar_dia_hs, flag_imagenes
    FROM reclamos, domicilio, tiporeclamo, calles, barrios, usuariosxsector, sectores, vecino
    WHERE reclamos.id_tipo_reclamo = tiporeclamo.id_tipo_reclamo
    AND reclamos.id_vecino = vecino.id_vecino
    AND tiporeclamo.id_responsable = usuariosxsector.id_usuario
    AND sectores.id_padre = '. $id_sec . '
    AND usuariosxsector.id_sector = sectores.id_sector
    AND reclamos.id_dom_reclamo = domicilio.id_domicilio
    AND domicilio.id_calle = calles.id_calle
    AND domicilio.id_barrio = barrios.id_barrio '. $cond_str .'
    ORDER BY fecha_alta_reclamo ASC;';
    /* los datos del titular se buscar por ajax al darle click */

    $query = $this->db->query($str_query);
    
    return $query->result_array();
  }

  function get_reclamos_no_vistos_creados_hace_mas_un_dia(){
    $end_date = date('Y-m-d H:i:s',time()); // fecha actual
    $str_query = "SELECT id_reclamo, codigo_reclamo, fecha_alta_reclamo, titulo, sec_1.tipo tipo_sector, sec_1.denominacion oficina_nombre, sec_2.denominacion secretaria_nombre , tiempo_respuesta_hs, estado FROM reclamos, tiporeclamo, sectores sec_1, sectores sec_2, usuariosxsector
      WHERE reclamos.id_tipo_reclamo = tiporeclamo.id_tipo_reclamo
      AND tiporeclamo.id_responsable = usuariosxsector.id_usuario
      AND usuariosxsector.id_sector = sec_1.id_sector 
      AND sec_1.id_padre = sec_2.id_sector
      AND reclamos.estado = 'Iniciado'
      ORDER BY sec_1.id_padre , sec_1.id_sector";

    $query = $this->db->query($str_query);
    
    return $query->result_array();
  }


  function get_reclamos_vistos_no_contactados_hace_mas_dos_dias(){
    $end_date = date('Y-m-d H:i:s',time()); // fecha actual
    $str_query = "SELECT id_reclamo, codigo_reclamo, fecha_alta_reclamo, titulo, sec_1.tipo tipo_sector, sec_1.denominacion oficina_nombre, sec_2.denominacion secretaria_nombre , tiempo_respuesta_hs, estado FROM reclamos, tiporeclamo, sectores sec_1, sectores sec_2, usuariosxsector
      WHERE reclamos.id_tipo_reclamo = tiporeclamo.id_tipo_reclamo
      AND tiporeclamo.id_responsable = usuariosxsector.id_usuario
      AND usuariosxsector.id_sector = sec_1.id_sector 
      AND sec_1.id_padre = sec_2.id_sector
      AND reclamos.estado = 'Visto'
      ORDER BY sec_1.id_padre , sec_1.id_sector";

    $query = $this->db->query($str_query);
    
    return $query->result_array();
  }

  function get_all_reclamos_verificados(){
    $str_query = "SELECT correctitud, id_reclamo, codigo_reclamo, fecha_alta_reclamo, sectores.tipo tipo_sector, sectores.denominacion oficina_nombre , fecha_llamada , estado,  titulo , tiempo_respuesta_hs
    FROM reclamos, tiporeclamo, sectores, usuariosxsector, llamadas_verificadoras
    WHERE contactado_verificado is not null
    /* AND reclamos.estado = 'Contactado' */
    AND reclamos.id_tipo_reclamo = tiporeclamo.id_tipo_reclamo
    AND tiporeclamo.id_responsable = usuariosxsector.id_usuario
    AND usuariosxsector.id_sector = sectores.id_sector 
    AND llamadas_verificadoras.id_reclamo_asociado = id_reclamo
    ORDER BY fecha_llamada, sectores.id_padre , sectores.id_sector; ";

    $query = $this->db->query($str_query);
    return $query->result_array();
  }

  // Trae todos los reclamos que puedan llamarse al vecino y que esten en contactados y aun no se han llamado
  function get_all_reclamos_contactados_no_verificados(){
    $str_query = "SELECT id_reclamo, codigo_reclamo, fecha_alta_reclamo, vecino.Apellido , vecino.Nombre,
    sectores.tipo tipo_sector, sectores.denominacion oficina_nombre , contactado_verificado, vecino.tel_fijo tel, vecino.tel_movil cel , reclamos.molestar_al_tel_fijo _tel, reclamos.molestar_al_tel_mov _cel, estado,  titulo,tiempo_respuesta_hs, reclamos.molestar_dia_hs
    FROM reclamos, tiporeclamo, sectores, usuariosxsector, vecino /* , llamadas_verificadoras */
    WHERE ( reclamos.molestar_al_tel_fijo = true OR reclamos.molestar_al_tel_mov = true )
    AND contactado_verificado is null
    AND reclamos.estado = 'Contactado'

    AND reclamos.id_tipo_reclamo = tiporeclamo.id_tipo_reclamo
    AND tiporeclamo.id_responsable = usuariosxsector.id_usuario
    AND usuariosxsector.id_sector = sectores.id_sector 
    AND vecino.id_vecino = reclamos.id_vecino
    ORDER BY sectores.id_padre , sectores.id_sector";

    $query = $this->db->query($str_query); 
    return $query->result_array();
  }

  function get_images($id){
    $this->db->select("file_name");
    $this->db->where('id_reclamo',$id);
    $this->db->from('upload_x_reclamo');
    $query = $this->db->get();
    return $query->result_array();
  }

  function verificacion_reclamo( $id_reclamo, $correctitud){
    $data['id_reclamo_asociado'] = $id_reclamo;
    $data['fecha_llamada'] = date('Y-m-d H:i:s',time());
    $data['correctitud'] = $correctitud;
    $saved = $this->db->insert('llamadas_verificadoras', $data);

    $this->db->set('contactado_verificado', $correctitud);
    $this->db->where('id_reclamo', $id_reclamo);
    $this->db->update('reclamos');   

    return $saved;
  }

  function get_reporte_global(){
    $str_query = 'SELECT estado, count(estado) as cantidad
                  FROM reclamos
                  group by estado ;';
    $query = $this->db->query($str_query); 
    return $query->result_array();     
  }

  function reporte_gl_sec(){
    $str_query = 'SELECT estado, count(estado) as cantidad, s1.id_padre as id_secretaria, s2.denominacion
                  FROM reclamos, tiporeclamo, usuariosxsector, sectores s1 , sectores s2
                  WHERE reclamos.id_tipo_reclamo = tiporeclamo.id_tipo_reclamo
                  AND tiporeclamo.id_responsable = usuariosxsector.id_usuario
                  AND s1.id_sector = usuariosxsector.id_sector
                  AND s1.id_padre = s2.id_sector

                  group by estado, s1.id_padre
                  order by s1.id_padre ;';

    $query = $this->db->query($str_query); 
    return $query->result_array(); 
  }

  function reporte_gl_of(){
    $str_query = 'SELECT estado, count(estado) as cantidad, sectores.denominacion, sectores.id_padre
                  FROM reclamos, tiporeclamo, usuariosxsector, sectores
                  WHERE reclamos.id_tipo_reclamo = tiporeclamo.id_tipo_reclamo
                  AND tiporeclamo.id_responsable = usuariosxsector.id_usuario
                  AND sectores.id_sector = usuariosxsector.id_sector
                  group by estado, sectores.id_sector
                  order by sectores.id_padre, sectores.id_sector  ;';
    $query = $this->db->query($str_query);
    return $query->result_array();
  }

  function reporte_reclamos_sin_fecha(){
    $str = 'SELECT reclamos.codigo_reclamo as NumRec, s1.denominacion Oficina , s2.denominacion Secretaria, estado, fecha_alta_reclamo
            FROM dbcav.reclamos, tiporeclamo, usuariosxsector, sectores s1, sectores s2
            WHERE reclamos.id_tipo_reclamo = tiporeclamo.id_tipo_reclamo
            AND tiporeclamo.id_responsable = usuariosxsector.id_usuario
            AND s1.id_sector = usuariosxsector.id_sector
            AND s1.id_padre = s2.id_sector ;';
    $query = $this->db->query($str);
    return $query->result_array();
  }

  function reporte_reclamos_localidades(){
    $str = 'SELECT id_localidad, localidades, tiporeclamo.id_tipo_reclamo , tiporeclamo.titulo , count(tiporeclamo.id_tipo_reclamo) as cantidad 
            FROM reclamos, tiporeclamo, domicilio, localidadxcalle, localidades
            WHERE reclamos.id_tipo_reclamo = tiporeclamo.id_tipo_reclamo
            AND domicilio.id_domicilio = reclamos.id_dom_reclamo
            AND domicilio.id_calle = localidadxcalle.id_calle
            AND localidades.id_localidad = localidadxcalle.id_loc
            group by tiporeclamo.id_tipo_reclamo
            order by localidades, titulo ;';
    $query = $this->db->query($str);
    return $query->result_array();   
  }

  function reporte_reclamos_localidades_global(){
    $str = 'SELECT localidades, count(localidades) as cantidad 
            FROM reclamos, domicilio, localidadxcalle, localidades
            WHERE domicilio.id_domicilio = reclamos.id_dom_reclamo
            AND domicilio.id_calle = localidadxcalle.id_calle
            AND localidades.id_localidad = localidadxcalle.id_loc
            group by  localidades ';
    $query = $this->db->query($str);
    return $query->result_array();      
  }

  function reasignar_reclamo($id_reclamo, $id_new_tipo_reclamo){

    $this->db->set('estado', 'Iniciado');
    $this->db->set('id_tipo_reclamo', $id_new_tipo_reclamo);
    $this->db->where('id_reclamo', $id_reclamo);
    $this->db->update('reclamos');

    return true;      
  }

/* ------------------------*/
/*  FUNCIONES AUXILIARES   */
/* ------------------------*/


  function armar_filtro_vecino($cond_str, $nro_rec, $apellido, $dni){
    $nro_rec != '' ? $cond_str = $cond_str . " AND codigo_reclamo LIKE '%" . $nro_rec ."%'" : '' ;

   // $apellido = preg_replace("/[^a-zA-ZñáéíóúÁÉÍÓÚÑ ]/", "", $apellido);//saneamiento

    $apellido != '' ? $cond_str = $cond_str . " AND vecino.apellido LIKE '%" . $apellido ."%'" : '' ;
    $dni != '' ? $cond_str = $cond_str . " AND vecino.dni LIKE '%" . $dni ."%'" : '' ;

    return $cond_str;
  }


  function armar_Str_Cond_Fechas_Tipo_Reclamo($cond_str, $fecha_desde, $fecha_hasta, $typeReclamo){
  $filtro_fecha = false;
  if ( $fecha_desde != '' OR $fecha_hasta != '') $filtro_fecha = true;
  if ( $fecha_hasta == '') $fecha_hasta = date('Y-m-d'); 
  if ( $fecha_desde == '') $fecha_desde = '2017-01-10';
  if ( $filtro_fecha){
    $cond_str = $cond_str . "AND fecha_alta_reclamo between '". $fecha_desde ."' and '".$fecha_hasta."' ";
  }

  if ($typeReclamo != ''){
    $cond_str = $cond_str . "AND tiporeclamo.id_tipo_reclamo ='". $typeReclamo ."' ";
  } 

  return $cond_str;
  }

}
