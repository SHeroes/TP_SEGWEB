<?php echo '<script src="'. base_url() .'assets/js/show_reclamos_crear.js"></script>'; ?>
<div class="container">
<h1>Tomar Reclamo</h1>
  <?php if ($id_vecino != '') echo '<div class="buscar_vecinos" style="display:none;">'; else echo '<div class="buscar_vecinos">'; ?>
  <?php    
    $this->view('buscar_vecinos_registrados');
     echo '</div>';
    //$this->view('registrar_vecino_nuevo');
  ?>
  <div class="filtro-secretaria" <?php if ($id_vecino == '')  echo 'style="display:none;"';  ?> >
    <h3>Para elegir el tipo de reclamo primero filtre por Secretaría y Oficina:</h3>

   <div class="col-sm-4">
    <form action="#oficina_filter" method="POST" >
    <p><select type="text" class="span4 form-control" name="secretaria_filter" id="secretaria_filter">
        <option value="">Todas las Secretaria</option>
        <?php foreach( $secretarias as $secretaria){
          echo  '<option value="'.$secretaria->id_sector.'"';
          if (isset($secretaria_selected) and $secretaria_selected == $secretaria->id_sector ){
            echo 'selected';
          }
          echo '>'. $secretaria->denominacion.'</option>';
        }?>
    </select></p>
    <p><input hidden  type="text" class="span4 id_vecino " name="id_vecino" value="<?php echo $id_vecino; ?>" id=""></p>
    <p><input hidden  type="text" class="span4 name_vecino " name="name_vecino" value="<?php echo $name_vecino; ?>" id=""></p>     
    <p><input type="submit" class="span4 btn" value="Filtrar Oficinas"></p>
    </form>
   </div>
   <div class="col-sm-4">
    <form action="#oficina_filter" method="POST" >
    <p><select type="text" class="span4 form-control" name="oficina_filter" id="oficina_filter">
        
          <?php 
          //print_r($oficinas_filtradas);
          if (isset($oficinas_filtradas)){
            echo '<option value="">Todas las Oficinas</option>';
            foreach( $oficinas_filtradas as $oficina){
              echo  '<option value="'.$oficina->id_sector.'">'. $oficina->denominacion.'</option>';
            }  
          } else {
            echo '<option value="">Todas las Oficinas</option>';
            foreach( $oficinas as $oficina){
              echo  '<option value="'.$oficina->id_sector.'">'. $oficina->denominacion.'</option>';
            }  
          }
         ?>
     </select></p>
    <p><input hidden  type="text" class="span4 id_vecino" name="id_vecino" value="<?php echo $id_vecino; ?>" id=""></p>
    <p><input hidden  type="text" class="span4 name_vecino" name="name_vecino" value="<?php echo $name_vecino; ?>" id=""></p>      
    <p><input type="submit" class="span4 btn" value="Mostrar Tipo Reclamos"></p>
    </form>
