<?php //echo '<script src="'. base_url() .'assets/js/show_reclamos_crear.js"></script>'; ?>
<div class="container-fluid">


  <div class="col-sm-12">

    <div class="col-sm-2">
    </div> 
    <div id="columna-pasos-hechos" class="col-sm-8"><h1>Pasos creados ordenados por creacion</h1>
      <?php 
      echo '<h3>Elegir el paso que debe tener asociados el/los formularios a subir</h3>';
      //print_r($array_pasos);
      //print_r($array_pasos);
      $max = sizeof($array_pasos);
      //if($max > 10){$max = 10;}
      for($i=0;$i<$max;$i++){
        ?><div id="paso-selector" class="col-sm-12 header" <?php echo 'value="'.$array_pasos[$i]->id.'"';?>      >
            <div class="col-sm-4"><?php echo $array_pasos[$i]->titulo; ?></div>
            <div class="col-sm-8"><?php echo $array_pasos[$i]->desc; ?></div>
          </div><?php
      }
      ?>
    </div>
  </div>
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/vendor/jquery-ui/jquery-ui.css">
<script src="<?php echo base_url();?>assets/js/vendor/jquery-ui/jquery-ui.js"></script>



<script>
$(document).ready(function() {
  $("#paso-selector").click(function() {
    var a = parseInt($(this).attr("value"));
    //alert(valor);
    //alert(a);
    var urlActual = '/index.php/tramites/upload_tr_formulario';
    //alert(urlActual+"?id-paso="+a);
    window.location.replace(urlActual+"?id-paso="+a);
  })
});



</script>