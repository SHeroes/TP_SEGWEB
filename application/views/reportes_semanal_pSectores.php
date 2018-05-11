<?php $this->load->view('header'); ?>


      <div class="container">
       <div class="row">

            <div class="col-md-12 reporte" style="margin-top: 50px; background-color: white;">



                  <?php
                  $table_header_Secretaria = '<table class="table ">
                  <thead class="thead-inverse"><tr class="tbl-sec-glob-tr"><th>Estado del Reclamo</th><th>Cantidad</th></tr></thead><tbody>';

                  $table_header_Oficina = '<table class="table">
                  <thead class="thead-inverse"><tr class="tbl-sec-glob-tr"><th>Estado del Reclamo</th><th>Cantidad</th><th>Sector / Oficina </th></tr></thead>';
                  $table_fin = '  </tbody></table>';    

                  //REPORTE GLOBAL
                  echo '<div class="reporte_global">Reporte Global</div>';
                  echo $table_header_Secretaria;
                  foreach ($reporte_global as $row) {
                    echo '<tr>';
                    echo '<td>'.$row['estado'].'</td>';
                    echo '<td>'.$row['cantidad'].'</td>';
                    echo '</tr>';
                  }
                  echo $table_fin;

                    foreach ($reporte_secretaria as $sec_id => $value){

                      // IMPRIMO ENCABEZADO //
                        $info_secretaria = $reporte_secretaria[$sec_id];
                        echo '<div class="reporte_global_sec" id-sec="'.$sec_id.'">Reporte Secretaria: '.$info_secretaria[0]['denominacion'].'</div>';
                        echo $table_header_Secretaria;
                        //  IMPRIMO VALORES DE SECRETARIA  // 
                          foreach ($info_secretaria as $row) {
                            echo '<tr>';
                            echo '<td>'.$row['estado'].'</td>';
                            echo '<td>'.$row['cantidad'].'</td>';
                            echo '</tr>';
                          }
                        echo $table_fin;

                        //  IMPRIMO LISTADO OFICINA correspondiente  // 
                        echo $table_header_Oficina;
                        foreach ($reporte_oficina[$sec_id] as $row) {
                            echo '<tr>';
                            echo '<td>'.$row['estado'].'</td>';
                            echo '<td>'.$row['cantidad'].'</td>';
                            echo '<td>'.$row['denominacion'].'</td>';
                            echo '</tr>';   
                        }
                        echo $table_fin;

                    }
                  ?>
               <!--/.container-fluid -->
             </div>
          </div>
        <!--/.navbar-header -->
      </div>
      <!--/.container-fluid -->


<?php $this->load->view('footer_base'); ?>
<?php echo '<script src="'. base_url() .'assets/js/reportes.js"></script>'; ?>