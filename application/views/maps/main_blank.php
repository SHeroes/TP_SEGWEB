<?php $this->load->view('header'); ?>

	<?php 
		$pos = strpos($unDomicilio['calle'], ",");
		$calleSingleName = "";
	if ($pos === false) {
	    $calleSingleName = $unDomicilio['calle'];
	} else {
		$calleSingleName = substr($unDomicilio['calle'], 0, $pos);
	}
		$calleSingleName = $calleSingleName . " " .$unDomicilio['altura']. ", ".$unDomicilio['loc_name'].", Buenos Aires";
	?>

	<div id="map"></div>
	<div>
		<input id="address" type="textbox" value="<?php echo $calleSingleName; ?>">
		<input type="button" value="Encode" onclick="codeAddress()">
		<div class="container">
			<form id="update_dom_form" name="update_dom" method="POST" action="./actualizar_domicilio">
				<p>localidad</p>
				<p><input id="loc_id" name="loc" type="textbox" placeholder="vacio"/></p>
				<p>domicilio id</p>
				<p><input id="dom_id" name="dom" type="textbox" value="<?php echo $unDomicilio['id_domicilio']; ?>"></p>
				<p>latitud</p>
				<p><input id="lat" name="lat" type="textbox" placeholder="vacio"/></p>
				<p>longitud</p>
				<p><input id="lng" name="lng" type="textbox" placeholder="vacio"/></p>
			</form>
		</div>
	</div>

<style>
  #map {
   /* height: 40%; */
  }
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
  #address {
    width: 500px;
    margin-left: 10%;
    margin-top: 20;
    margin-bottom: 20;
  }
</style>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyA0GuxesQUCN_PpC-x-RnnOZaxBzeTdqN0">
  </script>
<script>
	var geocoder;
	var map;
  	/*
	  function initialize() {
	    geocoder = new google.maps.Geocoder();
	    var latlng = new google.maps.LatLng(-34.8184400, -58.4562500);
	    var mapOptions = {
	      zoom: 12,
	      center: latlng
	    }
	    map = new google.maps.Map(document.getElementById('map'), mapOptions);
	  }
	*/


	function codeAddress() {
		geocoder = new google.maps.Geocoder();
		var address = document.getElementById('address').value;
		geocoder.geocode( { 'address': address}, function(results, status) {
		  if (status == 'OK') {
		    var loc_name = results[0].address_components[2].long_name;
		    var id_loc = 0;
		    console.log(loc_name);
		    //console.log(results[0].formatted_address + " - " + results[0].geometry.location);
		    if (loc_name == "Monte Grande")  { id_loc = 5;  } else
		    if (loc_name == "Luis Guillon")  { id_loc = 4;  } else
		    if (loc_name == "El Jagüel")     { id_loc = 3;  } else
		    if (loc_name == "Canning")       { id_loc = 2;  } else
		    if (loc_name == "9 de Abril")    { id_loc = 1;  } else
			if (loc_name == "Llavallol")     { id_loc = 6;  } else		    
		    if (loc_name == "Ezeiza")    	 { id_loc = 7;  } else
		    if (loc_name == "Esteban Echeverría")    	 { id_loc = 8;  } else
		     { id_loc = 10;  }

			$('input#loc_id').val(id_loc);
			$('input#lat').val(results[0].geometry.location.lat());
			$('input#lng').val(results[0].geometry.location.lng());
		    /*
		        1 9 de Abril
		        2 Canning
		        3 El Jagüel
		        4 Luis Guillón
		        5 Monte Grande
		    */
		    // console.log(results[0].address_components[0]);
		    //alert(results[0].formatted_address + " - " + results[0].geometry.location);
		    //end extra line
      
		  } else {
		    //alert('Geocode was not successful for the following reason: ' + status);
			$('input#loc_id').val(9);
			$('input#lat').val(-34.8267688);
			$('input#lng').val(-58.481107699999995);
		  }
		});

		setTimeout(function () {
		   document.update_dom.submit();
		}, 2000);  
	}

	setTimeout(function () {
		codeAddress();
	}, 2000);

</script>