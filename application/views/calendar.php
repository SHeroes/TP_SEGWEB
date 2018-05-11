 
  <div class="container">
      <h1> Feriados del Año en curso en Adelante </h1>
      <h4>Todos los Sabados y Domingo ya se consideran no laborales</h4>
      <?php
        echo '<table class="table"><thead class="thead-inverse">        <tr id="header-table">
          <th>Año</th><th>Mes</th><th>Dia</th><th>fecha</th>
          </tr></thead><tbody>';

        foreach( $array_fechas as $fecha){
          echo  '<tr><th scope="row">'. $fecha['anio'] .'</th>'.
                '<td>'.$fecha['mes'].'</td>'.
                '<td>'.$fecha['dia'].'</td>'.
                '<td>'.$fecha['fecha'].'</td>';
        }

        echo '  </tbody></table>';
     ?>
         
        <div class="col-sm-6" id="crear-feriado">

          <h3>Agregar Feriado</h3>
         
            <div class="">
            <form method="POST" action="insert_date/">
                 <p>fecha: <input type="text" name="datepicker" id="datepicker" size="30"></p>
                 <a><input type="submit" class="btn btn-primary" value="Agregar"></a>
            </form>
            </div>

        </div>
        <div class="col-sm-6" id="quitar-feriado">

        <h3>Quitar Feriado Existente</h3>
          
            <div class="">
            <form method="POST" action="delete_date/">
                 <p>fecha: <input type="text" name="datepicker2" id="datepicker2" size="30"></p>
                 <a><input type="submit" class="btn btn-primary" value="Quitar"></a>
            </form>
            </div>
        </div>
  </div>



<link rel="stylesheet" href="<?php echo base_url();?>assets/js/vendor/jquery-ui/jquery-ui.css">
  <script src="<?php echo base_url();?>assets/js/vendor/jquery-ui/jquery-ui.js"></script>

  <?php echo '<script src="'. base_url() .'assets/js/show_calendar.js"></script>'; ?> 