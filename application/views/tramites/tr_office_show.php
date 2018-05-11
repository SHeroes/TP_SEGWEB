<?php //echo '<script src="'. base_url() .'assets/js/show_reclamos_crear.js"></script>'; ?>
<div class="container-fluid">

  <div class="col-sm-12">
  <h1>Pasos de Trámites pendientes ordenados por fecha: </h1>
    <form action="#" id="state_filter" method="POST" >
        <div class="col-sm-3">
          <p><input type="text" name="apellido" class="input-form form-control" placeholder="Apellido..."></p>
          <p><input type="int" name="dni" class="input-form form-control" placeholder="DNI..."></p>
          <p><input type="text" name="nro_tr" class="input-form form-control" placeholder="Nº Tramite"></p>
        </div>
        <div class="col-sm-3">
          <p><input type="text" placeholder="desde:" class="input-fecha desde form-control" name="desde" id="datepicker" size="15"></p>
          <p><input type="text" placeholder="hasta:" class="input-fecha hasta form-control" name="hasta" id="datepicker2" size="15"></p>  
          <input type="submit" class="span4 btn" value="Filtrar">
          <p></p> 
        </div>        

        <div class="col-sm-6">
          <p><select type="text" class="span4 form-control" name="typePaso" id="typePaso_selector" style="margin-right: 30px;">
              <?php 
              foreach ($pasos_list as $key => $value) {
                echo '<option value="'.$value->id.'">'.$value->titulo. '</option>';             
              }
              ?>
          </select></p>
        </div>
    </form>

  <?php
/*
    [id] => 5
            [id_vecino] => 284
            [pasos_completados] => 0
            [pasos_totales_al_incio] => 0
            [obs] => 
            [tr_tipo_tramite_id] => 8
            [tr_fecha_tramite] => 2018-01-11 03:52:10
            [tr_fecha_cierre] => 
            [tr_grupo_id] => 2
            [titulo] => Entrega Restos
            [desc] => Se desprenden de los restos que guardaban en la casa
            [tr_paso_id] => 5
            [orden] => 1
            [tiempo_estimado] => 24
            [id_sector] => 26
            [check_list_json] => {"checklist":["Tener Certificado de Defuncion","Traer Urna Funeraria"]}
            [Nombre] => CARLOS
            [Apellido] => FOGIA
            [DNI] => 30800765
            [mail] => 
            [tel_fijo] => 42631553
            [tel_movil] => 
            [pasoId] => 5
            [tramiteId] => 9
*/      
        echo '<table class="table">
              <thead class="thead-inverse"><tr id="header-table">
                 <th>Tramite ID</th><th>DNI</th><th>Apellido, Nombre</th><th>email</th><th>tel.</th><th>movil</th>
                 <th>Fecha inicio</th><th>Pasos completados</th><th>Paso</th><th>Tratar</th>
              </tr></thead>
              <tbody>';
        foreach( $tramites_list as $tramite_paso){
          echo  '<tr>'.
                '<th scope="row">'. $tramite_paso->tramiteId .'</th>'.
                '<td>'.$tramite_paso->DNI.'</td>'.
                '<td>'.$tramite_paso->Apellido.', '.$tramite_paso->Nombre.'</td>'.
                '<td>'.$tramite_paso->mail.'</td>'.
                '<td>'.$tramite_paso->tel_fijo.'</td>'.
                '<td>'.$tramite_paso->tel_movil.'</td>'.
                '<td>'.$tramite_paso->tr_fecha_tramite.'</td>'.
                '<td>'.$tramite_paso->pasos_completados.' de '.$tramite_paso->pasos_totales_al_incio.'</td>'.
                '<td>'.$tramite_paso->titulo.'</td>'.
                '<td><a href="main_tr_operator/tratar_paso?id_paso='.$tramite_paso->pasoId.'&id_ttr='.$tramite_paso->tr_tipo_tramite_id.'&id_tr='.$tramite_paso->tramiteId.'&num_pasos_tot='.$tramite_paso->pasos_totales_al_incio.'" class="btn btn-primary" >Editar</a></td>'.
                '</tr>'
                ;
        }
        echo '</tbody></table>';
    ?>
  </div>
  <!-- <pre><?php // print_r($tramites_list); ?></pre> -->
</div>


 
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/vendor/jquery-ui/jquery-ui.css">
<script src="<?php echo base_url();?>assets/js/vendor/jquery-ui/jquery-ui.js"></script>
<?php echo '<script src="'. base_url() .'assets/js/show_calendar.js"></script>'; ?> 


<?php // echo '<script src="'. base_url() .'assets/js/header-table.js"></script>'; ?> 
