<?php // echo '<script src="'. base_url() .'assets/js/show_reclamos_crear.js"></script>'; ?>
<div class="container">
<h1>Lista de Reclamos Contactados según la Oficina correspondiente y aún no han sido verificados</h1>

    <?php if(isset($reclamos_list_contactados)){
      //print_r($reclamos_list_contactados);

      echo '<table class="table"><thead class="thead-inverse">        <tr id="header-table">
      <th>Código Reclamo</th><th>Fecha Alta</th><th> Título </th><th> Sector </th><th>Estado</th><th>Tel.</th>
      <th>Horarios para llamar:</th><th>Apellido , Nombre </th><th>Verificación</th><th>Obs.</th></tr>        </thead><tbody>';
      foreach ($reclamos_list_contactados as $rec) {
        echo  '<tr class="reclamo_row"><th scope="row" class="" id_reclamo="'.$rec['id_reclamo'].'">'.
        $rec['codigo_reclamo'] .'</th><td>'.$rec['fecha_alta_reclamo'].'</td><td>'.$rec['titulo'].'</td>'.
        //'<td>'.$rec['fecha_llamada'].'</td>'.
        '<td>'. $rec['oficina_nombre'].'</td><td>'. $rec['estado'].'</div></td>'.
        '<td>';
        if ($rec['_tel']){  echo $rec['tel'] ;  }
        echo '  ';
        if ($rec['_cel']){  echo $rec['cel'] ;  }
        echo '</td><td>'.$rec['molestar_dia_hs'].'</td>'.
        '<td>'.$rec['Apellido'].', '. $rec['Nombre']. '</td>'.
        '<td><div class="btn btn-success verficacion correcta">Correcto</div><div class="btn btn-warning verficacion incorrecta">Incorrecto</div></td>'.
        '<td class="observacion " id_reclamo="'.$rec['id_reclamo'].'" observacion="'  . '">
        <div class="btn btn-info observar">Observar</div></td>'.
        ''
        ;

      }

      echo '</tbody></table>'; 
      }
      ?>
</div>


<div id="obs-data" class="dialog-box" style="display: none;" title="Editar Observacion">
  <p>
    <form action="javascript:editar_observacion();" id="obs-form" method="POST" ><p><textarea type="text" class="span4" name="observacion_input" id="observacion-input" rows="8" cols="50" placeholder="" ></textarea></p><p><input type="hidden" name="id_rec" id="id-rec" class="span4" value=""></p><p><input type="submit" class="span4" value="Enviar"></p></form>
  </p>
</div> 



<?php echo '<script src="'. base_url() .'assets/js/show_contactados.js"></script>'; ?>
<?php echo '<script src="'. base_url() .'assets/js/header-table.js"></script>'; ?> 