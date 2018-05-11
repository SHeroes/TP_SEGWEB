<div class="show-ttr">

	<!-- <div>SHOW tipo de tramite tramite</div> -->
	</br>
	<h2><?php echo $ttr_data[0]->titulo;  ?></h2>
	<h4><?php echo $ttr_data[0]->desc;  ?></h4>
	<h3>Paso a Paso</h3>
	   <img class="trama" src="/assets/img/trama.svg" alt="">
	</br>
	</br>

<?php 
	echo '<div class="paso-paso">';
	foreach ($pasos as $key => $paso) {
		echo '<div class="paso">';
		echo '<div class="num">'.$paso['orden'] .'</div>';
		echo '<div class="paso-titulos">'.$paso['titulo'].' - Oficina: '.$paso['denominacion'].'</div>';
		echo '<div class="paso-content">'.$paso['desc'].'</div>';
		$data = json_decode($paso['check_list_json']);

		if (count($data->checklist)>0){
			echo '<div class="checklist">Items a completar para el paso <br>';
			foreach ($data->checklist as $key => $value) {
				$num = $key + 1;
				echo $num.' - '.$value.'<br>';
			}
			echo '</div>';
		}
		$primerFormulario = 0;
		foreach ($formularios as $key => $value) {
			if ($value['tr_paso_id'] == $paso['id']){
				if ($primerFormulario == 0){
					echo '<h6>Codigo de Formularios asociados al paso para Descargar: </h6>';
					$primerFormulario++;
				}
				echo '<span><a href="/uploads/tr_formularios/'.$value['file_name'].'">'. $value['codigo_interno'].'</a></span>';
				//	[file_name] => ramo2.docx		            	//	[codigo_interno] => OF_RAMO
            	//	[titulo] => RAMO             					//	[desc] => ramo loco 
			}
		}
		echo '</div>';
	}
	echo '</div>';
?>
</div>
<div id="form-iniciarTramite">
	<h3>¿Desea inciar el trámite ahora?</h3>
	<form method=post id="tr-inicio-form" class="" action="inciar_tramite">
		<input hidden name="id_vecino" value="<?php echo $id_vecino ?>;">
		<input hidden name="ttr" value="<?php echo $ttr ?>;">
		<input class="btn btn-primary" type="submit" name="" value="Iniciar Tramite">
	</form>
</div>