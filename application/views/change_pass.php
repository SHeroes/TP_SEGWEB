  <div id="ch_pass" class="dialog-box" style="display: none;" title="Cambiar Contraseña">
    <p>ingrese la contraseña nueva</p>
    <p><input type="text" class="span4" name="new_pass" id="new_pass" placeholder="password"></p>
    <div class="btn btn-primary">Cambiar</div>
  </div>

<link rel="stylesheet" href="<?php echo base_url();?>assets/js/vendor/jquery-ui/jquery-ui.css">

  <?php echo '<script src="'. base_url() .'assets/js/vendor/jquery-ui/jquery-ui.js"></script>'; ?>
  <?php echo '<script src="'. base_url() .'assets/js/change_pass.js"></script>'; ?>

<style>
.ui-draggable, .ui-droppable {
  background-position: top;
}

#vecino-data {
}

tr.reclamo_row{  
}

.input-form{
  margin-right: 30px;
  width: 130px;
}

.reclamo-form{
 display: none; 
}
.input-search-result{
  cursor: pointer;
  display: none;
}
tr.vecinos_filtrados{
  cursor: pointer;
}

.calle.input-search-result{
  background-color: khaki;
  margin-bottom: 10px;
}
.calle.input-search-result div{
      border-bottom: 1px solid white;
}
.calle.input-search-result div:hover{
  font-weight: 600;
}

.calle.input-search-result .hover{
  font-weight: 600;
}

.no-visto{
  visibility: hidden;
}

</style>