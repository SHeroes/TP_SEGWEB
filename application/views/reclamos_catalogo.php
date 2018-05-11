    <?php echo '<script src="'. base_url() .'assets/js/show_catalogo.js"></script>'; ?>  
  <div class="container">
      <h1> Catálogo de Reclamos </h1>         

        <div class="col-sm-6" id="crear-tipo-reclamo">
          <h3>Crear Tipo de Reclamo</h3>
            <div class="">
            <form method="POST" action="insertar_tipo_reclamo/">
                <p><input type="text" name="tiempo_respuesta" size="30" placeholder="Tiempo respuesta (hs.)"></p>
                <p><span>Responsable</span></p> 
                <p><select class="span4" name="id_responsable" id="id_responsable">
                  <?php foreach( $array_responsables as $responsable){
                      echo  '<option value="'. $responsable['id_responsable'] .'" id-sector="'.$responsable['sec_id']. '"'.
                    'nombre-sector="'.$responsable['sec_nombre']. '">'. $responsable['nombre'] .' ' .
                     $responsable['apellido'] .'</option>';
                  } ?>          
                </select></p>
                <p><input type="text" name="titulo" size="30" placeholder="Título"></p>
                <p><textarea name="descripcion" placeholder="Descripción" cols="60" rows="10"></textarea>  </p>
                <a><input type="submit" class="btn btn-primary" value="Agregar"></a>
            </form>
            </div>
        </div>

        <div class="col-sm-6" id="modificar-tipo-reclamo">
          <h3>Modificar Tipo Reclamos Existente</h3>
          <div class="">
          <form method="POST" action="modificar_tipo_reclamo/">
          <p><select class="span4" name="id_tipo_reclamo">
                <?php foreach( $tipos_reclamos as $tipo_reclamo){
                    echo  '<option value="'. $tipo_reclamo->id_tipo_reclamo .'">'. $tipo_reclamo->titulo .'</option>';
                } ?>    
               </select></p> 
              <p><input type="text" name="tiempo_respuesta" size="30" placeholder="Tiempo respuesta (hs.)"></p>
              <p><span>Responsable</span></p> 
              <p><select class="span4" name="id_responsable" id="id_responsable">
                <?php foreach( $array_responsables as $responsable){
                    echo  '<option value="'. $responsable['id_responsable'] .'" id-sector="'.$responsable['sec_id']. '"'.
                  'nombre-sector="'.$responsable['sec_nombre']. '">'. $responsable['nombre'] .' ' .
                   $responsable['apellido'] .'</option>';
                } ?>          
              </select></p>
              <p><input type="text" name="titulo" size="30" placeholder="Título"></p>
              <p><textarea name="descripcion" placeholder="Descripción" cols="60" rows="10"></textarea>  </p>               
              <a><input type="submit" class="btn btn-primary" value="Modificar"></a>
          </form>
          </div>
        </div>

        <div class="col-sm-6" id="desactivar-tipo-reclamo">
          <h3>Desactivar Tipo Reclamo Existente</h3>
          
            <div class="">
            <form method="POST" action="desactivar_tipo_reclamo/">
                <p><select class="span4" name="id_tipo_reclamo">
                <?php foreach( $tipos_reclamos as $tipo_reclamo){
                    echo  '<option value="'. $tipo_reclamo->id_tipo_reclamo .'">'. $tipo_reclamo->titulo .'</option>';
                } ?>    
                </select></p> 


                 <a><input type="submit" class="btn btn-primary" value="Quitar"></a>
            </form>
            </div>
        </div>

      <h1> Tipos de Reclamos Existentes</h1>
      <?php
        echo '<table class="table"><thead class="thead-inverse">        <tr id="header-table">
          <th>#id</th><th>Titulo</th><th>descripción</th><th>#id Responsable</th><th>Respuesta (hs.)</th><th>Estado</th>       </tr>        </thead><tbody>';
        foreach( $tipos_reclamos as $tipo_reclamo){
          echo  '<tr><th scope="row">'. $tipo_reclamo->id_tipo_reclamo .'</th>'.
                '<td>'.$tipo_reclamo->titulo.'</td>'.
                '<td>'.$tipo_reclamo->descripcion.'</td>'.
                '<td>'.$tipo_reclamo->id_responsable.'</td>'.
                '<td>'.$tipo_reclamo->tiempo_respuesta_hs.'</td>';
                $tipo_reclamo->estado_activo ? $estado = '<td> Activo </td>' : $estado = '<td> Inhabilitado </td>' ;
                echo $estado;
        }
        echo '  </tbody></table>';
     ?>
      </br>

  </div>
