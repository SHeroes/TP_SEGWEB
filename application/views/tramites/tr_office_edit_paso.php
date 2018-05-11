<?php //echo '<script src="'. base_url() .'assets/js/show_reclamos_crear.js"></script>'; ?>
<div class="container-fluid">

  <div class="col-sm-12">
        <?php // print_r($paso_array);        ?>
        <h1 class="tipo-tramite">Tipo tramite: <?php echo $ttr_data[0]->titulo .' - '. $ttr_data[0]->desc; ?></h1>
        <div class="col-sm-8">
          <h2 class="paso-actual-tramite">Paso Actual: <?php echo $paso_array['titulo'] .' - '. $paso_array['desc']; ?></h2>  
          <div class="col-sm-8">
            <h3>Checklist del paso a completar: </h3>
            <?php
              $data = json_decode($paso_array['check_list_json']);
              if (count($data->checklist)>0){
                echo '<div class="checklist">';
                foreach ($data->checklist as $key => $value) {
                  $num = $key + 1;
                  echo $num.' - '.$value.'<br>';
                }
                echo '</div>';
              }          
            ?>            
          </div>
          <div class="col-sm-4">
            formularios</br>
            <?php    //       print_r($formularios);      
                foreach ($formularios as $key => $value) {
                  if ($value['tr_paso_id'] == $paso_array['id']){
                    echo '<span><a href="/uploads/tr_formularios/'.$value['file_name'].'">'. $value['codigo_interno'].'</a></span>';
                  }
                }

                ?>
          </div> 
        </div>        
        <div class="col-sm-4">
          <div class="show-ttr col-right">
            <h3>Todos los Pasos del tramite</h3>
               <img class="trama" src="/assets/img/trama.svg" alt="">
            </br>          
              <?php 
              echo '<div class="paso-paso">';
              //print_r($ttr_pasos);
              foreach ($ttr_pasos as $key => $paso) {
                echo '<div class="paso">';
                echo '<div class="num">'.$paso['orden'] .'</div>';
                echo '<div class="paso-titulos">'.$paso['titulo'].' - Oficina: '.$paso['denominacion'].'</div>';
                echo '<div class="paso-content">'.$paso['desc'].'</div>';
                $data = json_decode($paso['check_list_json']);

                if (count($data->checklist)>0){
                  echo '<div class="checklist">Items a completar para el paso <br>';
                  foreach ($data->checklist as $key => $value) {
                    $num = $key + 1;
                    echo $num.' - '.$value.'<br>';
                  }
                  echo '</div>';
                }
                $primerFormulario = 0;
                foreach ($formularios as $key => $value) {
                  if ($value['tr_paso_id'] == $paso['id']){
                    if ($primerFormulario == 0){
                      echo '<h6>Codigo de Formularios asociados al paso para Descargar: </h6>';
                      $primerFormulario++;
                    }
                    echo '<span><a href="/uploads/tr_formularios/'.$value['file_name'].'">'. $value['codigo_interno'].'</a></span></br>';
                  }
                }
                echo '</div>';
              }
              echo '</div>';
              ?>
        </div>
  </div>

</div>


 
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/vendor/jquery-ui/jquery-ui.css">
<script src="<?php echo base_url();?>assets/js/vendor/jquery-ui/jquery-ui.js"></script>
