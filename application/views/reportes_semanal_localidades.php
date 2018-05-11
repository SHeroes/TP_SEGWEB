<?php $this->load->view('header'); ?>


      <div class="container">
       <div class="row">

            <div class="col-md-12 reporte" style="margin-top: 50px; background-color: white;">



                  <?php
                  $table_header = '<table class="table ">
                  <thead class="thead-inverse"><tr class="tbl-sec-glob-tr"><th>Id Tipo Rec.</th><th>titulo</th><th>cantidad</th></tr></thead><tbody>';
                  $table_fin = '  </tbody></table>';    


                  //REPORTE GLOBAL
                  echo '<div class="reporte_global">Reporte Global Localidades</div>';
                  echo '<table class="table ">
                  <thead class="thead-inverse"><tr class="tbl-sec-glob-tr"><th>Localidad</th><th>Cantidad de Reclamos</th></tr></thead><tbody>';
                  foreach ($reporte_localidades_gl as $row) {
                    echo '<tr>';
                    echo '<td>'.$row['localidades'].'</td>';
                    echo '<td>'.$row['cantidad'].'</td>';
                    echo '</tr>';
                  }
                  echo $table_fin;


                    $localidad = 0;


   
                      // IMPRIMO ENCABEZADO //
                 
                    foreach ($reporte_localidades as $value){
                        if ($localidad != $value['id_localidad']){
                          if ($localidad != 0) echo $table_fin;
                          $localidad = $value['id_localidad'];
                          echo '<div class="reporte_global" id-loc="'.$localidad.'">'.$value['localidades'].'</div>';
                          echo $table_header; 
                        }
                        //  IMPRIMO VALORES  // 
                        echo '<tr>';
                        echo '<td>'.$value['id_tipo_reclamo'].'</td>';
                        echo '<td>'.$value['titulo'].'</td>';
                        echo '<td>'.$value['cantidad'].'</td>';
                        echo '</tr>';


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