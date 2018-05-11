<?php echo '<script src="'. base_url() .'assets/js/tramites/tramites_vecino_main.js"></script>'; ?>


  <?php if ($id_vecino != '') {
      echo '<div class="nombre-vecino"><p>Bienvenido: '.$name_vecino.'</p></div>';
  } else{
      echo '<div><p><b>Error</b> no se encontro que vecino intenta realizar el tramite</p></div>';
  }
  ?>

<!-- <h1 id="titulo-pagina">Seleccionar Tramite</h1>-->

  <div id="tramite-selector-bar">
    <!-- "HOLA aca es donde te muestro todo lo que corresponde a los tramites recien ahora... que ya elegiste quien sos" -->
      <div class="row">
        <div class="col-sm-2 link-orange"><a href="/index/tramites/Main_tr_vecino/show_temas?id_vecino=<?php echo $id_vecino; ?>">Trámites por tema</a></div>
        <div class="col-sm-3 link-orange"><a href="/index/tramites/Main_tr_vecino/show_organismos?id_vecino=<?php echo $id_vecino; ?>">Trámites por organismo</a></div>
        <div class="col-sm-7">

          <?php echo '<form method="GET" id="selector_ttr" action="/index.php/tramites/Main_tr_vecino/show_ttr" >';?>
            <div class="col-sm-6">
              <select type="text" class="form-control" name="ttr" id="ttr_selector" placeholder="tipo de tramite" autocomplete="off">
              <?php foreach( $tipoTramites as $ttr){
              echo  '<option value="'. $ttr->id .'">'. $ttr->titulo.' - '.$ttr->desc.'</option>';
              }?>
              </select>
            </div>
            <div class="col-sm-4">
              <input type="submit" id="registrar_btn" class="btn btn-primary" value="Seleccionar">
            </div>
            <input type="hidden" name="id_vecino" value="<?php echo $id_vecino; ?>"/>
          </form>   
        </div>
    </div>
  </div>
  <div id="tramite-selector-bar-space">
    
  </div>  
  <div class="main-box">
      <div class="alert clearfix">
        <!-- <span class="fa fa-exclamation"></span> -->
        <p><b style="font-size: 25px;">!</b> El Centro de Atención al Vecino (CAV) funciona de lunes a viernes de 7:30 a 12:30.</p>
      </div>
  </div>

  <div class="vecino_chose_tramite" >
      

  <div class="row">
  <?php 
      $max_ttr_num_by_col =3;
      foreach ($grupos as $key => $grupo) {
        $counter = 0;
        //glyphicon-th-list
        $str_col_div =  
        '<div class="col-sm-4 '.$grupo->nombre.'">
            <div class="heading">
              <h4>
                <i class="glyphicon  '.$grupo->nombre.'"></i>
                <a href="/index.php/tramites/Main_tr_vecino/show_group?id_vecino='.$id_vecino.'&grupo='.$grupo->id.'">
              '.$grupo->nombre.'</a>
              </h4>
          </div>
          <ul class="grup-tramite-list">';
        echo $str_col_div;

        foreach ($tipoTramites as $ttr_key => $ttr_value) {

          if($ttr_value->tr_grupo_id == $grupo->id && $counter < $max_ttr_num_by_col){
            $counter++;
            echo '<li><a href="/index.php/tramites/Main_tr_vecino/show_ttr?id_vecino='.$id_vecino.'&ttr='.$ttr_value->id.'">' . $ttr_value->titulo . '</a></li>';

          }
        }
        echo '</ul></div>';
        
      }
  ?> 
  </div>
</div>