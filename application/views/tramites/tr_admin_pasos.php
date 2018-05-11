<?php //echo '<script src="'. base_url() .'assets/js/show_reclamos_crear.js"></script>'; ?>
<div class="container-fluid">
<h1>Creación de Pasos para Los Trámites</h1>

  <div class="col-sm-12">
  <!-- 
  1- select sec / oficina "texto de busqueda con SECRETARIA - OFICINA" (como en las calles)
  2- poner nombre y descripcion
  3-  agregar el JSON con el checklist
  4- enviar ( manteniendo la seleccion de la oficina)
  -->
    <div class="col-sm-4">

      <form id="form-paso" method="POST" style="display:block;" action="insertar_paso_tramite/">
      <?php
      echo '<select class="span4 form-control" name="id_sector">';
      foreach ($array_sectores_uso as $key => $value) {
        echo '<option value="'.$value['id'].'" >'.$value['secretaria'].' - '. $value['oficina'].'</option>';
      }
      echo '</select>';
      ?>
      <br>
      <p><input type="text" class="form-control" name="titulo" size="30" placeholder="Título" required></p>
      <p><textarea type="text" class="form-control" name="descripcion" cols="30" rows="5" placeholder="Descripción" required></textarea></p>
      <p><input name="checklist" id="checklist-hide" type="hidden" class="form-control checklist" placeholder="checklist-ocultar" cols="60" rows="2"></p>
      <br></br>
      <p>CHECKLIST QUE DEBE CUMPLIRSE PARA COMPLETAR EL PASO: </p>
      <p>
      <div class="input_fields_wrap">
        <div  class="item-check"><textarea type="text" name="mytext[]" rows="5" cols="50"></textarea>
        <button class="add_field_button btn btn-success btn-number"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
      </div>
      </p>
      <a><div id="paso-btn" class="btn btn-primary" value="Agregar">Agregar Paso</div></a>
      <a><input type="submit" class="btn btn-primary hidden" value="Agregar"></a>

      </form>
    </div> 
    <div id="columna-pasos-hechos" class="col-sm-8">
      <?php 
      echo '<h3>Pasos actuales los ultimo 10 creados recientemente</h3>';
      //print_r($array_pasos);
      $max = sizeof($array_pasos);
      if($max > 10){$max = 10;}
      for($i=0;$i<$max;$i++){
        ?><div class="col-sm-12 header">
            <div class="col-sm-4"><?php echo $array_pasos[$i]->titulo; ?></div>
            <div class="col-sm-8"><?php echo $array_pasos[$i]->desc; ?></div>
          </div><?php
          $json = $array_pasos[$i]->check_list_json;   //var_dump(json_decode($json, true));
          $checkListArray = json_decode($json, true);          //print_r($checkListArray['checklist']); 
          foreach ($checkListArray['checklist'] as $key => $value) {
            echo '<div class="col-sm-12 ck-list">'.$value.'</div>';
          }
      }
      ?>
    </div>
  </div>
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/vendor/jquery-ui/jquery-ui.css">
<script src="<?php echo base_url();?>assets/js/vendor/jquery-ui/jquery-ui.js"></script>



<script>
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    var text_JSON = $("#checklist-hide");
    var paso_button     =$("#paso-btn");
    var form            = $("#form-paso");
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="item-check"><textarea type="text" name="mytext[]" rows="5" cols="50"/><a href="#" class="remove_field btn btn-danger btn-number" data-type="minus"></textarea><span class="glyphicon glyphicon-minus"></span></a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    });

    $(paso_button).click(function(e){
      var obj = new Object();
      obj.checklist = new Array;
      $(".item-check textarea").each(function(index,elem){
          item = $(elem);
          console.log(index);
          obj.checklist[index] = item.val();
          //obj.checklist.push({index : item.val()})
      });
      var jsonString= JSON.stringify(obj);
      //console.log(jsonString);
      $(text_JSON).val(jsonString);
      $(form).submit();
    });
});



</script>