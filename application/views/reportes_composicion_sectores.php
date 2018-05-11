<?php $this->load->view('header'); ?>


      <div class="container">
       <div class="row">

            <div class="col-md-12 reporte" style="margin-top: 50px; background-color: white;">
                  <?php
                  /*
                  echo '<pre>';
                    print_r($reporte_secretarias);
                    die();
                  ?></pre><?php
*/
          

                  $table_header_Secretaria = '<table class="table ">
                  <thead class="thead-inverse"><tr class="tbl-sec-glob-tr"><th>Nombre</th><th>Apellido</th><th>Usuario</th></tr></thead><tbody>';

                  $table_header_Oficina = '<table class="table">
                  <thead class="thead-inverse"><tr class="tbl-sec-glob-tr"><th>Nombre</th><th>Apellido</th><th>Usuario</th></tr></thead>';

                  $table_fin = '  </tbody></table>';    

                  $table_fin = '';
                  $secretariaAnterior = 0;
                  $usuarioAnterior = 0;
                  $sectorAnterior = 0;
                  foreach ($reporte_secretarias as $row) {
                    if ($secretariaAnterior!= $row['id_secretaria']){
                      echo $table_fin;
                      $secretariaAnterior = $row['id_secretaria'];
                      echo '<div class="reporte_global">'.$row['denominacion'].'</div>';
                      echo $table_header_Secretaria;
                      echo '<tr class="lightGrey">';
                      echo '<td>'.$row['nombre'].'</td>';
                      echo '<td>'.$row['apellido'].'</td>';
                      echo '<td>'.$row['email'].'</td>';
                      echo '</tr>';
/***********************************/
                      foreach ($reporte_oficinas as $key => $value) {
                        if($row['id_secretaria'] == $value['id_padre']){
                          if($value['id_sector'] == $sectorAnterior){
                          }else {
                            echo '</tbody></table>';
                            echo '<div class="reporte_composicion_ofi" id-sec="'. $value['id_padre'].'">Oficina: '.$value['denominacion'].'</div>';
                            echo $table_header_Oficina;
                          }
                          if($value['id_user'] != $usuarioAnterior){
                            echo '<tr class="lightGrey">';
                            echo '<td>'.$value['nombre'].'</td>';
                            echo '<td>'.$value['apellido'].'</td>';
                            echo '<td>'.$value['email'].'</td>';
                            echo '</tr>';
                          }
                          $usuarioAnterior = $value['id_user'];
                          if($value['TipoReclamo'] != null){
                            echo '<tr class="">';
                            echo '<td>Tipo Reclamo:</td>';
                            echo '<td>'.$value['TipoReclamo'].'</td>';
                            echo '<td>'.$value['descripcionTipoReclamo'].'</td>';
                            echo '</tr>';
                          }
                        }
                        $usuarioAnterior = $value['id_user'];
                        $sectorAnterior = $value['id_sector'];
                      }
/*********************************/
                      $secretariaAnterior = $row['id_secretaria'];
                    }else {
                      echo '<tr class="lightGrey">';
                      echo '<td>'.$row['nombre'].'</td>';
                      echo '<td>'.$row['apellido'].'</td>';
                      echo '<td>'.$row['email'].'</td>';
                      echo '</tr>';
                    }
                    $table_fin = '</tbody></table>';  

                  }
                    echo $table_fin;
                  ?>
               <!--/.container-fluid -->
             </div>
          </div>
        <!--/.navbar-header -->
      </div>
      <!--/.container-fluid -->


<?php $this->load->view('footer_base'); ?>
<?php echo '<script src="'. base_url() .'assets/js/reportes.js"></script>'; ?>