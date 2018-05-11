<?php //echo '<script src="'. base_url() .'assets/js/show_reclamos_crear.js"></script>'; ?>
<div class="container-fluid">


  <div class="col-sm-12">


    <form action="insertar_tipo_tramite" method="POST" >
        <div class="col-sm-1"></div>
        <div class="col-sm-4" id="inputs-tipo-tramite">
          <p><input class="form-control" name="titulo" placeholder="titulo" required/></p>
          <p><textarea class="form-control" name="descripcion" placeholder="descripcion" ></textarea> </p>
          <p><br><b>Grupo al pertenecerá el tipo de tramite: </b></p><p><select type="text" class="span4 form-control" name="grupo" id="grupo_selector">
            <?php 
            foreach($grupos as $grupo_elemento){
              echo  '<option value="'.$grupo_elemento->id.'">'. $grupo_elemento->nombre.'</option>';
            }  
            ?>
          </select></p>
          <p><button type="submit" class="btn btn-primary">Enviar</button></p>
        </div> 
        <div id="columna-pasos-hechos" class="col-sm-6"><h1>Pasos creados ordenados por creacion</h1>
        <?php 
        echo '<h3>Elegir los pasos que  que debe tener asociados el/los formularios a subir</h3>';
        echo '<div class="list-pasos col-sm-12 ">';
            echo '<div class="col-sm-10">Titulo - Descripción del Paso</div>';
            echo '<div class="col-sm-1">Orden</div>';
            echo '<div class="col-sm-1">Tiempo</div>';                
        echo '</div>';
        $max = sizeof($array_pasos);      //if($max > 10){$max = 10;}

        echo '<div class="form-check col-sm-12 ">';
            for($i=0;$i<$max;$i++){
            echo '<label class="form-check-label col-sm-10">';
            echo '<input type="checkbox" class="form-check-input check-box-clickeable" >'.$array_pasos[$i]->titulo. ' - '. $array_pasos[$i]->desc;
            echo '</label>';
            echo '<input class="col-sm-1" style="display: none" placeholder="" name="'.$array_pasos[$i]->id.'" />';
            echo '<input class="col-sm-1" style="display: none" placeholder="hs." name="tiempo_estimado'.$array_pasos[$i]->id.'" />';
            }
        echo '</div>';

        ?>
        </div>
    </form>;
  </div>
<link rel="stylesheet" href="<?php echo base_url();?>assets/js/vendor/jquery-ui/jquery-ui.css">
<script src="<?php echo base_url();?>assets/js/vendor/jquery-ui/jquery-ui.js"></script>



<script>
$(document).ready(function() {

  $(".check-box-clickeable").click(function() {
    var el = $(this);
    input1 = el.parents("label").next();
    input2 = input1.next();
    input1.toggle();
    input2.toggle();
  })
  
});



</script>