</div>


    <?php if(isset($tipo_reclamos_filtrados)){
        echo '<table class="table"><thead class="thead-inverse">        <tr id="header-table">
        <th>Titulo</th><th>Descripcion</th><th>Tiempo respuesta hs</th><th>Dependencia</th></tr>        </thead><tbody>';
         foreach( $tipo_reclamos_filtrados as $reclamo){
          echo  '<tr><th scope="row" class="tipo_reclamo_row btn btn-primary" value="'. $reclamo->id_tipo_reclamo.'">'. $reclamo->titulo .'</th>'.
                '<td>'.$reclamo->descripcion.'</td>'.
                '<td>'.$reclamo->tiempo_respuesta_hs.'</td>'.
                '<td>'.$reclamo->denominacion.'</td>';
        }    
        echo '  </tbody></table>'; 
      } ?>
  </div>

  <form class="reclamo-form" action="insert_reclamo/" method="POST">
    <div class="col-sm-6" id="domicilio-reclamo-data">
     <h3>Domicilio de Reclamo</h3>
      <p><input id="usar_domicilio_vecino" class="more-reg form-check-input" type="checkbox" name="usar_domicilio_vecino" value="false" >Usar Domicilio del Vecino para el reclamo</p>
            
      <?php /*

      <p><select type="text" class="span4" name="id_domicilio" id="id_domicilio" placeholder="id_domicilio">
        <option value="">Si el domicilio de Reclamo ya existe... Elegirlo</option>
          <?php foreach( $all_domicilios_reclamo as $domicilio_rec){
          echo  '<option value="'. $domicilio_rec->id_domicilio .'">'. $domicilio_rec->calle .' Desde:  ' .  $domicilio_rec->altura_inicio .' Hasta: ' .  $domicilio_rec->altura_fin . '</option>';
          }?>
          </select>
      </p>

      */?>

      <p><input type="text" class="span4 more-reg  input-form calle required form-control" name="calle" id="calle" placeholder="calle" autocomplete="off" required>
          <input type="text" hidden class="hidden_id more-reg" id="calle_id_hidden" name="calle_id" value="">
      </p>
      <div class="calle input-search-result" ></div>
      

      <p><input type="text" class="span4 required more-reg  input-form form-control" name="altura_inicio" id="altura_inicio" placeholder="altura" required></p>
      <!-- <p style="display:none;"><input type="text" class="span4 required more-reg" name="altura_fin" id="altura_fin" placeholder="altura_fin"></p> -->
      <p><input type="text" class="span4 calle required more-reg  input-form  form-control" name="entrecalle1" id="entrecalle1" placeholder="entrecalle1" autocomplete="off" >
          <input type="text" hidden class="hidden_id more-reg" name="entrecalle1_id" value="">
      </p>
      <div class="calle input-search-result" ></div>
      
      <p><input type="text" class="span4 calle required more-reg  input-form form-control" name="entrecalle2" id="entrecalle2" placeholder="entrecalle2" autocomplete="off" >
         <input type="text" hidden class="hidden_id more-reg" name="entrecalle2_id" value="">
      </p>
      <div class="calle input-search-result"></div>

      <p><select type="text" class="span4 required more-reg  form-control" name="id_barrio" id="id_barrio" placeholder="id_barrio" autocomplete="off" required>
        <?php
        foreach( $all_barrios as $barrio){
        echo  '<option value="'. $barrio->id_barrio .'">'. $barrio->barrio. '</option>';
        }
        
        ?>
        </select></p>
      <p><input type="text" class="span4 more-reg  input-form form-control" name="columna_electrica" id="columna_electrica" placeholder="columna" >“este dato se pide si se refiere a una luminaria”</p>
    </div>
    <div class="col-sm-6" id="reclamo-data">
      <h3>Datos para Reclamo</h3>
      <p>Vecino que realiza el Reclamo:   <b><?php echo $name_vecino; ?></b></p>
      <p>Tipo de reclamo seleccionado:   <b id="tipo_reclamo_seleccionado"></b></p>
      <p><input hidden  type="text" class="span4  id_vecino more-reg" name="id_vecino" value="<?php echo $id_vecino; ?>" id=""></p>
      <p><input hidden  type="text" class="span4 name_vecino more-reg" name="name_vecino" value="<?php echo $name_vecino; ?>" id=""></p>
      <p><textarea rows="2" cols="50" type="text" class="span4 more-reg form-control" name="molestar_dia_hs" id="molestar_dia_hs" placeholder="Días y horarios en que puede ser molestado " ></textarea></p>
      <p><input type="checkbox" class="more-reg form-check-input" name="molestar_al_tel_fijo" value="true" >Se lo puede molestar al tel. fijo</p>
      <p><input type="checkbox" class="more-reg form-check-input" name="molestar_al_tel_mov" value="true" >Se lo puede molestar al tel. movil</p>
      <p><input type="checkbox" class="more-reg form-check-input" name="molestar_al_dom" value="true" >Se lo puede molestar al domicilio</p>
      <p><input type="checkbox" class="more-reg form-check-input" name="domicilio_restringido" value="true" >Si el vecino no quiere que se puedan ver sus datos</p>
      <p><input type="checkbox" class="more-reg form-check-input" name="redes_sociales" value="true" >Contactado por Redes Sociales</p>

    <!-- upload img // -->
      <p></p>
      <p><textarea class="more-reg form-control" rows="6" cols="50" type="text" name="comentarios" placeholder="comentarios"></textarea></p>

      <input hidden type="text" class="span4 more-reg" name="id_tipo_reclamo" value="" id="tipo_reclamo">

      <input hidden type="text" class="span4 more-reg" name="id_operador" id="id_operador" value="<?php echo $id_actual_user; ?>" >

      <p><a><input type="submit" class="btn btn-primary " value="Registrar Reclamo"></a></p>
      <p><a><input id="boton_mas_reclamos" class="btn btn-success" value="Registrar más Reclamos"></a></p>
    </div>

  </form>

</div>
