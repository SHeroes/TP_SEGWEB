<?php // echo '<script src="'. base_url() .'assets/js/show_reclamos_crear.js"></script>'; ?>
<div class="container">
<h1>Lista de Reclamos Verificados a imprimir</h1>

    <?php if(isset($reclamos_list_verificados)){
/*    	
    	echo '<pre>';
      print_r($reclamos_list_verificados);
      echo '</pre>';
*/
      echo '<table class="table"><thead class="thead-inverse">        <tr id="header-table">
      <th>Código Reclamo</th><th>Fecha Alta</th><th>Fecha Llamada Verif.</th><th> Título </th><th> tipo_sector </th><th> Sector </th><th>Rta. hs</th><th>Estado</th><th>Verificación</th></tr>        </thead><tbody>';
      foreach ($reclamos_list_verificados as $rec) {
        echo  '<tr class="reclamo_row"><th scope="row" class="" id_reclamo="'.$rec['id_reclamo'].'">'.
        $rec['codigo_reclamo'] .'</th>'.
        '<td>'.$rec['fecha_alta_reclamo'].'</td>'.
        '<td>'.$rec['fecha_llamada'].'</td>'.

        '<td>'.$rec['titulo'].'</td>'.
        '<td>'.$rec['tipo_sector'].'</td>'.
  		 	'<td>'.$rec['oficina_nombre'].'</td>'.
				'<td>'.$rec['tiempo_respuesta_hs'].'</td>'.
				'<td>'.$rec['estado'].'</td>';
				if ($rec['correctitud'] == true){ 
					echo '<td class="success"> Correcta </td>';
				} else if ($rec['correctitud'] == false) {
					echo '<td class="danger"> Incorrecta </td>';
				} else {
					echo '<td class="info"> Indefinida </td>';
				}
      }
      echo '  </tbody></table>'; 
 


      }?>
</div>
<?php echo '<script src="'. base_url() .'assets/js/header-table.js"></script>'; ?> 