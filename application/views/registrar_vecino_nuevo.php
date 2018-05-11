  <div class="col-sm-12" id="new-sector">
  <h3>Registrar Vecino Nuevo</h3>
    <form method="POST" id="insert_vecino_form" name="insert_vecino_form" action="insert_vecino/">
      <div class="col-sm-6">
        <h4> Datos del vecino </h4>
        <p><input type="text" class="span4 input-form form-control" name="nombre" id="nombre" placeholder="nombre" required></p>
        <p><input type="text" class="span4 input-form form-control" name="apellido" id="apellido" placeholder="apellido" required></p>
        <p><input type="text" class="span4 input-form form-control" name="dni" id="dni" placeholder="DNI" required></p>
        <p><input type="text" class="span4 input-form form-control" name="mail" id="mail" placeholder="mail"></p>
        <p><input type="text" class="span4 input-form form-control" name="tel_fijo" id="tel_fijo" placeholder="tel_fijo"></p>
        <p><input type="text" class="span4 input-form form-control" name="tel_movil" id="tel_movil" placeholder="tel_movil"></p>
      </div>
      <div class="col-sm-6 domicilio-data">
        <h4> Datos del Domicilio </h4>
        
        <p><select type="text" class="span4 form-control" name="id_loc" id="id_loc" placeholder="id_loc">
          <option value="">Seleccionar Localidad...</option>
            <?php foreach( $all_localidades as $localidad){
          echo '<option value="'. $localidad->id_localidad .'">'.$localidad->localidades.'</option>';
            }?>
            </select>
        </p>
        <div class="hidden">
          <p>localidad_id_google</p><p><input id="localidad_id_google" name="localidad_id_google" type="textbox" placeholder="vacio"/></p>
          <p>latitud</p><p><input id="lat" name="lat" type="textbox" placeholder="vacio"/></p>
          <p>longitud</p><p><input id="lng" name="lng" type="textbox" placeholder="vacio"/></p>  
        </div>

        <p><input type="text" class="span4 calle input-form  form-control" name="calle" id="calle" placeholder="calle" autocomplete="off" required>
            <input type="text" hidden class="hidden_id calles calle-principal" name="calle_id" value="">
        </p>
        <div class="calle input-search-result"></div>
        

        <p><input type="text" class="span4 required input-form form-control" name="altura" id="altura" placeholder="altura" required></p>
        <p><input type="text" class="span4 calle input-form  form-control" name="entrecalle1" id="entrecalle1" autocomplete="off" placeholder="entrecalle1">
            <input type="text" hidden class="hidden_id calles" name="entrecalle1_id" value="">
        </p>
        <div class="calle input-search-result" ></div>
        
        <p><input type="text" class="span4 calle  input-form form-control" name="entrecalle2" id="entrecalle2" placeholder="entrecalle2" autocomplete="off">
           <input type="text" hidden class="hidden_id calles" name="entrecalle2_id" value="">
        </p>
        <div class="calle input-search-result" ></div>

        <p><input type="text" class="span4  input-form form-control" name="departamento" id="departamento" placeholder="departamento"></p>
        <p><input type="text" class="span4  input-form form-control" name="piso" id="piso" placeholder="piso"></p>
        <p>Barrio:</p>
        <p><select type="text" class="span4 required form-control" name="id_barrio" id="id_barrio" placeholder="id_barrio" autocomplete="off" required>
          <?php foreach( $all_barrios as $barrio){
          echo  '<option value="'. $barrio->id_barrio .'">'. $barrio->barrio. '</option>';
          }?>
        </select></p>
        <p><a><input type="submit" id="registrar_btn" class="btn btn-primary" value="Registrar"></a></p>
        <!-- <p><a><input type="button" class="btn btn-primary" value="Registrar" onclick="codeAddress()"></a></p> -->
        </div>
    </form>
  </div>


<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyA0GuxesQUCN_PpC-x-RnnOZaxBzeTdqN0">
  </script>
<script type="text/javascript">
  var geocoder;

  function codeAddress() {
    geocoder = new google.maps.Geocoder();
    var calleName = $('#calle').val();
    var altura = $('#altura').val();
    var ubicacionComa = calleName.indexOf(',');
    if ( ubicacionComa > -1){
        calleName = calleName.substring(0,ubicacionComa);
    } 

    var localidadNombre = "Monte Grande";
    if ( $('#id_loc').val() == "" )  $('#id_loc').val(9) ;
    if ( $('#id_loc').val() < 8 ){
      localidadNombre = $('#id_loc option:selected').text();
    }

    var address = calleName + ' ' + altura + ', ' + localidadNombre + ', Buenos Aires, Argentina';
    console.log(address);
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
        if (loc_name == "Ezeiza")      { id_loc = 7;  } else
        if (loc_name == "Esteban Echeverría")      { id_loc = 8;  } else
         { id_loc = 10;  }

        $('input#localidad_id_google').val(id_loc);
        $('input#lat').val(results[0].geometry.location.lat());
        $('input#lng').val(results[0].geometry.location.lng());
      } else {
        console.log('Geocode was not successful for the following reason: ' + status);
        $('input#localidad_id_google').val(9);
        $('input#lat').val(-34.8267688);
        $('input#lng').val(-58.481107699999995);
      }
    });
        console.log("waiting...");
        setTimeout(function () {
          document.insert_vecino_form.submit();
        }, 1500);
  }


  $(document).ready(function(){
    $('#insert_vecino_form').on('submit', function(e){
      var errorCount = 0;
      $("input.hidden_id.calle-principal").each(function(index,elem){
        el = $(elem);
        if ( el.val()>0 ){

        } else {
          errorCount++;
          e.preventDefault();
          alert("Corrija los valores del campo "+ el.attr("name") + " antes de registrar");
        }
      });

      if (errorCount == 0){
        e.preventDefault();
        codeAddress();
      };

    });


  });


</script>