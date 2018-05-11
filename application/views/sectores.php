    <?php echo '<script src="'. base_url() .'assets/js/show_sectors.js"></script>'; ?>
    <div class="container">
      <h1> Sectores Existentes</h1>
      <?php
        echo '<table class="table"><thead class="thead-inverse">        <tr id="header-table">
          <th>#id</th><th>Denominación del Sector</th><th>Tipo Sector</th><th>id Dependencia</th><th>Fecha Creacion</th>       </tr>        </thead><tbody>';
        foreach( $array_sectores as $sector){
          echo  '<tr><th scope="row">'. $sector->id_sector .'</th>'.
                '<td>'.$sector->denominacion.'</td>'.
                '<td>'.$sector->tipo.'</td>'.
                '<td>'.$sector->id_padre.'</td>'.
                '<td>'.$sector->fecha_creacion.'</td>';
        }
        echo '  </tbody></table>';
     ?>
      </br>
        
      <div class="col-sm-6" id="new-sector">
      <h3>Crear Sector Nuevo</h3>
        <!-- <p><input type="text" class="span4" name="padre" id="padre" placeholder="sector padre"></p> -->
         <p><select class="span4" name="padre" id="padre">
        <option value="">Sector del que depende</option>
             <?php
              foreach( $array_sectores as $sector){
                echo  '<option value="'.$sector->id_sector.'">'. $sector->denominacion.'</option>';
              }
              ?>
        </select></p>
        <p><input type="text" class="span4" name="denominacion" id="denominacion" placeholder="denominacion"></p>
          <select class="span4" name="tipo" id="tipo" placeholder="Tipo de Sector">
            <option value="Oficina">Oficina</option>
            <option value="Intendencia">Intendencia</option>
            <option value="Secretaria">Secretaria</option> 
          </select>
        <p>  
        <p><a href="#" id="btnSubmitSector" class="btn btn-primary">Create</a></p>
      </p>
      </div>
      <div class="col-sm-6" id="mod-sector">
      <h3>Modificar Sector Existente</h3>
        <p><span>Elegir sector a modficar:</span><p>
        <select class="span4" name="id_sector" id="id_sector" placeholder="sector">
           <?php foreach( $array_sectores as $sector){
                    echo  '<option value="'.$sector->id_sector.'">'. $sector->denominacion.'</option>';
            }?>
        </select>
        <p><span>Ingresar los datos nuevos:</span><p>

        <p><select class="span4" name="padre" id="padre">
        <option value="">Sector del que dependerá</option>
             <?php
              foreach( $array_sectores as $sector){
                echo  '<option value="'.$sector->id_sector.'">'. $sector->denominacion.'</option>';
              }
              ?>
        </select></p>

        <p><input type="text" class="span4" name="denominacion" id="denominacion" placeholder="denominacion"></p>
          <select class="span4" name="tipo" id="tipo" placeholder="Tipo de Sector">
             <option value="Oficina">Oficina</option>
            <option value="Intendencia">Intendencia</option>
            <option value="Secretaria">Secretaria</option> 
          </select>
        <p>  
        <p><a href="#" id="btnSubmitModifySector" class="btn btn-primary">Modificar</a></p>
      </p>
      </div>
    </div>