<?php // echo '<script src="'. base_url() .'assets/js/show_reclamos_crear.js"></script>'; ?>
<div class="container">
<h1>Reclamos Vistos por mas de dos días a la fecha: <?php echo date('Y-m-d'); ?> y aún No Contactados </h1>
  


    <?php if(isset($reclamos_list_no_contactados)){


  /*
id_reclamo, codigo_reclamo, fecha_alta_reclamo, titulo, sec_1.denominacion oficina_nombre, sec_2.denominacion secretaria_nombre , tiempo_respuesta_hs, estado
*/

      echo '<table class="table"><thead class="thead-inverse">        <tr id="header-table">
      <th>Código Reclamo</th><th>Fecha Alta</th><th> Título </th><th> Secretaria </th><th> Sector </th><th>Rta. hs</th><th>Estado</th></tr>        </thead><tbody>';
      foreach ($reclamos_list_no_contactados as $rec) {
        echo  '<tr class="reclamo_row"><th scope="row" class="" id_reclamo="'.$rec['id_reclamo'].'">'.
        $rec['codigo_reclamo'] .'</th><td>'.$rec['fecha_alta_reclamo'].'</td><td>'.$rec['titulo'].'</td>';
        if ( $rec['tipo_sector'] == 'SECRETARIA'){	
           	echo 	'<td>'.$rec['oficina_nombre'].'</td><td> --------- </td>';
        } else {
           	echo 	'<td>'.$rec['secretaria_nombre'].'</td><td>'.$rec['oficina_nombre'].'</td>';
        }
				echo  '<td>'.$rec['tiempo_respuesta_hs'].'</td><td>'.$rec['estado'].'</div></td>';
        }
        echo '  </tbody></table>'; 
 

      }

      ?>
</div>

<?php echo '<script src="'. base_url() .'assets/js/header-table.js"></script>'; ?> 