<?php $this->load->view('header'); ?>


      <div class="container">
       <div class="row">

            <div class="col-md-12 reporte" style="margin-top: 50px;">
                  <?php
                  // print_r($reporte_reclamos);

                  $table_header_Secretaria = '<table class="table ">
                  <thead class="thead-inverse"><tr class="tbl-reclamos-tr"><th>Nº del Reclamo</th><th>Oficina</th><th>Secretaria</th><th>estado</th><th>Fecha de alta Reclamos</th></tr></thead><tbody>';
                  $table_fin = '  </tbody></table>';    

                  //REPORTE GLOBAL
                  echo $table_header_Secretaria;
                  foreach ($reporte_reclamos as $row) {
                    echo '<tr>';
                    echo '<td>'.$row['NumRec'].'</td>';
                    echo '<td>'.$row['Oficina'].'</td>';
                    echo '<td>'.$row['Secretaria'].'</td>';
                    echo '<td>'.$row['estado'].'</td>';
                    echo '<td>'.$row['fecha_alta_reclamo'].'</td>';
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