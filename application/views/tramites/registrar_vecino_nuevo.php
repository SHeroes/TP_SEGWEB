  <div class="col-sm-12" id="new-sector">
  <h3>Registrarse como Vecino Nuevo</h3>
    <form method="POST" id="insert_vecino_form" action="insert_vecino/">
      <div class="col-sm-6">
        <h4> Datos del vecino </h4>
        <p><input type="text" class="span4 input-form form-control" name="nombre" id="nombre" placeholder="nombre" required></p>
        <p><input type="text" class="span4 input-form form-control" name="apellido" id="apellido" placeholder="apellido" required></p>
        <p><input type="text" class="span4 input-form form-control" name="dni" id="dni" placeholder="DNI" required></p>
        <p><input type="text" class="span4 input-form form-control" name="mail" id="mail" placeholder="mail"></p>
        <p><input type="text" class="span4 input-form form-control" name="tel_fijo" id="tel_fijo" placeholder="tel_fijo"></p>
        <p><input type="text" class="span4 input-form form-control" name="tel_movil" id="tel_movil" placeholder="tel_movil"></p>
      </div>
      <div class="col-sm-6 domicilio-data">
        <h4> Datos del Domicilio </h4>
        
        <p><input type="text" class="span4 calle input-form  form-control" name="calle" id="calle" placeholder="calle" autocomplete="off" required>
            <input type="text" hidden class="hidden_id calles calle-principal" name="calle_id" value="">
        </p>
        <div class="calle input-search-result"></div>
        

        <p><input type="text" class="span4 required input-form form-control" name="altura" id="altura" placeholder="altura" required></p>
        <p><input type="text" class="span4 calle input-form  form-control" name="entrecalle1" id="entrecalle1" autocomplete="off" placeholder="entrecalle1">
            <input type="text" hidden class="hidden_id calles" name="entrecalle1_id" value="">
        </p>
        <div class="calle input-search-result" ></div>
        
        <p><input type="text" class="span4 calle  input-form form-control" name="entrecalle2" id="entrecalle2" placeholder="entrecalle2" autocomplete="off">
           <input type="text" hidden class="hidden_id calles" name="entrecalle2_id" value="">
        </p>
        <div class="calle input-search-result" ></div>
        <p>Seleccione el Barrio al que pertenece</p>
        <p><select type="text" class="span4 required form-control" name="id_barrio" id="id_barrio" placeholder="id_barrio" autocomplete="off" required></p>
          <?php foreach( $all_barrios as $barrio){
          echo  '<option value="'. $barrio->id_barrio .'">'. $barrio->barrio. '</option>';
          }?>
          </select>
        <p><input type="text" class="span4  input-form form-control" name="departamento" id="departamento" placeholder="departamento"></p>
        <p><input type="text" class="span4  input-form form-control" name="piso" id="piso" placeholder="piso"></p>
        </div>
      <p><a><input type="submit" id="registrar_btn" class="btn btn-primary" value="Registrar"></a></p>
        </div>
    </form>
  </div>

<script type="text/javascript">
   $(document).ready(function(){

    $('#insert_vecino_form').on('submit', function(e){
      // validation code here
      //var valid = true;
      $("input.hidden_id.calle-principal").each(function(index,elem){
        el = $(elem);
        if ( el.val()>0 ){

        } else {
          e.preventDefault();
          alert("Corrija los valores del campo "+ el.attr("name") + " antes de registrar");
        }
      })
    });

});
</script>