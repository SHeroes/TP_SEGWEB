<div class="container-fluid">
  <h1> Reclamos Existentes</h1>
    <div class="col-sm-12">
    <div class="col-sm-4">
    <form action="#" id="Apellido_filter" method="POST" >
    	<div class="col-sm-8">
    		<input type="text" name="Apellido_filter_sel" class="form-control" placeholder="Apellido...">
    	</div><div class="col-sm-4">
      	<input type="submit" class="span4 btn" value="Filtrar">
    	</div>
    </form>
    </div>
    <div class="col-sm-4">
    <form action="#" id="DNI_filter" method="POST" >
    	<div class="col-sm-8">
    		<input type="int" name="DNI_filter_sel" class="form-control" placeholder="DNI...">
      </div><div class="col-sm-4">
    		<input type="submit" class="span4 btn" value="Filtrar">
    	</div>
    </form>
    </div>
    <div class="col-sm-4">
    <form action="#" id="num_reclamo_filter" method="POST" >
    	<div class="col-sm-8">
    		<input type="text" name="num_reclamo_sel" class="form-control" placeholder="Nº Reclamo">
      </div><div class="col-sm-4">
    		<input type="submit" class="span4 btn" value="Filtrar">
    	</div>
    </form>
    </div>
    <br>
    <?php 

    if($reclamos_list != ''){
      echo '<table class="table" style="margin-top: 40px; "><thead class="thead-inverse">        <tr id="header-table">
      <th>Código Reclamo</th><th>Fecha Alta</th><th>Título</th><th>Reitero</th><th>Rta. hs</th><th>Dirección Reclamo</th><th>Estado</th><th>CAV</th><th>Obs.</th><th>Vecino</th><th>Apellido</th><th>DNI</th><th>Imagenes</th><th></th></tr>        </thead><tbody>';
      foreach ($reclamos_list as $rec) {
        echo  '<tr class="reclamo_row"><th scope="row" class="" id_reclamo="'.$rec['id_reclamo'].'"value="'. $rec['id_vecino'].' ">'. $rec['codigo_reclamo'] .'</th>'. '<td>'.$rec['fecha_alta_reclamo'].'</td>'.
            '<td>'.$rec['titulo'].'</td>'.
            '<td><div class="reitero-num">'.$rec['reitero'].'</div></td>'.
            '<td>'.$rec['tiempo_respuesta_hs'].'</td>'.
            '<td>'.$rec['calle'].' Nro: '.$rec['altura'].'</td>'.
            '<td>'.$rec['estado'].'</td>'.
            '<td class="comentario" comentario="'.$rec['comentarios'].'"><div class="btn btn-info">Ver</div></td>'.
            '<td class="observacion" id_reclamo="'.$rec['id_reclamo'].'" observacion="'  . '"><div class="btn btn-success ver">Ver</div></td>';
          if ($rec['domicilio_restringido'] == 0) echo '<td><div class="btn btn-info info-vecino" dom-res="0">Ver</div></td>'; else echo '<td></td>';
          	echo '<td>'.$rec['Apellido'].'</td>'.
            '<td>'.$rec['DNI'].'</td>'.
            '<td><a href="/index.php/upload?id-rec='.$rec['id_reclamo'].'" class="btn btn-info" target="_blank" >Subir</div></td>';
            if ($rec['flag_imagenes']) echo '<td><div class="btn btn-success sh-img" id_reclamo="'.$rec['id_reclamo'].'" >Ver..</div></td>';
            else echo '<td></td>';
        }
        echo '  </tbody></table>'; 
    }

    ?>

 
  </div>
</div>





  <div id="vecino-data" class="dialog-box" style="display: none;" title="Datos Reclamante">
    <p></p>
  </div> 

  <div id="ver-obs" class="dialog-box" style="display: none;" title="Visualizar Observaciones">
    <p></p>
  </div> 

  <div id="comments-data" class="dialog-box" style="display: none;" title="Comentario">
    <p></p>
  </div> 


  <div id="obs-data" class="dialog-box" style="display: none;" title="Editar Observacion">
    <p>
      <form action="javascript:editar_observacion();" id="obs-form" method="POST" ><p><textarea type="text" class="span4" name="observacion_input" id="observacion-input" rows="8" cols="50" placeholder="" ></textarea></p><p><input type="hidden" name="id_rec" id="id-rec" class="span4" value=""></p><p><input type="submit" class="span4" value="Enviar"></p></form>
    </p>
  </div> 

  <div id="reitero-data" class="dialog-box" style="display: none;" title="Reitero de reclamo">
    <p>Agregar comentarios al reclamo: </p>
    <p>
      <form action="javascript:editar_comentario_por_reitero();" id="reitero-form" method="POST" >
        <p><textarea type="text" class="span4" name="reitero_input" id="reitero-input" rows="10" cols="28" placeholder="" ></textarea></p>
        <p><input type="hidden" name="id-reitero" id="id-rei" class="span4" value=""></p>
        <p><input type="hidden" name="id-rei-num" id="id-rei-num" class="span4" value=""></p>
        <p><input type="submit" class="span4" value="Reiterar Reclamo"></p>
      </form>
    </p>
  </div> 

  <div id="img-box" class="ui-widget-content" style="display: none;" title="Fotos del Reclamo">
    <p>
      
    </p>
  </div> 


<?php echo '<script src="'. base_url() .'assets/js/show_reclamos_operator.js"></script>'; ?>
<?php echo '<script src="'. base_url() .'assets/js/reclamos_reitero.js"></script>'; ?>


<?php echo '<script src="'. base_url() .'assets/js/ver_imagenes_reclamo.js"></script>'; ?>